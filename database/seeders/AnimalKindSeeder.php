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
                "max_size" => 10,
                "max_age" => 10,
                "growth_factor" => 1,
            ],
            [
                "kind" => "dog",
                "max_size" => 15,
                "max_age" => 15,
                "growth_factor" => 2
            ],
            [
                "kind" => "bird",
                "max_size" => 5,
                "max_age" => 5,
                "growth_factor" => 3
            ],
            [
                "kind" => "mi",
                "max_size" => 20,
                "max_age" => 20,
                "growth_factor" => 4
            ],
        ],['kind', 'max_size', 'max_age', 'growth_factor'], ['kind']);
    }
}
