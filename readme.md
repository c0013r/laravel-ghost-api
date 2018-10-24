# laravel-ghost-api

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]

This is where your description should go. Take a look at [contributing.md](contributing.md) to see a to do list.

## Installation

Via Composer

``` bash
$ composer require c0013r/laravel-ghost-api
```

Publish config file

``` bash
$ php artisan vendor:publish --provider="c0013r\GhostAPI\ServiceProvider"
```

## Usage

``` php
use c0013r\GhostAPI\Facades\Ghost;

// get all posts
$posts = Ghost::posts()->get();

// get latest 15 (default limit) posts
$posts = Ghost::posts()->limit()->get();

// get posts with authors & tags
$posts = Ghost::posts()
            ->includeAuthors()
            ->includeTags()
            ->limit()->get();

// get tags
$tags = Ghost::tags()->get();

// get users
$tags = Ghost::users()->get();
```

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email andrew@7glyphs.com instead of using the issue tracker.

## Credits

- [Andrey Novikov][link-author]

## License

MIT. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/c0013r/laravel-ghost-api.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/c0013r/laravel-ghost-api.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/c0013r/laravel-ghost-api
[link-downloads]: https://packagist.org/packages/c0013r/laravel-ghost-api
[link-author]: https://github.com/c0013r