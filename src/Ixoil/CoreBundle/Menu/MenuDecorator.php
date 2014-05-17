<?php

namespace Ixoil\CoreBundle\Menu;

use Knp\Menu\ItemInterface;

/**
 * Description of MenuDecorator
 *
 * @package Ixoil\DashboardBundle\Menu
 * @author fantoine
 */
abstract class MenuDecorator {
    /**
     * @param ItemInterface $menu
     * @return void
     */
    abstract public function decorateMenu(ItemInterface $menu);
}
