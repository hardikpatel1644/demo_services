<?php

namespace Ixoil\UserBundle\Model;

/**
 * Class AccountStatus
 * @package Ixoil\UserBundle\Model
 */
abstract class AccountStatus
{
    /**
     * Account has not been checked
     */
    const Unchecked     = 0;
    
    /**
     * Account has been refused
     */
    const Refused       = 1;
    
    /**
     * Some informations are missing to finish to validate the account
     */
    const Pending       = 2;
    
    /**
     * Account has been accepted
     */
    const Accepted      = 3;
}