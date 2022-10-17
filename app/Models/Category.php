<?php

namespace App\Models;

use App\Models\Formation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        "intitule"
    ];

    public function formations()
    {
        return $this->hasMany(Formation::class);
    }
}
