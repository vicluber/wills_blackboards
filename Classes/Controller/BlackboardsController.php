<?php

namespace Wills\WillsBlackboards\Controller;

use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Wills\WillsBlackboards\Domain\Model\Blackboard;
use Wills\WillsBlackboards\Domain\Repository\BlackboardRepository;
use Wills\WillsBlackboards\Domain\Model\Comment;
use Wills\WillsBlackboards\Domain\Repository\CommentRepository;
use TYPO3\CMS\Extbase\Domain\Model\Category;
use TYPO3\CMS\Extbase\Domain\Repository\CategoryRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Wills\WillsBlackboards\Property\TypeConverter\UploadedFileReferenceConverter;
use TYPO3\CMS\Extbase\Property\PropertyMappingConfiguration;
/***
 *
 * This file is part of the "WillsBlackboards" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2019 
 *
 ***/
/**
 * BlackboardsController
 */
class BlackboardsController extends ActionController
{
    /**
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected $persistenceManager;

    /**
     * Inject the Blackboard repository
     *
     * @param Wills\WillsBlackboards\Domain\Repository\BlackboardRepository $blackboardRepository
     */
    private $blackboardRepository;

    public function injectBlackboardRepository(BlackboardRepository $blackboardRepository)
    {
        $this->blackboardRepository = $blackboardRepository;
    }
    /**
     * Inject the category repository
     *
     * @param TYPO3\CMS\Extbase\Domain\Repository\CategoryRepository $categoryRepository
     */
    private $categoryRepository;

