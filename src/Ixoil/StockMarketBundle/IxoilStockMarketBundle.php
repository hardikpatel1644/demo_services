<?php

namespace Ixoil\StockMarketBundle;

use Ixoil\StockMarketBundle\DependencyInjection\Compiler\LoaderPass;
use Ixoil\StockMarketBundle\DependencyInjection\Compiler\ProviderPass;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class IxoilStockMarketBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ProviderPass());
        $container->addCompilerPass(new LoaderPass());
    }
}
