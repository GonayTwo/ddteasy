<?php

namespace App\Livewire\Forms\Web\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Rule;
use Livewire\Form;

class ForgotPasswordForm extends Form
{
    #[Rule(['required', 'email', 'max:255'])]
    public ?string $email;

    public function store()
    {
        $user = User::where('email', $this->email)->first();

        if ($user) {
            Password::sendResetLink(['email' => $user->email]);
        }

        $this->reset();
    }
}
