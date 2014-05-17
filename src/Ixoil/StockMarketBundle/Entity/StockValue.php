<?php

namespace Ixoil\StockMarketBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity(repositoryClass="Ixoil\StockMarketBundle\Repository\StockValueRepository")
 * @ORM\Table(name="ixoil_stockmarket_stockvalue")
 */
class StockValue
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** 
     * @ORM\Column(type="float", nullable=false)
     */
    private $value;

    /** 
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $publication;

    /** 
     * @ORM\Column(type="string", nullable=false)
     */
    private $symbol;

    /** 
     * @ORM\Column(type="string", nullable=false)
     */
    private $loader;

    /** 
     * @ORM\Column(type="string", nullable=false)
     */
    private $provider;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set value
     *
     * @param string $value
     * @return StockValue
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set publication
     *
     * @param \DateTime $publication
     * @return StockValue
     */
    public function setPublication($publication)
    {
        $this->publication = $publication;

        return $this;
    }

    /**
     * Get publication
     *
     * @return \DateTime 
     */
    public function getPublication()
    {
        return $this->publication;
    }

    /**
     * Set symbol
     *
     * @param string $symbol
     * @return StockValue
     */
    public function setSymbol($symbol)
    {
        $this->symbol = $symbol;

        return $this;
    }

    /**
     * Get symbol
     *
     * @return string 
     */
    public function getSymbol()
    {
        return $this->symbol;
    }

    /**
     * Set loader
     *
     * @param string $loader
     * @return StockValue
     */
    public function setLoader($loader)
    {
        $this->loader = $loader;

        return $this;
    }

    /**
     * Get loader
     *
     * @return string 
     */
    public function getLoader()
    {
        return $this->loader;
    }

    /**
     * Set provider
     *
     * @param string $provider
     * @return StockValue
     */
    public function setProvider($provider)
    {
        $this->provider = $provider;

        return $this;
    }

    /**
     * Get provider
     *
     * @return string 
     */
    public function getProvider()
    {
        return $this->provider;
    }
}
