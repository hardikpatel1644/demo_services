<?php

namespace Ixoil\UserBundle\Form\Model\Traits;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class RegistrationStep3LogisticianTrait
 * @package Ixoil\UserBundle\Form\Model\Traits
 */
trait RegistrationStep3LogisticianTrait
{
    /**
     * @Assert\NotBlank(
     *  groups={"flow_ixoil_registration_step3"}
     * )
     */
    protected $logistician_terms_of_sales;

    public function getLogisticianTermsOfSales()
    {
        return $this->logistician_terms_of_sales;
    }
    public function setLogisticianTermsOfSales($tos)
    {
        $this->logistician_terms_of_sales = $tos;
    }
}