<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $primaryKey = 'lead_id';
    
    protected $fillable = [
        'company_name',
        'pic',
        'email',
        'address',
        'company_name_alias',
        'status',
        'created_by'
    ];

    // Relationships
    
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function projects()
    {
        return $this->hasMany(Project::class, 'lead_id', 'lead_id');
    }

    public function customer()
    {
        return $this->hasOne(Customer::class, 'lead_id', 'lead_id');
    }
}    
