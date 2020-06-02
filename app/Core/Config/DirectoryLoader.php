<?php


namespace App\Core\Config;


class DirectoryLoader implements Loader
{

    private string $dir;

    public function __construct(string $dir)
    {
        $this->dir = $dir;
    }

    public function load(): array
    {
        $values = [];

        // Check if directory exists
        if (!file_exists($this->dir)) {

        }

        // Check if it is directory
        if (!is_dir($this->dir)) {

        }
        // Get all files
        $files = scandir($this->dir);

        // Read only php file
        foreach ($files as $file) {
            if (preg_match("#\.php$#", $file)) {
                $values[pathinfo($file, PATHINFO_FILENAME)] = require $this->dir . DIRECTORY_SEPARATOR . $file;
            }
        }

        return $values;

    }
}