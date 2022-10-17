<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Personnel;
use App\Models\Groupe_formation;

class Participant extends Model
{
    protected $fillable = [
        'personnel_id',
        'groupe_id',
        'groupe_formation_id'
    ];


    public function personnel()
    {
        return $this->belongsTo(Personnel::class);
    }

    public function groupe_formation()
    {
        return $this->belongsTo(Groupe_formation::class);
    }
    use HasFactory;
}
