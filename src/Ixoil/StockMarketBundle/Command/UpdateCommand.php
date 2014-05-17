<?php

namespace Ixoil\StockMarketBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class UpdateCommand
 * @package Ixoil\StockMarketBundle\Command
 */
class UpdateCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('ixoil:stockmarket:update')
            ->setDescription('Load last stock market value from specified source.')
            ->addArgument('provider', InputArgument::REQUIRED, 'Provider key')
            ->addArgument('loader', InputArgument::OPTIONAL, 'Loader key')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $provider = $this->getContainer()->get('ixoil_stockmarket.provider.service');

        // Check if the provider exists
        $key = $input->getArgument('provider');
        $providerObj = $provider->getProvider($key);
        if(!$providerObj) {
            $output->writeln(sprintf('<error>Can\'t find provider "%s".</error>', $key));
            return;
        }

        // Check if loader exists
        $loaderKey = $input->getArgument('loader');
        if($loaderKey && !$providerObj->hasLoader($loaderKey)) {
            $output->writeln(sprintf('<error>Can\'t find loader "%s" in provider "%s".</error>', $loaderKey, $key));
            return;
        }

        // Update selected provider
        $output->writeln(sprintf('Updating last value for provider <comment>%s</comment>.', $key));
        $success = $provider->update($key, $loaderKey);
        if(!$success) {
            $output->writeln(sprintf('<error>A problem occurred when updating provider "%s".</error>', $key));
        } else {
            $output->writeln(sprintf('<info>Provider "%s" has been successfully updated.</info>', $key));
        }
    }
}