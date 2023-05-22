<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use Plugse\Maker\Input;

class InputTest extends TestCase
{
    public function testConfig()
    {
        $input = new Input(['teste.php']);
        $this->assertFileExists($input->fileConfig);
    }

    public function testInputProperties()
    {
        $commands = [
            'class',
            'conntroller',
            'empty',
            'interface',
            'test',
            'trait'
        ];

        foreach ($commands as $key => $command) {
            $filename = "./tests/files/test{$key}.php";
            $input = new Input([$command, $filename]);
            $fileName = ucfirst(basename($filename, '.php'));
            $filePath = dirname($filename) . '/';
            $fileNamespace = $input->config['namespace'] . $input->getNamespace($filePath);

            $this->assertEquals($command, $input->command);
            $this->assertEquals($fileName, $input->fileName);
            $this->assertEquals($filePath, $input->filePath);
            $this->assertEquals($fileNamespace, $input->namespace);
        }
    }
}
