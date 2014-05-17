<?php

namespace Ixoil\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Ixoil\UserBundle\Model\AccountType;
use Sonata\UserBundle\Entity\BaseUser as BaseUser;
use Doctrine\ORM\Mapping AS ORM;
use FOS\UserBundle\Model\GroupInterface;

/** 
 * @ORM\Entity(repositoryClass="Ixoil\UserBundle\Repository\UserRepository")
 * @ORM\Table(name="ixoil_user_user")
 */
class User extends BaseUser
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /** 
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $is_owner = false;

    /** 
     * @ORM\ManyToOne(targetEntity="Ixoil\UserBundle\Entity\Account", inversedBy="users")
     * @ORM\JoinColumn(name="account_id", referencedColumnName="id")
     */
    private $account;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $groups;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->groups = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set account
     *
     * @param \Ixoil\UserBundle\Entity\Account $account
     * @return User
     */
    public function setAccount(\Ixoil\UserBundle\Entity\Account $account = null)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * Get account
     *
     * @return \Ixoil\UserBundle\Entity\Account 
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Set is_owner
     *
     * @param boolean $isOwner
     * @return User
     */
    public function setIsOwner($isOwner)
    {
        $this->is_owner = $isOwner;

        return $this;
    }

    /**
     * Get is_owner
     *
     * @return boolean 
     */
    public function getIsOwner()
    {
        return $this->is_owner;
    }

    /**
     * Add groups
     *
     * @param \FOS\UserBundle\Model\GroupInterface $groups
     * @return User
     */
    public function addGroup(GroupInterface $groups)
    {
        $this->groups[] = $groups;

        return $this;
    }

    /**
     * Remove groups
     *
     * @param \FOS\UserBundle\Model\GroupInterface $groups
     */
    public function removeGroup(GroupInterface $groups)
    {
        $this->groups->removeElement($groups);
    }

    /**
     * Get groups
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * Determines the account type
     *
     * @see \Ixoil\UserBundle\Model\AccountType
     * @return string
     */
    public function getAccountType()
    {
        if($this->getAccount()) {
            return $this->getAccount()->getAccountType();
        } else {
            // TODO: Determine if the user is an admin or really an unknown type
            return AccountType::Unknown;
        }
    }
    
    public function getConfirmationToken()
    {
        return $this->confirmationToken;
    }
}
