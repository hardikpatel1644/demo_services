<?php

namespace Ixoil\UserBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;
use \Doctrine\Common\Collections\ArrayCollection;

/** 
 * @ORM\Entity
 * @ORM\Table(name="ixoil_user_subscription")
 */
class Subscription
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** 
     * @ORM\Column(type="string", unique=true, nullable=false)
     */
    private $code;

    /** 
     * @ORM\Column(type="string", nullable=false)
     */
    private $name;

    /** 
     * @ORM\Column(type="string", nullable=false)
     */
    private $account_type;

    /** 
     * @ORM\ManyToMany(targetEntity="Ixoil\UserBundle\Entity\SubscriptionOption", mappedBy="subscriptions")
     */
    private $options;

    /** 
     * @ORM\OneToMany(
     *     targetEntity="Ixoil\UserBundle\Entity\SubscriptionPrice", 
     *     mappedBy="subscription", 
     *     orphanRemoval=true, 
     *     cascade={"all"}
     * )
     */
    private $prices;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->options = new ArrayCollection();
        $this->prices = new ArrayCollection();
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
     * Set code
     *
     * @param string $code
     * @return Subscription
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
     * Set name
     *
     * @param string $name
     * @return Subscription
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set account_type
     *
     * @param string $accountType
     * @return Subscription
     */
    public function setAccountType($accountType)
    {
        $this->account_type = $accountType;

        return $this;
    }

    /**
     * Get account_type
     *
     * @return string 
     */
    public function getAccountType()
    {
        return $this->account_type;
    }

    /**
     * Add options
     *
     * @param \Ixoil\UserBundle\Entity\SubscriptionOption $options
     * @return Subscription
     */
    public function addOption(\Ixoil\UserBundle\Entity\SubscriptionOption $options)
    {
        $this->options[] = $options;

        return $this;
    }

    /**
     * Remove options
     *
     * @param \Ixoil\UserBundle\Entity\SubscriptionOption $options
     */
    public function removeOption(\Ixoil\UserBundle\Entity\SubscriptionOption $options)
    {
        $this->options->removeElement($options);
    }

    /**
     * Get options
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Add prices
     *
     * @param \Ixoil\UserBundle\Entity\SubscriptionPrice $prices
     * @return Subscription
     */
    public function addPrice(\Ixoil\UserBundle\Entity\SubscriptionPrice $prices)
    {
        $this->prices[] = $prices;

        return $this;
    }

    /**
     * Remove prices
     *
     * @param \Ixoil\UserBundle\Entity\SubscriptionPrice $prices
     */
    public function removePrice(\Ixoil\UserBundle\Entity\SubscriptionPrice $prices)
    {
        $this->prices->removeElement($prices);
    }

    /**
     * Get prices
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPrices()
    {
        return $this->prices;
    }
    
    /**
     * Return subscription name
     * 
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }
}
