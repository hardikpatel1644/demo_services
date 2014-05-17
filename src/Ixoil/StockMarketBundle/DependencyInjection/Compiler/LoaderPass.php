<?php

namespace Ixoil\StockMarketBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class LoaderPass
 * @package Ixoil\StockMarketBundle\DependencyInjection\Compiler
 */
class LoaderPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if(!$container->hasDefinition('ixoil_stockmarket.provider.service'))
            return;

        $definition = $container->getDefinition('ixoil_stockmarket.provider.service');

        $taggedServices = $container->findTaggedServiceIds('ixoil_stockmarket.loader');
        foreach($taggedServices as $id => $tagAttributes) {
            foreach($tagAttributes as $attributes) {
                $definition->addMethodCall(
                    'addLoader',
                    array(new Reference($id), $attributes['provider'], $attributes['alias'])
                );
            }
        }
    }
}