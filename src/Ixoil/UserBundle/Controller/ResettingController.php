<?php
namespace Ixoil\UserBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Sonata\UserBundle\Controller\ResettingFOSUser1Controller as BaseController;
use JMS\SecurityExtraBundle\Annotation\PreAuthorize;

/**
 * @PreAuthorize("isAnonymous()")
 */
class ResettingController extends BaseController
{
    /**
     * Reset user password
     * @param $token
     * @return RedirectResponse
     */
    public function resetAction($token)
    {
        $user = $this->container->get('fos_user.user_manager')->findUserByConfirmationToken($token);
        if (null === $user) {
            return $this->container
                ->get('templating')
                ->renderResponse('IxoilUserBundle:Resetting:alreadyReset.html.twig');
        } else {
            return parent::resetAction($token);
        }
    }
}
