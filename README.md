# Extra Icons for Filament

A comprehensive Filament plugin that adds multiple icon packages to enhance your Laravel Filament applications.

## Features

- Support for multiple popular icon libraries:
  - Bootstrap Icons
  - Feather Icons
  - Ionicons
  - Tabler Icons
  - Octicons
  - Font Awesome (Brands, Regular, Solid)
  - Ant Design Icons
  - Huge Icons
  - (More icon libraries in the future)

- Easy configuration and integration with Filament
- Customizable icon prefixes, fallbacks, and attributes

## Requirements

- PHP 8.1+
- Laravel 10.x or 11.x
- Filament 3.x
- Blade Icons

## Installation

Install the package via Composer:

```bash
composer require fahemdev/extra-icons
```

## Configuration

Publish the configuration file (optional):

```bash
php artisan vendor:publish --tag="extra-icons-config"
```

This will create a `config/extra-icons.php` file where you can customize icon settings.

## Usage in Filament

In your Filament resources, forms, or actions, you can now use icons from various libraries:

```php
// Bootstrap icon
->icon('bootstrap-star')

// Feather icon
->icon('feather-activity')

// Tabler icon
->icon('tabler-users')

// Font Awesome solid icon
->icon('fas-user')
```

## Customization

You can modify the `config/extra-icons.php` file to:
- Change icon prefixes
- Set fallback icons
- Add custom CSS classes
- Define default icon attributes

Example configuration:
```php
'bootstrapicons' => [
    'prefix' => 'bootstrap',
    'fallback' => 'default-icon',
    'class' => 'text-primary',
    'attributes' => [
        'width' => 24,
        'height' => 24,
    ],
],
```

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This package is open-sourced software licensed under the MIT license.

## Support

If you encounter any issues or have questions, please open an issue on GitHub.

## About the Author

Created by [FahemDev](https://fahemdev.com)
