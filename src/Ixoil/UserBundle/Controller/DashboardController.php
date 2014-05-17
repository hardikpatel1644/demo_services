<?php

namespace Ixoil\UserBundle\Controller;

use Symfony\Component\Routing\Annotation\Route as Route;
use Ixoil\CoreBundle\Controller\Controller;
use Ixoil\UserBundle\Model\AccountType;
use JMS\SecurityExtraBundle\Annotation\PreAuthorize;

/**
 * @Route("/dashboard")
 * @PreAuthorize("isAuthenticated()")
 */
class DashboardController extends Controller
{
    /**
     * @Route("/", name="ixoil_dashboard")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        
        // Set breadcrumb
        $this->addBreadcrumb('restricted.dashboard');
        $this->setSubTitle($this->trans(
            'dashboard.subtitle', 
            array(
                '%firstname%' => $user->getFirstname(),
                '%lastname%' => $user->getLastname(),
            ),
            'dashboard'
        ));
        
        // Display the right dashboard
        switch ($user->getAccountType()) {
            case AccountType::Purchaser:
                return $this->purchaserDashboard();

            case AccountType::Provider:
                return $this->providerDashboard();

            case AccountType::Logistician:
                return $this->logisticianDashboard();

            case AccountType::PurchaserLogistician:
                return $this->purchaserLogisticianDashboard();

            default:
                $securityContext = $this->get('security.context');
                return ($securityContext->isGranted('ROLE_SUPER_ADMIN') ?
                    $this->redirectTo('sonata_admin_dashboard') :
                    $this->render('IxoilUserBundle:Dashboard:index.html.twig')
                );
        }
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function purchaserDashboard()
    {
        $accountManager = $this->get('ixoil_user.manager.account');
        
        return $this->render(
            'IxoilUserBundle:Dashboard:index.purchaser.html.twig', array(
                'subscription' => $accountManager->getActiveSubscription()
            )
        );
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function providerDashboard()
    {
        return $this->render('IxoilUserBundle:Dashboard:index.provider.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function logisticianDashboard()
    {
        return $this->render('IxoilUserBundle:Dashboard:index.logistician.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function purchaserLogisticianDashboard()
    {
        return $this->render('IxoilUserBundle:Dashboard:index.purchaser-logistician.html.twig');
    }

}
