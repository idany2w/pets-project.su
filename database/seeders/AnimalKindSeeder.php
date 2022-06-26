<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\AnimalKind;


class AnimalKindSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AnimalKind::upsert([
            [
                "kind" => "cat",
                "max_size" => 15,
                "max_age" => 30,
                "growth_factor" => 3,
            ],
            [
                "kind" => "dog",
                "max_size" => 50,
                "max_age" => 30,
                "growth_factor" => 4
            ],
            [
                "kind" => "bird",
                "max_size" => 1,
                "max_age" => 5,
                "growth_factor" => 5
            ],
            [
                "kind" => "mi",
                "max_size" => 160,
                "max_age" => 20,
                "growth_factor" => 5
            ],
        ],['kind', 'max_size', 'max_age', 'growth_factor'], ['kind']);
    }
}
