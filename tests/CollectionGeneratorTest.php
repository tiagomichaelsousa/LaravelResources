<?php

namespace tiagomichaelsousa\LaravelResources\Tests;

use tiagomichaelsousa\LaravelResources\Generators\CollectionGenerator;

class CollectionGeneratorTest extends TestCase
{
    /** @test */
    public function it_generates_the_right_filename()
    {
        $generator = new CollectionGenerator($this->model);
        $filename = $generator->fileName();
        $generator->handle();

        $this->assertEquals($filename, "{$generator->className()}.php");
    }

    /** @test */
    public function it_generates_the_right_class_name()
    {
        $generator = new CollectionGenerator($this->model);
        $filename = $generator->className();
        $generator->handle();

        $this->assertEquals($filename, create_class_name($this->model, CollectionGenerator::class));
    }

    /** @test */
    public function it_creates_the_collection_file()
    {
        $generator = new CollectionGenerator($this->model);
        $config = namespace_path(config('laravel-resources.collections.namespace')."\\{$generator->fileName()}");

        $generator->handle();

        $this->assertFileExists($config);
    }

    /** @test */
    public function it_creates_the_collection_in_the_config_namespace()
    {
        config()->set('laravel-resources.collections.namespace', 'App\Http\Resources');
        $generator = new CollectionGenerator($this->model);

        $config = namespace_path(config('laravel-resources.collections.namespace')."\\{$generator->fileName()}");

        $generator->handle();

        $this->assertFileExists($config);
    }

    /** @test */
    public function it_generates_the_name_with_the_suffix_defined_in_the_configuration_file_for_the_collection()
    {
        config()->set('laravel-resources.collections.suffix', $suffix = 'Suffix');
        config()->set('laravel-resources.collections.prefix', null);

        $generator = new CollectionGenerator($this->model);
        $generator->handle();

        $this->assertEquals("{$this->model}Collection{$suffix}", $generator->className());
    }

    /** @test */
    public function it_generates_the_name_with_the_prefix_defined_in_the_configuration_file_for_the_collection()
    {
        config()->set('laravel-resources.collections.suffix', null);
        config()->set('laravel-resources.collections.prefix', $prefix = 'PrefixAPI');

        $generator = new CollectionGenerator($this->model);
        $generator->handle();

        $this->assertEquals("{$prefix}{$this->model}Collection", $generator->className());
    }

    /** @test */
    public function it_generates_the_name_with_the_suffix_and_prefix_defined_in_the_configuration_file_for_the_collection()
    {
        config()->set('laravel-resources.collections.prefix', $prefix = 'Foo');
        config()->set('laravel-resources.collections.suffix', $suffix = 'BarAPI');

        $generator = new CollectionGenerator($this->model);
        $generator->handle();

        $this->assertEquals("{$prefix}{$this->model}Collection{$suffix}", $generator->className());
    }
}
