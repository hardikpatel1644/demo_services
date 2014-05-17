<?php

namespace Ixoil\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ixoil\UserBundle\Entity\Subscription;
use Ixoil\UserBundle\Entity\SubscriptionOption;
/**
 * Description of subscriptionTypes
 *
 * @author OXIND
 */
class LoadSubscriptionTypesProvider extends AbstractFixture implements OrderedFixtureInterface
{        
    /**
     * 
     */
    public function getOrder()
    {
        return 2; // the order in which fixtures will be loaded
    }
    
    public function load(ObjectManager $manager)
    {        
        
    }

}