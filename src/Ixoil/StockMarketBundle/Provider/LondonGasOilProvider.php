<?php

namespace Ixoil\StockMarketBundle\Provider;

/**
 * Class LondonGasOilProvider
 * @package Ixoil\StockMarketBundle\Provider
 */
class LondonGasOilProvider extends BaseProvider
{
    /**
     * @return string
     */
    public function getSymbol()
    {
        return 'LGOH4';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'London Gas Oil';
    }
}