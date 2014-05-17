<?php

namespace Ixoil\CmsBundle\Controller;

use Ixoil\CoreBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * @Route("/contact")
 */
class ContactController extends Controller
{
    /**
     * @Route("/", name="ixoil_cms_contact")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function indexAction()
    {
        // Set breadcrumb
        $this
            ->addBreadcrumb('header.home', 'ixoil_index')
            ->addBreadcrumb('header.contact')
        ;
        
        // Get the session
        $flashBag = $this->get('session')->getFlashBag();

        // Get the form
        $form = $this->get('ixoil_cms.contact.form');

        // Get the handler
        $handler = $this->get('ixoil_cms.contact.form.handler');

        $process = $handler->process();
        if ($process) {
            return $this->redirectTo(
                'ixoil_cms_contact', 
                array('success' => $this->trans('contact.message.sent', array(), 'cms'))
            );
        }

        // Add error message
        if ($handler->hasError())
            $this->addError($this->trans('contact.message.error', array(), 'cms'));

        return array(
            'form' => $form->createView()
        );
    }
}
