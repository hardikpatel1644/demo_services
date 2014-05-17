<?php

namespace Ixoil\UserBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

/**
 * Description of SubscriptionOptionAdmin
 *
 * @author OXIND
 */
class SubscriptionOptionAdmin extends Admin
{

    protected $translationDomain = 'admin';

    /**
     * configure options
     * @param \Sonata\AdminBundle\Route\RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        parent::configureRoutes($collection);
        $collection->clearExcept(array('list', 'edit'));
    }

    /**
     * Function to list all fields
     * @param \Sonata\AdminBundle\Datagrid\ListMapper $list
     */
    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('name', null, array('label' => 'subscription.option.name'));
        $list->add('code', null, array('label' => 'subscription.option.code'));
        $list->add('prices', null, array('label' => 'subscription.prices'));
    }

    /**
     * Function to render edit fields in edit page
     * @param \Ixoil\AdminBundle\Admin\FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->with('subscription.option.title')
            ->add('name', null, array('label' => 'subscription.option.name'))
            ->add(
                'prices', 
                'sonata_type_collection', 
                array(
                    'label' => 'subscription.prices', 
                    'by_reference' => false
                ), 
                array(
                    'edit' => 'inline',
                    'inline' => 'table',
                    'sortable' => 'position',
                )
            )
            ->end();
    }

    public function preUpdate($option)
    {
        // fix weird bug with price relation not being persisted
        foreach($option->getPrices() as $price)
        {
            $price->setSubscription(null);
            $price->setSubscriptionOption($option);
        }
    }
}

