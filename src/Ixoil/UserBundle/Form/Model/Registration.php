<?php

namespace Ixoil\UserBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;
use Ixoil\UserBundle\Validator\Constraints as IxoilAssert;

/**
 * Class Registration
 * @package Ixoil\UserBundle\Form\Model
 */
class Registration
{
    use Traits\RegistrationStep1Trait;
    use Traits\RegistrationStep2Trait;
    use Traits\RegistrationStep3Trait;
}
