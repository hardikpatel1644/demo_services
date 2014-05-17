<?php

namespace Ixoil\UserBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="ixoil_user_account_provider")
 */
class ProviderAccount
{
    /** 
     * @ORM\Column(type="array", nullable=false)
     */
    private $activities;

    /** 
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $file_tos;

    /** 
     * @ORM\OneToOne(targetEntity="Ixoil\UserBundle\Entity\Account", inversedBy="providerAccount")
     * @ORM\JoinColumn(name="account_id", referencedColumnName="id", nullable=false, unique=true)
     * @ORM\Id
     */
    private $account;

    /**
     * Set activities
     *
     * @param array $activities
     * @return ProviderAccount
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
     * Set file_tos
     *
     * @param string $fileTos
     * @return ProviderAccount
     */
    public function setFileTos($fileTos)
    {
        $this->file_tos = $fileTos;

        return $this;
    }

    /**
     * Get file_tos
     *
     * @return string 
     */
    public function getFileTos()
    {
        return $this->file_tos;
    }

    /**
     * Set account
     *
     * @param \Ixoil\UserBundle\Entity\Account $account
     * @return ProviderAccount
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
