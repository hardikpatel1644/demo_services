<?php

namespace Ixoil\CmsBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Ixoil\CoreBundle\Controller\Controller;

/**
 * @Route("/")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="ixoil_index")
     */
    public function indexAction()
    {
        return $this->render('IxoilCmsBundle:Default:index.html.twig');
    }
}
