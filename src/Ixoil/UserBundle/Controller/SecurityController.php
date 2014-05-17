<?php

namespace Ixoil\UserBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Sonata\UserBundle\Controller\SecurityFOSUser1Controller as BaseController;

/**
 * Description of SecurityController
 *
 * @author OXIND, HARDIK
 */
class SecurityController extends BaseController
{
    /**
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function loginAction()
    {
        $obSession = $this->container->get('session');

        if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            // Check subscription is expired or not when user is logged in .
            return new RedirectResponse($this->container->get('router')->generate('ixoil_dashboard'));
        } else {
            // Check condition for subscription expired or not and redirect on subscription page
            if ($obSession->get('subscription_expired')) {
                $obSession->remove('subscription_expired');
                
                return new RedirectResponse($this->container->get('router')->generate('ixoil_subscription'));
            }
            
            return parent::loginAction();
        }
    }
}