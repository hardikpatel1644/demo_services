<?php

namespace Ixoil\CoreBundle\Model;

/**
 * enum for all Subscription Type.
 *
 * @author OXIND
 */
abstract class SubscriptionType
{
    const Trial = 'trial';
    const Standard = 'standard';
    const Premium = 'premium';
    const Platinium = 'platinium';
}
