<?php

namespace tiagomichaelsousa\LaravelResources\Tests;

use tiagomichaelsousa\LaravelResources\Generators\RequestGenerator;

class RequestGeneratorTest extends TestCase
{
    /** @test */
    public function it_generates_the_right_filename()
    {
        $generator = new RequestGenerator($this->model);
        $filename = $generator->fileName();
        $generator->handle();

        $this->assertEquals($filename, "{$generator->className()}.php");
    }

    /** @test */
    public function it_generates_the_right_class_name()
    {
        $generator = new RequestGenerator($this->model);
        $filename = $generator->className();
        $generator->handle();

        $this->assertEquals($filename, create_class_name($this->model, RequestGenerator::class));
    }

    /** @test */
    public function it_creates_the_request_file()
    {
        $generator = new RequestGenerator($this->model);

        $config = namespace_path(config('laravel-resources.requests.namespace')."\\{$generator->fileName()}");

        $generator->handle();

        $this->assertFileExists($config);
    }

    /** @test */
    public function it_creates_the_request_in_the_config_namespace()
    {
        config()->set('laravel-resources.requests.namespace', 'App\Http');

        $generator = new RequestGenerator($this->model);

        $config = namespace_path(config('laravel-resources.requests.namespace')."\\{$generator->fileName()}");

        $generator->handle();

        $this->assertFileExists($config);
    }

    /** @test */
    public function it_generates_the_name_with_the_suffix_defined_in_the_configuration_file_for_the_request()
    {
        config()->set('laravel-resources.requests.suffix', $suffix = 'Suffix');
        config()->set('laravel-resources.requests.prefix', null);

        $generator = new RequestGenerator($this->model);
        $generator->handle();

        $this->assertEquals("{$this->model}Request{$suffix}", $generator->className());
    }

    /** @test */
    public function it_generates_the_name_with_the_prefix_defined_in_the_configuration_file_for_the_request()
    {
        config()->set('laravel-resources.requests.prefix', $prefix = 'PrefixAPI');
        config()->set('laravel-resources.requests.suffix', null);

        $generator = new RequestGenerator($this->model);
        $generator->handle();

        $this->assertEquals("{$prefix}{$this->model}Request", $generator->className());
    }

    /** @test */
    public function it_generates_the_name_with_the_suffix_and_prefix_defined_in_the_configuration_file_for_the_request()
    {
        config()->set('laravel-resources.requests.prefix', $prefix = 'Foo');
        config()->set('laravel-resources.requests.suffix', $suffix = 'BarAPI');

        $generator = new RequestGenerator($this->model);
        $generator->handle();

        $this->assertEquals("{$prefix}{$this->model}Request{$suffix}", $generator->className());
    }
}
