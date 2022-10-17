<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Participant;
use App\Models\Seance;


class Groupe_formation extends Model
{
    use HasFactory;

    public function participants()
    {
        return $this->hasMany(Participant::class);
    }

    public function seance()
    {
        return $this->hasOne(Seance::class);
    }
}
