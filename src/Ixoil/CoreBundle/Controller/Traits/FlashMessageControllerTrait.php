<?php

namespace Ixoil\CoreBundle\Controller\Traits;

/**
 * Description of FlashMessageControllerTrait
 *
 * @author fantoine
 */
trait FlashMessageControllerTrait {
    /**
     * Session flashbag
     */
    private $flashbag;
    
    /**
     * Add one or more messages to session FlashBag
     * @param string $type
     * @param string|array $message
     */
    protected function addFlashMessage($type, $message)
    {
        if (!$this->flashbag)
            $this->flashbag = $this->get('session')->getFlashBag();
        
        $list = (!is_array($message) ? array($message) : $message);
        foreach ($list as $msg)
            $this->flashbag->add($type, $msg);
    }
    
    /**
     * Add Info flash message
     * @param string|array $message
     */
    protected function addInfo($message)
    {
        $this->addFlashMessage('info', $message);
    }
    
    /**
     * Add Error flash message
     * @param string|array $message
     */
    protected function addError($message)
    {
        $this->addFlashMessage('danger', $message);
    }
    
    /**
     * Add Warning flash message
     * @param string|array $message
     */
    protected function addWarning($message)
    {
        $this->addFlashMessage('warning', $message);
    }
    
    /**
     * Add Success flash message
     * @param string|array $message
     */
    protected function addSuccess($message)
    {
        $this->addFlashMessage('success', $message);
    }
}
