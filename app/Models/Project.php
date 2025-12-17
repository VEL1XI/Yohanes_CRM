<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $primaryKey = 'project_id';
    
    protected $fillable = [
        'lead_id',
        'sales_id',
        'status',
        'notes',
        'created_by'
    ];

    // Relationships
    public function lead()
    {
        return $this->belongsTo(Lead::class, 'lead_id', 'lead_id');
    }

    public function sales()
    {
        return $this->belongsTo(User::class, 'sales_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function details()
    {
        return $this->hasMany(ProjectDetail::class, 'project_id', 'project_id');
    }

    public function getTotalAmount()
    {
        return $this->details->sum('subtotal');
    }
}