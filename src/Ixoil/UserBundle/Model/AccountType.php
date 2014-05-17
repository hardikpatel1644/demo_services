<?php

namespace Ixoil\UserBundle\Model;

/**
 * Class AccountType
 * @package Ixoil\UserBundle\Model
 */
abstract class AccountType
{
    /**
     * Unknown account type
     */
    const Unknown               = 'unknown';
    
    /**
     * Administrator
     */
    const Admin                 = 'admin';
    
    /**
     * Only purchaser account
     */
    const Purchaser             = 'purchaser';
    
    /**
     * Only provider account
     */
    const Provider              = 'provider';
    
    /**
     * Only logistician account
     */
    const Logistician           = 'logistician';
    
    /**
     * Purchaser and logistician account
     */
    const PurchaserLogistician  = 'purchaser-logistician';
}