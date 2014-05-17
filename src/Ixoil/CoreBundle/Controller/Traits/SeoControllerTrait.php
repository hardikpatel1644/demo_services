<?php

namespace Ixoil\CoreBundle\Controller\Traits;

/**
 * Description of ControllerTrait
 *
 * @author fantoine
 */
trait SeoControllerTrait {
    
    /**
     * Seo manager
     */
    private $seo;
    
    /**
     * 
     * @return type
     */
    private function seo()
    {
        if (!$this->seo)
            $this->seo = $this->get('ixoil_core.service.seo');
        
        return $this->seo;
    }
    
    /**
     * 
     * @param string $title
     */
    protected function setTitle($title)
    {
        $this->seo()->setTitle($title);
    }
    
    /**
     * 
     * @param string $subtitle
     */
    protected function setSubTitle($subtitle)
    {
        $this->seo()->setSubTitle($subtitle);
    }
}
