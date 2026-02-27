<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'role',
        'status',
        'banned_at',
        'reputation',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'banned_at' => 'datetime',
        ];
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function colocations()
    {
        return $this->belongsToMany(Colocation::class, 'memberships')
                    ->using(Membership::class)
                    ->withPivot('role', 'joined_at', 'left_at')
                    ->withTimestamps();
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class, 'payer_id');
    }

    public function debts()
    {
        return $this->hasMany(Debt::class, 'debtor_id');
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isBanned()
    {
        return $this->status === 'banned' || $this->banned_at !== null;
    }

    public function isMember()
    {
        return $this->colocations()->wherePivot('role', 'member')->whereNull('memberships.left_at')->exists();
    }

    public function isOwner()
    {
        return $this->colocations()->wherePivot('role', 'owner')->whereNull('memberships.left_at')->exists();
    }

    public function isActiveMemberOrOwner()
    {
        return $this->colocations()
            ->where('colocations.status', 'active')
            ->whereNull('memberships.left_at')
            ->exists();
    }
}
