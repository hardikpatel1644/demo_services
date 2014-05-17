<?php

namespace Ixoil\UserBundle\Form\Model\Traits;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Trait RegistrationStep2Trait
 * @package Ixoil\UserBundle\Form\Model\Traits
 */
trait RegistrationStep2Trait
{
    /**
     * @Assert\NotBlank(
     *  groups={"flow_ixoil_registration_step2"}
     * )
     * @Assert\File(
     *  maxSize="5M",
     *  mimeTypes = {"application/pdf", "application/tiff", "image/jpg", "image/jpeg", "image/png" },
     *  mimeTypesMessage = "error.file.type",
     *  maxSizeMessage = "error.file.size",
     *  groups={"flow_ixoil_registration_step2"}
     * )
     */
    protected $bank_statement;

    public function getBankStatement()
    {
        return $this->bank_statement;
    }
    public function setBankStatement($statement)
    {
        $this->bank_statement = $statement;
    }

    /**
     * @Assert\NotBlank(
     *  groups={"flow_ixoil_registration_step2"}
     * )
     * @Assert\File(
     *  maxSize="5M",
     *  mimeTypes = {"application/pdf", "application/tiff", "image/jpg", "image/jpeg", "image/png" },
     *  mimeTypesMessage = "error.file.type",
     *  maxSizeMessage = "error.file.size",
     *  groups={"flow_ixoil_registration_step2"}
     * )
     */
    protected $certificate_of_incorporation;

    public function getCertificateOfIncorporation()
    {
        return $this->certificate_of_incorporation;
    }
    public function setCertificateOfIncorporation($certificate)
    {
        $this->certificate_of_incorporation = $certificate;
    }
}