<?php

namespace Ixoil\CmsBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Ixoil\CoreBundle\Controller\Controller;

/**
 * @Route("/")
 */
class PageController extends Controller
{
    /**
     * @Route("/qui-sommes-nous", name="ixoil_cms_whoweare")
     */
    public function whoWeAreAction()
    {
        // Set breadcrumb
        $this
            ->addBreadcrumb('header.home', 'ixoil_index')
            ->addBreadcrumb('header.whoWeAre')
        ;
        
        return $this->render('IxoilCmsBundle:Page:whoweare.html.twig');
    }

    /**
     * @Route("/a-propos", name="ixoil_cms_aboutus")
     */
    public function aboutusAction()
    {
        // Set breadcrumb
        $this
            ->addBreadcrumb('header.home', 'ixoil_index')
            ->addBreadcrumb('header.aboutUs')
        ;
        
        return $this->render('IxoilCmsBundle:Page:aboutus.html.twig');
    }
}
