# LaravelResources

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

Laravel Resources is a speed-up development package that allows you to create a boilerplate for Laravel apps with a default API structure.

## Installation

Via Composer

```bash
$ composer require tiagomichaelsousa/laravelresources --dev
```

## Usage

Create the resources

```bash
$ php artisan resources:create <model>
```

This command will create the Controller, the Request, the Policy, the API Resource and Collection and will also add the default routes for the API.

Publish configuration file

```bash
$ php artisan vendor:publish --provider="tiagomichaelsousa\LaravelResources\LaravelResourcesServiceProvider" --tag="config"
```

**Notes:**

- This package is fully configurable. You can change all the namespaces for the resources that will be created in the config file.
- Don't forget to edit the request file in order to add your default validation for the model.
- Don't forget to edit the policy file in order to fulfill your app business logic.

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

```bash
$ composer test
```

### With test coverage

```bash
$ composer test-report
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email the [author](tiagomichaelsousa@gmail.com) instead of using the issue tracker.

## Credits

- [@tiagomichaelsousa][link-author]
- [All Contributors][link-contributors]

## License

License MIT. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/tiagomichaelsousa/laravelresources.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/tiagomichaelsousa/laravelresources.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/tiagomichaelsousa/laravelresources/master.svg?style=flat-square
[ico-styleci]: https://github.styleci.io/repos/7548986/shield
[link-packagist]: https://packagist.org/packages/tiagomichaelsousa/laravelresources
[link-downloads]: https://packagist.org/packages/tiagomichaelsousa/laravelresources
[link-travis]: https://travis-ci.org/tiagomichaelsousa/laravelresources
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/tiagomichaelsousa
[link-contributors]: ../../contributors
