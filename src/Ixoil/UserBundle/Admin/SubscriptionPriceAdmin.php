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
class SubscriptionPriceAdmin extends Admin
{
    protected $translationDomain = 'admin';

    /**
     * configure options
     * @param \Sonata\AdminBundle\Route\RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        parent::configureRoutes($collection);
        $collection->clearExcept(array('create', 'edit', 'list'));
    }
    
    /**
     * set what to display in list.
     * @param \Sonata\AdminBundle\Datagrid\ListMapper $list
     */
    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('name', null, array('label'=>'subscription.price.name'));
        $list->add('duration', null, array('label'=>'subscription.price.duration'));
        $list->add('price', null, array('label'=>'subscription.price.value'));
        $list->add('subscription', null, array('label'=>'subscription.option.subscription'));
        $list->add('subscriptionOption', null, array('label'=>'subscription.option.title'));
    }
    
    /**
     * Function to render edit fields in edit page
     * @param \Ixoil\AdminBundle\Admin\FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->with('subscription.price.title')
            ->add('name', null, array('label' => 'subscription.price.name'))
            ->add('duration', null, array('label' => 'subscription.price.duration'))
            ->add('price', null, array('label' => 'subscription.price.value'))
            ->end();
    } 
}
