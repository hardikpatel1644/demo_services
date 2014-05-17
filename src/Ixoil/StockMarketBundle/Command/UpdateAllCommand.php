<?php

namespace Ixoil\StockMarketBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class UpdateAllCommand
 * @package Ixoil\StockMarketBundle\Command
 */
class UpdateAllCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('ixoil:stockmarket:update-all')
            ->setDescription('Load last stock market values from all available sources.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $provider = $this->getContainer()->get('ixoil_stockmarket.provider.service');

        // Get all available providers
        $providers = $provider->getProviders();

        // Get update command
        $command = $this->getApplication()->find('ixoil:stockmarket:update');

        // Update each provider
        foreach($providers as $key => $service) {
            $arguments = array(
                'command'   => 'ixoil:stockmarket:update',
                'provider'  => $key,
            );

            // Execute sub-command
            $input = new ArrayInput($arguments);
            $command->run($input, $output);
        }
    }
}