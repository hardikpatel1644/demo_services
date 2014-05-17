<?php

namespace Ixoil\UserBundle\Model;

/**
 * Description of PurchaserActivity
 *
 * @author fantoine
 */
class PurchaserActivity {
    /**
     * Freight transport
     * fr: Transport de marchandises
     */
    const FreightTransport = "purchaser.activity.freighttransport";
    
    /**
     * Passenger transport
     * fr: Transport de personnes
     */
    const PassengerTransport = "purchaser.activity.passengertransport";
    
    /**
     * Service station
     * fr: Station Service
     */
    const ServiceStation = "purchaser.activity.servicestation";
    
    /**
     * Dealer
     * fr: Revendeur
     */
    const Dealer = "purchaser.activity.dealer";
}
