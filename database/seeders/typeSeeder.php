<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Seeder;

class typeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Type::factory()->times(5)->create();
    }
}
