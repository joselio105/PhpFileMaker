<?php

declare(strict_types=1);

namespace Plugse\Maker;

use Plugse\Fp\File;

class Maker
{
    private $input;

    public function __construct(array $args)
    {
        $this->input = new Input($args);
    }

    public function createFile(): string
    {
        $content = $this->getContent();
        $filename = $this->input->filePath . $this->input->fileName . '.php';
        if (!file_exists($filename)) {
            File::saveFile($filename, $content);
            return "O arquivo '{$filename}' foi criado com sucesso";
        }

        return "O arquivo '{$filename}' Já existe";
    }

    private function getContent(): string
    {
        $filePath = __DIR__ . '/templates/';
        $fileName = $this->input->command . '.txt';
        $content = File::readFile($filePath . $fileName);
        $content = str_replace(
            ['%%NAMESPACE%%', '%%NAME%%'],
            [$this->input->namespace, $this->input->fileName],
            $content
        );

        return $content;
    }
}
