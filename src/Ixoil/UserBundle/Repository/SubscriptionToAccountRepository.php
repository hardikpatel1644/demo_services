<?php

namespace Ixoil\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

/**
 * class to create custom query for of table SubscriptionToAccount
 *
 * @author OXIND
 */
class SubscriptionToAccountRepository extends EntityRepository
{

    /**
     * Function to get count of Active subsciption for account
     * @param integer $snAccountId
     * @return boolean
     */
    public function hasActiveSubscription($snAccountId)
    {
        $ssDate = new \DateTime();
        $obQuerybuilder = $this->createQueryBuilder('s');
        $asResult = $obQuerybuilder
            ->select('COUNT(s)')
            ->where('s.end_date >= :today_date')
            ->andWhere('s.start_date <= :today_date')
            ->andWhere('s.account = :account_id')
            ->setParameter('today_date', $ssDate->format('Y-m-d H:i:s'))
            ->setParameter('account_id', $snAccountId)
            ->getQuery()
            ->getSingleScalarResult();
        
        return ($asResult > 0);
    }

    /**
     * Function to get the instance of the Active subsciption for account
     * @param integer $snAccountId
     * @return SubscriptionToAccount
     */
    public function getActiveSubscription($snAccountId)
    {
        try {
            $ssDate = new \DateTime();
            $obQuerybuilder = $this->createQueryBuilder('s');
            $asResult = $obQuerybuilder
                ->select('s')
                ->where('s.end_date >= :today_date')
                ->andWhere('s.start_date <= :today_date')
                ->andWhere('s.account = :account_id')
                ->setParameter('today_date', $ssDate->format('Y-m-d H:i:s'))
                ->setParameter('account_id', $snAccountId)
                ->getQuery()
                ->getSingleResult();

            return $asResult;
        } catch(NoResultException $e) {
            return null;
        }
    }
}
