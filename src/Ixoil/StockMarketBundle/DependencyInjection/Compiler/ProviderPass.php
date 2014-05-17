<?php

namespace Ixoil\StockMarketBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class ProviderPass
 * @package Ixoil\StockMarketBundle\DependencyInjection\Compiler
 */
class ProviderPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if(!$container->hasDefinition('ixoil_stockmarket.provider.service'))
            return;

        $definition = $container->getDefinition('ixoil_stockmarket.provider.service');

        $taggedServices = $container->findTaggedServiceIds('ixoil_stockmarket.provider');
        foreach($taggedServices as $id => $tagAttributes) {
            foreach($tagAttributes as $attributes) {
                $definition->addMethodCall(
                    'addProvider',
                    array(new Reference($id), $attributes['alias'])
                );
            }
        }
    }
}