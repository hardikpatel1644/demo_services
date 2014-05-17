<?php

namespace Ixoil\UserBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="ixoil_user_subscription_price")
 * 
 */
class SubscriptionPrice
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** 
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $name;

    /** 
     * @ORM\Column(type="integer", nullable=false)
     */
    private $duration;

    /** 
     * @ORM\Column(type="float", nullable=false)
     */
    private $price;

    /** 
     * @ORM\ManyToOne(targetEntity="Ixoil\UserBundle\Entity\Subscription", inversedBy="prices")
     * @ORM\JoinColumn(name="subscription_id", referencedColumnName="id")
     */
    private $subscription;

    /** 
     * @ORM\ManyToOne(targetEntity="Ixoil\UserBundle\Entity\SubscriptionOption", inversedBy="prices")
     * @ORM\JoinColumn(name="subscription_option_id", referencedColumnName="id")
     */
    private $subscriptionOption;

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
     * Set name
     *
     * @param string $name
     * @return SubscriptionPrice
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
     * Set duration
     *
     * @param integer $duration
     * @return SubscriptionPrice
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return integer 
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set price
     *
     * @param float $price
     * @return SubscriptionPrice
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set subscription
     *
     * @param \Ixoil\UserBundle\Entity\Subscription $subscription
     * @return SubscriptionPrice
     */
    public function setSubscription(\Ixoil\UserBundle\Entity\Subscription $subscription = null)
    {
        $this->subscription = $subscription;

        return $this;
    }

    /**
     * Get subscription
     *
     * @return \Ixoil\UserBundle\Entity\Subscription 
     */
    public function getSubscription()
    {
        return $this->subscription;
    }

    /**
     * Set subscriptionOption
     *
     * @param \Ixoil\UserBundle\Entity\SubscriptionOption $subscriptionOption
     * @return SubscriptionPrice
     */
    public function setSubscriptionOption(\Ixoil\UserBundle\Entity\SubscriptionOption $subscriptionOption = null)
    {
        $this->subscriptionOption = $subscriptionOption;

        return $this;
    }

    /**
     * Get subscriptionOption
     *
     * @return \Ixoil\UserBundle\Entity\SubscriptionOption 
     */
    public function getSubscriptionOption()
    {
        return $this->subscriptionOption;
    }
    
    /**
     * Return subscription price name
     * 
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }
}
