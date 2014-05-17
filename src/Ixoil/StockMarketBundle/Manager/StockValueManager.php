<?php

namespace Ixoil\StockMarketBundle\Manager;

use Doctrine\ORM\EntityManager;

/**
 * Description of StockValueManager
 *
 * @author OXIND
 */
class StockValueManager
{
    /**
     *
     * @var type EntityManager
     */
    protected $em;
    
    /**
     *
     * @var type EntityRepository
     */
    protected $repository;
    
    /**
     * 
     * @param \Doctrine\ORM\EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository('IxoilStockMarketBundle:StockValue');
    }
    
    /**
     * Returns an array of array containing the datas for the specified symbol.
     * First index of arrays is for timestamp, second index for stock value.
     * @param string $symbol
     * @return array
     */
    public function getSeriesDataForSymbol($symbol)
    {
        $min = null;
        $max = null;

        // Prepare data for chart
        $seriesData = $this->repository->getSeriesDataFromToday($symbol, 1);
        $result = array_map(
            function($objResult) use(&$min, &$max)
            {
                // Get values
                $dateTime = $objResult->getPublication()->getTimestamp() * 1000;
                $value = $objResult->getValue();

                // Get minimum and maximum values for this period
                if($min == null || $min > $value)
                    $min = $value;
                if($max == null || $max < $value)
                    $max = $value;

                return array($dateTime, $value);
            },
            $seriesData
        );

        return array(
            'minimum' => $min,
            'maximum' => $max,
            'data' => $result,
        );
    }

    /**
     * Returns the last available value for the specified symbol
     * @param string $symbol
     * @return float|null
     */
    public function getValueForSymbol($symbol)
    {
        $value = $this->repository->getLastForSymbol($symbol);
        return ($value ? $value->getValue() : null);
    }
}
