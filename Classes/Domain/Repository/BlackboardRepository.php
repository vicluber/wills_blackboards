<?php

namespace Wills\WillsBlackboards\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Extbase\Domain\Model\Category;
use Wills\WillsBlackboard\Domain\Repository\FrontendUserRepository;

class BlackboardRepository extends Repository
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
    public function findAll(Category $category = null)
    {
        $query = $this->createQuery();
        $query->setOrderings(
            [
                'uid' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING,
            ]
        );
        if($category != null){
            $query->matching($query->equals('category', $category));
        }
        return $query->execute();
    }
    /**
     * Updates FileReference "deleted" attr to true/1
     * @api
     */
    public function deleteImage(int $fileReferenceUid)
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('sys_file_reference');
        $queryBuilder
        ->update('sys_file_reference')
        ->where(
            $queryBuilder->expr()->eq('uid', $fileReferenceUid)
        )
        ->set('deleted', true)
        ->execute();
    }
}