<?php

namespace Ixoil\PurchaserBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="ixoil_purchaser_agency_billing")
 */
class AgencyBilling
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
    private $preferred_payment;

    /** 
     * @ORM\Column(type="array", nullable=false)
     */
    private $preferred_terms;

    /** 
     * @ORM\ManyToOne(targetEntity="Ixoil\CoreBundle\Entity\Address")
     * @ORM\JoinColumn(name="address_id", referencedColumnName="id", nullable=false)
     */
    private $address;

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
     * Set preferred_payment
     *
     * @param string $preferredPayment
     * @return AgencyBilling
     */
    public function setPreferredPayment($preferredPayment)
    {
        $this->preferred_payment = $preferredPayment;

        return $this;
    }

    /**
     * Get preferred_payment
     *
     * @return string 
     */
    public function getPreferredPayment()
    {
        return $this->preferred_payment;
    }

    /**
     * Set address
     *
     * @param \Ixoil\CoreBundle\Entity\Address $address
     * @return AgencyBilling
     */
    public function setAddress(\Ixoil\CoreBundle\Entity\Address $address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return \Ixoil\CoreBundle\Entity\Address 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set preferred_terms
     *
     * @param array $preferredTerms
     * @return AgencyBilling
     */
    public function setPreferredTerms($preferredTerms)
    {
        $this->preferred_terms = $preferredTerms;

        return $this;
    }

    /**
     * Get preferred_terms
     *
     * @return array 
     */
    public function getPreferredTerms()
    {
        return $this->preferred_terms;
    }
}
