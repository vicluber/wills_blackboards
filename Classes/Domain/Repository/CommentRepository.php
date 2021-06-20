<?php

namespace Wills\WillsBlackboards\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class CommentRepository extends Repository
{
    /**
     * Disable respecting of a storage pid within queries globally.
     */
    public function initializeObject()
    {
        $defaultQuerySettings = $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings::class);
        $defaultQuerySettings->setRespectStoragePage(false);
        $this->setDefaultQuerySettings($defaultQuerySettings);
    }

    /**
     * Returns all objects of this repository.
     *
     * @return QueryResultInterface|array
     * @api
     */
    public function findWhereBlackboard(int $blackboard)
    {
        $query = $this->createQuery();
        $query->matching($query->equals('blackboard', $blackboard));
        return $query->execute();
    }
}