<?php

namespace Ixoil\CoreBundle\Menu;

use Symfony\Component\DependencyInjection\ContainerAware;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;

/**
 * Description of Menu
 *
 * @author fantoine
 */
abstract class Menu extends ContainerAware {
    /**
     * @var \Knp\Menu\FactoryInterface $factory
     */
    //protected $factory;
    
    /**
     *
     * @var array 
     */
    protected $decorators;

    /**
     * 
     */
    public function __construct()
    {
        $this->decorators = array();
    }
    
    /**
     * Add a new menu decorator
     * @param \Ixoil\CoreBundle\Menu\MenuDecorator $decorator
     */
    public function addDecorator(MenuDecorator $decorator)
    {
        $this->decorators[] = $decorator;
    }
    
    /**
     * @return \Knp\Menu\ItemInterface
     */
    public function create()
    {
        $factory = $this->container->get('knp_menu.factory');
        
        $menu = $factory->createItem('root');
        
        // Build menu items
        $this->build($menu);
        
        // Execute decorators
        $this->decorate($menu);
        
        // Select current entry
        $uri = $this->container->get('request')->getRequestUri();
        $this->selectCurrent($uri, $menu);
        
        return $menu;
    }
    
    /**
     * @param \Knp\Menu\FactoryInterface $menu
     */
    abstract public function build(ItemInterface $menu);
    
    /**
     * 
     * @param \Knp\Menu\FactoryInterface $menu
     */
    public function decorate(ItemInterface $menu)
    {
        foreach ($this->decorators as $decorator)
            $decorator->decorateMenu($menu);
    }
    
    /**
     * 
     */
    protected function selectCurrent($uri, $menu, $parents = array())
    {
        // Search if the current route is in the menu
        // Or in children
        if ($menu->getUri() == $uri) {
            // Select current item
            $menu->setCurrent(true);

            // Open parents
            foreach ($parents as $parent)
                $parent->setExtra('open', true);

            return true;
        } else if($menu->hasChildren()) {
            foreach ($menu as $key => $item)
                if ($this->selectCurrent($uri, $item, array_merge($parents, array($menu))))
                    return true;
        }
        
        return false;
    }
}
