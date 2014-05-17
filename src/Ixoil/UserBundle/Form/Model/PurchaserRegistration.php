<?php

namespace Ixoil\UserBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;
use Ixoil\UserBundle\Validator\Constraints as IxoilAssert;

/**
 * Class PurchaserRegistration
 * @package Ixoil\UserBundle\Form\Model
 */
class PurchaserRegistration extends Registration
{
    use Traits\RegistrationStep2PurchaserTrait;
    use Traits\RegistrationStep3PurchaserTrait;
}