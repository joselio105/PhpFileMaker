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
        var_dump($this->input->namespace);
    }

    public function createFile(): void
    {
        $content = $this->getContent();
        $filename = $this->input->filePath . $this->input->fileName . '.php';

        File::saveFile($filename, $content);
    }

    private function getContent(): string
    {
        $filePath = __DIR__ . '/templates';
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
