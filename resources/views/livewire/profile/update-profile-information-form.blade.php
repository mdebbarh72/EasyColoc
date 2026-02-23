<?php

use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $pseudo = '';
    public string $bio = '';
    public string $avatar_url = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        
        $profile = $user->profile;
        if ($profile) {
            $this->pseudo = $profile->pseudo ?? '';
            $this->bio = $profile->bio ?? '';
            $this->avatar_url = $profile->avatar_url ?? '';
        }
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'pseudo' => ['nullable', 'string', 'max:50'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'avatar_url' => ['nullable', 'url', 'max:255'],
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
            $user->save();
        }

        // Update or Create profile
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'pseudo' => $validated['pseudo'],
                'bio' => $validated['bio'],
                'avatar_url' => $validated['avatar_url'],
            ]
        );

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section>
    <header class="mb-8">
        <h2 class="text-2xl font-bold text-slate-900 mb-1">
            {{ __('Profile Details') }}
        </h2>

        <p class="text-slate-500 font-medium">
            {{ __("Manage your personal identity and account settings.") }}
        </p>
    </header>

    <form wire:submit="updateProfileInformation" class="space-y-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Full Name')" />
                <x-text-input wire:model="name" id="name" name="name" type="text" class="block w-full" required autofocus autocomplete="name" placeholder="John Doe" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <!-- Pseudo -->
            <div>
                <x-input-label for="pseudo" :value="__('Display Name (Pseudo)')" />
                <x-text-input wire:model="pseudo" id="pseudo" name="pseudo" type="text" class="block w-full" placeholder="CoolRoommate42" />
                <x-input-error class="mt-2" :messages="$errors->get('pseudo')" />
            </div>
        </div>

        <div>
            <x-input-label for="email" :value="__('Email Address')" />
            <x-text-input wire:model="email" id="email" name="email" type="email" class="block w-full" required autocomplete="username" placeholder="john@example.com" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                <div class="mt-4 p-4 bg-yellow-50 rounded-2xl border border-yellow-100">
                    <p class="text-sm text-yellow-800 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        {{ __('Your email address is unverified.') }}

                        <button wire:click.prevent="sendVerification" class="font-bold text-yellow-900 underline hover:no-underline transition-all">
                            {{ __('Resend verification email') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-bold text-xs text-green-600 uppercase tracking-widest">
                            {{ __('Verification link sent!') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Avatar URL -->
        <div>
            <x-input-label for="avatar_url" :value="__('Avatar Image URL')" />
            <x-text-input wire:model="avatar_url" id="avatar_url" name="avatar_url" type="text" class="block w-full" placeholder="https://example.com/avatar.jpg" />
            <p class="mt-2 text-xs text-slate-400">Link to an image file (JPEG, PNG, SVG).</p>
            <x-input-error class="mt-2" :messages="$errors->get('avatar_url')" />
        </div>

        <!-- Bio -->
        <div>
            <x-input-label for="bio" :value="__('About You (Bio)')" />
            <textarea wire:model="bio" id="bio" name="bio" rows="4" class="block w-full bg-slate-50 border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-2xl shadow-sm transition-all py-3 px-4 resize-none" placeholder="Tell your roommates a bit about yourself..."></textarea>
            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
        </div>

        <div class="flex items-center gap-4 pt-4 border-t border-slate-50">
            <x-primary-button>{{ __('Update Profile') }}</x-primary-button>

            <x-action-message class="text-green-600 font-bold text-sm" on="profile-updated">
                {{ __('Saved successfully!') }}
            </x-action-message>
        </div>
    </form>
</section>
