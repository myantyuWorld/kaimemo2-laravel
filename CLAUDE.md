# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Structure

This is a monorepo with a Laravel 12 backend and Vue 3 + TypeScript frontend using separate directories. The project implements a household expense management application (家計簿アプリ) using **FSD (Feature-Sliced Design)** architecture for the frontend and **Clean Architecture pattern** for the backend.

### Key Architecture Components

- **Backend**: Laravel 12 with Clean Architecture pattern, MySQL database
- **Frontend**: Vue 3 with TypeScript using **FSD (Feature-Sliced Design)** architecture
- **Authentication**: Laravel Sanctum for API authentication with LINE integration support
- **Database**: MySQL 8.0 with comprehensive household expense management schema
- **Architecture**: Clean Architecture with UseCases pattern for business logic separation
- **Testing**: PHPUnit for backend, Vitest for frontend
- **Code Quality**: Laravel Pint (PHP), ESLint + Prettier (JS/TS)
- **Development Tools**: mise for task management, lefthook for git hooks

### Directory Structure

#### Backend (Laravel with Clean Architecture)
- `backend/app/` - Laravel application code following Clean Architecture
  - `Http/Controllers/` - Thin controllers using dependency injection
  - `UseCases/` - Business logic layer (Post/, User/ domains)
  - `Models/` - Eloquent models for household expense management
    - Master models: MUser, MHouse, MCategory, MBudget, MNotificationSetting
    - Transaction models: TExpense, TExpenseItem, TShoppingList, TNotification, THouseRelation
  - `Repositories/` - Data access layer with CRUD operations
    - `Master/` - Repositories for master data
    - `Transaction/` - Repositories for transaction data
- `backend/tests/` - PHP tests (Unit and Feature directories)
- `backend/config/` - Laravel configuration files
- `backend/database/` - Database schema and data
  - `migrations/` - Database migrations for 9 tables
  - `seeders/` - Master data seeding (users, houses, categories, budgets, notification settings)
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
- `docker-compose.yml` - MySQL 8.0 database container configuration
- `docs/design/kaimemo.sql` - Database design specification

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
docker-compose up -d  # Start MySQL container
mise run migrate      # Run database migrations
mise run fresh        # Fresh migrate with seeding
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

### Backend (Laravel 12 with Clean Architecture)
- **Architecture Pattern**: "なんちゃってクリーンアーキテクチャ" (Half-hearted Clean Architecture)
- **Business Logic**: Organized in UseCases directory with single-responsibility Action classes
- **Data Access**: Repository pattern with CRUD operations for all entities
- **Authentication**: Laravel Sanctum for API authentication with LINE integration support
- **Database**: MySQL 8.0 with comprehensive household expense management schema (9 tables)
- **Models**: Eloquent models with proper relationships (Master: 5 tables, Transaction: 4 tables)
- **Testing Framework**: PHPUnit with Laravel's testing utilities
- **Code Style**: Laravel Pint for PHP formatting

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

### Database and Architecture Specific Notes

- **Database**: MySQL container must be running via `docker-compose up -d` before migration
- **Clean Architecture**: Business logic belongs in UseCases, not Controllers
- **Repository Pattern**: Always use Repository classes for data access, not direct Eloquent calls in UseCases
- **Model Relationships**: Leverage Eloquent relationships defined in models for data fetching
- **Seeding**: Master data is automatically seeded with `mise run fresh` (users, houses, categories, budgets, notification settings)

### Household Expense Management Domain

- **Master Data**: Users, Houses, Categories, Budgets, NotificationSettings
- **Transaction Data**: Expenses, ExpenseItems, ShoppingLists, Notifications, HouseRelations
- **Key Relationships**: 
  - Users belong to Houses via HouseRelation (many-to-many)
  - Categories belong to Houses (one-to-many)
  - Expenses have multiple ExpenseItems with Categories
  - Budgets are set per House and Category with period types (monthly/weekly/daily)