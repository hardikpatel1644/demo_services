<?php

namespace Ixoil\UserBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Description of NotificationController
 *
 * @author fantoine
 * @Route("/notification")
 */
class NotificationController extends Controller {
    /**
     * @Route("/update" , name="ixoil_user_notification_update")
     */
    public function updateAction()
    {
        $manager = $this->get('ixoil_user.manager.notification');
        
        // If can't get logged user, return 403 error
        $user = $this->getUser();
        if (!$user)
            return JsonResponse::create(
                array('success' => false),
                JsonResponse::HTTP_FORBIDDEN
            );
        
        // Update unread notifications
        $result = $manager->readAllByUser($user);
        
        // Everything is successful
        return JsonResponse::create(array('success' => $result));
    }
}
