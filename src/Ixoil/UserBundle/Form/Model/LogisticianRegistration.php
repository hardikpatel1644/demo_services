<?php

namespace Ixoil\UserBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;
use Ixoil\UserBundle\Validator\Constraints as IxoilAssert;

/**
 * Class LogisticianRegistration
 * @package Ixoil\UserBundle\Form\Model
 */
class LogisticianRegistration extends Registration
{
    use Traits\RegistrationStep2LogisticianTrait;
    use Traits\RegistrationStep3LogisticianTrait;
}