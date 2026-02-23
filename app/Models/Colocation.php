<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Colocation extends Model
{
    /** @use HasFactory<\Database\Factories\ColocationFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'description', 'status'];

    public function owner()
    {
        return $this->users()->wherePivot('role', 'owner')->whereNull('memberships.left_at');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'memberships')
                    ->using(Membership::class)
                    ->withPivot('role', 'joined_at', 'left_at')
                    ->withTimestamps();
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function isActive()
    {
        return $this->status === 'active';
    }

    public function isCancelled()
    {
        return $this->status === 'canceled';
    }
}
