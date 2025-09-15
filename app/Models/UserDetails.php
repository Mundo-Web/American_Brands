<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
    use HasFactory;
    protected $fillable=[
    'email',
    'nombre',
    'apellidos',
    'phone',
    'departamento_id',
    'provincia_id',
    'distrito_id',
    'dir_av_calle',
    'dir_numero',
    'dir_bloq_lote',
    'imagen',
    'user_id',
    'status'
];

public function user()
{
    return $this->belongsTo(User::class, 'email', 'email');
}

public function department()
{
    return $this->belongsTo(Department::class, 'departamento_id');
}

public function province()
{
    return $this->belongsTo(Province::class, 'provincia_id');
}

public function district()
{
    return $this->belongsTo(District::class, 'distrito_id');
}

}
