<?php

namespace Ixoil\UserBundle\Form\Model\Traits;

use Symfony\Component\Validator\Constraints as Assert;
use Ixoil\UserBundle\Validator\Constraints as IxoilAssert;

/**
 * Trait RegistrationStep3Trait
 * @package Ixoil\UserBundle\Form\Model\Traits
 */
trait RegistrationStep3Trait
{
    /**
     * @Assert\NotBlank(
     *  groups={"flow_ixoil_registration_step3"}
     * )
     */
    protected $first_name;

    public function getFirstName()
    {
        return $this->first_name;
    }
    public function setFirstName($name)
    {
        $this->first_name = $name;
    }

    /**
     * @Assert\NotBlank(
     *  groups={"flow_ixoil_registration_step3"}
     * )
     */
    protected $last_name;

    public function getLastName()
    {
        return $this->last_name;
    }
    public function setLastName($name)
    {
        $this->last_name = $name;
    }

    /**
     * @Assert\NotBlank(
     *  groups={"flow_ixoil_registration_step3"}
     * )
     * @IxoilAssert\EmailAvailable(
     *  groups={"flow_ixoil_registration_step3"}
     * )
     */
    protected $email;

    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @Assert\NotBlank(
     *  groups={"flow_ixoil_registration_step3"}
     * )
     */
    protected $phone_number;

    public function getPhoneNumber()
    {
        return $this->phone_number;
    }
    public function setPhoneNumber($phone)
    {
        $this->phone_number = $phone;
    }

    /**
     * @Assert\NotBlank(
     *  groups={"flow_ixoil_registration_step3"}
     * )
     */
    protected $fax;

    public function getFax()
    {
        return $this->fax;
    }
    public function setFax($fax)
    {
        $this->fax = $fax;
    }

    /**
     * @Assert\NotBlank(
     *  groups={"flow_ixoil_registration_step3"}
     * )
     */
    protected $password;

    public function getPassword()
    {
        return $this->password;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @Assert\NotBlank(
     *  groups={"flow_ixoil_registration_step3"}
     * )
     * @Assert\True(
     *  groups={"flow_ixoil_registration_step3"}
     * )
     */
    protected $terms_of_use;

    public function getTermsOfUse()
    {
        return $this->terms_of_use;
    }
    public function setTermsOfUse($tou)
    {
        $this->terms_of_use = $tou;
    }
}