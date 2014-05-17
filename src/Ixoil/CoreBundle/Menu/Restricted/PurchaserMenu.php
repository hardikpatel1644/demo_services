<?php

namespace Ixoil\CoreBundle\Menu\Restricted;

use Knp\Menu\ItemInterface;
use Ixoil\CoreBundle\Menu\MenuDecorator;

/**
 * Class PurchaserMenu
 * @package Ixoil\CoreBundle\Menu\Restricted
 */
class PurchaserMenu extends MenuDecorator
{
    /**
     *
     */
    public function __construct()
    {

    }

    /**
     * @param ItemInterface $menu
     */
    public function decorateMenu(ItemInterface $menu)
    {
        // Agencies
        $agency = $menu
            ->addChild(
                'agency',
                array('label' => 'restricted.agency.title')
            )
            ->setExtra('icon', 'suitcase');
            $agency
                ->addChild(
                    'restricted.agency.createagency',
                    array('route' => 'ixoil_index')
                );
            $agency
                ->addChild(
                    'restricted.agency.manageagency',
                    array('route' => 'ixoil_index')
                );

        // Orders
        $order = $menu
            ->addChild(
                'order',
                array('label' => 'restricted.order.title')
            )
            ->setExtra('icon', 'file-text');
            $order
                ->addChild(
                    'restricted.order.makeanorder',
                    array('route' => 'ixoil_index')
                );
            $order
                ->addChild(
                    'restricted.order.seemyorder',
                    array('route' => 'ixoil_index')
                );

        $menu
            ->addChild(
                'restricted.myprovider',
                array('route' => 'ixoil_index')
            )
            ->setExtra('icon', 'user');
        $menu
            ->addChild(
                'restricted.myoutstanding',
                array('route' => 'ixoil_index')
            )
            ->setExtra('icon', 'pencil');
        $menu
            ->addChild(
                'restricted.mytank',
                array('route' => 'ixoil_index')
            )
            ->setExtra('icon', 'pencil');
    }

}
