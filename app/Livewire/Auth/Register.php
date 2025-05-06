<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.auth')]

class Register extends Component
{
    public string $first_name = '';
    
    public string $last_name = '';

    public string $username = ''; // Added username

    public string $gender = ''; // Added gender

    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';
    
    public string $role = '';
    
    public string $phone_number = '';
    
    public ?string $matrix_number = null;
    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        try {
            $validated = $this->validate([
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:255', 'unique:users,username'], // Validate unique username
                'gender' => ['required', 'in:male,female,other'], // Validate gender
                'name' => ['nullable', 'string', 'max:255'],
                'email' => ['nullable', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
                'password' => ['required', 'string', 'min:8','max:15','confirmed', Rules\Password::defaults()],
                'role' => ['required', 'in:buyer,seller'],
                'phone_number' => ['required', 'string', 'max:15','unique:'.User::class],
                'matrix_number' => ['nullable', 'string', 'max:255', 'required_if:role,seller'],
            ]);

            $validated['password'] = Hash::make($validated['password']);

            // Create the user
            $user = User::create([
                'name' => $validated['first_name'] . ' ' . $validated['last_name'],
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                
                'username' => $validated['username'], // Save username
                'gender' => $validated['gender'], // Save gender
                
                'email' => $validated['email'],
                'password' => $validated['password'],
                'phone_number' => $validated['phone_number'],
                'matrix_number' => $validated['role'] === 'seller' ? $validated['matrix_number'] : null,
            ]);

            // Assign the selected role to the user
            $user->assignRole($validated['role']);

            event(new Registered($user));

            Auth::login($user);

            // Redirect based on the role
            if ($validated['role'] === 'seller') {
                $this->redirect(route('seller.dashboard', absolute: false), navigate: true);
            } else {
                $this->redirect(route('buyer.dashboard', absolute: false), navigate: true);
            }
        } catch (\Exception $e) {
            // Log the error
            \Log::error($e->getMessage());

            // Display the error message
            session()->flash('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}

