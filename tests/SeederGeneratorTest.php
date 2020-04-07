<?php

namespace tiagomichaelsousa\LaravelResources\Tests;

use tiagomichaelsousa\LaravelResources\Generators\SeederGenerator;

class SeederGeneratorTest extends TestCase
{
    /** @test */
    public function it_generates_the_right_class_name()
    {
        $generator = new SeederGenerator($this->model);
        $filename = $generator->className();
        $generator->handle();

        $this->assertEquals($filename, "UsersTableSeeder");
    }

    /** @test */
    public function it_creates_the_seeder_file()
    {
        $generator = new SeederGenerator($this->model);

        $config = namespace_path(config('laravel-resources.database.seeds') . "\\{$generator->fileName()}");

        $generator->handle();

        $this->assertFileExists($config);
    }

    /** @test */
    public function it_creates_the_seeder_in_the_config_namespace()
    {
        config()->set('laravel-resources.database.seeds', 'database/dummy');

        $generator = new SeederGenerator($this->model);

        $config = namespace_path(config('laravel-resources.database.seeds') . "\\{$generator->fileName()}");

        $generator->handle();

        $this->assertFileExists($config);
    }

    /** @test */
    public function it_creates_the_seeder_in_the_default_namespace()
    {
        $generator = new SeederGenerator($this->model);

        $config = namespace_path(config('laravel-resources.database.seeds') . "\\{$generator->fileName()}");

        $generator->handle();

        $this->assertFileExists($config);
    }
}
