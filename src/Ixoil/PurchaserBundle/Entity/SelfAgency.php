<?php
namespace Ixoil\PurchaserBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="ixoil_purchaser_agency_self")
 */
class SelfAgency
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** 
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    private $company_number;

    /** 
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    private $vat_number;

    /** 
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $file_bank_statement;

    /** 
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $file_certificate_incorporation;

    /** 
     * @ORM\OneToMany(targetEntity="Ixoil\PurchaserBundle\Entity\ProviderRelation", mappedBy="agency")
     */
    private $purchaserRelations;

    /** 
     * @ORM\ManyToOne(targetEntity="Ixoil\PurchaserBundle\Entity\Agency", inversedBy="selfAgencies")
     * @ORM\JoinColumn(name="agency_id", referencedColumnName="id", nullable=false)
     */
    private $agency;

    /** 
     * @ORM\ManyToOne(targetEntity="Ixoil\PurchaserBundle\Entity\AgencyBilling")
     * @ORM\JoinColumn(name="agency_billing_id", referencedColumnName="id", nullable=false)
     */
    private $billingDetails;
}