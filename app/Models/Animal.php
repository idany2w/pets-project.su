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
    
    public function age()
    {
        if($this->size == $this->AnimalKind->max_size || $this->age == $this->AnimalKind->max_age){
            return false;
        }

        $next_size = $this->size * (1+$this->AnimalKind->growth_factor/10);
        if($next_size > $this->AnimalKind->max_size){
            $next_size = $this->AnimalKind->max_size;
        }

        $next_age = ++$this->age;
        if($next_age > $this->AnimalKind->max_age){
            $next_age = $this->AnimalKind->max_age;
        }

        $this->update([
            'age' => $next_age,
            'size' => $next_size,
        ]);
        return true;
    }
}
