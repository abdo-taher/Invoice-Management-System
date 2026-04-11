# Invoice Management System

A Laravel-based Invoice Management System for handling clients, invoices, payments, taxes, units, expenses, users, and roles.

## Features

- Client management
- Invoice creation and tracking
- Invoice payment registration
- Invoice print and download support
- Taxes and measurement units setup
- Expense tracking
- Role and permission management (Spatie)

## Tech Stack

- PHP 8.2+
- Laravel 11
- MySQL or SQLite
- Vite

## Installation

1. Clone the project:

```bash
git clone <your-repository-url>
cd rafiq-main
```

2. Install dependencies:

```bash
composer install
npm install
```

3. Configure environment:

```bash
cp .env.example .env
php artisan key:generate
```

4. Configure your database in `.env`, then run:

```bash
php artisan migrate --seed
```

5. Build assets:

```bash
npm run build
```

6. Start the application:

```bash
php artisan serve
```

## Development

Run the frontend dev server:

```bash
npm run dev
```

## Main Modules

- Dashboard
- Clients
- Invoices
- Expenses
- Units
- Taxes
- Users and Roles

## License

This project is open-sourced under the MIT license.
