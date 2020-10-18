<?php

namespace tiagomichaelsousa\LaravelResources\Tests;

use tiagomichaelsousa\LaravelResources\Generators\ModelGenerator;

class ModelGeneratorTest extends TestCase
{
    /**
     * Override to the model for this test suite.
     *
     * @var string
     */
    protected $model = 'Post';

    /** @test */
    public function it_creates_the_model_file()
    {
        $generator = new ModelGenerator($this->model);

        $config = namespace_path(config('laravel-resources.models.namespace')."\\{$generator->fileName()}");

        $generator->handle();

        $this->assertFileExists($config);
    }

    /** @test */
    public function it_creates_the_model_in_the_config_namespace()
    {
        config()->set('laravel-resources.models.namespace', 'App\Models');

        $generator = new ModelGenerator($this->model);

        $config = namespace_path(config('laravel-resources.models.namespace')."\\{$generator->fileName()}");

        $generator->handle();

        $this->assertFileExists($config);
    }
}
