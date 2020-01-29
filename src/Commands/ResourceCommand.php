<?php

namespace tiagomichaelsousa\LaravelResources\Commands;

use Illuminate\Console\Command;
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
     * @return boolean
     */
    private function modelExists()
    {
        return File::exists(base_path(lcfirst(str_replace('\\', '/', config('laravel-resources.models.namespace')))) . "/{$this->model}.php");
    }

    /**
     * Create the resources chosen by the user.
     *
     * @return void
     */
    private function createResources()
    {
        $this->info('Creating ' . count($this->resources) . ' resources ...');
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
            $this->error("The model {$this->model} does not exists");

            return ;
        }

        $this->createResources();
    }
}
