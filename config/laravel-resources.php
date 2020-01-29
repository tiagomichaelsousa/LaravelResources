<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Controller configs
    |--------------------------------------------------------------------------
    |
    | This values are used when a new controller is created.
    | If you change the namespace, it will automatically create the controller in the folder base path.
    | The suffix and prefix are variables that can be edited to change the class name for the controller
    |
    */
    'controllers' => [
        'namespace' => 'App\Http\Controllers',
        'suffix' => 'API',
        'prefix' => null,
    ],

    /*
    |--------------------------------------------------------------------------
    | Resources configs
    |--------------------------------------------------------------------------
    |
    | This values are used when a new resource is created.
    | If you change the namespace, it will automatically create the resource in the folder base path.
    | The suffix and prefix are variables that can be edited to change the class name for the controller.
    | When you create a resource you can also create a collection that will inherit the data from the resource.
    | The collection class will also have the possibility to define the suffix and prefix for the class name.
    |
    */
    'resources' => [
        'namespace' => 'App\Http\Resources',
        'suffix' => null,
        'prefix' => null,
    ],

    'collections' => [
        'namespace' => 'App\Http\Resources\Collections',
        'suffix' => null,
        'prefix' => null,
    ],

    /*
    |--------------------------------------------------------------------------
    | Resources configs
    |--------------------------------------------------------------------------
    |
    | This values are used when a new resource is created.
    | If you change the namespace, it will automatically create the resource in the folder base path.
    | The suffix and prefix are variables that can be edited to change the class name for the controller.
    | When you create a resource you can also create a collection that will inherit the data from the resource.
    | The collection class will also have the possibility to define the suffix and prefix for the class name.
    |
    */
    'requests' => [
        'namespace' => 'App\Http\Requests',
        'suffix' => null,
        'prefix' => null,
    ],

    /*
    |--------------------------------------------------------------------------
    | Policies configs
    |--------------------------------------------------------------------------
    |
    | This values are used when a new policy is created.
    | If you change the namespace, it will automatically create the resource in the folder base path.
    | The suffix and prefix are variables that can be edited to change the class name for the policy.
    |
    */
    'policies' => [
        'namespace' => 'App\Policies',
        'suffix' => null,
        'prefix' => null,
    ],

    /*
    |--------------------------------------------------------------------------
    | Model configs
    |--------------------------------------------------------------------------
    |
    | This config is used to fetch the models from the namespace.
    | Many projects change the path for the models to /app/models and thats the mainly reason
    | for the usage of this config value.
    |
    */
    'models' => [
        'namespace' => 'App',
    ],

    /*
    |--------------------------------------------------------------------------
    | Routes configs
    |--------------------------------------------------------------------------
    |
    | This config is used set the path and the filename where the stubs for the routes
    | will be added.
    |
    */
    'routes' => [
        'path' => 'routes',
        'filename' => 'api.php',
    ],
];
