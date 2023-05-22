<?php

declare(strict_types=1);

namespace Plugse\Maker;

use Exception;
use Plugse\Fp\Json;

use function PHPUnit\Framework\isNull;

class Input
{
    public $fileConfig;
    public $config;
    public $command;
    public $fileName;
    public $filePath;
    public $namespace;

    public function __construct(array $args)
    {
        $this->fileConfig = 'php-maker-config.json';
        $this->setConfig();
        $this->setCommand($args);
        $this->setFileNameAndPath($args);
        $this->setNamespace();
    }

    private function setConfig()
    {
        if (!file_exists($this->fileConfig)) {
            $this->createConfigFile();
        } else {
            $this->config = Json::read($this->fileConfig);
        }
    }

    private function createConfigFile(): void
    {
        $file = Json::read('composer.json');
        $this->config = [
            'namespace' => 'Plugse\\',
            'srcDir' => 'src/',
            'commands' => [],
        ];
        if (key_exists('autoload', $file)) {
            if (key_exists('psr-4', $file['autoload'])) {
                $this->config['namespace'] = array_keys($file['autoload']['psr-4'])[0];
                $this->config['srcDir'] = array_values($file['autoload']['psr-4'])[0];
            }
        }

        foreach (glob('./src/templates/*.txt') as $file) {
            array_push($this->config['commands'], basename($file, '.txt'));
        }

        Json::save($this->fileConfig, $this->config);
    }

    private function setCommand(array $args)
    {
        if (!key_exists(0, $args)) {
            throw new Exception("Erro: Faltou definir o tipo de arquivo a ser criado");
        }
        var_dump(
            $args[0],
            $this->config['commands'],
            in_array($args[0], array_keys($this->config['commands']))
        );
        if (in_array($args[0], array_keys($this->config['commands']))) {
            $this->command = $args[0];
        } else {
            $this->command = 'empty';
        }
    }

    private function setFileNameAndPath(array $args)
    {
        if (!key_exists(1, $args)) {
            if (preg_match('/(.\/)?(\w*\/(1))*\w+(\.php)[1]/', $args[0]) !== false) {
                $file = $args[0];
            } else {
                throw new Exception("Erro: Faltou definir o nome (e caminho) do arquivo a ser criado");
            }
        } else {
            $file = $args[1];
        }

        $this->filePath = dirname($file) . '/';
        $this->fileName = ucFirst(basename($file, '.php'));
    }

    private function setNamespace()
    {
        $this->namespace = $this->config['namespace'] . $this->getNamespace();
    }

    public function getNamespace(string $path = null): string
    {
        $path = isNull($path) ? $this->filePath : $path;
        $path = str_replace('./', '', $path);
        $path = str_replace('src/', '', $path);
        $path = strlen($path) > 0 ? substr($path, 0, -1) : $path;

        $response = [];
        foreach (explode('/', $path) as $part) {
            array_push($response, ucfirst($part));
        }

        return implode('\\', $response);
    }
}
