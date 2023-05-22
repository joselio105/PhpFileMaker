<?php

declare(strict_types=1);

namespace Plugse\Maker;

use Exception;
use Plugse\Fp\Json;

class Input
{
    public $command;
    public $fileName;
    public $filePath;
    public $namespace;
    public $config;

    public function __construct(array $args)
    {
        $this->setConfig();
        $this->setCommand($args);
        $this->setFileNameAndPath($args);
        $this->setNamespace();
    }

    private function setConfig()
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
    }

    private function setCommand(array $args)
    {
        if (!key_exists(0, $args)) {
            throw new Exception("Erro: Faltou definir o tipo de arquivo a ser criado");
        }

        $command = $args[0];

        if (!in_array($command, array_keys($this->config['commands']))) {
            $command = 'empty';
        }

        $this->command = $command;
    }

    private function setFileNameAndPath(array $args)
    {
        if (!key_exists(1, $args)) {
            if (preg_match('/(./)?(\w*\/)*(\w+)(\.php)?/', $this->command) != false) {
                $file = $args[0];
            } else {
                throw new Exception("Erro: Faltou definir o nome (e caminho) do arquivo a ser criado");
            }
        }

        $file = $args[1];

        $this->filePath = dirname($file) . '/';
        $this->fileName = ucFirst(basename($file, '.php'));
    }

    private function setNamespace()
    {
        $this->namespace = $this->config['namespace'] . $this->getNamespace();
    }

    private function getNamespace(): string
    {
        $path = str_replace('./', '', $this->filePath);
        $path = str_replace('src/', '', $path);
        $response = [];
        foreach (explode('/', substr($path, 0, -1)) as $part) {
            array_push($response, ucfirst($part));
        }

        return implode('\\', $response);
    }
}
