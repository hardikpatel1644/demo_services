<?php

namespace Ixoil\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class RegistrationStep4Type
 * @package Ixoil\UserBundle\Form\Type
 */
class RegistrationStep4Type extends RegistrationStepType
{
    
    protected  $step_title = 'step.four.title';
        
    /**
     * @return string
     */
    public function getName()
    {
        return 'ixoil_stepfour';
    }

}