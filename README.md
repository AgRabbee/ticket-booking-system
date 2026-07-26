# Ticket Booking System

A bus ticket booking web application built with Laravel. It allows customers to search bus trips, select seats, and pay online, while company administrators and system administrators manage trips, transports, drivers, and sales reports through separate dashboards.

## Key Features

- Search bus trips by route and travel date
- View seat availability and select seats for a trip
- Complete payment for a booking via Stripe
- Receive a booking confirmation email after payment
- Print a ticket or invoice after a successful booking
- Submit a contact/enquiry message to the admin
- Request registration of a new transport company
- Role-based access for three user types: customer, company admin, and system admin
- Company admin: manage trips (create, update fares), manage transports, manage drivers, view company sales and monthly sales reports
- System admin: manage users (view, update status), manage companies, manage transports system-wide, view system-wide sales reports
- Update profile information and change password (all authenticated users)

## Tech Stack

- **Backend**: Laravel 10 (PHP ^8.1)
- **Database**: MySQL
- **Payments**: Stripe (`stripe/stripe-php`)
- **Auth/API**: Laravel Sanctum
- **HTTP client**: Guzzle
- **Alerts**: SweetAlert for Laravel (`realrashid/sweet-alert`)
- **Admin panel UI**: AdminLTE 3 (loaded via CDN, not a package dependency)
- **Frontend build tooling**: Vite 5, `laravel-vite-plugin`, Axios
- **Testing**: PHPUnit 10, Faker, Mockery
- **Code style**: Laravel Pint
- **Local development**: Laravel Sail, Docker (custom `Dockerfile` and `docker-compose.yml` with app, nginx, and MySQL services)

## Screenshots

<!-- Add screenshots here, for example:
![Home page](docs/screenshots/home.png)
![Seat selection](docs/screenshots/seat-selection.png)
![Admin dashboard](docs/screenshots/admin-dashboard.png)
-->

## Installation and Setup

### Requirements

- PHP 8.1 or higher
- Composer
- MySQL
- Node.js and npm (for building frontend assets)

### Steps

1. Clone the repository:

   ```bash
   git clone https://github.com/AgRabbee/ticket-booking-system.git
   cd ticket-booking-system
   ```

2. Install PHP dependencies:

   ```bash
   composer install
   ```

3. Copy the environment file and generate an application key:

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Set the database connection details and Stripe keys in `.env`.

5. Run the database migrations:

   ```bash
   php artisan migrate
   ```

6. Install frontend dependencies and build assets:

   ```bash
   npm install
   npm run build
   ```

7. Start the local development server:

   ```bash
   php artisan serve
   ```

   The application will be available at `http://localhost:8000`.

### Running with Docker (alternative)

```bash
docker compose up -d --build
```

The application will be available at `http://localhost:8080`.

## Project Background

This project was originally built as a BSc final year project.

## Licence

This project is open-source and available under the MIT Licence.
