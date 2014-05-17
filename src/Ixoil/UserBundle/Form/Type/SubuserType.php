<?php

namespace Ixoil\UserBundle\Form\Type;


use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface;

/**
 * Subuser creation form
 *
 * @author OXIND
 */
class SubuserType extends AbstractType
{    
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', 'text', array('label' => 'subuser.firstname'))
            ->add('lastname', 'text', array('label' => 'subuser.lastname'))
            ->add('email', 'email', array('label' => 'subuser.email'))
            ->add('password', 'repeated', array(
                'type' => 'password',
                'invalid_message' => 'subuser.invalid_message.password',
                'options' => array('attr' => array('class' => 'password-field')),
                'required' => true,
                'first_options' => array('label' => 'subuser.password'),
                'second_options' => array('label' => 'subuser.repeat_password'),
            ))
            ->add('enabled', 'checkbox', array('label' => 'subuser.enable_user',
                'required' => false,
                'label_attr' => array('class' => 'col-lg-2 col-lg-offset-2'),
                'attr'     => array('checked'   => 'checked'),
            ))
            ->add('create', 'submit', array('label' => 'subuser.create'));
    }

    public function getName()
    {
        return 'subuser_create';
    }
    
    public function setDefaultOptions(\Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'translation_domain'=>'subuser',
                'data_class' =>'Ixoil\UserBundle\Entity\User'
            )
        );
    }
}
