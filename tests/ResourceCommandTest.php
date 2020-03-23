<?php

namespace tiagomichaelsousa\LaravelResources\Tests;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ResourceCommandTest extends TestCase
{

    /** @test */
    public function it_creates_the_resources_if_the_model_exists()
    {
        $this->artisan('resources:create', ['model' => 'User'])->expectsOutput('🚀 Resources created successfully 🚀');
    }
    
    /** @test */
    public function it_should_not_create_the_model_if_it_does_not_exists_and_the_user_deny_the_question()
    {
        $this->artisan('resources:create', ['model' => 'Foo'])
            ->expectsOutput('The model Foo does not exists.')
            ->expectsQuestion('Should I create it?', false);

        $this->assertFalse(File::exists(app_path('/Foo.php')));
    }

    /** @test */
    public function it_creates_the_model_if_it_does_not_exists_and_the_user_accepts_the_question()
    {
        $this->defaultQuestions();

        $path = namespace_path(config('laravel-resources.models.namespace')."\\Foo.php");
        
        $this->assertTrue(File::exists($path));
    }

    /** @test */
    public function it_creates_the_migration_when_the_response_to_the_question_is_true()
    {
        $this->defaultQuestions(['migration']);
       
        $this->assertEquals(1, collect(File::files(database_path("/migrations")))->count());
    }

    /** @test */
    public function it_creates_the_factory_when_the_response_to_the_question_is_true()
    {
        $this->defaultQuestions(['factory']);
       
        $this->assertEquals(1, collect(File::files(database_path("/factories")))->count());
    }

    /** @test */
    public function it_creates_the_seeder_when_the_response_to_the_question_is_true()
    {
        $this->defaultQuestions(['migration', 'factory', 'seeder']);
          
        $this->assertEquals(1, collect(File::files(database_path("/migrations")))->count());
        $this->assertEquals(1, collect(File::files(database_path("/seeds")))->count());
        $this->assertEquals(1, collect(File::files(database_path("/factories")))->count());
    }

    /** @test */
    public function it_creates_the_all_files_when_the_response_to_the_question_is_always_true()
    {
        $this->defaultQuestions(['seeder']);
           
        $this->assertEquals(1, collect(File::files(database_path("/seeds")))->count());
    }

    /**
    * Create the command boilerplate for the model creation.
    *
    * @return void
    */
    protected function defaultQuestions($args = [], $shouldCreate = true)
    {
        $this->artisan('resources:create', ['model' => 'Foo'])
             ->expectsOutput('The model Foo does not exists.')
             ->expectsQuestion('Should I create it?', $shouldCreate)
             ->expectsQuestion("Should I create the migration for Foo?", in_array('migration', $args))
             ->expectsQuestion("Should I create the factory for Foo?", in_array('factory', $args))
             ->expectsQuestion("Should I create the seeder for Foo?", in_array('seeder', $args));
    }
}
