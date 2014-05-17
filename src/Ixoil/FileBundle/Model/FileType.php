<?php

namespace Ixoil\FileBundle\Model;

/**
 * Description of FileType
 *
 * @author OXIND
 */
class FileType
{
    /**
     * 
     */
    const Account = "account";
    
    /**
     * 
     */
    const User = "user";
    
    /**
     * 
     */
    const Tmp = "tmp";
    
    /**
     *
     * @var type 
     */
    protected $type;
    
    /**
     *
     * @var type 
     */
    protected $value;
    
    /**
     * 
     * @param type $type
     * @param type $value
     */
    private function __construct($type, $value = null)
    {
        $this->type = $type;
        $this->value = $value;
    }
    
    /**
     * 
     * @return type
     */
    public function getType()
    {
        return $this->type;
    }
    
    /**
     * 
     * @return type
     */
    public function getValue()
    {
        return $this->value;
    }
    
    /**
     * 
     * @param type $value
     * @return \FileType
     */
    public static function account($value)
    {
        return new FileType(self::Account, $value);
    }
    
    /**
     * 
     * @param type $value
     * @return \FileType
     */
    public static function user($value)
    {
        return new FileType(self::User, $value);
    }
    
    /**
     * 
     */
    private static $tmp = null;
    public static function tmp()
    {
        if(!self::$tmp)
            self::$tmp = new FileType(self::Tmp);
        
        return self::$tmp;
    }
}