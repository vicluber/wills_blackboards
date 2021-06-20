<?php

namespace Wills\WillsBlackboards\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use Wills\WillsBlackboards\Domain\Model\Blackboard;
use Wills\WillsBlackboards\Domain\Model\FrontendUser;

class Comment extends AbstractEntity
{
    /**
     * crdate
     * 
     * @var int
     */
    protected $crdate;

    /**
     * text
     * 
     * @var string
     */
    protected $text = '';

    /**
     * The blackboard in which the comment is being made
     *
     * @var Blackboard
     */
    protected $blackboard;

    /**
     * user
     * 
     * @var FrontendUser
     */
    protected $user = null;

    /**
     * Sets the crdate
     * 
     * @param int $crdate
     */
    public function setCrdate(int $crdate): void
    {
        $this->crdate = $crdate;
    }

    /**
     * Returns the crdate
     * 
     * @return int $crdate
     */
    public function getCrdate(): int
    {
        return $this->crdate;
    }

    /**
     * Sets the text
     * 
     * @param string $text
     * @return void
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * Returns the text
     * 
     * @return string $text
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * Sets the blackboard for this comment
     * 
     * @param Blackboard
     */
    public function setBlackboard(Blackboard $blackboard): void
    {
        $this->blackboard = $blackboard;
    }

    /**
     * Returns the blackboard of the comment
     *
     * @return Blackboard
     */
    public function getBlackboard()
    {
        return $this->blackboard;
    }

    /**
     * Sets the user
     * 
     * @param FrontendUser
     */
    public function setUser(int $user): void
    {
        $this->user = $user;
    }

    /**
     * Returns the user
     * 
     * @return FrontendUser
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Returns true if this comment belongs to the logged user
     * @return bool
     */
    public function isOwner() : bool
    {
        if($this->getUser()->getUid() == $GLOBALS['TSFE']->fe_user->user['uid'])
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    
}