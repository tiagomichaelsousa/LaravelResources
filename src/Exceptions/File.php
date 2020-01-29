<?php

namespace tiagomichaelsousa\LaravelResources\Exceptions;

use Exception;

class File extends Exception
{
    public static function alreadyExistsInDirectory(string $path)
    {
        return new static("The file already exists in the path $path");
    }

    public static function doesNotExists(string $path)
    {
        return new static("The file doesn't exists in the path $path");
    }
}
