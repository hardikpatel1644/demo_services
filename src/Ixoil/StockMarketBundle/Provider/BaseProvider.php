<?php

namespace Ixoil\StockMarketBundle\Provider;

/**
 * Class BaseProvider
 * @package Ixoil\StockMarketBundle\Provider
 */
abstract class BaseProvider
{
    /**
     * @var array
     */
    protected $loaders = array();

    /**
     * @param BaseLoader $loader
     * @param string $alias
     */
    public function addLoader(BaseLoader $loader, $alias)
    {
        $this->loaders[$alias] = $loader;
    }

    /**
     * @return array
     */
    public function getLoaders()
    {
        return $this->loaders;
    }

    /**
     * @param $alias
     * @return BaseLoader|null
     */
    public function getLoader($alias)
    {
        return ($this->hasLoader($alias) ? $this->loaders[$alias] : null);
    }

    /**
     * @param string $alias
     * @return bool
     */
    public function hasLoader($alias)
    {
        return isset($this->loaders[$alias]);
    }


    /**
     * @return string
     */
    abstract public function getSymbol();

    /**
     * @return string
     */
    abstract public function getName();
}