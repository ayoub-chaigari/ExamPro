<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@ofppt.ma',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Create Teacher
        User::factory()->create([
            'name' => 'Teacher User',
            'email' => 'teacher@ofppt.ma',
            'password' => bcrypt('password'),
            'role' => 'teacher',
        ]);

        // Create Categories
        $subjects = ['Mathématiques', 'Développement Web', 'Algorithmique', 'Réseaux Informatiques'];
        foreach ($subjects as $subject) {
            \App\Models\Category::create(['name' => $subject, 'type' => 'subject']);
        }
        
        $levels = ['1ère Année TSGE', '2ème Année TDI', '1ère Année TDM'];
        foreach ($levels as $level) {
            \App\Models\Category::create(['name' => $level, 'type' => 'level']);
        }
    }
}
