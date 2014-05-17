<?php

namespace Ixoil\StockMarketBundle\Provider\EuroDollar;

use Ixoil\StockMarketBundle\Provider\BaseLoader;

/**
 * Class XeLoader
 * @package Ixoil\StockMarketBundle\Provider\EuroDollar
 */
class XeLoader extends BaseLoader
{
    /**
     * @return array|false
     */
    public function load()
    {
        // Load page
        $crawler = $this->crawlGet('http://www.xe.com/fr/currencyconverter/convert/?Amount=1&From=EUR&To=USD');

        // Search value
        $value = floatval($crawler->filter('.ucc-result-table .uccRes .rightCol')->text());

        // Search date
        $dateText = $crawler->filter('.uccMMR a')->text();
        $matches = array();
        if(!preg_match('/(?P<date>[0-9]{4}-[0-9]{1,2}-[0-9]{1,2} [0-9]{1,2}:[0-9]{1,2})/', $dateText, $matches))
            return false;
        $datetime = date_create($matches['date'], new \DateTimeZone('UTC'));

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
        return 'Xe';
    }
}