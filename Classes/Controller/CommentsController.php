<?php

namespace Wills\WillsBlackboards\Controller;

use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Wills\WillsBlackboards\Domain\Repository\CommentRepository;
use Wills\WillsBlackboards\Domain\Model\Comment;

/**
 * CommentsController
 */
class CommentsController extends ActionController
{
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
     * Action that creates the comment sent by the form on blackboard "show" view
     * $pidList holds the id of the storage for the comments
     * $GLOBALS['TSFE']->fe_user->user['uid'] holds the id of the logged user
     * @param Comment
     */
    public function createCommentAction(Comment $comment)
    {
        $pidList = $this->configurationManager->getConfiguration(
            \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK
        )['persistence']['storagePid'];
        $comment->setPid($pidList);
        $comment->setUser($GLOBALS['TSFE']->fe_user->user['uid']);
        $this->commentRepository->add($comment);
        $this->redirect('show', 'Blackboards', 'WillsBlackboards', ['blackboard' => $comment->getBlackboard()]);
    }

    /**
     * Action that deletes the comment
     * $blackboard holds the blackboard which is related to the comment
     * @param Comment Comment object sent by the link.action on the ListItem.html for each comment
     */
    public function deleteAction(Comment $comment)
    {
        $blackboard = $comment->getBlackboard();
        $this->commentRepository->remove($comment);
        $this->view->assign('comments', $comments);
        $this->redirect('show', 'Blackboards', NULL, ['blackboard' => $blackboard]);
    }
}