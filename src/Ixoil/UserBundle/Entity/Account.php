<?php

namespace Ixoil\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping AS ORM;
use Ixoil\UserBundle\Model\AccountType;

/** 
 * @ORM\Entity
 * @ORM\Table(name="ixoil_user_account")
 */
class Account
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** 
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $is_locked;

    /** 
     * @ORM\Column(type="integer", nullable=false)
     */
    private $status = 0;

    /** 
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $name;

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
     * @ORM\Column(type="decimal", nullable=false)
     */
    private $tos_version;

    /** 
     * @ORM\OneToOne(targetEntity="Ixoil\CoreBundle\Entity\Address")
     * @ORM\JoinColumn(name="address_id", referencedColumnName="id", nullable=false, unique=true)
     */
    private $address;

    /** 
     * @ORM\OneToOne(targetEntity="Ixoil\UserBundle\Entity\ProviderAccount", mappedBy="account")
     */
    private $providerAccount;

    /** 
     * @ORM\OneToOne(targetEntity="Ixoil\UserBundle\Entity\PurchaserAccount", mappedBy="account")
     */
    private $purchaserAccount;

    /** 
     * @ORM\OneToOne(targetEntity="Ixoil\UserBundle\Entity\LogisticianAccount", mappedBy="account")
     */
    private $logisticianAccount;

    /** 
     * @ORM\OneToMany(targetEntity="Ixoil\UserBundle\Entity\User", mappedBy="account")
     */
    private $users;
    
    /**
     * Constructor
     */
    public function __construct()
    {
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
     * @return Account
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
     * Set status
     *
     * @param integer $status
     * @return Account
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set company_number
     *
     * @param string $companyNumber
     * @return Account
     */
    public function setCompanyNumber($companyNumber)
    {
        $this->company_number = $companyNumber;

        return $this;
    }

    /**
     * Get company_number
     *
     * @return string 
     */
    public function getCompanyNumber()
    {
        return $this->company_number;
    }

    /**
     * Set vat_number
     *
     * @param string $vatNumber
     * @return Account
     */
    public function setVatNumber($vatNumber)
    {
        $this->vat_number = $vatNumber;

        return $this;
    }

    /**
     * Get vat_number
     *
     * @return string 
     */
    public function getVatNumber()
    {
        return $this->vat_number;
    }

    /**
     * Set file_bank_statement
     *
     * @param string $fileBankStatement
     * @return Account
     */
    public function setFileBankStatement($fileBankStatement)
    {
        $this->file_bank_statement = $fileBankStatement;

        return $this;
    }

    /**
     * Get file_bank_statement
     *
     * @return string 
     */
    public function getFileBankStatement()
    {
        return $this->file_bank_statement;
    }

    /**
     * Set file_certificate_incorporation
     *
     * @param string $fileCertificateIncorporation
     * @return Account
     */
    public function setFileCertificateIncorporation($fileCertificateIncorporation)
    {
        $this->file_certificate_incorporation = $fileCertificateIncorporation;

        return $this;
    }

    /**
     * Get file_certificate_incorporation
     *
     * @return string 
     */
    public function getFileCertificateIncorporation()
    {
        return $this->file_certificate_incorporation;
    }

    /**
     * Set tos_version
     *
     * @param string $tosVersion
     * @return Account
     */
    public function setTosVersion($tosVersion)
    {
        $this->tos_version = $tosVersion;

        return $this;
    }

    /**
     * Get tos_version
     *
     * @return string 
     */
    public function getTosVersion()
    {
        return $this->tos_version;
    }

    /**
     * Set address
     *
     * @param \Ixoil\CoreBundle\Entity\Address $address
     * @return Account
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
     * Set providerAccount
     *
     * @param \Ixoil\UserBundle\Entity\ProviderAccount $providerAccount
     * @return Account
     */
    public function setProviderAccount(\Ixoil\UserBundle\Entity\ProviderAccount $providerAccount = null)
    {
        $this->providerAccount = $providerAccount;

        return $this;
    }

    /**
     * Get providerAccount
     *
     * @return \Ixoil\UserBundle\Entity\ProviderAccount 
     */
    public function getProviderAccount()
    {
        return $this->providerAccount;
    }

    /**
     * Set purchaserAccount
     *
     * @param \Ixoil\UserBundle\Entity\PurchaserAccount $purchaserAccount
     * @return Account
     */
    public function setPurchaserAccount(\Ixoil\UserBundle\Entity\PurchaserAccount $purchaserAccount = null)
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
     * Set logisticianAccount
     *
     * @param \Ixoil\UserBundle\Entity\LogisticianAccount $logisticianAccount
     * @return Account
     */
    public function setLogisticianAccount(\Ixoil\UserBundle\Entity\LogisticianAccount $logisticianAccount = null)
    {
        $this->logisticianAccount = $logisticianAccount;

        return $this;
    }

    /**
     * Get logisticianAccount
     *
     * @return \Ixoil\UserBundle\Entity\LogisticianAccount
     */
    public function getLogisticianAccount()
    {
        return $this->logisticianAccount;
    }

    /**
     * Set is_locked
     *
     * @param boolean $isLocked
     * @return Account
     */
    public function setIsLocked($isLocked)
    {
        $this->is_locked = $isLocked;

        return $this;
    }

    /**
     * Get is_locked
     *
     * @return boolean 
     */
    public function getIsLocked()
    {
        return $this->is_locked;
    }

    /**
     * Add users
     *
     * @param \Ixoil\UserBundle\Entity\User $users
     * @return Account
     */
    public function addUser(\Ixoil\UserBundle\Entity\User $users)
    {
        $this->users[] = $users;

        return $this;
    }

    /**
     * Remove users
     *
     * @param \Ixoil\UserBundle\Entity\User $users
     */
    public function removeUser(\Ixoil\UserBundle\Entity\User $users)
    {
        $this->users->removeElement($users);
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
     * Determines the account type
     *
     * @see \Ixoil\UserBundle\Model\AccountType
     * @return string
     */
    public function getAccountType()
    {
        if($this->getProviderAccount()) {
            return AccountType::Provider;
        } else if($this->getPurchaserAccount() && $this->getLogisticianAccount()) {
            return AccountType::PurchaserLogistician;
        }  else if($this->getPurchaserAccount()) {
            return AccountType::Purchaser;
        } else if($this->getLogisticianAccount()) {
            return AccountType::Logistician;
        } else {
            return AccountType::Unknown;
        }
    }
    
    public function __toString()
    {
       return ($this->getName() ?: '');
    }
}
