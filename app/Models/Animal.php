<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    use HasFactory;
    protected $primaryKey = 'name';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'kind',
        'age',
        'size',
    ];
    
    public function AnimalKind()
    {
        return $this->belongsTo(AnimalKind::class, 'kind', 'kind');
    }
}
