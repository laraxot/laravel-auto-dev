# Laravel Auto Dev

## Description

This Laravel package, `laraxot/laravel-auto-dev`, provides an Artisan command `make:code`, which automates code generation for specific development tasks. It interacts with external APIs to fetch the necessary data and supports options for making tests and Filament resources.

### Install the Server

Before installing the Laravel package, set up the necessary server which hosts the endpoint for code generation. The server can be found and installed from the following repository:

[laravel-auto-dev-server](https://github.com/laraxot/laravel-auto-dev-server)

After setting up the server, proceed with the installation of the Laravel package.

## Package Installation

Install the package using Composer:

```bash
composer require laraxot/laravel-auto-dev
```

After installation, you can publish and configure the necessary files:

```bash
php artisan vendor:publish --provider="Laraxot\AutoDev\AutoDevServiceProvider"
```

## Optional Configurations

Set the required variables in your .env file:

```plaintext
API_URL=http://localhost:3000/generate
API_BASE_DIR=/specify/root/folder
```

Update the configuration file config/make_code.php with:

```php
return [
    'url' => env('MAKE_CODE_URL'),
];
```

### Usage

To execute the make:code command, use:

```bash
php artisan make:code "Write the task here" [--test] [--filament]
```

### Options

    --test: Runs the command in test mode (optional).
    --filament: Uses the Filament library (optional).

### Testing

Run the integrated tests with:

```bash
php artisan test
```

### Contributing

Contributions to the project are welcome! Submit a pull request with your changes or open an issue to discuss modifications or additions.

### License

This project is released under the GPL3.0 License.