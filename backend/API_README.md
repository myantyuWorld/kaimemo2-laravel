# Backend API Documentation

This is a pure Laravel API project with sample endpoints and comprehensive tests.

## Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
```

## Development

```bash
composer run dev  # Start development server on port 8000
```

## Testing

```bash
composer run test  # Run all tests
php artisan test   # Alternative test command
```

## Available Endpoints

### Health Check
- `GET /up` - Laravel health check
- `GET /api/health` - Custom health check with JSON response

### Users API (`/api/v1/users`)
- `GET /api/v1/users` - List all users with pagination
  - Query parameters: `search`, `per_page`, `page`
- `POST /api/v1/users` - Create new user
  - Required: `name`, `email`, `password`
- `GET /api/v1/users/{id}` - Get specific user
- `PATCH /api/v1/users/{id}` - Update user
  - Optional: `name`, `email`, `password`
- `DELETE /api/v1/users/{id}` - Delete user

### Posts API (`/api/v1/posts`)
- `GET /api/v1/posts` - List all posts with pagination
  - Query parameters: `search`, `status`, `per_page`, `page`
- `POST /api/v1/posts` - Create new post
  - Required: `title`, `content`, `user_id`
  - Optional: `status` (draft, published, archived)
- `GET /api/v1/posts/{id}` - Get specific post
- `PATCH /api/v1/posts/{id}` - Update post
  - Optional: `title`, `content`, `status`
- `DELETE /api/v1/posts/{id}` - Delete post

### Search
- `GET /api/v1/search` - Universal search endpoint
  - Query parameters: `q`, `page`, `per_page`

## Models

### User
- Fields: `id`, `name`, `email`, `password`, `created_at`, `updated_at`
- Relationships: `hasMany(Post)`

### Post  
- Fields: `id`, `title`, `content`, `status`, `user_id`, `created_at`, `updated_at`
- Relationships: `belongsTo(User)`
- Status values: `draft`, `published`, `archived`

## Authentication

The project is configured with Laravel Sanctum for API authentication, though the sample endpoints don't require authentication for demonstration purposes.

## Testing

Comprehensive test coverage includes:
- Unit tests for basic functionality
- Feature tests for all API endpoints
- Validation testing
- Search and filtering functionality
- Health check endpoints

All tests use in-memory SQLite database for fast execution.