<?php

namespace tiagomichaelsousa\LaravelResources\Tests;

use tiagomichaelsousa\LaravelResources\Generators\FactoryGenerator;

class FactoryGeneratorTest extends TestCase
{
    /** @test */
    public function it_generates_the_right_class_name()
    {
        $generator = new FactoryGenerator($this->model);
        $filename = $generator->className();
        $generator->handle();

        $this->assertEquals($filename, "UserFactory");
    }

    /** @test */
    public function it_creates_the_migration_file()
    {
        $generator = new FactoryGenerator($this->model);

        $config = namespace_path(config('laravel-resources.database.factories') . "\\{$generator->fileName()}");

        $generator->handle();

        $this->assertFileExists($config);
    }

    /** @test */
    public function it_creates_the_migration_in_the_config_namespace()
    {
        config()->set('laravel-resources.database.factories', 'database/dummy');

        $generator = new FactoryGenerator($this->model);

        $config = namespace_path(config('laravel-resources.database.factories') . "\\{$generator->fileName()}");

        $generator->handle();

        $this->assertFileExists($config);
    }

    /** @test */
    public function it_creates_the_migration_in_the_default_namespace()
    {
        $generator = new FactoryGenerator($this->model);

        $config = namespace_path(config('laravel-resources.database.factories') . "\\{$generator->fileName()}");

        $generator->handle();

        $this->assertFileExists($config);
    }
}
