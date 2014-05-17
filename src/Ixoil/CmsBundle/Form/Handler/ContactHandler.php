<?php

namespace Ixoil\CmsBundle\Form\Handler;

use Ixoil\CmsBundle\Form\Model\Contact;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Ixoil\EmailBundle\Model\EmailType;

class ContactHandler
{
    /**
     * @var \Symfony\Component\Form\Form
     */
    protected $form;

    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $request;

    /**
     * @var EngineInterface
     */
    protected $templating;

    /**
     * @var Swiftmailer
     */
    protected $mailer;

    /**
     * @var
     */
    protected $translator;

    /**
     * @var string
     */
    protected $contactEmail;

    /**
     * @var bool
     */
    protected $withError;

    /**
     * @param Form $form
     * @param Request $request
     * @param EngineInterface $templating
     * @param $mailer
     * @param Translator $translator
     * @param $contactEmail
     */
    public function __construct(Form $form, Request $request, EngineInterface $templating, $mailer, Translator $translator, $contactEmail)
    {
        $this->form = $form;
        $this->request = $request;
        $this->templating = $templating;
        $this->mailer = $mailer;
        $this->translator = $translator;
        $this->contactEmail = $contactEmail;

        $this->withError = false;
    }

    /**
     * Handle form
     *
     * @return Boolean
     */
    public function process()
    {
        $this->withError = false;

        // Check the method
        if($this->request->isMethod('POST')) {
            // Bind value with form
            $this->form->handleRequest($this->request);

            // Validate form
            if($this->form->isValid()) {
                $result = $this->onSuccess($this->form->getData());
                $this->withError = !$result;
                return $result;
            }
        }

        return false;
    }

    /**
     * @param \Ixoil\CmsBundle\Form\Model\Contact $data
     * @return bool
     */
    protected function onSuccess(Contact $data) {

        $result = $this->mailer->sendTwigEmail(
            $this->contactEmail,
            EmailType::ContactUs,
            array(
                'name'=> 'Admin', 
                'user_detail' => $data
            )
        );
        
        return $result;
    }

    /**
     * @return bool
     */
    public function hasError()
    {
        return $this->withError;
    }
}