<?php

namespace Ixoil\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Ixoil\CoreBundle\Controller\Controller;

/**
 * @Route("/subscription")
 */
class SubscriptionController extends Controller
{
    /**
     * @Route("/", name="ixoil_subscription")
     * @Template()
     */
    public function indexAction()
    {
        // Set breadcrumb
        $this
            ->addBreadcrumb('header.home', 'ixoil_index')
            ->addBreadcrumb('nomenu.subscription.renew');
        
        return $this->render('IxoilUserBundle:Subscription:index.html.twig');
    }
}
