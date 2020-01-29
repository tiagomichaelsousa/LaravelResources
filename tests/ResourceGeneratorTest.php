<?php

namespace tiagomichaelsousa\LaravelResources\Tests;

use tiagomichaelsousa\LaravelResources\Generators\ResourceGenerator;

class ResourceGeneratorTest extends TestCase
{
    /** @test */
    public function it_generates_the_right_filename()
    {
        $generator = new ResourceGenerator($this->model);
        $filename = $generator->fileName();
        $generator->handle();

        $this->assertEquals($filename, "{$generator->className()}.php");
    }

    /** @test */
    public function it_generates_the_right_class_name()
    {
        $generator = new ResourceGenerator($this->model);
        $filename = $generator->className();
        $generator->handle();

        $this->assertEquals($filename, create_class_name($this->model, ResourceGenerator::class));
    }

    /** @test */
    public function it_creates_the_resource_file()
    {
        $generator = new ResourceGenerator($this->model);

        $config = namespace_path(config('laravel-resources.resources.namespace')."\\{$generator->fileName()}");

        $generator->handle();

        $this->assertFileExists($config);
    }

    /** @test */
    public function it_creates_the_request_in_the_config_namespace()
    {
        config()->set('laravel-resources.resources.namespace', 'App\Http');

        $generator = new ResourceGenerator($this->model);

        $config = namespace_path(config('laravel-resources.resources.namespace')."\\{$generator->fileName()}");

        $generator->handle();

        $this->assertFileExists($config);
    }

    /** @test */
    public function it_generates_the_name_with_the_suffix_defined_in_the_configuration_file_for_the_resource()
    {
        config()->set('laravel-resources.resources.suffix', $suffix = 'Suffix');
        config()->set('laravel-resources.resources.prefix', null);

        $generator = new ResourceGenerator($this->model);
        $generator->handle();

        $this->assertEquals("{$this->model}Resource{$suffix}", $generator->className());
    }

    /** @test */
    public function it_generates_the_name_with_the_prefix_defined_in_the_configuration_file_for_the_resource()
    {
        config()->set('laravel-resources.resources.prefix', $prefix = 'Prefix');
        config()->set('laravel-resources.resources.suffix', null);

        $generator = new ResourceGenerator($this->model);
        $generator->handle();

        $this->assertEquals("{$prefix}{$this->model}Resource", $generator->className());
    }

    /** @test */
    public function it_generates_the_name_with_the_suffix_and_prefix_defined_in_the_configuration_file_for_the_resource()
    {
        config()->set('laravel-resources.resources.prefix', $prefix = 'Foo');
        config()->set('laravel-resources.resources.suffix', $suffix = 'BarAPI');

        $generator = new ResourceGenerator($this->model);
        $generator->handle();

        $this->assertEquals("{$prefix}{$this->model}Resource{$suffix}", $generator->className());
    }
}
