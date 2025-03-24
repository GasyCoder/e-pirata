<?php

namespace Database\Factories;

use App\Models\Enigma;
use Illuminate\Database\Eloquent\Factories\Factory;

class EnigmaFactory extends Factory
{
    protected $model = Enigma::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'content' => $this->faker->text,
            'answer' => $this->faker->word,
            'hint1' => $this->faker->sentence,
            'hint2' => $this->faker->sentence,
            'hint3' => $this->faker->sentence,
            'fragment' => $this->faker->word,
            'points' => $this->faker->numberBetween(10, 100),
            'difficulty' => $this->faker->numberBetween(1, 5),
            'order' => $this->faker->unique()->numberBetween(1, 100),
            'chapter_id' => null, // Assurez-vous d'ajuster si nécessaire
        ];
    }
}
