<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Membership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class InvitationController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'nullable|email',
            'colocation_id' => 'required|exists:colocations,id',
        ]);

        $colocation = \App\Models\Colocation::findOrFail($validated['colocation_id']);
        
        $this->authorize('create', [\App\Models\Invitation::class, $colocation]);

        if ($validated['email']) {
            $user = \App\Models\User::where('email', $validated['email'])->first();
            if ($user && $user->isActiveMemberOrOwner()) {
                return redirect()->back()->with('error', 'This user is already in an active colocation.');
            }
        }

        $invitation = Invitation::create([
            'email' => $validated['email'] ?: null,
            'token' => \Illuminate\Support\Str::random(40),
            'expires_at' => now()->addHour(),
            'colocation_id' => $colocation->id,
            'status' => 'pending',
        ]);

        if ($invitation->email) {
            \Illuminate\Support\Facades\Mail::to($invitation->email)->send(new \App\Mail\InvitationMail($invitation));
        }

        return redirect()->back()->with('success', $invitation->email ? 'Invitation sent!' : 'Public invitation created!');
    }

    public function show($token)
    {
        $invitation = Invitation::where('token', $token)->firstOrFail();

        if (!$invitation->pending() || $invitation->expired()) {
            return view('invitations.show', [
                'invitation' => $invitation,
                'error' => 'This invitation is no longer active or has expired.'
            ]);
        }

        if (Auth::check() && Auth::user()->isActiveMemberOrOwner()) {
            return view('invitations.show', [
                'invitation' => $invitation,
                'error' => "You can't join another colocation while you are in an active colocation."
            ]);
        }

        return view('invitations.show', compact('invitation'));
    }

    public function accept(Request $request, $token)
    {
        $invitation = Invitation::where('token', $token)->firstOrFail();

        if (!Gate::allows('accept', $invitation)) {
            if (Auth::user()->isActiveMemberOrOwner()) {
                return redirect()->back()->with('error', "You can't join another colocation while you are in an active colocation.");
            }
            return redirect()->back()->with('error', 'You are not authorized to accept this invitation.');
        }

        Membership::create([
            'user_id' => Auth::id(),
            'colocation_id' => $invitation->colocation_id,
            'role' => 'member',
            'joined_at' => now(),
        ]);

        $invitation->update([
            'status' => 'accepted',
            'accepted_at' => now(),
        ]);

        return redirect()->route('colocations.show', $invitation->colocation_id)
            ->with('success', 'Welcome to the colocation! You are now a member.');
    }

    public function deny(Request $request, $token)
    {
        $invitation = Invitation::where('token', $token)->firstOrFail();

        if ($invitation->pending()) {
        }

        return redirect()->route('dashboard')->with('status', 'Invitation declined.');
    }
}
