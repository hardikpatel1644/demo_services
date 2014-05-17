<?php

namespace Ixoil\CoreBundle\Controller\Traits;

/**
 * Description of BreadcrumbControllerTrait
 *
 * @author fantoine
 */
trait BreadcrumbControllerTrait {
    /**
     * Breadcrumb manager
     */
    private $breadcrumb;
    
    /**
     * Returns breadcrumb service
     * @return type
     */
    protected function breadcrumb()
    {
        if (!$this->breadcrumb)
            $this->breadcrumb = $this->get('white_october_breadcrumbs');
        
        return $this->breadcrumb;
    }
    
    /**
     * Specify the breadcrumb items
     * @param array $items
     */
    protected function setBreadcrumb($items)
    {
        $bc = $this->breadcrumb();
     
        // Clear items
        $bc->clear();
        
        // Add items
        foreach ($items as $item) {
            // Get label
            $label = (isset($item['label']) ? $item['label'] : '-');
            
            // Get URL
            $url = (isset($item['route']) ? 
                $this->generateUrl(
                    $item['route'], 
                    (isset($item['route_args']) ? $item['route_args'] : array())
                ) : 
                (isset($item['url']) ? 
                    $item['url'] : 
                    null
                )
            );
            
            // Get translation parameters
            $args = (isset($item['args']) ? $item['args'] : array());
            
            // Add item
            $bc->addItem($label, $url, $args);
        }
    }
    
    protected function addBreadcrumb($label, $route = null, $routeArgs = array(), $breadcrumbArgs = array())
    {
        $bc = $this->breadcrumb();
        
        // Generate url
        $url = ($route != null ? $this->generateUrl($route, $routeArgs) : null);
        
        // Add item
        $bc->addItem($label, $url, $breadcrumbArgs);
        
        return $this;
    }
}
