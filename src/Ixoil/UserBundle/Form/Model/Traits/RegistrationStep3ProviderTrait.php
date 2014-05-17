<?php

namespace Ixoil\UserBundle\Form\Model\Traits;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class RegistrationStep3ProviderTrait
 * @package Ixoil\UserBundle\Form\Model\Traits
 */
trait RegistrationStep3ProviderTrait
{
    /**
     * @Assert\NotBlank(
     *  groups={"flow_ixoil_registration_step3"}
     * )
     */
    protected $provider_terms_of_sales;

    public function getProviderTermsOfSales()
    {
        return $this->provider_terms_of_sales;
    }
    public function setProviderTermsOfSales($tos)
    {
        $this->provider_terms_of_sales = $tos;
    }
}