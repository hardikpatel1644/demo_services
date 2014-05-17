<?php

namespace Ixoil\StockMarketBundle\Provider;

use Guzzle\Http\Client;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class BaseLoader
 * @package Ixoil\StockMarketBundle\Provider
 */
abstract class BaseLoader
{
    /**
     * @return false|array
     */
    abstract public function load();

    /**
     * @return string
     */
    abstract public function getName();


    /**
     * @param $url
     * @return Client
     */
    protected function getClient($url)
    {
        return new Client($url);
    }

    /**
     * @param $url
     * @return \Guzzle\Http\Message\Response
     */
    protected function httpGet($url)
    {
        $request = $this->getClient($url)->get();
        return $request->send();
    }

    /**
     * @param $url
     * @return Crawler
     */
    protected function crawlGet($url)
    {
        $response = $this->httpGet($url);
        return new Crawler($response->getBody(true), $url);
    }
}