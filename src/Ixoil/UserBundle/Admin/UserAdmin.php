<?php

namespace Ixoil\UserBundle\Admin;

use Sonata\UserBundle\Admin\Entity\UserAdmin as BaseUserAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class UserAdmin extends BaseUserAdmin
{    
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        parent::configureDatagridFilters($datagridMapper);

        $datagridMapper
            ->remove('id')
            ->remove('locked')
            ->remove('groups')

            ->add('firstname')
            ->add('lastname')
            ->add('account.name')
            ->add('account.company_number')
        ;
    }        
    
    protected function configureListFields(ListMapper $listMapper)
    {                
        // Here we set the fields of the ListMapper variable, $listMapper (but this can be called anything)
        $listMapper
            ->add(
                'email',
                null,
                array('label'=>'user.labels.email')
            )
            ->add(
                'username',
                null,
                array('label'=>'user.labels.username')
            )
            ->add(
                'enabled',
                null,
                array('editable' => true, 'label'=>'user.labels.enabled')
            )
            ->add(
                'locked',
                null,
                array('editable' => true, 'label'=>'user.labels.locked')
            )
            ->add(
                'createdAt',
                null,
                array('label' => 'user.labels.created_at')
            )
            ->add(
                '_action',
                'actions',
                array(
                    'label' => 'user.labels.action',
                    'actions' => array(
                        'show' => array(),
                    )
                )
            )
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('General', array('label'=>'user.heading.general'))
                ->add('username', null, array('label'=>'user.labels.username'))
                ->add('email', null, array('label'=>'user.labels.email'))
            ->end()
            ->with('Profile', array('label'=>'user.heading.profile'))
                ->add('firstname', null, array('label'=>'user.labels.firstname'))
                ->add('lastname', null, array('label'=>'user.labels.lastname'))
            ->end()
            ->with('Company Info', array('label'=>'user.heading.company_info'))
                ->add('is_owner', null, array('label'=>'company.owner'))
                ->add('account.name', null, array('label'=>'company.name'))
                ->add('account.address.phone', null, array('label'=>'company.address.phone'))
                ->add('account.address.fax', null, array('label'=>'company.address.fax'))
                ->add('account.address.street', null, array('label'=>'company.address.street'))
                ->add('account.address.city', null, array('label'=>'company.address.city'))
                ->add('account.address.country', null, array('label'=>'company.address.country'))                
                ->add('account.address.zip_code', null, array('label'=>'company.address.zip_code'))
            ->end()
        ;
    }
}