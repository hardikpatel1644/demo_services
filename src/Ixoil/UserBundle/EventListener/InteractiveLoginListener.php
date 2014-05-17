<?php

namespace Ixoil\UserBundle\EventListener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\Mapping AS ORM;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Flash;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

/**
 * Override fos interactive listener
 *
 * @author HARDIK
 */
class InteractiveLoginListener
{

    /**
     *
     * @var \Ixoil\CoreBundle\Manager\AccountManager $accountManager
     */
    protected $accountManager;

    /**
     *
     * @var Flash\FlashBag $obFlashBag
     */
    protected $obFlashBag;

    /**
     *
     * @var \Symfony\Component\DependencyInjection\Container $obContainer 
     */
    protected $obContainer;

    /**
     * @var \Doctrine\ORM\EntityManager $obEm
     */
    protected $obEm;

    /**
     * $var Router
     */
    public $obRouter;

    /**
     *
     * @var Symfony\Component\Translation\TranslatorInterface   $obTranslator
     */
    public $obTranslator;

    /**
     *
     * @var redirect Url $ssUrl
     */
    protected $ssUrl;

    /**
     * Default constructor
     * @param $accountManager
     */
    public function __construct($accountManager, $obContainer)
    {
        $this->accountManager = $accountManager;
        $this->obContainer = $obContainer;
        $this->obFlashBag = $this->obContainer->get('session')->getFlashBag();
        $this->obEm = $this->obContainer->get('doctrine.orm.entity_manager');

        $this->obRouter = $this->obContainer->get('router');
        $this->obTranslator = $this->obContainer->get('translator');
    }

    /**
     * Function to chcek validation login 
     * @param \Symfony\Component\Security\Http\Event\InteractiveLoginEvent $obEvent
     */
    public function onLogin(InteractiveLoginEvent $obEvent)
    {
        $obUser = $obEvent->getAuthenticationToken()->getUser();
        if ($obUser && $obUser->getAccount()) {
            $hasActiveSubscription = $this->accountManager->hasActiveSubscription($obUser->getAccount());
            if ($obUser->getIsOwner() == true && $hasActiveSubscription == false) {
                // Logout
                $this->accountManager->removeAuthentication();
                
                // Add flashbag message
                $this->obFlashBag->set('alert', $this->obTranslator->trans('core.messages.error.subscription.renew', array(), 'core'));
                
                // Make sure to redirect to subscription page
                $this->ssUrl = 'ixoil_subscription';
            }
            // Check validity of the user and its account
            else if ($obUser instanceof UserInterface && !$this->accountManager->isValid($obUser->getAccount())) {
                // Logout
                $this->accountManager->removeAuthentication();

                // Add flashbag message
                $this->obFlashBag->set('danger', $this->obTranslator->trans('core.messages.error.invalid_login', array(), 'core'));

                // Make sure to redirect to home page
                $this->ssUrl = 'fos_user_security_login';
            }
        }
    }

    /**
     * Function to redirect response on kernel event
     * @param \Symfony\Component\HttpKernel\Event\FilterResponseEvent $obEvent
     */
    public function onKernelResponse(FilterResponseEvent $obEvent)
    {
        if (null !== $this->ssUrl) {
            $ssUrl = $this->obRouter->generate($this->ssUrl);
            $obEvent->setResponse(new RedirectResponse($ssUrl));
        }
    }
}

