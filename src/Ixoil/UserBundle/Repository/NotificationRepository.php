<?php

namespace Ixoil\UserBundle\Repository;

use Ixoil\UserBundle\Entity\User;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr;

/**
 * Description of NotificationRepository
 */
class NotificationRepository extends EntityRepository
{
    /**
     * @param User $user
     * @return array
     */
    public function getNotificationsByUserQueryBuilder(User $user)
    {
        $qb = $this->createQueryBuilder('e');
        
        $qb
            ->where($qb->expr()->eq('e.user', ':user'))
            ->setParameter('user', $user)
        ;

        return $qb;
    }
}
