<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TrainingNameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('training_names')->delete();
        DB::table('training_names')->insert([
            ['training_name' => 'dg', 'visibility' => true],
            ['training_name' => 'csa', 'visibility' => true],
            ['training_name' => 'other', 'visibility' => true]
        ]);
    }
}
