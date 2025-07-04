# Laravel Hotel Reservation API Setup Guide

This is a REST API built using Laravel for Hotel Reservation Mobile App.

## Prerequisites

-   PHP 8.1+
-   Composer
-   MySQL/PostgreSQL

## Installation & Setup

### 1. Database Migration

Run the database migrations to create all necessary tables:

```bash
php artisan migrate
```

### 2. Seed Database

Populate the database with sample data:

```bash
php artisan db:seed
```

### 3. Generate IDE Helper for Facades

Generate autocompletion for Laravel Facades. This creates `_ide_helper.php` file:

```bash
php artisan ide-helper:generate
```

### 4. Generate Model PHPDocs

Add PHPDocs to your models for better IDE support. The `-RW` flags will Reset existing PHPDocs and Write directly to the models:

```bash
php artisan ide-helper:models -RW
```

## What These Commands Do

-   **migrate**: Creates database tables based on migration files
-   **db:seed**: Populates tables with sample/default data
-   **ide-helper:generate**: Creates IDE helper file for Laravel facades autocompletion
-   **ide-helper:models -RW**: Adds PHPDoc comments to Eloquent models for better IDE support

## Next Steps

After running these commands, your Laravel Hotel Reservation API will be ready with:

-   ✅ Database schema created
-   ✅ Sample data loaded
-   ✅ IDE autocompletion configured
-   ✅ Model documentation generated

You can now start the development server:

```bash
php artisan serve
```

The API will be available at `http://localhost:8000`
