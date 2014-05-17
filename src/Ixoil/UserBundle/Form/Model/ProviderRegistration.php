<?php

namespace Ixoil\UserBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;
use Ixoil\UserBundle\Validator\Constraints as IxoilAssert;

/**
 * Class ProviderRegistration
 * @package Ixoil\UserBundle\Form\Model
 */
class ProviderRegistration extends Registration
{
    use Traits\RegistrationStep2ProviderTrait;
    use Traits\RegistrationStep3ProviderTrait;
}
