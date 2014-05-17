<?php

namespace Ixoil\PurchaserBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="ixoil_purchaser_agency_group")
 */
class GroupAgency
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** 
     * @ORM\ManyToOne(targetEntity="Ixoil\PurchaserBundle\Entity\Agency", inversedBy="groupAgencies")
     * @ORM\JoinColumn(name="agency_id", referencedColumnName="id", nullable=false)
     */
    private $agency;

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
     * Set agency
     *
     * @param \Ixoil\PurchaserBundle\Entity\Agency $agency
     * @return GroupAgency
     */
    public function setAgency(\Ixoil\PurchaserBundle\Entity\Agency $agency)
    {
        $this->agency = $agency;

        return $this;
    }

    /**
     * Get agency
     *
     * @return \Ixoil\PurchaserBundle\Entity\Agency 
     */
    public function getAgency()
    {
        return $this->agency;
    }
}
