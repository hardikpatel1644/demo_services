<?php

namespace Ixoil\UserBundle\Form\Model\Traits;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Trait RegistrationStep2ProviderTrait
 * @package Ixoil\UserBundle\Form\Model\Traits
 */
trait RegistrationStep2ProviderTrait
{
    /**
     * @Assert\NotBlank(
     *  groups={"flow_ixoil_registration_step2"}
     * )
     */
    protected $activities;

    public function getActivities()
    {
        return $this->activities;
    }
    public function setActivities($activities)
    {
        $this->activities = $activities;
    }
}