# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Structure

This is a Laravel 12 + Vue 3 + TypeScript application using Inertia.js as the bridge. The main codebase is in the `src/` directory, with the root containing configuration files.

### Key Architecture Components

- **Backend**: Laravel 12 with Fortify for authentication
- **Frontend**: Vue 3 with TypeScript and Inertia.js
- **UI Library**: Reka UI components with Tailwind CSS v4
- **Build Tool**: Vite with Laravel Wayfinder plugin
- **Testing**: Pest for PHP, built-in test structure

### Directory Structure

- `src/app/` - Laravel application code (controllers, models, middleware)
- `src/resources/js/` - Vue.js frontend application
  - `pages/` - Inertia.js pages (Dashboard, Settings, etc.)
  - `components/` - Vue components including UI library components
  - `composables/` - Vue composables (useAppearance, useTwoFactorAuth, etc.)
  - `wayfinder/` - Laravel Wayfinder configuration
- `src/resources/css/` - Stylesheets
- `src/tests/` - PHP tests (Unit and Feature directories)

## Development Commands

### Setup
```bash
cd src
composer run setup  # Full project setup (install dependencies, generate key, migrate, build)
```

### Development Server
```bash
cd src
composer run dev     # Start all development services (server, queue, logs, vite)
composer run dev:ssr # Development with SSR support
```

### Building
```bash
cd src
npm run build        # Production build
npm run build:ssr    # Production build with SSR
```

### Code Quality
```bash
cd src
npm run lint         # ESLint with auto-fix
npm run format       # Prettier formatting
npm run format:check # Check formatting
./vendor/bin/pint    # Laravel Pint (PHP formatting)
```

### Testing
```bash
cd src
composer run test    # Run all PHP tests
php artisan test     # Alternative test command
```

### Individual Development Services
```bash
cd src
php artisan serve          # Development server
php artisan queue:listen   # Queue worker
php artisan pail           # Real-time logs
npm run dev               # Vite development server
```

## Key Features

- **Authentication**: Laravel Fortify with 2FA support
- **UI Components**: Reka UI component library
- **Theme Support**: Light/dark mode with appearance composable
- **Settings Pages**: Profile, Password, Two-Factor, Appearance
- **Real-time Development**: Concurrent server, queue, logs, and asset compilation

## Testing Notes

- Uses Pest as the testing framework
- Test environment configured with SQLite in-memory database
- Feature tests cover settings functionality
- Run tests with `composer run test` from the `src/` directory