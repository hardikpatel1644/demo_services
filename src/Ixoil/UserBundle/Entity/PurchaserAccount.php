<?php

namespace Ixoil\UserBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;
use \Doctrine\Common\Collections\ArrayCollection;

/** 
 * @ORM\Entity
 * @ORM\Table(name="ixoil_user_account_purchaser")
 */
class PurchaserAccount
{
    /** 
     * @ORM\Column(type="array", nullable=false)
     */
    private $activities;

    /** 
     * @ORM\OneToOne(targetEntity="Ixoil\UserBundle\Entity\Account", inversedBy="purchaserAccount")
     * @ORM\JoinColumn(name="account_id", referencedColumnName="id", nullable=false, unique=true)
     * @ORM\Id
     */
    private $account;

    /** 
     * @ORM\OneToMany(targetEntity="Ixoil\PurchaserBundle\Entity\Agency", mappedBy="purchaserAccount")
     */
    private $agencies;

    /** 
     * @ORM\OneToMany(targetEntity="Ixoil\PurchaserBundle\Entity\ProviderRelation", mappedBy="purchaser")
     */
    private $providerRelations;

    /** 
     * @ORM\ManyToOne(targetEntity="Ixoil\PurchaserBundle\Entity\AgencyBilling")
     * @ORM\JoinColumn(name="agency_billing_id", referencedColumnName="id")
     */
    private $billingDetails;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->agencies = new ArrayCollection();
        $this->activities = new ArrayCollection();
        $this->providerRelations = new ArrayCollection();
    }

    /**
     * Set account
     *
     * @param \Ixoil\UserBundle\Entity\Account $account
     * @return PurchaserAccount
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
     * Add agencies
     *
     * @param \Ixoil\PurchaserBundle\Entity\Agency $agencies
     * @return PurchaserAccount
     */
    public function addAgency(\Ixoil\PurchaserBundle\Entity\Agency $agencies)
    {
        $this->agencies[] = $agencies;

        return $this;
    }

    /**
     * Remove agencies
     *
     * @param \Ixoil\PurchaserBundle\Entity\Agency $agencies
     */
    public function removeAgency(\Ixoil\PurchaserBundle\Entity\Agency $agencies)
    {
        $this->agencies->removeElement($agencies);
    }

    /**
     * Get agencies
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAgencies()
    {
        return $this->agencies;
    }

    /**
     * Set activities
     *
     * @param array $activities
     * @return PurchaserAccount
     */
    public function setActivities($activities)
    {
        $this->activities = $activities;

        return $this;
    }

    /**
     * Get activities
     *
     * @return array 
     */
    public function getActivities()
    {
        return $this->activities;
    }

    /**
     * Set billingDetails
     *
     * @param \Ixoil\PurchaserBundle\Entity\AgencyBilling $billingDetails
     * @return PurchaserAccount
     */
    public function setBillingDetails(\Ixoil\PurchaserBundle\Entity\AgencyBilling $billingDetails)
    {
        $this->billingDetails = $billingDetails;

        return $this;
    }

    /**
     * Get billingDetails
     *
     * @return \Ixoil\PurchaserBundle\Entity\AgencyBilling 
     */
    public function getBillingDetails()
    {
        return $this->billingDetails;
    }

    /**
     * Add providerRelation
     *
     * @param \Ixoil\PurchaserBundle\Entity\ProviderRelation $providerRelation
     * @return PurchaserAccount
     */
    public function addProviderRelation(\Ixoil\PurchaserBundle\Entity\ProviderRelation $providerRelation)
    {
        $this->providerRelations[] = $providerRelation;

        return $this;
    }

    /**
     * Remove providerRelation
     *
     * @param \Ixoil\PurchaserBundle\Entity\ProviderRelation $providerRelation
     */
    public function removeProviderRelation(\Ixoil\PurchaserBundle\Entity\ProviderRelation $providerRelation)
    {
        $this->providerRelations->removeElement($providerRelation);
    }

    /**
     * Get providerRelations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProviderRelations()
    {
        return $this->providerRelations;
    }
}
