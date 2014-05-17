<?php

namespace Ixoil\CoreBundle\Menu;

use Knp\Menu\ItemInterface;

/**
 * Description of HeaderMenu
 *
 * @author OXIND
 */
class HeaderMenu extends Menu
{
    /**
     * @override
     * @return \Knp\Menu\ItemInterface
     */
    public function build(ItemInterface $menu)
    {
        $menu->setChildrenAttribute('class', 'nav navbar-nav');
        
        $menu->addChild(
            'header.home', 
            array('route' => 'ixoil_index')
        );
        
        $menu->addChild(
            'header.aboutUs', 
            array('route' => 'ixoil_cms_aboutus')
        );
        
        $menu->addChild(
            'header.whoWeAre',
            array('route' => 'ixoil_cms_whoweare')
        );
      
        $menu->addChild(
            'header.contact',
            array('route' => 'ixoil_cms_contact')
        );
    }
}