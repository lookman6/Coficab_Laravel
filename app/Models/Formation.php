<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Seance;

class Formation extends Model
{
    use HasFactory;
    protected $fillable = [
        'theme',
        'categorie_id'
    ];

    public function categorie()
    {
        return $this->belongsTo(Category::class);
    }

    public function seance()
    {
        return $this->hasOne(Seance::class);
    }
}
