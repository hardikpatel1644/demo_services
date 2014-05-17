<?php

namespace Ixoil\StockMarketBundle\Provider\EuroDollar;

use Ixoil\StockMarketBundle\Provider\BaseLoader;

/**
 * Class YahooLoader
 * @package Ixoil\StockMarketBundle\Provider\EuroDollar
 */
class YahooLoader extends BaseLoader
{
    /**
     * @return array|false
     */
    public function load()
    {
        // Load page
        $content = $this->httpGet('http://download.finance.yahoo.com/d/quotes.csv?s=EURUSD=X&f=l1d1t1&e=.csv');
        $body = $content->getBody(true);

        // Extract CSV
        $csv = str_getcsv($body);

        // Get value
        $value = floatval($csv[0]);

        // Get datetime
        $date = date_parse($csv[1]);
        $time = date_parse($csv[2]);
        $mktime = mktime(
            $time['hour'],
            $time['minute'],
            $time['second'],
            $date['month'],
            $date['day'],
            $date['year']
        );
        $datetime = date_create(date('Y-m-d H:i:s', $mktime), new \DateTimeZone('EST'));

        return array(
            'value' => $value,
            'date' => $datetime
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'Yahoo Finance';
    }
}