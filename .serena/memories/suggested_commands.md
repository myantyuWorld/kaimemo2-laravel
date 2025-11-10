# Development Commands for KaiMemo2 Laravel

## Setup
```bash
cd src
composer run setup  # Full project setup (install dependencies, generate key, migrate, build)
```

## Development Server
```bash
cd src
composer run dev     # Start all development services (server, queue, logs, vite)
composer run dev:ssr # Development with SSR support
```

## Building
```bash
cd src
npm run build        # Production build
npm run build:ssr    # Production build with SSR
```

## Code Quality
```bash
cd src
npm run lint         # ESLint with auto-fix
npm run format       # Prettier formatting
npm run format:check # Check formatting
./vendor/bin/pint    # Laravel Pint (PHP formatting)
```

## Testing
```bash
cd src
composer run test    # Run all PHP tests
php artisan test     # Alternative test command
```

## Individual Development Services
```bash
cd src
php artisan serve          # Development server
php artisan queue:listen   # Queue worker
php artisan pail           # Real-time logs
npm run dev               # Vite development server
```

## System Commands (Darwin)
- `git` - Version control
- `ls` - List files
- `cd` - Change directory
- `grep` - Search text
- `find` - Find files