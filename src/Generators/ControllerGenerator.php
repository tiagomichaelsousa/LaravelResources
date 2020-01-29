<?php

namespace tiagomichaelsousa\LaravelResources\Generators;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use tiagomichaelsousa\LaravelResources\Exceptions\File as FileException;

class ControllerGenerator implements Generator
{
    /**
     * The model for that will be used in the controller.
     *
     * @var string
     */
    private $model;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Get the Stub for the controller.
     *
     * @return string
     */
    public function getStub()
    {
        return File::get(__DIR__.'/../stubs/controllers/controller.stub');
    }

    /**
     * Get the replacements for the stub.
     *
     * @return array
     */
    public function replacements()
    {
        return array_merge(
            [
                '{{NAMESPACE}}' => config('laravel-resources.controllers.namespace'),
                '{{CONTROLLER_NAMESPACE}}' => config('laravel-resources.controllers.namespace'),
                '{{CONTROLLER_NAME}}' => "{$this->className()}",
                '{{RESOURCE_NAMESPACE}}' => config('laravel-resources.resources.namespace').'\\'.create_class_name($this->model, ResourceGenerator::class),
                '{{RESOURCE_COLLECTION_NAMESPACE}}' => config('laravel-resources.collections.namespace').'\\'.create_class_name($this->model, CollectionGenerator::class),
                '{{MODEL_CLASS}}' => "{$this->model}",
            ],
            $this->modelReplacements(),
            $this->requestReplacements(),
            $this->methodsReplacements()
        );
    }

    /**
     * Get the replacements for the stub methods.
     *
     * @return array
     */
    private function methodsReplacements()
    {
        $methods = [];

        foreach (['index', 'store', 'show', 'update', 'destroy'] as $method) {
            $stub = File::get(__DIR__."/../stubs/controllers/controller.method.{$method}.stub");

            $replaces = [
                '{{CLASS_NAME}}' => $this->model,
                '{{RESOURCE_NAME}}' => $method === 'index' ? create_class_name($this->model, CollectionGenerator::class) : create_class_name($this->model, ResourceGenerator::class),
                '{{CLASS_VARIABLE}}' => lcfirst($this->model),
            ];

            $methodStubName = strtoupper($method);

            array_push($methods, ["{{{$methodStubName}_METHOD}}" => str_replace(array_keys($replaces), array_values($replaces), $stub)]);
        }

        return Arr::collapse($methods);
    }

    /**
     * Get the replacements for the current model.
     *
     * @return array
     */
    public function modelReplacements()
    {
        return [
            '{{MODEL_CLASS}}' => $this->model,
            '{{MODEL_VARIABLE}}' => lcfirst($this->model),
            '{{MODEL_NAMESPACE}}' => config('laravel-resources.models.namespace')."\\{$this->model}",
        ];
    }

    /**
     * Get the replacements for the current request of the current model.
     *
     * @return array
     */
    public function requestReplacements()
    {
        $requestClass = create_class_name($this->model, RequestGenerator::class);

        return [
            '{{REQUEST_CLASS}}' =>  $requestClass,
            '{{REQUEST_NAMESPACE}}' => config('laravel-resources.requests.namespace')."\\{$requestClass}",
        ];
    }

    /**
     * Verify if the resource already exists.
     *
     * @return mixed|\tiagomichaelsousa\LaravelResources\Exceptions\File
     */
    public function fileAlreadyExists($path)
    {
        if (File::exists($path)) {
            throw FileException::alreadyExistsInDirectory($path);
        }
    }

    /**
     * Verify if the directory and create one if it doesn't.
     *
     * @return bool
     */
    public function directoryExists($path)
    {
        return (bool) File::isDirectory($path) ?: make_directory($path);
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
     * Generate the file name.
     *
     * @return string
     */
    public function fileName()
    {
        return "{$this->className()}.php";
    }

    /**
     * Handle the resource creation.
     *
     * @return void
     */
    public function handle()
    {
        $namespace = config('laravel-resources.controllers.namespace');
        $directory = namespace_path($namespace);

        $path = "{$directory}/{$this->filename()}";

        $this->fileAlreadyExists($path);

        $replaces = $this->replacements($this->model);

        $stub = str_replace(array_keys($replaces), array_values($replaces), $this->getStub());

        $this->directoryExists($directory);

        file_put_contents($path, $stub);
    }
}
