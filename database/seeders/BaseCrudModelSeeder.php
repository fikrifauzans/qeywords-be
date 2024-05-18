<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Base\BaseCrudModel;

class BaseCrudModelSeeder extends Seeder
{
    public function run()
    {
        BaseCrudModel::factory()->count(1000)->create();
    }
}
