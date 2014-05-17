<?php

namespace Ixoil\PurchaserBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="ixoil_purchaser_tank")
 */
class Tank
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
    private $average_delivery_frequence;

    /** 
     * @ORM\Column(type="decimal", nullable=false)
     */
    private $average_daily_consumption;

    /** 
     * @ORM\Column(type="string", nullable=false)
     */
    private $storage_type;

    /** 
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $auto_level_update;

    /** 
     * @ORM\Column(type="integer", nullable=true)
     */
    private $empty_alert_level;

    /** 
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $empty_alert;

    /** 
     * @ORM\Column(type="string", nullable=false)
     */
    private $oil_type;

    /** 
     * @ORM\Column(type="integer", nullable=false)
     */
    private $current_level;

    /** 
     * @ORM\Column(type="integer", nullable=false)
     */
    private $total_capacity;

    /** 
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $name;

    /** 
     * @ORM\ManyToOne(targetEntity="Ixoil\PurchaserBundle\Entity\Agency", inversedBy="tanks")
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
     * @return Tank
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

    /**
     * Set average_delivery_frequence
     *
     * @param string $averageDeliveryFrequence
     * @return Tank
     */
    public function setAverageDeliveryFrequence($averageDeliveryFrequence)
    {
        $this->average_delivery_frequence = $averageDeliveryFrequence;

        return $this;
    }

    /**
     * Get average_delivery_frequence
     *
     * @return string 
     */
    public function getAverageDeliveryFrequence()
    {
        return $this->average_delivery_frequence;
    }

    /**
     * Set average_daily_consumption
     *
     * @param string $averageDailyConsumption
     * @return Tank
     */
    public function setAverageDailyConsumption($averageDailyConsumption)
    {
        $this->average_daily_consumption = $averageDailyConsumption;

        return $this;
    }

    /**
     * Get average_daily_consumption
     *
     * @return string 
     */
    public function getAverageDailyConsumption()
    {
        return $this->average_daily_consumption;
    }

    /**
     * Set storage_type
     *
     * @param string $storageType
     * @return Tank
     */
    public function setStorageType($storageType)
    {
        $this->storage_type = $storageType;

        return $this;
    }

    /**
     * Get storage_type
     *
     * @return string 
     */
    public function getStorageType()
    {
        return $this->storage_type;
    }

    /**
     * Set auto_level_update
     *
     * @param boolean $autoLevelUpdate
     * @return Tank
     */
    public function setAutoLevelUpdate($autoLevelUpdate)
    {
        $this->auto_level_update = $autoLevelUpdate;

        return $this;
    }

    /**
     * Get auto_level_update
     *
     * @return boolean 
     */
    public function getAutoLevelUpdate()
    {
        return $this->auto_level_update;
    }

    /**
     * Set empty_alert_level
     *
     * @param integer $emptyAlertLevel
     * @return Tank
     */
    public function setEmptyAlertLevel($emptyAlertLevel)
    {
        $this->empty_alert_level = $emptyAlertLevel;

        return $this;
    }

    /**
     * Get empty_alert_level
     *
     * @return integer 
     */
    public function getEmptyAlertLevel()
    {
        return $this->empty_alert_level;
    }

    /**
     * Set empty_alert
     *
     * @param boolean $emptyAlert
     * @return Tank
     */
    public function setEmptyAlert($emptyAlert)
    {
        $this->empty_alert = $emptyAlert;

        return $this;
    }

    /**
     * Get empty_alert
     *
     * @return boolean 
     */
    public function getEmptyAlert()
    {
        return $this->empty_alert;
    }

    /**
     * Set oil_type
     *
     * @param string $oilType
     * @return Tank
     */
    public function setOilType($oilType)
    {
        $this->oil_type = $oilType;

        return $this;
    }

    /**
     * Get oil_type
     *
     * @return string 
     */
    public function getOilType()
    {
        return $this->oil_type;
    }

    /**
     * Set current_level
     *
     * @param integer $currentLevel
     * @return Tank
     */
    public function setCurrentLevel($currentLevel)
    {
        $this->current_level = $currentLevel;

        return $this;
    }

    /**
     * Get current_level
     *
     * @return integer 
     */
    public function getCurrentLevel()
    {
        return $this->current_level;
    }

    /**
     * Set total_capacity
     *
     * @param integer $totalCapacity
     * @return Tank
     */
    public function setTotalCapacity($totalCapacity)
    {
        $this->total_capacity = $totalCapacity;

        return $this;
    }

    /**
     * Get total_capacity
     *
     * @return integer 
     */
    public function getTotalCapacity()
    {
        return $this->total_capacity;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Tank
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
}
