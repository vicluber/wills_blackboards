<?php

namespace Wills\WillsBlackboards\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Domain\Model\Category;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Wills\WillsBlackboards\Domain\Model\FrontendUser;

class Blackboard extends AbstractEntity
{
    /**
     * crdate
     * 
     * @var int
     */
    protected $crdate;
    
    /**
     * title
     * 
     * @var string
     */
    protected $title = '';

    /**
     * description
     * 
     * @var string
     */
    protected $description = '';

    /**
     * The category of the idea
     *
     * @var Category
     */
    protected $category;

    /**
     * user
     * 
     * @var FrontendUser
     */
    protected $user = null;

    /**
     * image
     * 
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $image = null;

    /**
     * phone number
     * 
     * @var string
     */
    protected $phoneNumber = '';

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
     * Sets the title
     * 
     * @param string $title
     * @return void
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Returns the title
     * 
     * @return string $title
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Sets the description
     * 
     * @param string $description
     * @return void
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * Returns the description
     * 
     * @return string $description
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Sets the category
     * 
     * @param TYPO3\CMS\Extbase\Domain\Model\Category The category of the idea
     */
    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }

    /**
     * Returns the category of the idea
     *
     * @return TYPO3\CMS\Extbase\Domain\Model\Category The category of the idea
     */
    public function getCategory()
    {
        return $this->category;
    }

    
    /**
     * Sets the status
     * 
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * Returns the status
     * 
     * @return int $status
     */
    public function getStatus(): int
    {
        return $this->status;
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
     * Returns the image
     * 
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Sets the image
     * 
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
     * @return void
     */
    public function setImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $image = null)
    {
        $this->image = $image;
    }

    /**
     * Sets the phone number
     * 
     * @param string $phoneNumber
     * @return void
     */
    public function setPhoneNumber(string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * Returns the phone number
     * 
     * @return string $phoneNumber
     */
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }
}