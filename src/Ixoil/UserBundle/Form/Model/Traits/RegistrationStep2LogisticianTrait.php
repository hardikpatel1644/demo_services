<?php

namespace Ixoil\UserBundle\Form\Model\Traits;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Trait RegistrationStep2LogisticianTrait
 * @package Ixoil\UserBundle\Form\Model\Traits
 */
trait RegistrationStep2LogisticianTrait
{
    /**
     * @Assert\NotBlank(
     *  groups={"flow_ixoil_registration_step2"}
     * )
     * @Assert\Count(
     *      min = "1"
     * )
     */
    protected $delivery_areas;

    public function getDeliveryAreas()
    {
        return $this->delivery_areas;
    }
    public function setDeliveryAreas($areas)
    {
        $this->delivery_areas = $areas;
    }

}