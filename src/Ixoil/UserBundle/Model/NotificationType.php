<?php

namespace Ixoil\UserBundle\Model;

/**
 * Description of NotificationType
 */
class NotificationType
{
    /**
     * 
     */
    const ACCOUNT_ALMOST_EXPIRED = "account.almost.expired";
    
    
    /**
     *
     * @var string 
     */
    protected $type;
    
    /**
     *
     * @var type 
     */
    protected $arguments;
    
    /**
     * 
     * @param string $type
     * @param array $value
     */
    private function __construct($type, $arguments = null)
    {
        $this->type = $type;
        $this->arguments = $arguments;
    }
    
    /**
     * 
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
    
    /**
     * 
     * @return array
     */
    public function getArguments()
    {
        return $this->arguments;
    }
}