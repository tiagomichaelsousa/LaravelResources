<?php

namespace tiagomichaelsousa\LaravelResources\Generators;

use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use tiagomichaelsousa\LaravelResources\Exceptions\File as FileException;

class MigrationGenerator implements Generator
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
        return File::get(__DIR__.'/../stubs/migrations/migration.stub');
    }

    /**
     * Get the replacements for the stub.
     *
     * @return array
     */
    public function replacements()
    {
        return array_merge([
            '{{CLASS_NAME}}' => $this->className(),
            '{{TABLE_NAME}}' => Str::lower(Str::snake(Str::plural($this->model))),
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
        $name = Str::plural($this->model);

        return "Create{$name}Table";
    }

    /**
     * Generate the file name.
     *
     * @return string
     */
    public function fileName()
    {
        $date = Carbon::now()->format('Y_m_d_Hms');
        $name = Str::lower(Str::snake($this->className()));

        return "{$date}_{$name}.php";
    }

    /**
     * Handle the resource creation.
     *
     * @return void
     */
    public function handle()
    {
        $namespace = config('laravel-resources.database.migrations');
        $directory = base_path(lcfirst(str_replace('\\', '/', $namespace)));
        $path = "{$directory}/{$this->fileName()}";

        $this->fileAlreadyExists($path);

        $replaces = $this->replacements($this->model);
        $stub = str_replace(array_keys($replaces), array_values($replaces), $this->getStub());

        $this->directoryExists($directory);

        file_put_contents($path, $stub);
    }
}
