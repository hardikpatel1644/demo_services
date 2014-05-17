<?php

namespace Ixoil\UserBundle\Manager;

use Ixoil\UserBundle\Model\AccountStatus;
use Ixoil\UserBundle\Entity\Account;

/**
 * Class to manage account related functionality 
 *
 * @author fantoine,hardik
 */
class AccountManager
{
    /**
     * @var \Doctrine\ORM\EntityManager $obEm
     */
    private $obEm;

    /**
     *
     * @var \SecurityContext $securityContext
     */
    private $securityContext;

    /**
     *  default constructor
     */
    public function __construct(\Doctrine\ORM\EntityManager $obEm, $securityContext)
    {
        $this->obEm = $obEm;
        $this->securityContext = $securityContext;
    }

    /**
     * Function to check validation for company activation
     * @param \Ixoil\UserBundle\Entity\Account $obAccount
     * @return boolean
     */
    public function isValid(Account $obAccount)
    {
        return (
            !empty($obAccount) &&
            !$obAccount->getIsLocked() &&
            $obAccount->getStatus() == AccountStatus::Accepted &&
            $this->hasActiveSubscription($obAccount)
        );
    }

    /**
     * Function to check active subscription for an account
     * @param \Ixoil\UserBundle\Entity\Account|\Ixoil\UserBundle\Entity\User|null $obAccount
     * @return boolean
     */
    public function hasActiveSubscription($obAccount = null)
    {
        return $this->getRepository('IxoilUserBundle:SubscriptionToAccount')
            ->hasActiveSubscription( $this->findAccountId($obAccount));
    }

    /**
     * Function to check active subscription for an account
     * @param \Ixoil\UserBundle\Entity\Account|\Ixoil\UserBundle\Entity\User|null $obAccount
     * @return type
     */
    public function getActiveSubscription($obAccount = null)
    {
        return $this->getRepository('IxoilUserBundle:SubscriptionToAccount')
            ->getActiveSubscription($this->findAccountId($obAccount));
    }

    /**
     * Helper to quickly find the account ID of an account, a user or the logged user if any.
     * Returns -1 if there is no valid available account ID
     * @param \Ixoil\UserBundle\Entity\Account|\Ixoil\CoreBundle\Entity\User|null $obAccount
     * @return integer|-1
     */
    public function findAccountId($object = null)
    {
        if ($object instanceof Account || is_subclass_of($object, '\Ixoil\UserBundle\Entity\Account')) {
            return $object->getId();
        } else if ($object instanceof \Ixoil\UserBundle\Entity\User || is_subclass_of($object, '\Ixoil\UserBundle\Entity\User')) {
            return ($object->getAccount() ? $this->findAccountId($object->getAccount()) : -1);
        } else if (!$object) {
            $user = ($this->securityContext->getToken() != null ) ? $this->securityContext->getToken()->getUser() : null;
            return ($user ? $this->findAccountId($user) : -1);
        } else {
            return -1;
        }
    }

    /**
     * Function to remove security token 
     */
    public function removeAuthentication()
    {
        $this->obEm->flush();
        $this->securityContext->setToken(null);
        
        return true;
    }

    /**
     * @return \Ixoil\UserBundle\Repository\AccountRepository
     */
    public function getRepository($name = 'IxoilUserBundle:Account')
    {
        return $this->obEm->getRepository($name);
    }
}
