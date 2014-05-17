<?php

namespace Ixoil\StockMarketBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class StockValueRepository
 * @package Ixoil\StockMarketBundle\Repository
 */
class StockValueRepository extends EntityRepository
{
    /**
     * @param $symbol
     * @param string $timeLimit
     * @param string $timeUnit
     * @return array
     */
    public function getSeriesDataFromToday($symbol, $timeLimit='2', $timeUnit='day')
    {
        $modify = '-'.$timeLimit.' '.$timeUnit;
        
        $lastDateTime = new \DateTime();
        $lastDateTime->modify($modify);
        $lastDateTime->setTime(0, 0, 1);
        
        $queryBuilder = $this->getEntityManager()
            ->createQuery('SELECT s FROM IxoilStockMarketBundle:StockValue s WHERE s.publication >= :date AND s.symbol = :value ORDER BY s.publication DESC')
            ->setParameter('value', $symbol)
            ->setParameter('date', $lastDateTime->format('Y-m-d H:i:s'));
    
        return $queryBuilder->getResult();
    }

    /**
     * @param string $symbol
     * @return Ixoil\StockMarketBundle\Entity\StockValue
     */
    public function getLastForSymbol($symbol)
    {
        $queryBuilder = $this->createQueryBuilder('s')
            ->where('s.symbol = :value')
            ->setParameter('value', $symbol)
            ->orderBy('s.publication', 'DESC')
            ->setMaxResults(1);

        $result = $queryBuilder->getQuery()->getResult();
        return (count($result) > 0 ? $result[0] : null);
    }
}