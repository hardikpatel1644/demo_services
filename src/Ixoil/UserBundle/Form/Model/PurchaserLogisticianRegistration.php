<?php

namespace Ixoil\UserBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;
use Ixoil\UserBundle\Validator\Constraints as IxoilAssert;

/**
 * Class PurchaserLogisticianRegistration
 * @package Ixoil\UserBundle\Form\Model
 */
class PurchaserLogisticianRegistration extends Registration
{
    use Traits\RegistrationStep2PurchaserTrait;
    use Traits\RegistrationStep2LogisticianTrait;
    use Traits\RegistrationStep3PurchaserTrait;
    use Traits\RegistrationStep3LogisticianTrait;
}