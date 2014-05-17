<?php

namespace Ixoil\FileBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Ixoil\FileBundle\Model\FileType;

/**
 * Class CleanTmpCommand
 * @package Ixoil\FileBundle\Command
 */
class CleanTmpCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('ixoil:file:clean-tmp')
            ->setDescription('Clear all expired files in the directory.')
            ->addArgument(
                'kind', 
                InputArgument::OPTIONAL, 
                'Directory kind. It can be <comment>tmp</comment>(default), <comment>account</comment> or <comment>user</comment>.'
            )
            ->addArgument(
                'value', 
                InputArgument::OPTIONAL, 
                'Account or user ID. Required for <comment>account</comment> and <comment>user</comment>.'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Get file helper
        $helper = $this->getContainer()->get('ixoil_file.manager');
        
        // Get file kind
        $kindArg = $input->getArgument('kind');
        if (!$kindArg)
            $kindArg = 'tmp';
        
        $kind = null;
        $kindDisplay = '';
        switch ($kindArg) {
            case 'tmp':
                $kind = FileType::tmp();
                $kindDisplay = 'tmp';
                break;
            case 'account':
            case 'accounts':
                $value = $input->getArgument('value');
                if (!$value) {
                    $output->writeln('<error>You must specify an account ID.</error>');
                    return;
                }
                $kind = FileType::account($value);
                $kindDisplay = 'account/'.$value;
                break;
            case 'user':
            case 'users':
                $value = $input->getArgument('value');
                if (!$value) {
                    $output->writeln('<error>You must specify an user ID.</error>');
                    return;
                }
                $kind = FileType::user($value);
                $kindDisplay = 'user/'.$value;
                break;
            default:
                $output->writeln(sprintf('<error>Invalid directory kind "%s".</error>', $kindArg));
                return;
        }
        
        // Display info
        $output->writeln(sprintf('Clearing temporary files in <info>%s</info>', $kindDisplay));
        
        // Clear directory
        $removedFiles = $helper->clearTemporaryFiles($kind);
        
        if (count($removedFiles) == 0) {
            $output->writeln('<comment>No temporary file to remove.</comment>');
        } else {
            $output->writeln('<comment>Removed following temporary files:</comment>');
            foreach ($removedFiles as $file) {
                $output->writeln(sprintf('  <info>%s</info>', $file));
            }
        }
    }
}