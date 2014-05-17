<?php

namespace Ixoil\EmailBundle\Mailer;

use Symfony\Component\Templating\EngineInterface;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;

/**
 * Description of TwigMailer
 *
 * @author Hardik
 */
class TwigMailer extends DefaultMailer
{

    /**
     * @var \Symfony\Component\Templating\EngineInterface  $obTemplating 
     */
    protected $obTemplating;

    /**
     * @var Translator $obTranslator
     */
    protected $obTranslator;

    /**
     * Default constructor
     * @param $kernel
     * @param \Swift_Mailer $obSwiftMailer
     * @param string $ssDefaultSender
     * @param \Symfony\Component\Templating\EngineInterface $obTemplating
     * @param \Symfony\Bundle\FrameworkBundle\Translation\Translator $obTranslator
     */
    public function __construct($kernel, \Swift_Mailer $obSwiftMailer, $ssDefaultSender, EngineInterface $obTemplating, Translator $obTranslator)
    {
        parent::__construct($kernel, $obSwiftMailer, $ssDefaultSender);

        $this->obTemplating = $obTemplating;
        $this->obTranslator = $obTranslator;
    }

    /**
     * Function to send Email by selected email type and template
     * @param type $ssTo
     * @param string $ssEmailType
     * @param array $asData
     * @return boolean
     */
    public function sendTwigEmail($ssTo, $ssEmailType, $asData, $embedImages = true)
    {
        if (!empty($ssTo) && !empty($ssEmailType) && !empty($asData))
        {
            // Get email subject
            $ssSubject = $this->getSubject($ssEmailType);
            
            // Get email body
            $ssBody = $this->obTemplating->render(
                'IxoilEmailBundle:templates:' . $ssEmailType . '.html.twig', 
                array('mail_content' => $asData)
            );
            
            return $this->sendSimpleEmail($ssTo, $ssSubject, $ssBody, null, $embedImages);
        }
        
        return false;
    }

    /**
     * Function to get subject based on email type
     * @param string $ssEmailType
     * @return String
     */
    public function getSubject($ssEmailType)
    {
        // Get email subject translation key
        $ssSubject = (!empty($ssEmailType) ? 'email.subject.' . $ssEmailType : '');

        return $this->obTranslator->trans($ssSubject, array(), 'email');
    }
}
