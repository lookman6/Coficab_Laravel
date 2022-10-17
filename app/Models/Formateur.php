<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Seance;

class Formateur extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'cabinet_id',
        'user_id'
    ];

    public function seance()
    {
        return $this->hasOne(Seance::class);
    }
}
