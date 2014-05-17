<?php

namespace Ixoil\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Ixoil\CoreBundle\Controller\Controller;
use Ixoil\EmailBundle\Model\EmailType;
use JMS\SecurityExtraBundle\Annotation\PreAuthorize;

/**
 * @Route("/registration")
 * @PreAuthorize("isAnonymous()")
 */
class RegistrationController extends Controller
{
    /**
     * @Route("/", name="ixoil_registration")
     */
    public function indexAction()
    {
        // Get the manager
        $registration = $this->get('ixoil_user.helper.registration');

        // Check if we have a registration type, otherwise redirect to home
        if (!$registration->getRegistrationType()) {
            return $this->redirectTo(
                'ixoil_index', 
                array('danger' => $this->trans('flash.invalidaccounttype', array(), 'registration'))
            );
        }
        
        // Get the handler
        $handler = $this->get('ixoil_user.form.registration.handler');

        $process = $handler->process();
        if ($process) {
            $goToNextStep = true;

            // On last step, we send email and save data...
            if ($handler->isLastStep()) {
                $goToNextStep = $registration->saveRegistration($handler->getFormModel());

                if ($goToNextStep) {
                    $registration->sendConfirmationMail();
                    $handler->clearFlowSession();
                }
            }

            // Try to go to next step
            if ($goToNextStep) {
                if ($handler->getFlow()->nextStep())
                    $handler->resetForm();
            } else {
                // Display error message
                $this->addError($this->trans('error.unexpected', array(), 'registration'));
            }
        }

        return $this->render(
            'IxoilUserBundle:Registration:index.html.twig', 
            array(
                'form' => $handler->getForm(),
                'formView' => $handler->getForm()->createView(),
                'flow' => $handler->getFlow(),
                'recap' => $handler->getFlow()->getFormData(),
                'type' => $registration->getRegistrationType(),
            )
        );
    }
    
    /**
     * @Route("/resendconfirmationmail", name="ixoil_registration_resendconfirmationmail")
     */
    public function resendConfirmationMailAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $registration = $this->get('ixoil_user.helper.registration');
            $registration->sendConfirmationMail();
        }
        
        $message = $this->trans('flash.mail_send', array(), 'registration');
        return new Response($message);
    }
    
    /**
     * @Route("/confirmemail/{token}", name="ixoil_registration_confirmemail")
     */
    public function confirmEmailAction($token)
    {
        // Find user with received token.
        $userManger = $this->get('fos_user.user_manager');
        
        /* @var $user \Ixoil\UserBundle\Entity\User */
        $user = $userManger->findUserByConfirmationToken($token);
        if (null === $user) {
            return $this->redirectTo(
                'fos_user_security_login', 
                array('danger' => $this->trans('flash.token_missing', array(), 'registration'))
            );
        }

        // Set token to null and enable user.
        $user->setConfirmationToken(null);
        $user->setEnabled(true);
        $userManger->updateUser($user);
         
        // Send am Email to Administrator.
        $userProfileURL = $this->generateUrl(
            'admin_ixoil_core_account_show',
            array('id'=>$user->getAccount()->getId()), 
            UrlGeneratorInterface::ABSOLUTE_URL
        );
        
        $adminMailID = $this->container->getParameter('admin_email');
        
        /* @var $mailer \Ixoil\EmailBundle\Mailer\TwigMailer */
        $mailer = $this->get('ixoil_email.mailer.twig');
        $mailer->sendTwigEmail(
            $adminMailID, 
            EmailType::EmailConfirmed,
            array('name' => 'Admin', 'profile_url' => $userProfileURL)
        );
        
        return $this->redirectTo(
            'fos_user_security_login', 
            array('success' => $this->trans('flash.emailconfirm', array(), 'registration'))
        );
    }
    
    /**
     * @Route("/{type}", name="ixoil_registration_type")
     */
    public function typeAction($type)
    {
        // Get the manager
        $registration = $this->get('ixoil_user.helper.registration');
        
        // Clear session
        $handler = $this->get('ixoil_user.form.registration.handler');
        $handler->clearFlowSession();
        $registration->clearRegistrationFilesSession();
        
        // Save registration type in session
        $process = $registration->saveRegistrationType($type);
        if($process) {
            // Redirect to registration index
            return $this->redirectTo('ixoil_registration');
        } else {
            return $this->redirectTo(
                'ixoil_index',
                array('danger' => $this->trans('flash.invalidaccounttype', array(), 'registration'))
            );
        }
    }
}
