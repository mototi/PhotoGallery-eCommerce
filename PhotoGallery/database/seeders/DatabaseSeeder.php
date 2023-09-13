<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Schema;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        User::truncate();

        User::factory()->admin()->create([
            'name' => 'admin User',
            'email' => 'admin1@example.com',
            'password' => Hash::make('secret'),
        ]);

        //development seeding
        if(app()-> environment() == 'local'){
            $this->call([
                CustomerSeeder::class,
                AdminSeeder::class,
            ]);
        }

        Schema::enableForeignKeyConstraints();
    }
}
