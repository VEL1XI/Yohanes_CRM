<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $primaryKey = 'service_id';
    
    protected $fillable = [
        'service_name',
        'speed',
        'price',
        'description',
        'status'
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    // Relationships
    public function projectDetails()
    {
        return $this->hasMany(ProjectDetail::class, 'service_id', 'service_id');
    }

    public function customerServices()
    {
        return $this->hasMany(CustomerService::class, 'service_id', 'service_id');
    }

    // Helper method
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }
}