<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use Plugse\Maker\Maker;

class MakerTest extends TestCase
{
    private static $files;

    protected function tearDown(): void
    {
        foreach (self::$files as $file) {
            unlink($file);
        }
    }

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

        foreach ($commands as $key => $command) {
            self::$files[$key] = "./tests/files/{$command}.php";
            $maker = new Maker([$command, self::$files[$key]]);
            $maker->createFile();

            $this->assertFileExists(self::$files[$key]);
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
