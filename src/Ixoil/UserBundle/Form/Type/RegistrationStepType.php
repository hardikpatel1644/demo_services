<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ixoil\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Description of RegistrationStep
 *
 * @author OXIND
 */
abstract class RegistrationStepType extends AbstractType
{
    
    protected $arrControls;
    
    protected $step_title;
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if(count($this->arrControls) > 0)
        {
            $arrControls = $this->arrControls;

            foreach ($arrControls as $child => $vlaues)
            {
                $builder->add($child, $arrControls[$child]['type'], $arrControls[$child]['options']);
            }
        }
    }

    /**
     * 
     * @param type $title title of step
     */
    public function setStepTitle($title)
    {
        $this->step_title = $title;
    }
    
    /**
     * @return string
     */
    public function getStepTitle()
    {
        return $this->step_title;
    }
    
    /**
     * @return string
     */
    abstract public function getName();
    
    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'translation_domain' => 'registration',
        ));
    }
    
    public function addControl($child , $type, $options)
    {
        $this->arrControls[ $child ] = array('type'=>$type,'options'=>$options);
    }
    
    public function getControlLabel($child)
    {
        
        $lable = null;
        $arrControls = $this->arrControls;
        
        if (array_key_exists($child, $arrControls) && array_key_exists('label', $arrControls[$child]['options']))
        {
            $lable = $arrControls[$child]['options']['label'];
        }

        return $lable;
    }
    
    public function getControlType($child)
    {
        
        $type = null;
        $arrControls = $this->arrControls;
        
        if (array_key_exists($child, $arrControls))
        {
            $type = $arrControls[$child]['type'];
        }

        return $type;
    }
}
