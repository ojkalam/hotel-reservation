# Laravel Hotel Reservation API

This is a robust REST API built with **Laravel** for a Hotel Reservation Mobile App, designed to provide a comprehensive backend solution for managing hotel bookings, rooms, amenities, and user interactions. It leverages **MySQL** (or PostgreSQL) as its primary database.

## Key Features & Technologies

This project utilizes the following key technologies and packages:

-   **Laravel Framework**: The foundation for the API, providing a robust and scalable architecture.
-   **Laravel Sanctum**: For API token authentication, ensuring secure access to your endpoints.
-   **Tymon/JWT-Auth**: Implements JSON Web Token authentication for flexible and stateless API security.
-   **Laravel Telescope**: A powerful assistant for debugging and monitoring your Laravel application.
-   **Laravel Debugbar**: Integrates a developer toolbar to display debug information on any page.
-   **Laravel IDE Helper**: Enhances IDE autocompletion for Laravel facades and models, improving development experience.
-   **Pest PHP**: A delightful PHP testing framework for writing elegant tests.

## Prerequisites

-   PHP 8.2+ (as required by `composer.json`)
-   Composer
-   MySQL or PostgreSQL database

## Installation & Setup

1.  **Clone the repository:**

    ```bash
    git clone <your-repository-url>
    cd hotel-reservation-api
    ```

2.  **Install Composer dependencies:**

    ```bash
    composer install
    ```

3.  **Create a `.env` file:**

    Copy the `.env.example` file and configure your database connection and other environment variables.

    ```bash
    cp .env.example .env
    ```

4.  **Generate Application Key:**

    ```bash
    php artisan key:generate
    ```

5.  **Configure Database:**

    Update your `.env` file with your database credentials:

    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_user
    DB_PASSWORD=your_database_password
    ```

6.  **Run Database Migrations:**

    This will create all necessary tables in your database.

    ```bash
    php artisan migrate
    ```

7.  **Seed Database (Optional):**

    Populate the database with sample data for development and testing.

    ```bash
    php artisan db:seed
    ```

8.  **Generate IDE Helper Files (Recommended for Development):**

    For enhanced IDE autocompletion and code navigation:

    ```bash
    php artisan ide-helper:generate
    php artisan ide-helper:models -RW
    ```

## Running the Application

Start the Laravel development server:

```bash
php artisan serve
```

The API will typically be available at `http://localhost:8000`.

## Testing

Run the tests using Pest PHP:

```bash
php artisan test
```