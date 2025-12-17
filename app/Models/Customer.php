<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $primaryKey = 'customer_id';
    
    protected $fillable = [
        'lead_id',
        'name',
        'phone',
        'email',
        'address',
        'status'
    ];

    // Relationships
    public function lead()
    {
        return $this->belongsTo(Lead::class, 'lead_id', 'lead_id');
    }

     public function services()
    {
        return $this->hasMany(CustomerService::class, 'customer_id', 'customer_id');
    }

    public function activeServices()
    {
        return $this->services()->where('status', 'aktif');
    }
}