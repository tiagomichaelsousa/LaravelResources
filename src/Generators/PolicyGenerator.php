<?php

namespace tiagomichaelsousa\LaravelResources\Generators;

use Illuminate\Support\Facades\File;
use tiagomichaelsousa\LaravelResources\Exceptions\File as FileException;

class PolicyGenerator implements Generator
{
    /**
     * The model for that will be used in the policy.
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
     * Get the Stub for the policy.
     *
     * @return string
     */
    public function getStub()
    {
        return File::get(__DIR__.'/../stubs/policies/api.policies.stub');
    }

    /**
     * Get the replacements for the stub.
     *
     * @return array
     */
    public function replacements()
    {
        return array_merge([
            '{{NAMESPACE}}' => config('laravel-resources.policies.namespace'),
            '{{CLASS_NAME}}' => "{$this->className()}",
            '{{MODEL_NAMESPACE}}' => config('laravel-resources.models.namespace'),
            '{{MODEL_NAME}}' => config('laravel-resources.models.namespace'),
            '{{MODEL_CLASS}}' => $this->model,
            '{{MODEL_VARIABLE}}' => lcfirst($this->model),
        ]);
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
        $namespace = config('laravel-resources.policies.namespace');
        $directory = base_path(lcfirst(str_replace('\\', '/', $namespace)));
        $path = "{$directory}/{$this->fileName()}";

        $this->fileAlreadyExists($path);

        $replaces = $this->replacements($this->model);
        $stub = str_replace(array_keys($replaces), array_values($replaces), $this->getStub());

        $this->directoryExists($directory);

        file_put_contents($path, $stub);
    }
}
