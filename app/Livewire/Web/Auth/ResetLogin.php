<?php

namespace App\Livewire\Web\Auth;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Resetar Senha')]
class ResetLogin extends Component
{
    public bool $status_pass;

    public bool $status_newPass;

    public string $token;

    public string $email;

    public string $password;

    public string $password_confirmation;

    protected $rules = [
        'email' => 'required|email',
        'token' => 'required',
        'password' => 'required',
        'password_confirmation' => ['required', 'same:password'],
    ];

    public function mount()
    {
        $this->token = request()->token;
        $this->email = request()->email;
        $this->validateToken();
    }

    public function validateToken()
    {
        $user = User::where('email', $this->email)->first();

        if (!$user || !Password::tokenExists($user, $this->token)) {
            return $this->status_pass = false;
        }

        return $this->status_pass = true;
    }

    public function render()
    {
        if ($this->status_pass) {
            return view('livewire.web.auth.reset-password', ['emailReset' => $this->email, 'tokenReset' => $this->token]);
        }

        return abort(404);
    }

    public function saveNewPassword()
    {
        $request = ['email' => $this->email, 'password' => $this->password, 'password_confirmation' => $this->password_confirmation, 'token' => $this->token];
        $resetar = Password::reset(
            $request,
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request['password']),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );
        if ($resetar == 'passwords.reset') {
            return $this->status_newPass = true;
        }

        return $this->status_newPass = false;
    }

    public function save()
    {
        $this->validate();
        $this->saveNewPassword();
        if ($this->status_newPass) {
            return $this->js("modal('Sucesso!', 'Senha atualizada', 'success')");
        }

        return $this->js("modal('Erro', 'Link expirado ou já utilizado', 'warning')");
    }
}
