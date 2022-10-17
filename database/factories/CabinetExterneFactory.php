<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CabinetExterne>
 */
class CabinetExterneFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $id = rand(1,10);
        return [
            'nom' => 'cabinet'.$id,
            'adresse' => 'adresse'.$id,
        ];
    }
}
