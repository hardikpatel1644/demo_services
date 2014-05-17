<?php

namespace Ixoil\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;

/**
 * Description of RegistrationStepOne
 *
 * @author OXIND
 */
class RegistrationStep1Type extends RegistrationStepType
{
    
    protected  $step_title = 'step.one.title';
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this
            ->addControl('company_name', 'text', array(
               'label' => 'step.one.company_name'
            ));
            $this->addControl('company_number', 'text', array(
               'label' => 'step.one.company_number'
            ));
            $this->addControl('address', 'textarea', array(
               'label' => 'step.one.address'
            ));
            $this->addControl('zip_code', 'text', array(
               'label' => 'step.one.zip_code',
               'invalid_message' => 'error.zip_code'
            ));
            $this->addControl('city', 'text', array(
               'label' => 'step.one.city'
            ));
            $this->addControl('country', 'country', array(
                'empty_value' => 'step.one.country_empty',
                'preferred_choices' => array('FR', 'ES', 'IT', 'CH', 'LU', 'BE', 'NL', 'DE', 'AT', 'UK'),
                'label' => 'step.one.country',
            ));
            $this->addControl('VAT', 'text', array(
               'label' => 'step.one.vat'
            ));
        
        parent::buildForm($builder, $options);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ixoil_stepone';
    }

}