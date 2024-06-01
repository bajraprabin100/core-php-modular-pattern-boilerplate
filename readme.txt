Use php 8.2 version
cd myapp/public
php migrate.php migrate
php -S localhost:8000

php migrate.php rollback

Go to the Google Cloud Console.
Create a new project.
Enable the Google Calendar API for your project.
Create OAuth 2.0 credentials and download the credentials.json file.
Add the credentials.json file in config folder

Install Google API Client Library for PHP:

Use Composer to install the library. If you don’t have Composer, you can download it from getcomposer.org.
Run composer install in your project directory.
