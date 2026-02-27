<?php

namespace App\Livewire;

use App\Models\Colocation;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Support\Str;
use Livewire\Component;

class InviteUser extends Component
{
    public Colocation $colocation;
    public $email = '';
    public $foundUser = null;
    public $isModalOpen = false;

    protected $rules = [
        'email' => 'nullable|email',
    ];

    public function mount(Colocation $colocation)
    {
        $this->colocation = $colocation;
    }

    public function updatedEmail($value)
    {
        if ($value && filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->foundUser = User::where('email', $value)->first();
        } else {
            $this->foundUser = null;
        }
    }

    public function invite()
    {
        $this->authorize('create', Invitation::class);
        $this->validate();

        if ($this->email) {
            $user = User::where('email', $this->email)->first();
            
            if ($user && $user->isActiveMemberOrOwner()) {
                $this->addError('email', 'This user is already in an active colocation and cannot be invited.');
                return;
            }
        }

        $invitation = Invitation::create([
            'email' => $this->email ?: null,
            'token' => Str::random(40),
            'expires_at' => now()->addHour(),
            'colocation_id' => $this->colocation->id,
            'status' => 'pending',
        ]);

        if ($this->email) {
            \Illuminate\Support\Facades\Mail::to($this->email)->send(new \App\Mail\InvitationMail($invitation));
        }

        $this->reset(['email', 'foundUser']);
        $this->dispatch('close-modal', 'inviteModal');
        $this->dispatch('notify', ['message' => $this->email ? 'Invitation sent to ' . $this->email : 'Public invitation generated!', 'type' => 'success']);
    }

    public function render()
    {
        return view('livewire.invite-user');
    }
}
