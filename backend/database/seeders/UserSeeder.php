<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'EduConnect',
            'email' => 'admin@educonnect.com',
            'password' => Hash::make('password123'),
            'phone' => '+33123456789',
            'city' => 'Paris',
            'country' => 'France',
            'role' => 'admin',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Create test students
        $students = [
            [
                'first_name' => 'Marie',
                'last_name' => 'Dupont',
                'email' => 'marie.dupont@email.com',
                'phone' => '+33123456790',
                'date_of_birth' => '1998-05-15',
                'address' => '123 Rue de la Paix',
                'city' => 'Lyon',
                'country' => 'France',
            ],
            [
                'first_name' => 'Jean',
                'last_name' => 'Martin',
                'email' => 'jean.martin@email.com',
                'phone' => '+33123456791',
                'date_of_birth' => '1999-08-22',
                'address' => '456 Avenue des Champs',
                'city' => 'Marseille',
                'country' => 'France',
            ],
            [
                'first_name' => 'Sophie',
                'last_name' => 'Bernard',
                'email' => 'sophie.bernard@email.com',
                'phone' => '+33123456792',
                'date_of_birth' => '1997-12-03',
                'address' => '789 Boulevard Saint-Germain',
                'city' => 'Toulouse',
                'country' => 'France',
            ],
            [
                'first_name' => 'Pierre',
                'last_name' => 'Moreau',
                'email' => 'pierre.moreau@email.com',
                'phone' => '+33123456793',
                'date_of_birth' => '2000-03-18',
                'address' => '321 Rue Victor Hugo',
                'city' => 'Nice',
                'country' => 'France',
            ],
            [
                'first_name' => 'Emma',
                'last_name' => 'Leroy',
                'email' => 'emma.leroy@email.com',
                'phone' => '+33123456794',
                'date_of_birth' => '1998-11-07',
                'address' => '654 Place de la République',
                'city' => 'Strasbourg',
                'country' => 'France',
            ]
        ];

        foreach ($students as $studentData) {
            User::create(array_merge($studentData, [
                'password' => Hash::make('password123'),
                'role' => 'student',
                'is_active' => true,
                'email_verified_at' => now(),
            ]));
        }

        // Create additional random students
        User::factory(15)->create([
            'role' => 'student',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
    }
}
