<?php

namespace tiagomichaelsousa\LaravelResources\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use tiagomichaelsousa\LaravelResources\Generators\CollectionGenerator;
use tiagomichaelsousa\LaravelResources\Generators\ControllerGenerator;
use tiagomichaelsousa\LaravelResources\Generators\PolicyGenerator;
use tiagomichaelsousa\LaravelResources\Generators\RequestGenerator;
use tiagomichaelsousa\LaravelResources\Generators\ResourceGenerator;
use tiagomichaelsousa\LaravelResources\Generators\RouteGenerator;

class ResourceCommand extends Command
{
    /**
     * The resources that can be created.
     *
     * @var array
     */
    private $resources = [
        ResourceGenerator::class,
        CollectionGenerator::class,
        RequestGenerator::class,
        PolicyGenerator::class,
        ControllerGenerator::class,
        RouteGenerator::class,
    ];

    /**
     * The resources that can be created if the model does not exists.
     *
     * @var array
     */
    private $modelResources = [
        'migration', 'factory', 'seeder',
    ];

    /**
     * The model name for the resources.
     *
     * @var string
     */
    private $model;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'resources:create
                            {model : The model for the resource}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will allow you to create all resources that you need for a clean api code structure';

    /**
     * Verify if the model exists to create the resources.
     *
     * @return bool
     */
    private function modelExists()
    {
        return File::exists(base_path(lcfirst(str_replace('\\', '/', config('laravel-resources.models.namespace'))))."/{$this->model}.php");
    }

    /**
     * Create the model if does not exists.
     *
     * @return void
     */
    private function createModel()
    {
        $flags = [];

        foreach ($this->modelResources as $resource) {
            if ($this->confirm("Should I create the {$resource} for {$this->model}?", true)) {
                array_push($flags, ' -'.substr($resource, 0, 1));
            }
        }

        Artisan::call("make:model {$this->model}".implode('', $flags));
    }

    /**
     * Create the resources for the model.
     *
     * @return void
     */
    private function createResources()
    {
        $this->info('Creating '.count($this->resources).' resources ...');
        $this->line('');

        $bar = $this->getOutput()->createProgressBar(count($this->resources));

        foreach ($this->resources as $resource) {
            (new $resource($this->model))->handle();
            $bar->advance();
        }

        $bar->finish();
        $this->line('');
        $this->line('');

        $this->info('🚀 Resources created successfully 🚀');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Checking if the model exists ...');

        $this->model = $this->argument('model');

        if (! $this->modelExists($this->model)) {
            $this->info("The model {$this->model} does not exists.");

            if ($this->confirm('Should I create it?', true)) {
                $this->createModel();
            }

            return;
        }

        $this->createResources();
    }
}
