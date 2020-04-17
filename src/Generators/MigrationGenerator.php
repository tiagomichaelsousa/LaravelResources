<?php

namespace tiagomichaelsousa\LaravelResources\Generators;

use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MigrationGenerator extends AbstractGenerator
{
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
