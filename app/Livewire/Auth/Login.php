<?php

namespace App\Livewire\Auth;

use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.guest')]
class Login extends Component
{
    public $identifier = '';
    public $password = '';
    public $remember = false;
    public $loginMethod = 'email';

    public function mount()
    {
        // Get login method from settings
        $this->loginMethod = Setting::get('login_method', 'email');
    }

    public function login()
    {
        // Dynamic validation based on login method
        $rules = [
            'identifier' => $this->loginMethod === 'email' 
                ? 'required|email' 
                : 'required|string',
            'password' => 'required',
        ];

        $this->validate($rules);

        // Build credentials array based on login method
        $credentials = [
            $this->loginMethod => $this->identifier,
            'password' => $this->password
        ];

        if (Auth::attempt($credentials, $this->remember)) {
            session()->regenerate();

            // Redirect based on user role
            $user = Auth::user();
            $defaultRoute = $user->role->value === 'admin' ? route('dashboard') : route('student.dashboard');

            return $this->redirectIntended(default: $defaultRoute, navigate: true);
        }

        $this->addError('identifier', 'The provided credentials do not match our records.');
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
