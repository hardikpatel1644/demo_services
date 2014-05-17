<?php

namespace Ixoil\StockMarketBundle\Provider\LondonGasOil;

use Ixoil\StockMarketBundle\Provider\BaseLoader;

/**
 * Class InvestingLoader
 * @package Ixoil\StockMarketBundle\Provider\LondonGasOil
 */
class InvestingLoader extends BaseLoader
{
    /**
     * @return array|false
     */
    public function load()
    {
        // Load page
        $crawler = $this->crawlGet('http://www.investing.com/commodities/london-gas-oil');

        // Search value
        $value = floatval($crawler->filter('#last_last')->text());

        // Search date
        $dateText = $crawler->filter('#quotes_summary_current_data .left .bottom.lighterGrayFont.arial_11 span:nth-child(2)')->text();
        $date = array();
        if(!preg_match('/(?P<hour>[0-9]{1,2}):(?P<minute>[0-9]{1,2}):(?P<second>[0-9]{1,2})/', $dateText, $date))
            return false;

        // Prepare date
        $datetime = new \DateTime();
        $datetime->setTimezone(new \DateTimeZone('UTC'));
        $datetime->setTime($date['hour'], $date['minute'], $date['second']);

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
        return 'Investing';
    }
}