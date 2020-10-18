<?php

namespace tiagomichaelsousa\LaravelResources\Tests;

use tiagomichaelsousa\LaravelResources\Generators\ControllerGenerator;

class ControllerGeneratorTest extends TestCase
{
    /** @test */
    public function it_generates_the_right_filename()
    {
        $generator = new ControllerGenerator($this->model);
        $filename = $generator->fileName();
        $generator->handle();

        $this->assertEquals($filename, "{$generator->className()}.php");
    }

    /** @test */
    public function it_generates_the_right_class_name()
    {
        $generator = new ControllerGenerator($this->model);
        $filename = $generator->className();
        $generator->handle();

        $this->assertEquals($filename, create_class_name($this->model, ControllerGenerator::class));
    }

    /** @test */
    public function it_creates_the_controller_file()
    {
        $generator = new ControllerGenerator($this->model);

        $config = namespace_path(config('laravel-resources.controllers.namespace')."\\{$generator->fileName()}");

        $generator->handle();

        $this->assertFileExists($config);
    }

    /** @test */
    public function it_creates_the_controller_in_the_config_namespace()
    {
        config()->set('laravel-resources.controllers.namespace', 'App\Http\Controllers\API');

        $generator = new ControllerGenerator($this->model);

        $config = namespace_path(config('laravel-resources.controllers.namespace')."\\{$generator->fileName()}");

        $generator->handle();

        $this->assertFileExists($config);
    }

    /** @test */
    public function it_generates_the_name_with_the_suffix_defined_in_the_configuration_file_for_the_controller()
    {
        config()->set('laravel-resources.controllers.suffix', $suffix = 'Suffix');
        config()->set('laravel-resources.controllers.prefix', null);

        $generator = new ControllerGenerator($this->model);
        $generator->handle();

        $this->assertEquals("{$this->model}Controller{$suffix}", $generator->className());
    }

    /** @test */
    public function it_generates_the_name_with_the_prefix_defined_in_the_configuration_file_for_the_controller()
    {
        config()->set('laravel-resources.controllers.prefix', $prefix = 'Prefix');
        config()->set('laravel-resources.controllers.suffix', null);

        $generator = new ControllerGenerator($this->model);
        $generator->handle();

        $this->assertEquals("{$prefix}{$this->model}Controller", $generator->className());
    }

    /** @test */
    public function it_generates_the_name_with_the_suffix_and_prefix_defined_in_the_configuration_file_for_the_controller()
    {
        config()->set('laravel-resources.controllers.prefix', $prefix = 'Foo');
        config()->set('laravel-resources.controllers.suffix', $suffix = 'BarAPI');

        $generator = new ControllerGenerator($this->model);
        $generator->handle();

        $this->assertEquals("{$prefix}{$this->model}Controller{$suffix}", $generator->className());
    }
}
