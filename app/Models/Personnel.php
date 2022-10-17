<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Participant; 

class Personnel extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'prenom',
        'actif',
        'departement',
        'fonction',
        'matricule'
    ];


    public function participant()
    {
        return $this->hasOne(Participant::class);
    }
}
