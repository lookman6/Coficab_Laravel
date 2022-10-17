<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Formation;
use App\Models\Formateur;
use App\Models\Groupe_formation;


class Seance extends Model
{
    protected $fillable = [
        'formateur_id',
        'formation_id',
        'cabinet_id',
        'salle_id',
        'dateDebut',
        'dateFin',
        'cout',
        'type',
        'duree',
        'groupe_formation_id'
    ];
    
    use HasFactory;


    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }
    public function formateur()
    {
        return $this->belongsTo(Formateur::class);
    }

    public function groupe_formation()
    {
        return $this->belongsTo(Groupe_formation::class);
    }
}
