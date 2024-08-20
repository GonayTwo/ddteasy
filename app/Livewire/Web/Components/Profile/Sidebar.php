<?php

namespace App\Livewire\Web\Components\Profile;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Sidebar extends Component
{
    public string $route;

    public function mount(string $route)
    {
        $this->route = $route;
    }

    public function render()
    {
        return view('livewire.web.components.profile.sidebar');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('site.auth.login');
    }
}
