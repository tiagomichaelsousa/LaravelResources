<?php

namespace tiagomichaelsousa\LaravelResources\Tests;

use tiagomichaelsousa\LaravelResources\Generators\MigrationGenerator;

class MigrationGeneratorTest extends TestCase
{
    /** @test */
    public function it_generates_the_right_class_name()
    {
        $generator = new MigrationGenerator($this->model);
        $filename = $generator->className();
        $generator->handle();

        $this->assertEquals($filename, "CreateUsersTable");
    }

    /** @test */
    public function it_creates_the_migration_file()
    {
        $generator = new MigrationGenerator($this->model);

        $config = namespace_path(config('laravel-resources.database.migrations') . "\\{$generator->fileName()}");

        $generator->handle();

        $this->assertFileExists($config);
    }

    /** @test */
    public function it_creates_the_migration_in_the_config_namespace()
    {
        config()->set('laravel-resources.database.migrations', 'database/dummy');

        $generator = new MigrationGenerator($this->model);

        $config = namespace_path(config('laravel-resources.database.migrations') . "\\{$generator->fileName()}");

        $generator->handle();

        $this->assertFileExists($config);
    }

    /** @test */
    public function it_creates_the_migration_in_the_default_namespace()
    {
        $generator = new MigrationGenerator($this->model);

        $config = namespace_path(config('laravel-resources.database.migrations') . "\\{$generator->fileName()}");

        $generator->handle();

        $this->assertFileExists($config);
    }
}
