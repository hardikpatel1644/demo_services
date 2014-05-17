<?php

namespace Ixoil\UserBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;
use \Doctrine\Common\Collections\ArrayCollection;

/** 
 * @ORM\Entity
 * @ORM\Table(name="ixoil_user_subscription_option")
 */
class SubscriptionOption
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
     * @ORM\OneToMany(
     *     targetEntity="Ixoil\UserBundle\Entity\SubscriptionPrice", 
     *     mappedBy="subscriptionOption", 
     *     orphanRemoval=true, 
     *     cascade={"all"}
     * )
     */
    private $prices;

    /** 
     * @ORM\ManyToMany(targetEntity="Ixoil\UserBundle\Entity\Subscription", inversedBy="options")
     * @ORM\JoinTable(
     *     name="ixoil_user_subscription2subscription_option", 
     *     joinColumns={@ORM\JoinColumn(name="subscription_option_id", referencedColumnName="id", nullable=false)}, 
     *     inverseJoinColumns={@ORM\JoinColumn(name="subscription_id", referencedColumnName="id", nullable=false)}
     * )
     */
    private $subscriptions;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->prices = new ArrayCollection();
        $this->subscriptions = new ArrayCollection();
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
     * @return SubscriptionOption
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
     * @return SubscriptionOption
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
     * Add account
     *
     * @param \Ixoil\UserBundle\Entity\Account $account
     * @return SubscriptionOption
     */
    public function addAccount(\Ixoil\UserBundle\Entity\Account $account)
    {
        $this->accounts[] = $account;

        return $this;
    }

    /**
     * Remove account
     *
     * @param \Ixoil\UserBundle\Entity\Account $account
     */
    public function removeAccount(\Ixoil\UserBundle\Entity\Account $account)
    {
        $this->accounts->removeElement($account);
    }

    /**
     * Get accounts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAccounts()
    {
        return $this->accounts;
    }

    /**
     * Add prices
     *
     * @param \Ixoil\UserBundle\Entity\SubscriptionPrice $prices
     * @return SubscriptionOption
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
     * Add subscriptions
     *
     * @param \Ixoil\UserBundle\Entity\Subscription $subscriptions
     * @return SubscriptionOption
     */
    public function addSubscription(\Ixoil\UserBundle\Entity\Subscription $subscriptions)
    {
        $this->subscriptions[] = $subscriptions;

        return $this;
    }

    /**
     * Remove subscriptions
     *
     * @param \Ixoil\UserBundle\Entity\Subscription $subscriptions
     */
    public function removeSubscription(\Ixoil\UserBundle\Entity\Subscription $subscriptions)
    {
        $this->subscriptions->removeElement($subscriptions);
    }

    /**
     * Get subscriptions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSubscriptions()
    {
        return $this->subscriptions;
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
