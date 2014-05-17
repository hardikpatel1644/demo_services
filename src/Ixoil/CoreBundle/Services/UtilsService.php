<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ixoil\CoreBundle\Services;

/**
 * Description of UtilsService
 *
 * @author OXIND
 */
class UtilsService
{
    /**
     * generate password of given length.
     * @param integer $length
     * @return string 
     */
    function generatePassword($length = 8, $upperCharCount = 0, $numberCharCount = 0,$specialCharCount = 0)
    {   
        $smallChars = 'abcdefghijklmnopqrstuvwxyz';
        $upperChars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numberChars = '0123456789';
        $specialChars = '!@#$%^&*()_-=+;:,.?';
        
        $password = '';
        
        if(($upperCharCount + $numberCharCount + $specialCharCount) <= $length )
        {
            if ($upperCharCount > 0)
            {
                $password .= substr(str_shuffle($upperChars), 0, $upperCharCount);
                $length -= $upperCharCount;
            }

            if ($numberCharCount > 0)
            {
                $password .= substr(str_shuffle($numberChars), 0, $numberCharCount);
                $length -= $numberCharCount;
            }

            if ($specialCharCount > 0)
            {
                $password .= substr(str_shuffle($specialChars), 0, $specialCharCount);
                $length -= $specialCharCount;
            }
            
            $password .= substr(str_shuffle($smallChars), 0, $length);
            
            $password = str_shuffle($password);
        }
        else
        {
           $chars = $smallChars.$upperCharCount.$numberCharCount.$specialChars;
           
           $password .= substr(str_shuffle($chars), 0, $length);
        }
            
        return $password;
    }

}
