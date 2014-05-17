<?php

namespace Ixoil\CoreBundle\Controller\Traits;

/**
 * Description of RouterControllerTrait
 *
 * @author fantoine
 */
trait RouterControllerTrait {
    use FlashMessageControllerTrait;
    
    /**
     * Redirect to specified route.
     * Can also add messages to flash bag
     * @param string $route
     * @param array $args
     * @param array $messages
     * @param integer $status
     * @return RedirectResponse
     */
    protected function redirectTo($route, $messages = array(), $args = array(), $status = 302)
    {
        return $this->redirectToUrl(
            $this->generateUrl($route, $args),
            $messages,
            $status
        );
    }
    
    /**
     * Redirect to specified URL.
     * @param string $url
     * @param array $messages
     * @param int $status
     * @return RedirectResponse
     */
    protected function redirectToUrl($url, $messages = array(), $status = 302)
    {
        // Add flash messages
        if (count($messages) > 0)
            foreach ($messages as $type => $message)
                $this->addFlashMessage($type, $message);
        
        // Do redirection
        return $this->redirect($url, $status);
    }
}
