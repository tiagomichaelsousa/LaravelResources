<?php

namespace tiagomichaelsousa\LaravelResources\Tests;

class ResourceCommandTest extends TestCase
{
    /** @test */
    public function it_requires_that_the_model_exists()
    {
        $this->artisan('resources:create', ['model' => 'Foo'])->expectsOutput('The model Foo does not exists');
        $this->artisan('resources:create', ['model' => 'User'])->expectsOutput('🚀 Resources created successfully 🚀');
    }
}