    public function injectcategoryRepository(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    /**
     * Inject the Comment repository
     *
     * @param Wills\WillsBlackboards\Domain\Repository\CommentRepository $commentRepository
     */
    private $commentRepository;

    public function injectCommentRepository(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * Set TypeConverter option for image upload
     */
    public function initializeCreateAction()
    {
        $this->setTypeConverterConfigurationForImageUpload('blackboard');
    }

    /**
     * Set TypeConverter option for image upload
     */
    public function initializeUpdateAction()
    {
        $this->setTypeConverterConfigurationForImageUpload('blackboard');
    }

    /**
     * Initializes the view before invoking an action method.
     * Override this method to solve assign variables common for all actions
     * or prepare the view in another way before the action is called.
     *
     * @param \TYPO3\CMS\Extbase\Mvc\View\ViewInterface $view The view to be initialized
     */
    protected function initializeView(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface $view)
    {
        $view->assign('contentObjectData', $this->configurationManager->getContentObject()->data);
        parent::initializeView($view);
    }

    /**
     * Set page Uid to each page with a plugin and sets the Uid of the parent category for the blackboards
     */
    public function initializeAction()
    {
       $this->blackboardsParentCategorie = (int) ($this->settings['blackboardsParentCategorie'] ?? false);
       $this->blackboardsUidViewPage = (int) ($this->settings['blackboardsUidViewPage'] ?? false);
       $this->blackboardsUidNewPage = (int) ($this->settings['blackboardsUidNewPage'] ?? false);
       $this->blackboardsUidListPage = (int) ($this->settings['blackboardsUidListPage'] ?? false);
    }

    /**
     *
     */
    protected function setTypeConverterConfigurationForImageUpload($argumentName)
    {
        \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Object\Container\Container::class)
            ->registerImplementation(
                \TYPO3\CMS\Extbase\Domain\Model\FileReference::class,
                \Wills\WillsBlackboards\Domain\Model\FileReference::class
            );

        $uploadConfiguration = [
            UploadedFileReferenceConverter::CONFIGURATION_ALLOWED_FILE_EXTENSIONS => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
            UploadedFileReferenceConverter::CONFIGURATION_UPLOAD_FOLDER => '1:/user_upload/',
        ];
        /** @var PropertyMappingConfiguration $newExampleConfiguration */
        $newExampleConfiguration = $this->arguments[$argumentName]->getPropertyMappingConfiguration();
        $newExampleConfiguration->forProperty('image')
            ->setTypeConverterOptions(
                UploadedFileReferenceConverter::class,
                $uploadConfiguration
        );
    }

    /**
     * Action for displaying the page and listing the blackboards.
     * $blackboardsList contains all blackboards filtered by $category. There is a custom findAll method into blackboardsRepository to filter by category if its set.
     * $currentCategory contains 'all' to not set any filter if $category comes null.
     * $blackboardsParentCategorie contains the id of the parent category of the blackboard to fill the filter options. This must be set in a Flexform on the plugin configuration
     * $categories contains a list of the system cateogires created for blackboards filtered by the $blackboardsParentCategorie
     * @param Category Contains the category to filter by sent by the link on top of the list, if is not null $currentCategory will be set with the title of the sent category
     */
    public function listAction(Category $category = null)
    {
        $blackboardsList = $this->blackboardRepository->findAll($category);
        $currentCategory = 'all';
        if($category != null){
            $currentCategory = $category->getTitle();
        }
        $this->view->assign('currentCategory', $currentCategory);
        $categories = $this->categoryRepository->findByParent($this->blackboardsParentCategorie);
        $this->view->assign('blackboardsList', $blackboardsList);
        $this->view->assign('categories', $categories);
    }

    /**
     * Action show
     * $blackboard contains a blackboard object
     * $comments contains a list of comments returned by findWhereBlackboard(), a custom methd on commentRepository that returns the comments filtered by the blackboardUid parameter.
     * @param Wills\WillsBlackboards\Domain\Model\Blackboard Blackboard
     */
    public function showAction(Blackboard $blackboard)
    {
        $comments = $this->commentRepository->findWhereBlackboard($blackboard->getUid());
        $this->view->assign('blackboard', $blackboard);
        $this->view->assign('comments', $comments);
        $this->view->assign('user-uid', $GLOBALS['TSFE']->fe_user->user['uid']);
    }

    /**
     * Displaying the view with the form for new blackboards
     * $blackboard contains an instance of Blackboard() model
     * $blackboardsParentCategorie contains the id of the parent category of the blackboards to load the select input for the blackboard category. This must be set in a Flexform on the plugin configuration
     * $categories contains a list of the system categories created for blackboards filtered by the $blackboardsParentCategorie
     */
    public function newAction()
    {
        $blackboard = new Blackboard();
        $categories = $this->categoryRepository->findByParent($this->blackboardsParentCategorie);
        $this->view->assign('blackboard', $blackboard);
        $this->view->assign('categories', $categories);
    }

    /**
     * The action of creating a new blackboard called from the form for new blackboards
     * $pidList contains the storagePid of the selected page for containing the blackboards set on the plugin options
     * $GLOBALS['TSFE']->fe_user->user['uid'] contains the uid of the logged user
     * At the end redirects to the show function on this controller (if controller parameter is null the default is the current controller) searching for the plugin BlackboardsShow on the page $this->blackboardsUidShowPage
     * @param Blackboard Contains a blackboard object sent by the form on the "new" view
     */
    public function createAction(Blackboard $blackboard)
    {
        $pidList = $this->configurationManager->getConfiguration(
            \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK
        )['persistence']['storagePid'];
        $blackboard->setPid($pidList);
        $blackboard->setUser($GLOBALS['TSFE']->fe_user->user['uid']);
        $this->blackboardRepository->add($blackboard);
        $this->persistenceManager->persistAll();
    }

    /**
     * Displaying the view with the form for editing a blackboard
     * 
     * @param Blackboard Contains the blackboard set by the link in the "show" view
     */
    public function editAction(Blackboard $blackboard)
    {
        $categories = $this->categoryRepository->findByParent($this->blackboardsParentCategorie);
        $this->view->assign('blackboard', $blackboard);
        $this->view->assign('categories', $categories);
    }

    /**
     * The action called by the form on "edit" view to update a blackboard
     * $pidList contains the page id of the page storage for blackboards
     * $GLOBALS['TSFE']->fe_user->user['uid'] contains the id of the logged user
     * $_POST['tx_willsblackboards_blackboardsshow']['fileReferenceUid'] contains the id of the file reference linked to that blackboard to delete the reference of the previous image after setting the new one.
     * The comment are the actions to take to delete, besides the reference, the actuall previous file image
     * @param Blackboard Contains the blackboard object sent by the form on "edit" view
     */
    public function updateAction(Blackboard $blackboard)
    {
        $pidList = $this->configurationManager->getConfiguration(
            \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK
        )['persistence']['storagePid'];
        $blackboard->setPid($pidList);
        $blackboard->setUser($GLOBALS['TSFE']->fe_user->user['uid']);
        $this->blackboardRepository->update($blackboard);
        if(isset($_POST['tx_willsblackboards_blackboardsshow']['fileReferenceUid']))
        {
            // Deleteing the previous file after updating
            /*$fileRepository = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Resource\FileRepository::class);
            $fileReference = $fileRepository->findByRelation('tx_willsblackboards_domain_model_blackboard', 'image', $blackboard->getUid());
            $file = $fileReference[0]->getOriginalFile();
            $file->getStorage()->deleteFile($file);*/
            $this->blackboardRepository->deleteImage($_POST['tx_willsblackboards_blackboardsshow']['fileReferenceUid']);
        }
        $this->redirect(
            'show',
            'Blackboards',
            'WillsBlackboards',
            [
                'blackboard' => $blackboard
            ]
        );
    }

    /**
     * Display the view with the form to edit the image file of a blackboard
     * @param Blackboard Contains the blackboard object sent by the form on "edit" view
     */
    public function imageEditAction(Blackboard $blackboard, int $fileReferenceUid)
    {
        $this->view->assign('blackboard', $blackboard);
        $this->view->assign('fileReferenceUid', $fileReferenceUid);
    }

    /**
     * Action of deleteing a blackboard
     * @param Blackboard Contains the blackboard object sent by the form on "edit" view
     */
    public function deleteAction(Blackboard $blackboard)
    {
        $this->blackboardRepository->remove($blackboard);
        $this->redirect('list');
    }
}