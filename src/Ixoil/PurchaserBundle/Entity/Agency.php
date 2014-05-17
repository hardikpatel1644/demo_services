<?php

namespace Ixoil\PurchaserBundle\Entity;

use \Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="ixoil_purchaser_agency")
 */
class Agency
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
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $delivery_contact;

    /** 
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $file_tipp;

    /** 
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $delivery_type;

    /** 
     * @ORM\Column(type="integer", nullable=false)
     */
    private $annual_volume;

    /** 
     * @ORM\OneToOne(targetEntity="Ixoil\CoreBundle\Entity\Address")
     * @ORM\JoinColumn(name="agency_address_id", referencedColumnName="id", nullable=false, unique=true)
     */
    private $address;

    /** 
     * @ORM\OneToOne(targetEntity="Ixoil\CoreBundle\Entity\Address")
     * @ORM\JoinColumn(name="delivery_address_id", referencedColumnName="id", nullable=false, unique=true)
     */
    private $deliveryAddress;

    /** 
     * @ORM\OneToMany(targetEntity="Ixoil\PurchaserBundle\Entity\Tank", mappedBy="agency")
     */
    private $tanks;

    /** 
     * @ORM\OneToMany(targetEntity="Ixoil\PurchaserBundle\Entity\SelfAgency", mappedBy="agency")
     */
    private $selfAgencies;

    /** 
     * @ORM\OneToMany(targetEntity="Ixoil\PurchaserBundle\Entity\GroupAgency", mappedBy="agency")
     */
    private $groupAgencies;

    /** 
     * @ORM\ManyToOne(targetEntity="Ixoil\UserBundle\Entity\PurchaserAccount", inversedBy="agencies")
     * @ORM\JoinColumn(name="account_id", referencedColumnName="account_id", nullable=false)
     */
    private $purchaserAccount;

    /** 
     * @ORM\ManyToMany(targetEntity="Ixoil\UserBundle\Entity\User")
     * @ORM\JoinTable(
     *     name="ixoil_purchaser_user2agency", 
     *     joinColumns={@ORM\JoinColumn(name="agency_id", referencedColumnName="id", nullable=false)}, 
     *     inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)}
     * )
     */
    private $users;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tanks = new ArrayCollection();
        $this->selfAgencies = new ArrayCollection();
        $this->groupAgencies = new ArrayCollection();
        $this->users = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Agency
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
     * Set address
     *
     * @param \Ixoil\CoreBundle\Entity\Address $address
     * @return Agency
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
     * Set deliveryAddress
     *
     * @param \Ixoil\CoreBundle\Entity\Address $deliveryAddress
     * @return Agency
     */
    public function setDeliveryAddress(\Ixoil\CoreBundle\Entity\Address $deliveryAddress)
    {
        $this->deliveryAddress = $deliveryAddress;

        return $this;
    }

    /**
     * Get deliveryAddress
     *
     * @return \Ixoil\CoreBundle\Entity\Address 
     */
    public function getDeliveryAddress()
    {
        return $this->deliveryAddress;
    }

    /**
     * Set purchaserAccount
     *
     * @param \Ixoil\UserBundle\Entity\PurchaserAccount $purchaserAccount
     * @return Agency
     */
    public function setPurchaserAccount(\Ixoil\UserBundle\Entity\PurchaserAccount $purchaserAccount)
    {
        $this->purchaserAccount = $purchaserAccount;

        return $this;
    }

    /**
     * Get purchaserAccount
     *
     * @return \Ixoil\UserBundle\Entity\PurchaserAccount 
     */
    public function getPurchaserAccount()
    {
        return $this->purchaserAccount;
    }


    /**
     * Set delivery_contact
     *
     * @param string $deliveryContact
     * @return Agency
     */
    public function setDeliveryContact($deliveryContact)
    {
        $this->delivery_contact = $deliveryContact;

        return $this;
    }

    /**
     * Get delivery_contact
     *
     * @return string 
     */
    public function getDeliveryContact()
    {
        return $this->delivery_contact;
    }

    /**
     * Set delivery_type
     *
     * @param string $deliveryType
     * @return Agency
     */
    public function setDeliveryType($deliveryType)
    {
        $this->delivery_type = $deliveryType;

        return $this;
    }

    /**
     * Get delivery_type
     *
     * @return string 
     */
    public function getDeliveryType()
    {
        return $this->delivery_type;
    }

    /**
     * Set annual_volume
     *
     * @param integer $annualVolume
     * @return Agency
     */
    public function setAnnualVolume($annualVolume)
    {
        $this->annual_volume = $annualVolume;

        return $this;
    }

    /**
     * Get annual_volume
     *
     * @return integer 
     */
    public function getAnnualVolume()
    {
        return $this->annual_volume;
    }

    /**
     * Add tanks
     *
     * @param \Ixoil\PurchaserBundle\Entity\Tank $tanks
     * @return Agency
     */
    public function addTank(\Ixoil\PurchaserBundle\Entity\Tank $tanks)
    {
        $this->tanks[] = $tanks;

        return $this;
    }

    /**
     * Remove tanks
     *
     * @param \Ixoil\PurchaserBundle\Entity\Tank $tanks
     */
    public function removeTank(\Ixoil\PurchaserBundle\Entity\Tank $tanks)
    {
        $this->tanks->removeElement($tanks);
    }

    /**
     * Get tanks
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTanks()
    {
        return $this->tanks;
    }

    /**
     * Add selfAgencies
     *
     * @param \Ixoil\PurchaserBundle\Entity\SelfAgency $selfAgencies
     * @return Agency
     */
    public function addSelfAgency(\Ixoil\PurchaserBundle\Entity\SelfAgency $selfAgencies)
    {
        $this->selfAgencies[] = $selfAgencies;

        return $this;
    }

    /**
     * Remove selfAgencies
     *
     * @param \Ixoil\PurchaserBundle\Entity\SelfAgency $selfAgencies
     */
    public function removeSelfAgency(\Ixoil\PurchaserBundle\Entity\SelfAgency $selfAgencies)
    {
        $this->selfAgencies->removeElement($selfAgencies);
    }

    /**
     * Get selfAgencies
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSelfAgencies()
    {
        return $this->selfAgencies;
    }

    /**
     * Add groupAgencies
     *
     * @param \Ixoil\PurchaserBundle\Entity\GroupAgency $groupAgencies
     * @return Agency
     */
    public function addGroupAgency(\Ixoil\PurchaserBundle\Entity\GroupAgency $groupAgencies)
    {
        $this->groupAgencies[] = $groupAgencies;

        return $this;
    }

    /**
     * Remove groupAgencies
     *
     * @param \Ixoil\PurchaserBundle\Entity\GroupAgency $groupAgencies
     */
    public function removeGroupAgency(\Ixoil\PurchaserBundle\Entity\GroupAgency $groupAgencies)
    {
        $this->groupAgencies->removeElement($groupAgencies);
    }

    /**
     * Get groupAgencies
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGroupAgencies()
    {
        return $this->groupAgencies;
    }

    /**
     * Add user
     *
     * @param \Ixoil\UserBundle\Entity\User $user
     * @return Agency
     */
    public function addUser(\Ixoil\UserBundle\Entity\User $user)
    {
        $this->user[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \Ixoil\UserBundle\Entity\User $user
     */
    public function removeUser(\Ixoil\UserBundle\Entity\User $user)
    {
        $this->user->removeElement($user);
    }

    /**
     * Get user
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Set file_tipp
     *
     * @param string $fileTipp
     * @return Agency
     */
    public function setFileTipp($fileTipp)
    {
        $this->file_tipp = $fileTipp;

        return $this;
    }

    /**
     * Get file_tipp
     *
     * @return string 
     */
    public function getFileTipp()
    {
        return $this->file_tipp;
    }
}
