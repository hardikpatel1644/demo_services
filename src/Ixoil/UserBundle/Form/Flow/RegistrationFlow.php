<?php

namespace Ixoil\UserBundle\Form\Flow;

use Craue\FormFlowBundle\Form\FormFlow;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RegistrationFlow
 *
 * @author OXIND
 */
class RegistrationFlow extends FormFlow
{
    protected $allowDynamicStepNavigation = true;
    /**
     * @var array
     */
    protected $steps;

    /**
     * @param $steps
     */
    public function __construct(array $steps)
    {
        $this->steps = $steps;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ixoil_registration';
    }

    /**
     * @return array
     */
    protected function loadStepsConfig()
    {
        return array_map(
            function($step) {
               return array(
                   'label' => $step->getStepTitle(),
                   'type' => $step
               );
            },
            $this->steps
        );
    }

    /**
     * @param $stepNumber
     * @return null|string
     */
    public function getStepLabel($stepNumber)
    {
        $stepLabel = null;
        if ($stepNumber >= $this->getFirstStepNumber() && $stepNumber <= $this->getLastStepNumber())
        {
            $stepLabel =  $this->getStep($stepNumber)->getLabel();
        }
        return $stepLabel;
    }
    
    /**
     * 
     * @param type $stepNumber
     * @param type $child
     * @return type
     */
    public function getControlLabel($stepNumber,$child)
    {
        $lable = null;

        $stepNumber--;

        if ($stepNumber >= 0)
        {
            $lable = $this->steps[$stepNumber]->getControlLabel($child);
        }

        return $lable;
    }
    
    /**
     * 
     * @param type $stepNumber
     * @param type $child
     * @return type
     */
    public function getControlType($stepNumber,$child)
    {
        $type = null;

        $stepNumber--;

        if ($stepNumber >= 0)
        {
            $type = $this->steps[$stepNumber]->getControlType($child);
        }

        return $type;
    }

}