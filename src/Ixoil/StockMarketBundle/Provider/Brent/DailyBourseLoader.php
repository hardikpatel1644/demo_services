<?php

namespace Ixoil\StockMarketBundle\Provider\Brent;

use Ixoil\StockMarketBundle\Provider\BaseLoader;

/**
 * Class DailyBourseLoader
 * @package Ixoil\StockMarketBundle\Provider\Brent
 */
class DailyBourseLoader extends BaseLoader
{
    /**
     * @return array|false
     */
    public function load()
    {
        // Load page
        $crawler = $this->crawlGet('http://www.daily-bourse.fr/cours-petrole.php');

        // Search value
        $value = floatval($crawler->filter('#page .column.w725 .left.w350 span.txtxxxlarge')->text());

        // Search date
        $dateText = $crawler->filter('#page .column.w725 .left.w350 > p')->text();

        // Get datetime
        $date = array();
        if(!preg_match('@(?P<day>[0-9]{1,2})/(?P<month>[0-9]{1,2})/(?P<year>[0-9]{2,4}) à (?P<hour>[0-9]{1,2}):(?P<minute>[0-9]{1,2}):(?P<second>[0-9]{1,2})@', $dateText, $date))
            return false;

        $mktime = mktime(
            $date['hour'],
            $date['minute'],
            $date['second'],
            $date['month'],
            $date['day'],
            $date['year']
        );

        $datetime = date_create(date('Y-m-d H:i:s', $mktime), new \DateTimeZone('Europe/Paris'));

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
        return 'Daily Bourse';
    }
}