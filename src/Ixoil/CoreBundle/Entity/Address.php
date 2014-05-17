<?php

namespace Ixoil\CoreBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="ixoil_core_address")
 */
class Address
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** 
     * @ORM\Column(type="text", nullable=false)
     */
    private $street;

    /** 
     * @ORM\Column(type="string", length=5, nullable=false)
     */
    private $zip_code;

    /** 
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    private $city;

    /** 
     * @ORM\Column(type="string", length=5, nullable=false)
     */
    private $country;

    /** 
     * @ORM\Column(type="decimal", nullable=true)
     */
    private $longitude;

    /** 
     * @ORM\Column(type="decimal", nullable=true)
     */
    private $latitude;

    /** 
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $phone_alt;

    /** 
     * @ORM\Column(type="string", length=10, nullable=false)
     */
    private $phone;

    /** 
     * @ORM\Column(type="string", length=10, nullable=false)
     */
    private $fax;

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
     * Set street
     *
     * @param string $street
     * @return Address
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string 
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set zip_code
     *
     * @param string $zipCode
     * @return Address
     */
    public function setZipCode($zipCode)
    {
        $this->zip_code = $zipCode;

        return $this;
    }

    /**
     * Get zip_code
     *
     * @return string 
     */
    public function getZipCode()
    {
        return $this->zip_code;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Address
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return Address
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     * @return Address
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string 
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     * @return Address
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set phone_alt
     *
     * @param string $phoneAlt
     * @return Address
     */
    public function setPhoneAlt($phoneAlt)
    {
        $this->phone_alt = $phoneAlt;

        return $this;
    }

    /**
     * Get phone_alt
     *
     * @return string 
     */
    public function getPhoneAlt()
    {
        return $this->phone_alt;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return Address
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set fax
     *
     * @param string $fax
     * @return Address
     */
    public function setFax($fax)
    {
        $this->fax = $fax;

        return $this;
    }

    /**
     * Get fax
     *
     * @return string 
     */
    public function getFax()
    {
        return $this->fax;
    }
}
