<?php

namespace tiagomichaelsousa\LaravelResources\Generators;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SeederGenerator extends AbstractGenerator
{
    /**
     * Get the Stub for the policy.
     *
     * @return string
     */
    public function getStub()
    {
        return File::get(__DIR__ . '/../stubs/seeds/seed.stub');
    }

    /**
     * Get the replacements for the stub.
     *
     * @return array
     */
    public function replacements()
    {
        return array_merge([
            '{{MODEL_NAMESPACE}}' => config('laravel-resources.models.namespace'),
            '{{MODEL_NAME}}' => $this->model,
            '{{MODEL_PLURAL}}' => Str::plural($this->model),
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
        $plural = Str::plural($this->model);

        return "{$plural}TableSeeder";
    }

    /**
     * Handle the resource creation.
     *
     * @return void
     */
    public function handle()
    {
        $namespace = config('laravel-resources.database.seeds');
        $directory = base_path(lcfirst(str_replace('\\', '/', $namespace)));
        $path = "{$directory}/{$this->fileName()}";

        $this->fileAlreadyExists($path);

        $replaces = $this->replacements($this->model);
        $stub = str_replace(array_keys($replaces), array_values($replaces), $this->getStub());

        $this->directoryExists($directory);

        file_put_contents($path, $stub);
    }
}
