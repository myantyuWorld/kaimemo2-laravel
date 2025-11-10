<?php

namespace App\Http\UseCases\Settings;

use App\Http\Requests\Settings\ProfileUpdateRequest;
use App\UseCases\User\UpdateUserProfileUseCase;
use Illuminate\Http\RedirectResponse;

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
