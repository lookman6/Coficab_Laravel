<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personne extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'cin',
    //     'nom',
    //     'prenom',
    //     'dateNaissance',
    //     'sexe',
    //     'email',
    //     'telephone',
    //     'login',
    //     'motDePasse'
    // ];


    // public function etudiant()
    // {
    //     return $this->hasOne(Etudiant::class);
    // }

    // public function professeur()
    // {
    //     return $this->hasOne(Professeur::class);
    // }

    // public function administrateur()
    // {
    //     return $this->hasOne(Administrateur::class);
    // }
}
