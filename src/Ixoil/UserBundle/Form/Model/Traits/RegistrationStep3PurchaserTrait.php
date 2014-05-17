<?php

namespace Ixoil\UserBundle\Form\Model\Traits;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class RegistrationStep3PurchaserTrait
 * @package Ixoil\UserBundle\Form\Model\Traits
 */
trait RegistrationStep3PurchaserTrait
{
    /**
     * @Assert\NotBlank(
     *  groups={"flow_ixoil_registration_step3"}
     * )
     */
    protected $purchaser_terms_of_sales;

    public function getPurchaserTermsOfSales()
    {
        return $this->purchaser_terms_of_sales;
    }
    public function setPurchaserTermsOfSales($tos)
    {
        $this->purchaser_terms_of_sales = $tos;
    }
}