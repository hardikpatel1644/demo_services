<?php

namespace Ixoil\StockMarketBundle\Provider;

/**
 * Class BrentProvider
 * @package Ixoil\StockMarketBundle\Provider
 */
class BrentProvider extends BaseProvider
{
    /**
     * @return string
     */
    public function getSymbol()
    {
        return 'BRENT';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'Brent';
    }
}