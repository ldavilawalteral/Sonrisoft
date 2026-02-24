<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


use App\Traits\BelongsToTenant;

class Patient extends Model
{
    use HasFactory, SoftDeletes, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'dni',
        'nombres',
        'apellidos',
        'celular',
        'email',
        'direccion',
        'alergias',
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class)->orderBy('scheduled_at', 'desc');
    }
}
