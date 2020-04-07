<?php

namespace tiagomichaelsousa\LaravelResources\Tests;

use Illuminate\Support\Facades\File;
use Orchestra\Testbench\TestCase as Orchestra;
use tiagomichaelsousa\LaravelResources\LaravelResourcesServiceProvider;

abstract class TestCase extends Orchestra
{
    /**
     * Default model to run the test suite.
     *
     * @var string
     */
    protected $model = 'User';

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->clearDirectories();

        $this->initialize();
    }

    /**
     * Clean up the testing environment before the next test.
     *
     * @return void
     */
    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * Clean up the testing environment directories before the next test.
     *
     * @return void
     */
    private function clearDirectories()
    {
        File::cleanDirectory(base_path('app'));
        File::deleteDirectory(base_path('routes'));
        File::cleanDirectory(database_path('migrations'));
        File::cleanDirectory(database_path('factories'));
        File::cleanDirectory(database_path('seeds'));
        File::cleanDirectory(database_path('dummy'));
    }

    /**
     * Create the test suite default folder structure.
     *
     * @return void
     */
    private function initialize()
    {
        if (!File::exists(namespace_path(config('laravel-resources.models.namespace')) . '/User.php')) {
            $this->artisan('make:model User');
        }

        if (!File::exists($route = namespace_path(config('laravel-resources.routes.path')) . '/' . config('laravel-resources.routes.filename'))) {
            make_directory(namespace_path(config('laravel-resources.routes.path')));
            file_put_contents($route, '<?php');
        }
    }

    /**
     * Create the test suite default folder structure.
     *
     * @return void
     */
    protected function getPackageProviders($app)
    {
        return [
            LaravelResourcesServiceProvider::class,
        ];
    }
}
