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
class LoadSubscriptionTypesPurchaser extends AbstractFixture implements OrderedFixtureInterface
{        
    /**
     * 
     */
    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }
    
    public function load(ObjectManager $manager)
    {
        // Account types
        $accountType = array('purchaser');
        
        // Subscription types
        $subscriptionTypes = array(
            array(
                'code' => 'standard',
                'label' => 'Standard'
            ),
            array(
                'code' => 'premium',
                'label' => 'Premium'
            ),
            array(
                'code' => 'platinium',
                'label' => 'Platinium'
            ),
            array(
                'code' => 'trial',
                'label' => 'Trial'
            ),
        );
        
        // Subscription options
        $subscriptionOptions = array(
            array(
                'code' => '1',
                'label' => 'Données générales marchés'
            ),
            array(
                'code' => '2',
                'label' => 'Achat carburant'
            ),
            array(
                'code' => '3',
                'label' => 'Gestion de vos besoins en D/D'
            ),
            array(
                'code' => '4',
                'label' => 'Gestion de vos stocks'
            ),
            array(
                'code' => '5',
                'label' => 'Evolution marché et tendances'
            ),
            array(
                'code' => '6',
                'label' => 'Gestion des encours'
            ),
            array(
                'code' => '7',
                'label' => 'Plannificateur d\'achat'
            ),
            array(
                'code' => '8',
                'label' => 'Analyse financière poste carburant'
            ),
        );
        
        // Subscription/Option matrix
        $arrMatrix = [
            [1, 1, 1, 1],
            [1, 1, 1, 1],
            [0, 1, 1, 1],
            [0, 1, 1, 1],
            [0, 0, 1, 1],
            [0, 1, 1, 1],
            [0, 0, 1, 1],
            [1, 1, 1, 1],
        ];
        
        // For each account type
        foreach($accountType as $type)
        {
            // For each subscription type
            foreach ($subscriptionTypes as $subType)
            {
                // Create subscription
                $subscription = new Subscription();
                $subscription
                    ->setCode($type.'-'.$subType['code'])
                    ->setName($subType['label'])
                    ->setAccountType($type)
                ;
                $manager->persist($subscription);
                
                // Save reference
                $this->addReference('subscription-'.$type.'-'.$subType['code'], $subscription);
            }
            
            // For each subscription option type
            foreach ($subscriptionOptions as $optKey => $option)
            {
                // Create option
                $subscriptionOption = new SubscriptionOption();
                $subscriptionOption
                    ->setCode($type.'-'.$option['code'])
                    ->setName($option['label'])
                ;
                $manager->persist($subscriptionOption);
                
                // Save reference
                $this->addReference('subscription-option-'.$type.'-'.$option['code'], $subscriptionOption);
            }
            
            // Links subscriptions and options together
            foreach ($arrMatrix as $rowKey => $row)
            {
                foreach ($row as $colKey => $col)
                {
                    // Add link if required
                    if (1 === $col)
                    {
                        // Get option/subscription
                        $option         = $this->getReference('subscription-option-'.$type.'-'.$subscriptionOptions[$rowKey]['code']);
                        $subscription   = $this->getReference('subscription-'.$type.'-'.$subscriptionTypes[$colKey]['code']);

                        // Link them
                        $subscription->addOption($option);
                        $option->addSubscription($subscription);
                        $manager->persist($subscription);
                        $manager->persist($option);
                    }
                }
            }
        }
       
        // Final flush
        $manager->flush();
    }
}