<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;

class Payment extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'treatment_id',
        'tenant_id',
        'amount',
        'payment_method',
    ];

    public function treatment()
    {
        return $this->belongsTo(Treatment::class);
    }
}
