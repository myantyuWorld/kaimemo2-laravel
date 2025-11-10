# Clean Architecture Implementation

This Laravel application has been restructured following clean architecture principles based on [this article](https://zenn.dev/kihirakota/articles/dev-policy-based-on-imitation-clean-architecture).

## Architecture Overview

The implementation uses a "lightweight clean architecture" with clear separation of concerns across different layers:

### Layer Structure

1. **Controllers** (`app/Http/Controllers/`) - HTTP request handling only
2. **Sea-level Use Cases** (`app/Http/UseCases/`) - API-specific logic and orchestration
3. **Underwater-level Use Cases** (`app/UseCases/`) - Core domain logic
4. **Resources** (`app/Http/Resources/`) - API response formatting
5. **Requests** (`app/Http/Requests/`) - Input validation
6. **Models** (`app/Models/`) - Data persistence

### Key Principles Applied

- **Single Responsibility**: Each class has one clear purpose
- **Dependency Injection**: Use cases are injected into controllers
- **Layer Separation**: Business logic separated from HTTP concerns
- **Testability**: Easy to unit test individual use cases

## Example Implementation: Profile Management

### Current Structure:
```
ProfileController (HTTP layer)
├── UpdateProfileUseCase (Sea-level - API orchestration)
│   └── UpdateUserProfileUseCase (Underwater - Core domain logic)
└── DeleteProfileUseCase (Sea-level - API orchestration)
    └── DeleteUserUseCase (Underwater - Core domain logic)
```

### Files Created:
- `app/UseCases/User/UpdateUserProfileUseCase.php` - Core user update logic
- `app/UseCases/User/DeleteUserUseCase.php` - Core user deletion logic
- `app/Http/UseCases/Settings/UpdateProfileUseCase.php` - API-specific profile update
- `app/Http/UseCases/Settings/DeleteProfileUseCase.php` - API-specific profile deletion
- `app/Http/Resources/Settings/ProfileResource.php` - API response formatting

### Benefits

1. **Maintainability**: Clear separation makes code easier to understand and modify
2. **Reusability**: Core use cases can be reused across different API endpoints
3. **Testability**: Each layer can be tested independently
4. **Scalability**: Easy to add new features following established patterns

### Usage Patterns

#### Controller Pattern:
```php
class ProfileController extends Controller
{
    public function __construct(
        private UpdateProfileUseCase $updateProfileUseCase,
        private DeleteProfileUseCase $deleteProfileUseCase
    ) {}

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        return $this->updateProfileUseCase->execute($request);
    }
}
```

#### Sea-level Use Case Pattern:
```php
class UpdateProfileUseCase
{
    public function __construct(
        private UpdateUserProfileUseCase $updateUserProfileUseCase
    ) {}

    public function execute(ProfileUpdateRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $user = $request->user();
        
        $this->updateUserProfileUseCase->execute($user, $validatedData);
        
        return to_route('profile.edit');
    }
}
```

#### Underwater Use Case Pattern:
```php
class UpdateUserProfileUseCase
{
    public function execute(User $user, array $data): User
    {
        $user->fill($data);
        
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
        
        $user->save();
        
        return $user;
    }
}
```

## Next Steps

1. Apply this pattern to other controllers (Password, TwoFactorAuthentication)
2. Create API resource classes for consistent response formatting
3. Add interfaces for use cases to improve testability
4. Implement shared use cases for common operations