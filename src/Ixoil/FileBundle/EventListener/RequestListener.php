<?php

namespace Ixoil\FileBundle\EventListener;

use \Symfony\Component\HttpKernel\Event\GetResponseEvent;

/**
 * Description of RequestEventListener
 *
 * @author fantoine
 */
class RequestListener {
    /**
     *
     * @var
     */
    protected $helper;
    
    /**
     * 
     * @param $helper
     */
    public function __construct($helper) {
        $this->helper = $helper;
    }
    
    /**
     * 
     * @param type $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        // Randomly execute GC for temporary files
        $this->gcTemporaryFiles();
    }
    
    /**
     * Executes file helper clearTemporaryFiles() method
     */
    protected function gcTemporaryFiles()
    {
        $rand = mt_rand(0, 100);
        
        // 2/100 chance of executing the temporary clear
        if ($rand < 2)
            $this->helper->clearTemporaryFiles();
    }
}
