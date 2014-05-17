<?php
namespace Ixoil\PurchaserBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="ixoil_purchaser_provider_relation")
 */
class ProviderRelation
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** 
     * @ORM\Column(type="decimal", nullable=false)
     */
    private $default_outstanding;

    /** 
     * @ORM\Column(type="decimal", nullable=false)
     */
    private $current_outstanding;

    /** 
     * @ORM\ManyToOne(targetEntity="Ixoil\PurchaserBundle\Entity\SelfAgency", inversedBy="purchaserRelations")
     * @ORM\JoinColumn(name="self_agency_id", referencedColumnName="id")
     */
    private $agency;

    /** 
     * @ORM\ManyToOne(targetEntity="Ixoil\UserBundle\Entity\PurchaserAccount", inversedBy="providerRelations")
     * @ORM\JoinColumn(name="purchaser_account_id", referencedColumnName="account_id")
     */
    private $purchaser;

    /** 
     * @ORM\ManyToOne(targetEntity="Ixoil\UserBundle\Entity\ProviderAccount")
     * @ORM\JoinColumn(name="provider_account_id", referencedColumnName="account_id", nullable=false)
     */
    private $provider;

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
     * Set default_outstanding
     *
     * @param string $defaultOutstanding
     * @return ProviderRelation
     */
    public function setDefaultOutstanding($defaultOutstanding)
    {
        $this->default_outstanding = $defaultOutstanding;

        return $this;
    }

    /**
     * Get default_outstanding
     *
     * @return string 
     */
    public function getDefaultOutstanding()
    {
        return $this->default_outstanding;
    }

    /**
     * Set current_outstanding
     *
     * @param string $currentOutstanding
     * @return ProviderRelation
     */
    public function setCurrentOutstanding($currentOutstanding)
    {
        $this->current_outstanding = $currentOutstanding;

        return $this;
    }

    /**
     * Get current_outstanding
     *
     * @return string 
     */
    public function getCurrentOutstanding()
    {
        return $this->current_outstanding;
    }

    /**
     * Set agency
     *
     * @param \Ixoil\PurchaserBundle\Entity\SelfAgency $agency
     * @return ProviderRelation
     */
    public function setAgency(\Ixoil\PurchaserBundle\Entity\SelfAgency $agency = null)
    {
        $this->agency = $agency;

        return $this;
    }

    /**
     * Get agency
     *
     * @return \Ixoil\PurchaserBundle\Entity\SelfAgency 
     */
    public function getAgency()
    {
        return $this->agency;
    }

    /**
     * Set purchaser
     *
     * @param \Ixoil\UserBundle\Entity\PurchaserAccount $purchaser
     * @return ProviderRelation
     */
    public function setPurchaser(\Ixoil\UserBundle\Entity\PurchaserAccount $purchaser = null)
    {
        $this->purchaser = $purchaser;

        return $this;
    }

    /**
     * Get purchaser
     *
     * @return \Ixoil\UserBundle\Entity\PurchaserAccount 
     */
    public function getPurchaser()
    {
        return $this->purchaser;
    }

    /**
     * Set provider
     *
     * @param \Ixoil\UserBundle\Entity\ProviderAccount $provider
     * @return ProviderRelation
     */
    public function setProvider(\Ixoil\UserBundle\Entity\ProviderAccount $provider)
    {
        $this->provider = $provider;

        return $this;
    }

    /**
     * Get provider
     *
     * @return \Ixoil\UserBundle\Entity\ProviderAccount 
     */
    public function getProvider()
    {
        return $this->provider;
    }
}
