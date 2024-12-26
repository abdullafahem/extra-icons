# Extra Icons for Filament

<a href="https://packagist.org/packages/blade-ui-kit/blade-icons">
    <img src="https://img.shields.io/packagist/v/fahemdev/extra-icons" alt="Latest Stable Version">
</a>
<a href="https://packagist.org/packages/blade-ui-kit/blade-icons">
    <img src="https://img.shields.io/packagist/dt/fahemdev/extra-icons" alt="Total Downloads">
</a>

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

## Publishing Icon Resources

Publish the icon resources (optional):

```bash
php artisan extra-icons:publish
```

This will create icon folders in the resources folder `extra-icons/resources/icon-package-name` file where you can find icons.

## Usage in Filament

In your Filament resources, forms, or actions, you can now use icons from various libraries:

```php
// Bootstrap Icons (prefix: 'bootstrap')
->icon('bootstrap-star')
->icon('bootstrap-activity')

// Feather Icons (prefix: 'feather')
->icon('feather-star')
->icon('feather-activity')

// Ionicons (prefix: 'ion')
->icon('ion-star')
->icon('ion-activity')

// Tabler Icons (prefix: 'tabler')
->icon('tabler-star')
->icon('tabler-users')

// Octicons (prefix: 'octicon')
->icon('octicon-star')
->icon('octicon-person')

// Font Awesome Brands (prefix: 'fab')
->icon('fab-github')
->icon('fab-twitter')

// Font Awesome Regular (prefix: 'far')
->icon('far-star')
->icon('far-user')

// Font Awesome Solid (prefix: 'fas')
->icon('fas-star')
->icon('fas-user')

// Ant Design Icons (prefix: 'ant')
->icon('ant-star')
->icon('ant-user')

// Huge Icons (prefix: 'huge')
->icon('huge-star')
->icon('huge-user')
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

We welcome contributions to the Extra Icons package! Here's how you can help:

1. **Fork the Repository**

   - Click the "Fork" button at the top right of the repository page
   - Clone your forked repository to your local machine:
     ```bash
     git clone https://github.com/your-username/extra-icons.git
     cd extra-icons
     ```

2. **Create a Branch**

   ```bash
   git checkout -b feature/your-feature-name
   ```

3. **Make Your Changes**

   - Implement your feature or bug fix
   - Ensure your code follows the project's coding standards
   - Add tests if applicable

4. **Commit and Push**

   ```bash
   git add .
   git commit -m "Description of your changes"
   git push origin feature/your-feature-name
   ```

5. **Create a Pull Request**
   - Open a pull request from your fork to the main repository
   - **Important:** Please notify the maintainer (FahemDev) about your contribution
   - Provide a clear description of your changes and their purpose

## License

This package is open-sourced software licensed under the MIT license.

## Support

If you encounter any issues or have questions, please open an issue on GitHub.

## About the Author

Created by [FahemDev](https://fahemdev.com)
