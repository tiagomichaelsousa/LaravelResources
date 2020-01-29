<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

if (! function_exists('make_directory')) {

    /**
     * Create recursive directory.
     *
     * @param  string  $path
     * @param  string  $mode
     * @param  bool  $recursive
     * @param  bool  $force
     * @return bool
     */
    function make_directory($path, int $mode = 0755, bool $recursive = true, bool $force = false)
    {
        return File::makeDirectory($path, $mode, $recursive, $force);
    }
}

if (! function_exists('namespace_path')) {

    /**
     * Receive a namespace and convert it to a path.
     *
     * @param  string  $path
     * @return string
     */
    function namespace_path($path)
    {
        return base_path(lcfirst(str_replace('\\', '/', $path)));
    }
}

if (! function_exists('create_class_name')) {

    /**
     * Receive a classname for a resource.
     *
     * @param  string  $path
     * @return string
     */
    function create_class_name($model, $resource)
    {
        $resource = Str::before(class_basename($resource), 'Generator');
        $configKey = Str::plural(strtolower($resource));
        $className = "{$model}{$resource}";

        if (! is_null($suffix = config("laravel-resources.{$configKey}.suffix"))) {
            $className = Str::finish($className, $suffix);
        }

        if (! is_null($prefix = config("laravel-resources.{$configKey}.prefix"))) {
            $className = Str::start($className, $prefix);
        }

        return $className;
    }
}
