<?php

namespace Ixoil\UserBundle\Form\Type;


use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface;

/**
 * Subuser creation form
 *
 * @author OXIND
 */
class EditSubuserType extends AbstractType
{    
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', 'text', array('label' => 'subuser.firstname'))
            ->add('lastname', 'text', array('label' => 'subuser.lastname'))
            ->add('email', 'email', array('label' => 'subuser.email'))
            ->add('enabled', 'checkbox', array('label' => 'subuser.enable_user',
                'required' => false,
                'label_attr' => array('class' => 'col-lg-2 col-lg-offset-2')
            ))
            ->add('edit', 'submit', array('label' => 'subuser.update'));
    }

    public function getName()
    {
        return 'subuser_edit';
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
