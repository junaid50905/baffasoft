<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Vanguard\Member;
use Vanguard\MemberDetail;

class MemberDetailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MemberDetail::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'firm_name' => $this->faker->sentence, //Generates a fake sentence
//            'body' => $this->faker->paragraph(30), //generates fake 30 paragraphs
            'member_id' => Member::factory() //Generates a User from factory and extracts id

        ];
    }
}
