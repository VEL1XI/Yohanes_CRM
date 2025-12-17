<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function leads()
    {
        return $this->hasMany(Lead::class, 'created_by');
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'created_by');
    }

    public function projects()
    {
        return $this->hasMany(Project::class, 'sales_id');
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isManager()
    {
        return $this->role === 'manager';
    }

    public function isSales()
    {
        return $this->role === 'sales';
    }
}