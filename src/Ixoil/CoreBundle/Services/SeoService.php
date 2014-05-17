<?php

namespace Ixoil\CoreBundle\Services;

/**
 * Description of SeoService
 *
 * @author fantoine
 */
class SeoService {
    /**
     *
     * @var string
     */
    protected $title = null;
    
    /**
     *
     * @var string
     */
    protected $subtitle = null;
    
    /**
     * 
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }
    
    /**
     * 
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
    
    /**
     * 
     * @param string $title
     */
    public function setSubTitle($subtitle)
    {
        $this->subtitle= $subtitle;
    }
    
    /**
     * 
     * @return string
     */
    public function getSubTitle()
    {
        return $this->subtitle;
    }
}
