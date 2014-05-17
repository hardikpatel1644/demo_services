<?php

namespace Ixoil\UserBundle\Twig\Extension;

use Symfony\Component\Security\Core\SecurityContext;
use Ixoil\UserBundle\Manager\NotificationManager;

/**
 * Description of NotificationExtension
 *
 * @author fantoine
 */
class NotificationExtension extends \Twig_Extension {
    /**
     *
     * @var \Symfony\Component\Security\Core\SecurityContext 
     */
    protected $securityContext;
    
    /**
     *
     * @var \Ixoil\UserBundle\Manager\NotificationManager 
     */
    protected $manager;
    
    /**
     * 
     * @param \Symfony\Component\Security\Core\SecurityContext $securityContext
     * @param \Ixoil\UserBundle\Manager\NotificationManager
     */
    public function __construct(SecurityContext $securityContext, NotificationManager $manager)
    {
        $this->securityContext = $securityContext;
        $this->manager = $manager;
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return 'ixoil_user_notification';
    }
    
    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            'ixoil_notifications_count'     => new \Twig_Function_Method($this, 'notificationsCount'),
            'ixoil_notifications'           => new \Twig_Function_Method($this, 'notifications'),
        );
    }
    
    /**
     * @return integer
     */
    public function notificationsCount()
    {
        $user = $this->getUser();
        
        if (!$user)
            return 0;
        
        return $this->manager->getNotificationsCountByUser($user, true);
    }
    
    /**
     * @return integer
     */
    public function notifications()
    {
        $user = $this->getUser();
        
        if (!$user)
            return array();
        
        return $this->manager->getNotificationsByUser($user, 7, false);
    }
    
    /**
     * Return current active user
     * @return Ixoil\UserBundle\Entity\User
     */
    protected function getUser()
    {
        $token = $this->securityContext->getToken();
        return (is_object($token) ? $token->getUser() : null);
    }
}
