# COVID Vaccine Registration System

This is a COVID vaccine registration system developed using Laravel. The application allows users to register for vaccinations, select vaccine centers, and check their registration status. 

## Table of Contents

- [Features](#features)
- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Running the Application](#running-the-application)
- [Usage](#usage)
- [Database Seeders](#database-seeders)
- [Notes on Optimization](#notes-on-optimization)
- [Future Enhancements](#future-enhancements)
- [Testing](#testing)
- [License](#license)

## Features

- **User Registration**: Users can register for vaccination at a selected vaccine center.
- **Vaccine Center Selection**: Users must choose a vaccine center with a daily limit.
- **First Come First Serve Scheduling**: Users are scheduled based on registration time.
- **Email Notifications**: Users receive an email notification the night before their scheduled vaccination date.
- **Search Status**: Users can check their registration status using their NID.


## Prerequisites

Make sure you have the following installed on your machine:

- PHP >= 8.2
- Composer
- Laravel >= 11.x
- MySQL or Sqlite

## Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/absiddik96/vaccination.git
   ```

2. Navigate to the project directory:

   ```bash
   cd vaccination
   ```

3. Install the dependencies:

   ```bash
   composer install
   ```

4. Copy the `.env.example` file to `.env` and configure your database settings:

   ```bash
   cp .env.example .env
   ```

5. Generate the application key:

   ```bash
   php artisan key:generate
   ```

6. Configure your database settings in the `.env` file:

   ```
   DB_CONNECTION=mysql
   DB_HOST=your_database_host
   DB_PORT=your_database_port
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_user
   DB_PASSWORD=your_database_password
   ```
7. Configure your mail settings in the `.env` file:

   ```
   MAIL_MAILER=smtp
   MAIL_HOST=your_mail_host
   MAIL_PORT=your_mail_port
   MAIL_USERNAME=your_mail_username
   MAIL_PASSWORD=your_mail_password
   MAIL_ENCRYPTION=your_mail_encryption
   ```

8. Run the migrations to create the necessary tables:

   ```bash
   php artisan migrate
   ```

9. Seed the database with vaccine centers:

   ```bash
   php artisan db:seed --class=VaccineCenterSeeder
   ```

## Running the Application

To start the local development server, run:

```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser to access the application.

### Running Scheduled Tasks and Queues

To run scheduled tasks and queue workers, you can use the following commands:

1. **Schedule Work**:
   ```bash
   php artisan schedule:work
   ```
   This command will run the scheduled tasks defined in your application.

2. **Queue Work**:
   ```bash
   php artisan queue:work
   ```
   This command will process jobs on the queue.

Make sure to run these commands in separate terminal windows or sessions if you are running them simultaneously.

## Usage

1. **Register for Vaccination**:
   - Navigate to the registration page.
   - Fill in your details and select a vaccine center.
   - Submit the form to register.

2. **Check Registration Status**:
   - Go to the search page.
   - Enter your NID to see your vaccination status.

## Database Seeders

The application includes a seeder (`VaccineCenterSeeder`) that pre-populates the database with 25 vaccine centers. You can modify the seeder located at `database/seeders/VaccineCenterSeeder.php` to change the number of centers or their details.

## Notes on Optimization

For performance optimization, consider the following:

- Use database indexing on frequently queried columns (e.g., NID).
- Implement caching for frequently accessed data, such as vaccine center information.
- Use queue jobs for sending emails to prevent blocking the request cycle.

## Future Enhancements

If an additional requirement for sending SMS notifications is introduced, the following changes would be needed:

- Integrate a third-party SMS service (e.g., Twilio).
- Create a service class to handle SMS notifications.
- Update the notification logic to send both email and SMS.


## Testing

This project uses Pest for testing. To run the test suite, follow these steps:

### Setting up the Testing Environment


1. Copy the `.env.testing.example` file to `.env.testing`:

   ```bash
   cp .env.testing.example .env.testing
   ```
2. Generate the application key:

   ```bash
    php artisan key:generate --env=testing
   ```
   
3. Configure your database settings in the `.env.testing` file:

   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_user
   DB_PASSWORD=your_database_password
   ```

4. Run the migrations to create the necessary tables:

   ```bash
   php artisan migrate --env=testing
   ```

### Running Tests

Run the test suite with Pest by executing the following command:
```bash
php artisan test
```


## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.
