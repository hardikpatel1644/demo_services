<?php

namespace Ixoil\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;
/**
 * Description of UserRepository
 *
 * @author OXIND
 */
class UserRepository extends EntityRepository
{
    /**
     * Return all details of company owner from User table.
     * @param type $accountid Account id of the user.
     */
    public function getCompanyOwnerDetails($accountid)
    {
        $queryBuilder = $this->createQueryBuilder('u')
                ->select('u')
                ->leftJoin('u.account', 'a')
                ->where('u.is_owner = :val')
                ->andWhere('a.id = :accountId')
                ->setParameter('accountId', $accountid)
                ->setParameter('val', 1);
        
        return $queryBuilder->getQuery()->getSingleResult();
    }
    
    /**
     * 
     * @param integer $userId
     * @param integer $accountId
     */
    public function getSubuser( $userId , $accountId )
    {
        $queryBuilder = $this->createQueryBuilder('u')
                ->select('u')
                ->leftJoin('u.account', 'a')
                ->where('u.id = :userid')
                ->andWhere('a.id = :accountId')
                ->setParameter( 'accountId', $accountId )
                ->setParameter('userid', $userId);
        
        return $queryBuilder->getQuery()->getOneOrNullResult();
    }
}
