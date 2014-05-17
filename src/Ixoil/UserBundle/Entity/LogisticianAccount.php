<?php

namespace Ixoil\UserBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="ixoil_user_account_logistician")
 */
class LogisticianAccount
{
    /** 
     * @ORM\Column(type="array", nullable=false)
     */
    private $delivery_areas;

    /** 
     * @ORM\OneToOne(targetEntity="Ixoil\UserBundle\Entity\Account", inversedBy="logisticianAccount")
     * @ORM\JoinColumn(name="account_id", referencedColumnName="id", nullable=false, unique=true)
     * @ORM\Id
     */
    private $account;

    /**
     * Set delivery_areas
     *
     * @param array $deliveryAreas
     * @return LogisticianAccount
     */
    public function setDeliveryAreas($deliveryAreas)
    {
        $this->delivery_areas = $deliveryAreas;

        return $this;
    }

    /**
     * Get delivery_areas
     *
     * @return array 
     */
    public function getDeliveryAreas()
    {
        return $this->delivery_areas;
    }

    /**
     * Set account
     *
     * @param \Ixoil\UserBundle\Entity\Account $account
     * @return LogisticianAccount
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
