<?php

namespace Ixoil\UserBundle\Manager;

use Ixoil\UserBundle\Entity\Notification;
use Ixoil\UserBundle\Entity\User;
use Doctrine\ORM\EntityManager;

/**
 * Description of NotificationManager
 */
class NotificationManager
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Create a notification for the given user.
     *
     * @param User $user
     * @param type $code
     * @param array $arguments
     * @param boolean $deletable    the notification is deleted when read if true, nothing happen ortherwise
     * @return Notification
     */
    public function notify(
        User $user,
        $code,
        array $arguments = array(),
        $deletable = false)
    {
        $notification = new Notification();

        // Set notification properties
        $notification->setArguments($arguments);
        $notification->setDeletable($deletable);
        $notification->setUser($user);
        $notification->setCode($code);
        $notification->setCreatedAt(new \DateTime());

        // Save the notification in the database
        $this->em->persist($notification);
        $this->em->flush();

        return $notification;
    }

    /**
     * @param User $user
     * @param integer $limit
     * @param boolean $onlyUnread
     * @return array
     */
    public function getNotificationsByUser(User $user, $limit = 5, $onlyUnread = true)
    {
        $qb = $this->getRepository()
            ->getNotificationsByUserQueryBuilder($user)
            ->setMaxResults($limit)
            ->orderBy('e.created_at', 'DESC');
        
        if ($onlyUnread)
            $qb = $qb->andWhere('e.read_at IS NULL');
        
        return $qb
            ->getQuery()
            ->getResult();
    }
    
    /**
     * @param User $user
     * @param boolean $onlyUnread
     * @return array
     */
    public function getNotificationsCountByUser(User $user, $onlyUnread = true)
    {
        $qb = $this->getRepository()
            ->getNotificationsByUserQueryBuilder($user)
            ->select('COUNT(e)');
        
        if ($onlyUnread)
            $qb = $qb->andWhere('e.read_at IS NULL');
        
        return $qb
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Mark specified notification as read
     * @param Notification $notification
     */
    public function read(Notification $notification)
    {
        // Delete or update the notification
        if ($notification->isDeletable()) {
            $this->em->remove($notification);
        } else if (null === $notification->getReadAt()) {
            $notification->setReadAt(new \DateTime());
            $this->em->persist($notification);
        }

        // Save it in the database
        $this->em->flush();
    }
    
    /**
     * Mark all unread notifications as read.
     * @param \Ixoil\UserBundle\Entity\User $user
     */
    public function readAllByUser(User $user)
    {
        $qb = $this->getRepository()->getNotificationsByUserQueryBuilder($user);
        $qb = $qb->andWhere('e.read_at IS NULL');
        
        // Delete all unread deletable notifications
        $deletableQb = clone $qb;
        $deletableQb->delete()
            ->andWhere($deletableQb->expr()->eq('e.deletable', '1'))
            ->getQuery()
            ->execute();
        
        // Mark all unread and not-deletable notifications as read
        $nonDeletableQb = clone $qb;
        $nonDeletableQb->update()
            ->andWhere($nonDeletableQb->expr()->eq('e.deletable', '0'))
            ->set('e.read_at', ':readAt')
            ->setParameter('readAt', new \DateTime())
            ->getQuery()
            ->execute();
        
        return true;
    }

    /**
     * @return \Ixoil\UserBundle\Repository\NotificationRepository
     */
    public function getRepository()
    {
        return $this->em->getRepository('IxoilUserBundle:Notification');
    }
}
