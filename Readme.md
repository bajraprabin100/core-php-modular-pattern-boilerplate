# Core PHP Modular Pattern Boilerplate

This boilerplate provides a modular pattern structure for building PHP applications.

## Folder Structure

- **core/**: Contains core PHP classes such as HttpRequest, Router, GoogleClient, Model, and Helpers.
- **modules/**: Contains modules for different features, including controllers, views, validations, and models.
  - **event/**: Example module for event-related functionalities.
    - **controllers/**: Controllers for handling event-related actions.
    - **views/**: Views for displaying event-related content.
    - **validation/**: Validation classes for event-related data.
    - **models/**: Models for interacting with event-related data.
- **public/**: Contains publicly accessible files such as index.php, migrate.php, and oauth2callback.php.
- **vendor/**: Contains Composer dependencies.
- **README.md**: This file providing an overview of the project.
- **composer.json**: Configuration file for Composer.

## Installing Dependencies

1. Install the Google API Client Library for PHP using Composer:
composer install

## Usage

1. Navigate to the `public` directory: `cd myapp/public`.
2. Run `php migrate.php migrate` to perform database migrations.
3. Start the PHP built-in server: `php -S localhost:8000`.
4. Access the application in your web browser.

## Setting Up Google Calendar Integration

1. Go to the Google Cloud Console.
2. Create a new project.
3. Enable the Google Calendar API for your project.
4. Create OAuth 2.0 credentials and download the credentials.json file.
5. Add the credentials.json file to the `config` folder in your project.



## Running Migrations

To run database migrations, use the `migrate.php` script:

php migrate.php migrate

To rollback migrations:

php migrate.php rollback


## License

This project is licensed under the [MIT License](https://opensource.org/licenses/MIT) - see the [LICENSE](LICENSE) file for details.

