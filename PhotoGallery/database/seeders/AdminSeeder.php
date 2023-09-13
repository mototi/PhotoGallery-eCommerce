<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Admin::truncate();
        Admin::factory()->count(10)->create();
        Schema::enableForeignKeyConstraints();
    }

}
