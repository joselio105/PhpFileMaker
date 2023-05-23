<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use Plugse\Maker\Maker;

class MakerTest extends TestCase
{
    private static $files;

    public function testCreateFile()
    {
        $commands = [
            'class',
            'controller',
            'empty',
            'interface',
            'test',
            'trait'
        ];

        foreach ($commands as $command) {
            $file = "./tests/files/{$command}.php";
            $maker = new Maker([$command, $file]);
            $maker->createFile();

            $this->assertFileExists($file);
            unlink($file);
        }
    }

    public function testCreateEmptyFile()
    {
        $filename = "./tests/files/EmptyTest.php";
        $maker = new Maker([$filename]);
        $maker->createFile();

        $this->assertFileExists($filename);
    }
}
