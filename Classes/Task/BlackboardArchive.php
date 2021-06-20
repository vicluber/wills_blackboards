<?php

namespace Wills\WillsBlackboards\Task;

use \TYPO3\CMS\Core\Utility\GeneralUtility as GeneralUtility;
use \TYPO3\CMS\Core\Log\LogManager as LogManager;
use \Psr\Log\LoggerInterface as LoggerInterface;
use TYPO3\CMS\Core\Database\ConnectionPool;

class BlackboardArchive extends \TYPO3\CMS\Scheduler\Task\AbstractTask {


    /**
    * Static Message
    *
    * @var string
    */
    private $message = "Blackboards Archived";

    /**
     * Logger
     *
     * @var \TYPO3\CMS\Core\Log\Logger
     */
    protected $logger;


    /**
     * Function executed from scheduler. main Function
     * 
     * @return  void
     */
    
    function execute() {
        $this->setLogger(GeneralUtility::makeInstance(LogManager::class)->getLogger(__CLASS__));

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_willsblackboards_domain_model_blackboard');
        $blackboards = $queryBuilder
                        ->select('*')
                        ->from('tx_willsblackboards_domain_model_blackboard')
                        ->execute()
                        ->fetchAll();
        foreach($blackboards as $key => $blackboard)
        {
            if($blackboard['hidden'] == 0)
            {
                $datetime1 = new \DateTime('NOW');
                $datetime2 = new \DateTime(date("Y-m-d H:i:s", $blackboard['crdate']));
                $interval = $datetime1->diff($datetime2);
                if($interval->days > $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['wills_blackboards']['BlackboardsExpirationDate'])
                {
                    $updateHidden = $queryBuilder
                                    ->update('tx_willsblackboards_domain_model_blackboard')
                                    ->where(
                                        $queryBuilder->expr()->eq('uid', $blackboard['uid'])
                                     )
                                     ->set('hidden', '1')
                                    ->execute();
                }
            }
        }
        $this->logger->log(4,$this->generateMessage());
        return true;
    }

    /**
     * Sets a logger.
     *
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    

    private function generateMessage() {

        $message = "===== ".$this->message." =====";

        return $message;
    }


}

?>