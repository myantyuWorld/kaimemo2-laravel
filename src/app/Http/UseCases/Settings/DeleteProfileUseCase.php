<?php

namespace App\Http\UseCases\Settings;

use App\UseCases\User\DeleteUserUseCase;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DeleteProfileUseCase
{
    public function __construct(
        private DeleteUserUseCase $deleteUserUseCase
    ) {}

    public function execute(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        $this->deleteUserUseCase->execute($user);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
