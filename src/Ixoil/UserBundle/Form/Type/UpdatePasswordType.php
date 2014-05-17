<?php

namespace Ixoil\UserBundle\Form\Type;


use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface;

/**
 * Subuser creation form
 *
 * @author OXIND
 */
class UpdatePasswordType extends AbstractType
{    
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('password', 'repeated', array(
                'type' => 'password',
                'invalid_message' => 'subuser.invalid_message.password',
                'options' => array('attr' => array('class' => 'password-field')),
                'required' => true,
                'first_options' => array('label' => 'subuser.password'),
                'second_options' => array('label' => 'subuser.repeat_password'),
            ))
            ->add('create', 'submit', array('label' => 'title.update_password'));
    }

    public function getName()
    {
        return 'update_password';
    }
    
    public function setDefaultOptions(\Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'translation_domain' => 'subuser',
                'data_class' =>'Ixoil\UserBundle\Entity\User'
            )
        );
    }
}
