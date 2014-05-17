<?php

namespace Ixoil\UserBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="ixoil_user_subscription_option2account")
 * 
 */
class SubscriptionOptionToAccount
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
     * @ORM\ManyToOne(targetEntity="Ixoil\UserBundle\Entity\Account")
     * @ORM\JoinColumn(name="account_id", referencedColumnName="id", nullable=false)
     */
    private $account;

    /** 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Ixoil\UserBundle\Entity\SubscriptionOption")
     * @ORM\JoinColumn(name="subscription_option_id", referencedColumnName="id", nullable=false)
     */
    private $subscriptionOption;

    /**
     * Set start_date
     *
     * @param \DateTime $startDate
     * @return SubscriptionOptionToAccount
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
     * @return SubscriptionOptionToAccount
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
     * Set account
     *
     * @param \Ixoil\UserBundle\Entity\Account $account
     * @return SubscriptionOptionToAccount
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

    /**
     * Set subscriptionOption
     *
     * @param \Ixoil\UserBundle\Entity\SubscriptionOption $subscriptionOption
     * @return SubscriptionOptionToAccount
     */
    public function setSubscriptionOption(\Ixoil\UserBundle\Entity\SubscriptionOption $subscriptionOption)
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
}
