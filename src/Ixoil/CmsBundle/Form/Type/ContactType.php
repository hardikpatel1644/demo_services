<?php

namespace Ixoil\CmsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * 
 */
class ContactType extends AbstractType
{
    /**
     * @var string $class
     */
    protected $class;

    /**
     * @param string $class
     */
    public function __construct($class)
    {
        $this->class = $class;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'label' => 'contact.form.label.name',
            ))
            ->add('email', 'email', array(
                'label' => 'contact.form.label.email',
            ))
            ->add('company', 'text', array(
                'label' => 'contact.form.label.company',
            ))
            ->add('phone', 'text', array(
                'label' => 'contact.form.label.phone',
                'required' => false,
            ))
            ->add('message', 'textarea', array(
                'label' => 'contact.form.label.message',
            ))
            ->add('save', 'submit', array(
                'label' => 'contact.form.submit',
            ));
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->class,
            'translation_domain' => 'cms',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ixoil_contact';
    }
}