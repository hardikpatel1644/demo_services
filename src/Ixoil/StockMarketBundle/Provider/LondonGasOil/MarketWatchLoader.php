<?php

namespace Ixoil\StockMarketBundle\Provider\LondonGasOil;

use Ixoil\StockMarketBundle\Provider\BaseLoader;

/**
 * Class MarketWatchLoader
 * @package Ixoil\StockMarketBundle\Provider\LondonGasOil
 */
class MarketWatchLoader extends BaseLoader
{
    /**
     * @return array|false
     */
    public function load()
    {
        // Load page
        $crawler = $this->crawlGet('http://www.marketwatch.com/investing/future/lgoh4?countrycode=uk');

        // Search value
        $value = floatval($crawler->filter('#maincontent .pricewrap .data')->text());

        // Search date
        $dateText = $crawler->filter('#maincontent .lastpricedetails .bgTimestamp.longformat')->text();
        $datetime = new \DateTime($dateText, new \DateTimeZone('UTC'));

        return array(
            'value' => $value,
            'date' => $datetime,
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'Market Watch';
    }
}