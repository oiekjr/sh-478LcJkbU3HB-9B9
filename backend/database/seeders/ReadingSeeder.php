<?php

namespace Database\Seeders;

use App\Models\Reading;
use Illuminate\Database\Seeder;

class ReadingSeeder extends Seeder
{
    public function run(): void
    {
        Reading::factory()->count(3)->create();
    }
}

