# KaiMemo2 Laravel Project Overview

## Purpose
This is a Laravel 12 + Vue 3 + TypeScript application with Inertia.js as the bridge. It appears to be a memo/note-taking application with user authentication and settings management.

## Tech Stack
- **Backend**: Laravel 12 with Fortify for authentication
- **Frontend**: Vue 3 with TypeScript and Inertia.js
- **UI Library**: Reka UI components with Tailwind CSS v4
- **Build Tool**: Vite with Laravel Wayfinder plugin
- **Testing**: Pest for PHP testing
- **Package Manager**: npm for frontend, Composer for backend

## Key Dependencies
- Laravel Framework 12.0
- Laravel Fortify (authentication)
- Laravel Wayfinder (routing)
- Inertia.js for SPA-like experience
- Vue 3 with TypeScript
- Reka UI component library
- Tailwind CSS v4

## Current Structure
- Main codebase is in `src/` directory
- Standard Laravel structure with additional TypeScript/Vue frontend
- Uses FSD (Feature-Sliced Design) architecture in frontend (`src/resources/js-fsd/`)
- Settings functionality implemented with profile, password, and 2FA management