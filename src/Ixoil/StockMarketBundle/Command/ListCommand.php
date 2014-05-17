<?php

namespace Ixoil\StockMarketBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ListCommand
 * @package Ixoil\StockMarketBundle\Command
 */
class ListCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('ixoil:stockmarket:list')
            ->setDescription('List all available providers and their loaders.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $service = $this->getContainer()->get('ixoil_stockmarket.provider.service');

        // List providers
        foreach($service->getProviders() as $key => $provider) {
            $output->writeln(sprintf('* %s (<comment>%s</comment>)', $provider->getName(), $key));

            // List loaders
            foreach($provider->getLoaders() as $key => $loader) {
                $output->writeln(sprintf('  * %s (<comment>%s</comment>)', $loader->getName(), $key));
            }
        }
    }
}