<?php

namespace Ixoil\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Ixoil\UserBundle\Model\AccountType;
use Ixoil\UserBundle\Model\PurchaserActivity;
use Ixoil\UserBundle\Model\ProviderActivity;

/**
 * Class RegistrationStep2Type
 * @package Ixoil\UserBundle\Form\Type
 */
class RegistrationStep2Type extends RegistrationStepType
{
    
    protected  $step_title = 'step.two.title';
    
    /**
     * @var
     */
    protected $manager;
    
    /**
     * @var
     */
    protected $translor;

    /**
     * @param $manager
     */
    public function __construct($translator, $manager)
    {
        $this->translator = $translator;
        $this->manager = $manager;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Add common stuff
        $this->addControl(
            'bank_statement',
            'file', 
            array(
                'label' => 'step.two.bank_statement',
                'attr' => array('help_text' => 'help.step.two.file'),
            )
        );
        
        $this->addControl(
            'certificate_of_incorporation',
            'file', 
            array(
                'label' => 'step.two.certificate_of_incorporation',
                'attr' => array('help_text' => 'help.step.two.file'),
            )
        );

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
            ->addControl('activities', 'choice', array(
                'choices' => array(
                    PurchaserActivity::FreightTransport => $this->translator->trans('model.purchaser.activity.freighttransport', array(), 'core'),
                    PurchaserActivity::PassengerTransport => $this->translator->trans('model.purchaser.activity.passengertransport', array(), 'core'),
                    PurchaserActivity::ServiceStation => $this->translator->trans('model.purchaser.activity.servicestation', array(), 'core'),
                    PurchaserActivity::Dealer => $this->translator->trans('model.purchaser.activity.dealer', array(), 'core'),
                ),
                'multiple' => true,
                'expanded' => true,
                'label' => 'step.two.activity'
            ));
    }

    /**
     * 
     */
    protected function buildProviderForm()
    {
        $this
            ->addControl('activities', 'choice', array(
                'choices' => array(
                    ProviderActivity::Tanker => $this->translator->trans('model.provider.activity.tanker', array(), 'core'),
                    ProviderActivity::Dealer => $this->translator->trans('model.provider.activity.dealer', array(), 'core'),
                    ProviderActivity::Merkant => $this->translator->trans('model.provider.activity.merkant', array(), 'core'),
                    ProviderActivity::GMS => $this->translator->trans('model.provider.activity.lms', array(), 'core'),
                ),
                'multiple' => true,
                'expanded' => true
            ));
    }

    /**
     * 
     */
    protected function buildLogisticianForm()
    {
        $this->addControl('delivery_areas' , 'jvectormap' , array('label'=>'step.two.delivery_areas'));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ixoil_steptwo';
    }
}