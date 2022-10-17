<?php

namespace Database\Factories;

use App\Models\CabinetExterne;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Formateur>
 */
class FormateurFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $id = rand(1,10);
        $cabinet_externesId = CabinetExterne::pluck('id')->toArray();
        return [
            'prenom' => 'prenomFormateur'.$id,
            'nom' => 'nomFormateur'.$id,
            'email' => 'formateur'.$id.'@gmail.com',
            'cabinet_id' => $cabinet_externesId[array_rand($cabinet_externesId)]
        ];
    }
}
