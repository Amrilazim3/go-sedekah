# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Go Sedekah is a Laravel-based donation platform that facilitates charitable giving between donors and needy individuals. The application uses role-based access control with three main user types: Admin, Donor, and Needy users.

## Development Commands

### Local Development (Laravel Sail)
- Start development server: `./vendor/bin/sail up` (add `-d` for background)
- Build frontend assets: `./vendor/bin/sail npm run dev` or `./vendor/bin/sail npm watch`
- Run tests: `./vendor/bin/sail test`
- Run PHPUnit tests: `./vendor/bin/sail artisan test`
- Access application: http://localhost
- Preview emails: http://localhost:8025 (Mailhog)

### Frontend Development
- Development server: `npm run dev` or `vite`
- Production build: `npm run build` or `vite build`

### Testing
- PHPUnit: `php artisan test` or `./vendor/bin/sail test`
- Browser tests: Laravel Dusk is configured (`./vendor/bin/sail dusk`)

## Architecture & Core Components

### Tech Stack
- **Backend**: Laravel 9, PHP 8.1+
- **Frontend**: Vue 3 + Inertia.js + Tailwind CSS
- **Authentication**: Laravel Jetstream with Fortify
- **Payment Gateway**: Billplz integration
- **Real-time**: Laravel Echo with Pusher/Soketi
- **Permissions**: Spatie Laravel Permission package

### Key Models & Relationships
- **User**: Has roles (admin/donor/needy), profile photos, banks, donation requests
- **DonationRequest**: Belongs to User and Bank, has many Donations
- **Donation**: Belongs to User and DonationRequest, integrates with Billplz
- **Bank**: Belongs to User, stores banking details for needy users

### Role-Based Architecture
- **Admin**: Manage users, approve/reject donation requests, verify donations
- **Needy**: Create donation requests, manage bank details
- **Donor**: Make donations to approved requests

### Important Business Logic
- Donation requests require admin approval before being visible to donors
- Verified donations have a 7-day expiry period (`verification_expiry_at`)
- Progress tracking calculates percentage based on `currently_received` vs `target_amount`
- Timezone is set to Asia/Kuala_Lumpur for date formatting

### Payment Integration
- Uses Billplz for payment processing
- Bill URLs are dynamically generated based on sandbox/production mode
- Donation status tracking through Billplz webhooks

### Frontend Structure
- Inertia.js for SPA-like experience
- Vue 3 components in `resources/js/Components/`
- Role-specific dashboard and donation components
- Tailwind CSS with HeadlessUI for styling

### Key Directories
- `app/Http/Controllers/`: Role-specific controllers (Admin/, Donor/, Needy/)
- `app/Models/`: Core business models
- `app/Notifications/`: Role-specific notification classes
- `resources/js/`: Vue components and frontend logic
- `database/migrations/`: Database schema definitions
- `tests/Feature/`: Feature tests for all major functionality

### Configuration Notes
- Role permissions managed through Spatie package
- Billplz configuration in `config/services.php`
- Queue jobs for donation verification expiry
- Real-time notifications for donation events