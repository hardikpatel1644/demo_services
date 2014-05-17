<?php

namespace Ixoil\CoreBundle\Twig\Extension;

/**
 * Class SeoExtension
 * @package Ixoil\CoreBundle\Twig\Extension
 */
class SeoExtension extends \Twig_Extension
{
    /**
     * @var 
     */
    protected $breadcrumbs;
    
    /**
     * @var 
     */
    protected $translator;
    
    /**
     * @var 
     */
    protected $seo;
    
    /**
     * @param
     */
    public function __construct($breadcrumbs, $translator, $seo)
    {
        $this->breadcrumbs = $breadcrumbs;
        $this->translator = $translator;
        $this->seo = $seo;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ixoil_core_seo';
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            'ixoil_title'           => new \Twig_Function_Method($this, 'getTitle', array('is_safe' => array('html'))),
            'ixoil_subtitle'        => new \Twig_Function_Method($this, 'getSubTitle', array('is_safe' => array('html'))),
            'ixoil_print_title'     => new \Twig_Function_Method($this, 'printTitle', array('is_safe' => array('html'))),
            'ixoil_print_subtitle'  => new \Twig_Function_Method($this, 'printSubTitle', array('is_safe' => array('html'))),
        );
    }

    /**
     *
     */
    public function getTitle($parameters = array(), $translationDomain = '')
    {
        // Get title
        $title = "";
        if ($this->seo->getTitle())
            $title = $this->seo->getTitle();
        else if(count($this->breadcrumbs))
            $title = $this->breadcrumbs[count($this->breadcrumbs) - 1]->text;
        
        // Translate and print it
        return $this->translator->trans($title, $parameters, $translationDomain);
    }
    
    /**
     *
     */
    public function getSubTitle($parameters = array(), $translationDomain = '')
    {
        // Get title
        $subtitle = "";
        if ($this->seo->getSubTitle())
            $subtitle = $this->seo->getSubTitle();
        
        // Translate and print it
        return $this->translator->trans($subtitle, $parameters, $translationDomain);
    }
    
    /**
     *
     */
    public function printTitle($parameters = array(), $translationDomain = '')
    {
        // Get title and print it
        echo htmlentities($this->getTitle($parameters, $translationDomain));
    }
    
    /**
     *
     */
    public function printSubTitle($parameters = array(), $translationDomain = '')
    {
        // Get title and print it
        echo htmlentities($this->getSubTitle($parameters, $translationDomain));
    }
}