<?php

namespace Ixoil\StockMarketBundle\Provider\Brent;

use Ixoil\StockMarketBundle\Provider\BaseLoader;

/**
 * Class LesEchosLoader
 * @package Ixoil\StockMarketBundle\Provider\Brent
 */
class LesEchosLoader extends BaseLoader
{
    /**
     * @return array|false
     */
    public function load()
    {
        // Load page
        $content = $this->httpGet('http://bourse.lesechos.fr/bourse/streaming/getCours.jsp?code=C%3APBROUSDBR.SP&place=WCOMO&codif=ISO');
        $body = $content->getBody(true);

        // Extract JSON
        $json = json_decode(utf8_decode(trim($body)), true);

        // Get value
        $value = floatval(str_replace(',', '.', $json['cotation']['valorisationEnc']));

        // Get datetime
        $date = array();
        preg_match('@^(?P<day>[0-9]{1,2})/(?P<month>[0-9]{1,2})/(?P<year>[0-9]{2,4})$@', trim($json['cotation']['jour']), $date);

        $time = array();
        preg_match('@^(?P<hour>[0-9]{1,2})H (?P<minute>[0-9]{1,2})mn (?P<second>[0-9]{1,2})s$@', trim($json['cotation']['heure_secondes']), $time);

        // Fix year
        if(strlen($date['year']) == 2) {
            $prefix = substr(date('Y'), 0, 2);
            $date['year'] = $prefix . $date['year'];
        }

        $mktime = mktime(
            $time['hour'],
            $time['minute'],
            $time['second'],
            $date['month'],
            $date['day'],
            $date['year']
        );

        $datetime = date_create(date('Y-m-d H:i:s', $mktime), new \DateTimeZone('Europe/Paris'));

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
        return 'Les Echos Bourse';
    }
}