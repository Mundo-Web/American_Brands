<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;
    
    protected $fillable = [        
        'department_id',
        'description',
        'active',
    ];

    protected $keyType = 'string';

    public $incrementing = false;
    
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
