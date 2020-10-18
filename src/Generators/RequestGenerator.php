<?php

namespace tiagomichaelsousa\LaravelResources\Generators;

use Illuminate\Support\Facades\File;

class RequestGenerator extends AbstractGenerator
{
    /**
     * Get the Stub for the request.
     *
     * @return string
     */
    public function getStub()
    {
        return File::get(__DIR__.'/../stubs/requests/api.request.stub');
    }

    /**
     * Get the replacements for the stub.
     *
     * @return array
     */
    public function replacements()
    {
        return array_merge([
            '{{NAMESPACE}}'  => config('laravel-resources.requests.namespace'),
            '{{CLASS_NAME}}' => $this->className(),
        ]);
    }

    /**
     * Generate the class name.
     *
     * @return string
     */
    public function className()
    {
        return create_class_name($this->model, self::class);
    }

    /**
     * Handle the resource creation.
     *
     * @return void
     */
    public function handle()
    {
        $namespace = config('laravel-resources.requests.namespace');
        $directory = base_path(lcfirst(str_replace('\\', '/', $namespace)));
        $path = "{$directory}/{$this->filename()}";

        $this->fileAlreadyExists($path);

        $replaces = $this->replacements($this->model);
        $stub = str_replace(array_keys($replaces), array_values($replaces), $this->getStub());

        $this->directoryExists($directory);

        file_put_contents($path, $stub);
    }
}
