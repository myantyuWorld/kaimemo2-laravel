# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Structure

This is a monorepo with a Laravel 12 backend and Vue 3 + TypeScript frontend using separate directories. The project uses **FSD (Feature-Sliced Design)** architecture for the frontend.

### Key Architecture Components

- **Backend**: Laravel 12 with Sanctum for authentication
- **Frontend**: Vue 3 with TypeScript using **FSD (Feature-Sliced Design)** architecture
- **Testing**: PHPUnit for backend, Vitest for frontend
- **Code Quality**: Laravel Pint (PHP), ESLint + Prettier (JS/TS)
- **Development Tools**: mise for task management, lefthook for git hooks

### Directory Structure

#### Backend (Laravel)
- `backend/app/` - Laravel application code (controllers, models, middleware)
- `backend/tests/` - PHP tests (Unit and Feature directories)
- `backend/config/` - Laravel configuration files
- `backend/database/` - Migrations, seeders, factories
- `backend/routes/` - Route definitions (web.php, api.php)

#### Frontend (FSD Architecture)
- `frontend/src/` - Vue.js frontend application following FSD principles
  - `app/` - Application-wide setup, providers, app entry point
  - `pages/` - Page components
  - `widgets/` - Large composite UI blocks
  - `features/` - Business features (Auth, Settings, User management)
  - `entities/` - Business entities (User, etc.)
  - `shared/` - Shared utilities and components
    - `ui/` - Reusable UI components
    - `lib/` - Utility functions
    - `types/` - TypeScript type definitions

#### Root Configuration
- `mise.toml` - Task definitions and tool management
- `lefthook.yml` - Git hooks configuration for code quality

## Development Commands

### Setup
```bash
mise run setup  # Full project setup (install dependencies, generate key, migrate)
```

### Development Server
```bash
mise run dev     # Start Laravel development server
mise run vite    # Start Vite development server (frontend)
```

### Building
```bash
mise run build       # Production build for frontend
mise run build-ssr   # Production build with SSR support
```

### Code Quality
```bash
mise run lint        # ESLint with auto-fix (frontend)
mise run format      # Prettier formatting (frontend)
mise run format-php  # Laravel Pint (PHP formatting)
```

### Testing
```bash
mise run test        # Run PHP tests (backend)
cd frontend && npm run test:unit  # Run frontend tests
```

### Database Operations
```bash
mise run migrate     # Run database migrations
mise run fresh       # Fresh migrate with seeding
```

### Individual Services
```bash
mise run serve       # Laravel development server only
mise run queue       # Queue worker
mise run logs        # Real-time logs (Laravel Pail)
```

### Direct Commands (alternative to mise)
```bash
# Backend
cd backend
composer run setup   # Setup backend
composer run dev      # Development server  
composer run test     # Run tests
./vendor/bin/pint     # Format PHP code

# Frontend  
cd frontend
npm install           # Install dependencies
npm run dev           # Development server
npm run build         # Production build
npm run test:unit     # Run tests
npm run lint          # Lint and fix
npm run format        # Format code
```

## Architecture Notes

### Monorepo Structure
- **Backend and Frontend Separation**: Backend in `backend/`, frontend in `frontend/`
- **Task Management**: Uses `mise` for unified task running across both parts
- **Code Quality**: Automated formatting and linting with pre-commit hooks via `lefthook`

### Backend (Laravel 12)
- **Authentication**: Laravel Sanctum for API authentication
- **Testing Framework**: PHPUnit with Laravel's testing utilities
- **Code Style**: Laravel Pint for PHP formatting
- **Database**: Configured for SQLite (development) and other databases

### Frontend (Vue 3 + TypeScript)
- **Architecture**: Feature-Sliced Design (FSD) for scalable structure
- **Testing**: Vitest for unit testing
- **Build Tool**: Vite for fast development and building
- **Code Quality**: ESLint + Prettier for consistent code style
- **State Management**: Pinia for Vue state management

### Development Workflow
- **Git Hooks**: Pre-commit hooks run formatting, linting, and tests automatically
- **Tool Management**: `mise` manages Node.js version and provides unified commands
- **Separate Servers**: Backend and frontend run on different ports during development

## Important Development Notes

- Always run commands from the project root using `mise run <task>` for consistency
- Pre-commit hooks will automatically format and lint code before commits
- Backend tests should be run before making changes to API endpoints
- Frontend follows FSD architecture - place new features in appropriate layers