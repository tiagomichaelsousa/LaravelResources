<?php

namespace tiagomichaelsousa\LaravelResources\Generators;

use Illuminate\Support\Facades\File;

class PolicyGenerator extends AbstractGenerator
{
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
            '{{NAMESPACE}}'       => config('laravel-resources.policies.namespace'),
            '{{CLASS_NAME}}'      => "{$this->className()}",
            '{{MODEL_NAMESPACE}}' => config('laravel-resources.models.namespace'),
            '{{MODEL_NAME}}'      => config('laravel-resources.models.namespace'),
            '{{MODEL_CLASS}}'     => $this->model,
            '{{MODEL_VARIABLE}}'  => lcfirst($this->model),
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
