<?php

namespace App\Livewire\Settings;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Profile extends Component
{
    use WithFileUploads;

    public string $name = '';

    public string $email = '';

    public $first_name;

    public $last_name;

    public $avatar;

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->first_name = auth()->user()->first_name;
        $this->last_name = auth()->user()->last_name;
        $this->email = auth()->user()->email;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        try {
            $validated = $this->validate([
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'email' => [
                    'required',
                    'string',
                    'lowercase',
                    'email',
                    'max:255',
                    Rule::unique(User::class)->ignore(auth()->id()),
                ],
                'avatar' => ['nullable', 'image', 'max:5120'],
            ]);

            $user = auth()->user();

            // Handle avatar upload
            if ($this->avatar) {
                // Delete old avatar if exists
                if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                }

                // Generate a filename using the username and preserve the file extension
                $extension = $this->avatar->getClientOriginalExtension();
                $filename = $user->username . '.' . $extension;

                // Store the avatar with the custom filename
                $path = $this->avatar->storeAs('avatars', $filename, 'public');

                // Save the path in the validated data
                $validated['avatar'] = $path;
            }

            // Update user with validated data
            $user->fill([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'name' => $validated['first_name'] . ' ' . $validated['last_name'],
                'email' => $validated['email'],
            ]);

            if (isset($validated['avatar'])) {
                $user->avatar = $validated['avatar'];
            }

            $user->save();

            $this->dispatch('profile-updated', name: $user->name);
        } catch (\Exception $e) {
            $this->addError('save', 'Failed to update profile: ' . $e->getMessage());
        }
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }

    public function render()
    {
        return view('livewire.settings.profile');
    }
}
