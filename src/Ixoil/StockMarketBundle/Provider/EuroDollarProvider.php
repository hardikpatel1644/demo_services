<?php

namespace Ixoil\StockMarketBundle\Provider;

/**
 * Class EuroDollarProvider
 * @package Ixoil\StockMarketBundle\Provider
 */
class EuroDollarProvider extends BaseProvider
{
    /**
     * @return string
     */
    public function getSymbol()
    {
        return 'EURUSD';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'Euro-Dollar parity';
    }
}