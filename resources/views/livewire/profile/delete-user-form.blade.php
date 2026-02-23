<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component
{
    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}; ?>

<section class="space-y-6">
    <header>
        <h2 class="text-2xl font-bold text-red-600 mb-1">
            {{ __('Danger Zone') }}
        </h2>

        <p class="text-slate-500 font-medium">
            {{ __('Permanently delete your account and all associated data. This action cannot be undone.') }}
        </p>
    </header>

    <x-danger-button
        onclick="window.openModal('confirm-user-deletion')"
    >{{ __('Delete Account') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit="deleteUser" class="p-10">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-slate-900 mb-2">
                    {{ __('Final Confirmation') }}
                </h2>

                <p class="text-slate-600">
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                </p>
            </div>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    wire:model="password"
                    id="password"
                    name="password"
                    type="password"
                    class="block w-full"
                    placeholder="{{ __('Confirm with your password') }}"
                    required
                />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mt-10 flex justify-end gap-3">
                <x-secondary-button onclick="window.closeModal('confirm-user-deletion')">
                    {{ __('Keep My Account') }}
                </x-secondary-button>

                <x-danger-button>
                    {{ __('Yes, Delete Everything') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
