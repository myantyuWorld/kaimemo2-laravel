# Code Style and Conventions

## PHP/Laravel Conventions
- PSR-4 autoloading with `App\` namespace
- Laravel Pint for code formatting (based on PSR-12)
- Uses Laravel Fortify for authentication
- Controllers follow standard Laravel conventions
- Request classes for validation (e.g., `ProfileUpdateRequest`)
- Uses Inertia.js for bridging backend/frontend

## Frontend Conventions
- TypeScript with Vue 3 Composition API
- ESLint with Prettier for formatting
- Uses FSD (Feature-Sliced Design) architecture pattern
- Path aliases configured (`@app/*`, `@pages/*`, etc.)
- Reka UI component library with Tailwind CSS
- Components use TypeScript for type safety

## Testing
- Pest framework for PHP testing
- Test organization: `src/tests/Unit/` and `src/tests/Feature/`
- Uses SQLite in-memory database for testing

## File Organization
- Backend code in `src/app/`
- Frontend in `src/resources/js-fsd/` following FSD principles
- Routes separated by feature (e.g., `settings.php`)
- Request validation in dedicated classes