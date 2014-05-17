<?php

namespace Ixoil\UserBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity(repositoryClass="Ixoil\UserBundle\Repository\SubscriptionToAccountRepository")
 * @ORM\Table(name="ixoil_user_subscription2account")
 */
class SubscriptionToAccount
{
    /** 
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $start_date;

    /** 
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $end_date;

    /** 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Ixoil\UserBundle\Entity\Subscription")
     * @ORM\JoinColumn(name="subscription_id", referencedColumnName="id", nullable=false)
     */
    private $subscription;

    /** 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Ixoil\UserBundle\Entity\Account")
     * @ORM\JoinColumn(name="account_id", referencedColumnName="id", nullable=false)
     */
    private $account;

    /**
     * Set start_date
     *
     * @param \DateTime $startDate
     * @return SubscriptionToAccount
     */
    public function setStartDate($startDate)
    {
        $this->start_date = $startDate;

        return $this;
    }

    /**
     * Get start_date
     *
     * @return \DateTime 
     */
    public function getStartDate()
    {
        return $this->start_date;
    }

    /**
     * Set end_date
     *
     * @param \DateTime $endDate
     * @return SubscriptionToAccount
     */
    public function setEndDate($endDate)
    {
        $this->end_date = $endDate;

        return $this;
    }

    /**
     * Get end_date
     *
     * @return \DateTime 
     */
    public function getEndDate()
    {
        return $this->end_date;
    }

    /**
     * Set subscription
     *
     * @param \Ixoil\UserBundle\Entity\Subscription $subscription
     * @return SubscriptionToAccount
     */
    public function setSubscription(\Ixoil\UserBundle\Entity\Subscription $subscription)
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
     * Set account
     *
     * @param \Ixoil\UserBundle\Entity\Account $account
     * @return SubscriptionToAccount
     */
    public function setAccount(\Ixoil\UserBundle\Entity\Account $account)
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
}
