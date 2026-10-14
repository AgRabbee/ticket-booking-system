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

5. Run the database migrations and seed the demo company, bus, districts and accounts:

   ```bash
   php artisan migrate --seed
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

## Demo Data

Trips are dated, so a deployment runs out of bookable trips over time. When no upcoming trip has a free seat, the home page shows a **Generate demo trips** button that adds five trips with empty seats over the coming week, each run by a randomly named demo operator. The same can be done from the command line (for example from a daily cron job):

```bash
php artisan demo:trips
```

Demo accounts (password `123456`), offered on the sign-in page:

| Role | Email |
| --- | --- |
| System admin (demo) | `demo.admin@tbs.com` |
| Company admin | `demo.company@tbs.com` |
| Customer | `demo.traveller@tbs.com` |

These accounts are listed in `config/demo.php`. The `demo` middleware stops them deleting transport types, pausing or denying users and companies, and changing their passwords; they get a pop-up explaining why. The real system admin (`admin@tbs.com`) is not published and has no restrictions.

To reset a database to a clean, complete demo data set (every role, three active companies and one pending, buses, drivers, past sales and upcoming trips):

```bash
php artisan db:seed --class=DemoDataSeeder
```

This empties every table except `districts` and `transports`, deletes every user except the main system admin `admin@tbs.com` (whose row is left untouched), and then refills everything with new data. `php artisan migrate --seed` on a new database produces the same data set.

Stripe runs in test mode: pay with card `4242 4242 4242 4242`, any future expiry date and any CVC.

## Project Background

This project was originally built as a BSc final year project.

## Licence

This project is open-source and available under the MIT Licence.
