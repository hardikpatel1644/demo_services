<?php

namespace Ixoil\CmsBundle\Controller;

use Ixoil\CoreBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of ErrorController
 *
 * @author fantoine
 * @Route("/error")
 */
class ErrorController extends Controller
{
    /**
     * @Route("/denied")
     */
    public function accessDeniedAction()
    {
        $this->setTitle($this->trans('error.access_denied.title', array(), 'error'));
        
        return $this->render('IxoilCmsBundle:Error:access_denied.html.twig');
    }
}
