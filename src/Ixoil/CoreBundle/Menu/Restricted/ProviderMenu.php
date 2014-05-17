<?php

namespace Ixoil\CoreBundle\Menu\Restricted;

use Knp\Menu\ItemInterface;
use Ixoil\CoreBundle\Menu\MenuDecorator;

/**
 * Class ProviderMenu
 * @package Ixoil\CoreBundle\Menu\Restricted
 */
class ProviderMenu extends MenuDecorator
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
        // TODO: Add provider menu
    }
}