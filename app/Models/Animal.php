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
        $next_size = $this->size * (1+$this->AnimalKind->growth_factor/10);
        $next_age = ++$this->age;

        if($next_size > $this->AnimalKind->max_size || $next_age > $this->AnimalKind->max_age){
            return false;
        } else{
            $this->update([
                'age' => $next_age,
                'size' => $next_size,
            ]);
            return true;
        }
    }
}
