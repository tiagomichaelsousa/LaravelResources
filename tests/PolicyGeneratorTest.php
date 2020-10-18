<?php

namespace tiagomichaelsousa\LaravelResources\Tests;

use tiagomichaelsousa\LaravelResources\Generators\PolicyGenerator;

class PolicyGeneratorTest extends TestCase
{
    /** @test */
    public function it_generates_the_right_filename()
    {
        $generator = new PolicyGenerator($this->model);
        $filename = $generator->fileName();
        $generator->handle();

        $this->assertEquals($filename, "{$generator->className()}.php");
    }

    /** @test */
    public function it_generates_the_right_class_name()
    {
        $generator = new PolicyGenerator($this->model);
        $filename = $generator->className();
        $generator->handle();

        $this->assertEquals($filename, create_class_name($this->model, PolicyGenerator::class));
    }

    /** @test */
    public function it_creates_the_policy_file()
    {
        $generator = new PolicyGenerator($this->model);

        $config = namespace_path(config('laravel-resources.policies.namespace')."\\{$generator->fileName()}");

        $generator->handle();

        $this->assertFileExists($config);
    }

    /** @test */
    public function it_creates_the_policy_in_the_config_namespace()
    {
        config()->set('laravel-resources.policies.namespace', 'App\Http\Policies');

        $generator = new PolicyGenerator($this->model);

        $config = namespace_path(config('laravel-resources.policies.namespace')."\\{$generator->fileName()}");

        $generator->handle();

        $this->assertFileExists($config);
    }

    /** @test */
    public function it_generates_the_name_with_the_suffix_defined_in_the_configuration_file_for_the_policy()
    {
        config()->set('laravel-resources.policies.suffix', $suffix = 'Suffix');
        config()->set('laravel-resources.policies.prefix', null);

        $generator = new PolicyGenerator($this->model);
        $generator->handle();

        $this->assertEquals("{$this->model}Policy{$suffix}", $generator->className());
    }

    /** @test */
    public function it_generates_the_name_with_the_prefix_defined_in_the_configuration_file_for_the_policy()
    {
        config()->set('laravel-resources.policies.prefix', $prefix = 'Prefix');
        config()->set('laravel-resources.policies.suffix', null);

        $generator = new PolicyGenerator($this->model);
        $generator->handle();

        $this->assertEquals("{$prefix}{$this->model}Policy", $generator->className());
    }

    /** @test */
    public function it_generates_the_name_with_the_suffix_and_prefix_defined_in_the_configuration_file_for_the_policy()
    {
        config()->set('laravel-resources.policies.prefix', $prefix = 'Foo');
        config()->set('laravel-resources.policies.suffix', $suffix = 'BarAPI');

        $generator = new PolicyGenerator($this->model);
        $generator->handle();

        $this->assertEquals("{$prefix}{$this->model}Policy{$suffix}", $generator->className());
    }
}
