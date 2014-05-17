<?php

namespace Ixoil\UserBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

/**
 * SubscriptionAdmin to List Subscription Entity
 *
 * @author OXIND
 */
class SubscriptionAdmin extends Admin
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
     * set what to display in list.
     * @param \Sonata\AdminBundle\Datagrid\ListMapper $list
     */
    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('name', null, array('label'=>'subscription.name'));
        $list->add('account_type', null, array('label' => 'subscription.account_type'));
        $list->add('options', null, array('label' => 'subscription.options'));
        $list->add('prices', null, array('label' => 'subscription.prices'));
    }
    
    /**
     * Function to render edit fields in edit page
     * @param \Ixoil\AdminBundle\Admin\FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->with('subscription.title')
            ->add('name', null, array('label' => 'subscription.name'))
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
    
    public function preUpdate($subscription)
    {
        // fix weird bug with price relation not being persisted
        foreach($subscription->getPrices() as $price)
        {
            $price->setSubscription($subscription);
            $price->setSubscriptionOption(null);
        }
    }
}
