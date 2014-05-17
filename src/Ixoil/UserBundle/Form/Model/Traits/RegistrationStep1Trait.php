<?php

namespace Ixoil\UserBundle\Form\Model\Traits;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Trait RegistrationStep1Trait
 * @package Ixoil\UserBundle\Form\Model\Traits
 */
trait RegistrationStep1Trait
{
    /**
     * @Assert\NotBlank(
     *  groups={"flow_ixoil_registration_step1"}
     * )
     */
    protected $company_name;

    public function getCompanyName()
    {
        return $this->company_name;
    }
    public function setCompanyName($company)
    {
        $this->company_name = $company;
    }

    /**
     * @Assert\NotBlank(
     *  groups={"flow_ixoil_registration_step1"}
     * )
     */
    protected $company_number;

    public function getCompanyNumber()
    {
        return $this->company_number;
    }
    public function setCompanyNumber($number)
    {
        $this->company_number = $number;
    }

    /**
     * @Assert\NotBlank(
     *  groups={"flow_ixoil_registration_step1"}
     * )
     */
    protected $address;

    public function getAddress()
    {
        return $this->address;
    }
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @Assert\Regex(
     *  pattern="/^\d{5}$/",
     *  groups={"flow_ixoil_registration_step1"}
     * )
     */
    protected $zip_code;

    public function getZipCode()
    {
        return $this->zip_code;
    }
    public function setZipCode($zip)
    {
        $this->zip_code = $zip;
    }

    /**
     * @Assert\NotBlank(
     *  groups={"flow_ixoil_registration_step1"}
     * )
     */
    protected $city;

    public function getCity()
    {
        return $this->city;
    }
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @Assert\NotBlank(
     *  groups={"flow_ixoil_registration_step1"}
     * )
     */
    protected $country;

    public function getCountry()
    {
        return $this->country;
    }
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @Assert\NotBlank(
     *  groups={"flow_ixoil_registration_step1"}
     * )
     */
    protected $VAT;

    public function getVAT()
    {
        return $this->VAT;
    }
    public function setVAT($vat)
    {
        $this->VAT = $vat;
    }
}