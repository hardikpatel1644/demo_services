<?php

namespace Ixoil\EmailBundle\Mailer;

use Symfony\Component\DomCrawler\Crawler;

/**
 * Description of MailerHelper
 *
 * @author OXIND
 */
class DefaultMailer
{

    /**
     * @param \Swift_Mailer $swiftMailer
     */
    protected $swiftMailer;

    /**
     * @var string
     */
    protected $defaultSender;
    
    /**
     *
     * @var type 
     */
    protected $kernel;

    /**
     *
     * @var string|null
     */
    protected $webPath = null;
    
    /**
     * 
     * @param \Swift_Mailer $swiftMailer
     * @param string $defaultSender
     */
    function __construct($kernel, \Swift_Mailer $swiftMailer, $defaultSender)
    {
        $this->kernel = $kernel;
        $this->swiftMailer = $swiftMailer;
        $this->defaultSender = $defaultSender;
    }

    /**
     * Prepare a Swift_Mailer message instance and fill it with specified datas
     * @param $to
     * @param $subject
     * @param $body
     * @param $altBody
     * @param $embedImages
     * @return \Swift_Mime_SimpleMessage
     */
    public function createEmail($to, $subject, $body, $altBody = null, $embedImages = true)
    {
        // Prepare email
        $email = \Swift_Message::newInstance()
            //->setContentType('text/html')
            ->setFrom($this->defaultSender)
            ->setTo($to)
            ->setSubject($subject)
            ->setContentType('text/html');
        
        // Embed images if required
        if ($embedImages)
            $body = $this->embedImages($email, $body);
        
        // Prepare a default plain text message
        if (!$altBody)
            $altBody = trim(strip_tags($body));
        
        // Set body
        $email
            ->setBody($body, 'text/html')
            ->addPart($altBody, 'text/plain');

        // Return the email content
        return $email;
            
    }

    /**
     * Send an already prepared email
     * @param \Swift_Message $message
     * @return boolean
     */
    public function sendEmail(\Swift_Message $message)
    {
        // Assign a default sender if not specified
        if (!$message->getFrom())
            $message->setFrom($this->defaultSender);

        // Send email
        return (bool) $this->swiftMailer->send($message);
    }

    /**
     * Process the email sending
     * @param string $to
     * @param string $subject
     * @param string $body
     * @param string|null $altBody
     * @return boolean
     */
    public function sendSimpleEmail($to, $subject, $body, $altBody = null, $embedImages = true)
    {
        // Prepare email message
        $message = $this->createEmail($to, $subject, $body, $altBody, $embedImages);

        // Use SwiftMailer to send a simple html/text email
        $result = $this->swiftMailer->send($message);
        return ($result === 1);
    }

    /**
     * Extract images and embed them directly in the email
     * @param \Swift_Mime_SimpleMessage $email
     * @param string $body
     * @return string
     */
    protected function embedImages(&$email, $body)
    {
        $crawler = new Crawler($body);
        
        // Get web path
        $webPath = $this->getWebPath();
        
        // Save CIDs for re-use
        $cids = array();
        
        // Get all images
        $crawler->filter('img')->each(function($node, $i) use (&$email, $webPath) {
            // Get file path
            $path = $webPath . $node->attr('src');
            
            // Check if we already have this CIDs
            // Otherwise, if image exists, embed it
            // Otherwise, don't change anything
            $cid = '';
            if (isset($cids[$path])) {
                $cid = $cids[$path];
            } else if (file_exists($path)) {
                $cid = $cids[$path] = $email->embed(\Swift_Image::fromPath($path));
            } else {
                return;
            }
            
            // Replace url
            $node->getNode(0)->setAttribute('src', $cid);
        });
        
        // Extract xml from crawler
        return $this->saveXML($crawler);
    }
    
    /**
     * Return the path to web/ directory
     * @return string
     */
    protected function getWebPath()
    {
        if (!$this->webPath)
            $this->webPath = $this->kernel->getRootDir() . '/../web';
        
        return $this->webPath;
    }
    
    /**
     * Crawler doesn't provide an easy way to extract xml content.
     * HTML export doesn't close empty tags with a slash however missing slashes may break strip_tags().
     * This method is mostly a copy/paste of Crawler::html(), but using saveXML() method instead.
     * @param \Symfony\Component\DomCrawler\Crawler $crawler
     */
    protected function saveXML(Crawler $crawler)
    {
        if (!count($this)) {
            throw new \InvalidArgumentException('The current node list is empty.');
        }

        $xml = '';
        foreach ($crawler->getNode(0)->childNodes as $child)
            $xml .= $child->ownerDocument->saveXML($child);

        return $xml;
    }
}
