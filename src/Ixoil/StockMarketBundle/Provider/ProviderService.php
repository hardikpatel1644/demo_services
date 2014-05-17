<?php

namespace Ixoil\StockMarketBundle\Provider;

use Doctrine\ORM\EntityManager;
use Ixoil\StockMarketBundle\Entity\StockValue;
use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * Class ProviderService
 * @package Ixoil\StockMarketBundle\Provider
 */
class ProviderService extends ContainerAware
{
    /**
     * @var
     */
    protected $providers;

    /**
     * @var
     */
    protected $em;

    /**
     * @var
     */
    protected $logger;

    /**
     *
     */
    public function __construct(EntityManager $entityManager, $logger)
    {
        $this->providers = array();
        $this->em = $entityManager;
        $this->logger = $logger;
    }

    /**
     * @param string $providerKey
     * @param string|null $loaderKey
     * @return bool
     */
    public function update($providerKey, $loaderKey = null)
    {
        // Check if provider exists
        $provider = $this->getProvider($providerKey);
        if(!$provider)
            return false;

        // Get available loaders
        $loaders = $provider->getLoaders();
        $loaderKeys = [];
        if(!$loaderKey) {
            $loaderKeys = array_keys($loaders);
            shuffle($loaderKeys);
        } else {
            if(!isset($loaders[$loaderKey]))
                return false;

            $loaderKeys[] = $loaderKey;
        }

        // Try load until we have a working loader
        foreach($loaderKeys as $loaderKey) {
            $loader = $provider->getLoader($loaderKey);

            // Try to get the new value
            $result = null;
            try {
                $result = $loader->load();
            } catch(\Exception $e) {}

            // If result is not valid, continue to next loader
            if(!$this->isValidResult($result)) {
                $this->logger->warn(sprintf('[StockMarket] Loader "%s" didn\'t worked for provider "%s"', $loaderKey, $providerKey));
                continue;
            }

            // Fix date : All date must be stored in UTC
            if($result['date']->getTimezone()->getName() != 'UTC')
                $result['date']->setTimezone(new \DateTimeZone('UTC'));

            // Save new value
            $stockValue = new StockValue();
            $stockValue->setValue($result['value']);
            $stockValue->setPublication($result['date']);
            $stockValue->setSymbol($provider->getSymbol());
            $stockValue->setProvider($providerKey);
            $stockValue->setLoader($loaderKey);
            $this->em->persist($stockValue);
            $this->em->flush();

            return true;
        }

        // Log error
        $this->logger->err(sprintf('[StockMarket] No loader worked for provider "%s"', $providerKey));

        return false;
    }

    /**
     * @param array $result
     * @return bool
     */
    protected function isValidResult($result)
    {
        return is_array($result) &&
            (isset($result['value']) && is_float($result['value'])) &&
            (isset($result['date']) && $result['date'] instanceof \DateTime);
    }

    /**
     * @param BaseProvider $provider
     * @param string $alias
     */
    public function addProvider(BaseProvider $provider, $alias)
    {
        $this->providers[$alias] = $provider;
    }

    /**
     * @return array
     */
    public function getProviders()
    {
        return $this->providers;
    }

    /**
     * @param string $alias
     * @return BaseProvider|null
     */
    public function getProvider($alias)
    {
        return ($this->hasProvider($alias) ? $this->providers[$alias] : null);
    }

    /**
     * @param string $alias
     * @return bool
     */
    public function hasProvider($alias)
    {
        return isset($this->providers[$alias]);
    }

    /**
     * @param BaseLoader $loader
     * @param string $target
     * @param string $alias
     */
    public function addLoader(BaseLoader $loader, $target, $alias)
    {
        // Check if provider exists
        if(!$this->hasProvider($target))
            return;

        // Save loader
        $provider = $this->getProvider($target);
        $provider->addLoader($loader, $alias);
    }
}