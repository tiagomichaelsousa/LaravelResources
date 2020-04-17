<?php

namespace tiagomichaelsousa\LaravelResources\Generators;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use tiagomichaelsousa\LaravelResources\Exceptions\File as FileException;

class RouteGenerator extends AbstractGenerator
{
    /**
     * Get the Stub for the request.
     *
     * @return string
     */
    public function getStub()
    {
        return File::get(__DIR__.'/../stubs/routes/api.routes.stub');
    }

    /**
     * Get the replacements for the stub.
     *
     * @return array
     */
    public function replacements()
    {
        return array_merge([
            '{{MODEL_NAME}}' => $this->model,
            '{{MODEL_VARIABLE}}' => lcfirst($this->model),
            '{{CONTROLLER_NAME}}' => create_class_name($this->model, 'ControllerGenerator'),
            '{{ROUTE_NAME}}' => Str::plural(Str::kebab($this->model)),
        ]);
    }

    /**
     * Verify if the resource already exists.
     *
     * @return mixed|\tiagomichaelsousa\LaravelResources\Exceptions\File
     */
    public function fileAlreadyExists($path)
    {
        if (File::missing($path)) {
            throw FileException::doesNotExists($path);
        }
    }

    /**
     * Generate the class name.
     *
     * @return string
     */
    public function className()
    {
        return 'Route';
    }

    /**
     * Generate the file name.
     *
     * @return string
     */
    public function fileName()
    {
        return config('laravel-resources.routes.filename');
    }

    /**
     * Handle the resource creation.
     *
     * @return void
     */
    public function handle()
    {
        $path = config('laravel-resources.routes.path');
        $directory = base_path($path);
        $path = "{$directory}/{$this->fileName()}";

        $this->fileAlreadyExists($path);

        $replaces = $this->replacements($this->model);
        $stub = str_replace(array_keys($replaces), array_values($replaces), $this->getStub());

        $this->directoryExists($directory);

        file_put_contents($path, [$stub, PHP_EOL], FILE_APPEND);
    }
}
