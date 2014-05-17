<?php

namespace Ixoil\UserBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity(repositoryClass="Ixoil\UserBundle\Repository\NotificationRepository")
 * @ORM\Table(name="ixoil_user_notification")
 */
class Notification
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** 
     * @ORM\Column(type="string", nullable=false)
     */
    private $code;

    /** 
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $arguments;

    /** 
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $deletable;

    /** 
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $created_at;

    /** 
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $read_at;

    /** 
     * @ORM\ManyToOne(targetEntity="Ixoil\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;

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
     * Set code
     *
     * @param string $code
     * @return Notification
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set arguments
     *
     * @param array $arguments
     * @return Notification
     */
    public function setArguments($arguments)
    {
        $this->arguments = $arguments;

        return $this;
    }

    /**
     * Get arguments
     *
     * @return array 
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * Set deletable
     *
     * @param boolean $deletable
     * @return Notification
     */
    public function setDeletable($deletable)
    {
        $this->deletable = $deletable;

        return $this;
    }

    /**
     * Get deletable
     *
     * @return boolean 
     */
    public function getDeletable()
    {
        return $this->deletable;
    }

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return Notification
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;

        return $this;
    }

    /**
     * Get created_at
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set read_at
     *
     * @param \DateTime $readAt
     * @return Notification
     */
    public function setReadAt($readAt)
    {
        $this->read_at = $readAt;

        return $this;
    }

    /**
     * Get read_at
     *
     * @return \DateTime 
     */
    public function getReadAt()
    {
        return $this->read_at;
    }

    /**
     * Set user
     *
     * @param \Ixoil\UserBundle\Entity\User $user
     * @return Notification
     */
    public function setUser(\Ixoil\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Ixoil\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}
