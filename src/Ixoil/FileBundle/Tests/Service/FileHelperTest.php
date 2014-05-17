<?php

namespace Ixoil\FileBundle\Tests\Service;

use Ixoil\FileBundle\Service\FileHelper;

/**
 * Class FileManagerTest
 * @package Ixoil\FileBundle\Tests\Service
 */
class FileHelperTest extends \PHPUnit_Framework_TestCase
{
    public function testGuessExtension()
    {
        $fileManager = new FileManager('../data/');

        // Simple case
        $this->assertEquals('.pdf', $fileManager->guessExtension('filename.pdf'));
        $this->assertEquals('.pdf', $fileManager->guessExtension('filename.pdf', true));
        $this->assertEquals('pdf', $fileManager->guessExtension('filename.pdf', false));

        // Mixed upper/lowercase case
        $this->assertEquals('.pdf', $fileManager->guessExtension('filename.PdF'));
        $this->assertEquals('.pdf', $fileManager->guessExtension('filename.PdF', true));
        $this->assertEquals('pdf', $fileManager->guessExtension('filename.pDF', false));

        // Several dots in filename case
        $this->assertEquals('.pdf', $fileManager->guessExtension('long.filename.pdf'));
        $this->assertEquals('.pdf', $fileManager->guessExtension('long.filename.pdf', true));
        $this->assertEquals('pdf', $fileManager->guessExtension('long.filename.pdf', false));
    }
}