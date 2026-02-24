<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;

class Product extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'unit_type_id',
        'nombre',
        'precio',
        'stock',
    ];

    public function unitType()
    {
        return $this->belongsTo(UnitType::class);
    }
}
