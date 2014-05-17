<?php

namespace Ixoil\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Ixoil\UserBundle\Model\AccountType;

/**
 * Class RegistrationStep3Type
 * @package Ixoil\UserBundle\Form\Type
 */
class RegistrationStep3Type extends RegistrationStepType
{
    
    protected  $step_title = 'step.three.title';
        
    /**
     * @var
     */
    protected $manager;

    /**
     * @param $manager
     */
    public function __construct($manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->addControl('first_name', 'text', array(
                'label' => 'step.three.first_name'
            ));
        $this->addControl('last_name', 'text', array(
            'label' => 'step.three.last_name'
        ));
        $this->addControl('email', 'email', array(
            'label' => 'step.three.email'
        ));
        $this->addControl('phone_number', 'text', array(
            'label' => 'step.three.phone_number'
        ));
        $this->addControl('fax', 'text', array(
            'label' => 'step.three.fax'
        ));
        $this->addControl('password', 'repeated', array(
            'type' => 'password',
            'invalid_message' => 'The password fields must match.',
            'options' => array('attr' => array('class' => 'password-field')),
            'required' => true,
            'first_options' => array('label' => 'step.three.password'),
            'second_options' => array('label' => 'step.three.confirm_password'),
        ));
        $this->addControl('terms_of_use', 'checkbox', array(
            'label' => 'step.three.terms_of_use',
        ));

        // Add account type specific fields
        switch($this->manager->getRegistrationType()) {
            case AccountType::Purchaser:
                $this->buildPurchaserForm();
                break;
            case AccountType::Provider:
                $this->buildProviderForm();
                break;
            case AccountType::Logistician:
                $this->buildLogisticianForm();
                break;
            case AccountType::PurchaserLogistician:
                $this->buildPurchaserForm();
                $this->buildLogisticianForm();
                break;
        }
        
        parent::buildForm($builder, $options);
    }

    /**
     * 
     */
    protected function buildPurchaserForm()
    {
        $this
            ->addControl('purchaser_terms_of_sales', 'checkbox', array(
                'label' => 'step.three.terms_of_sales.purchaser'
            ));
    }

    /**
     * @param FormBuilderInterface $builder
     */
    protected function buildProviderForm()
    {
        $this
            ->addControl('provider_terms_of_sales', 'checkbox', array(
                'label' => 'step.three.terms_of_sales.provider'
            ));
    }

    /**
     * @param FormBuilderInterface $builder
     */
    protected function buildLogisticianForm()
    {
        $this
            ->addControl('logistician_terms_of_sales', 'checkbox', array(
                'label' => 'step.three.terms_of_sales.logistician'
            ));;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ixoil_stepthree';
    }

}