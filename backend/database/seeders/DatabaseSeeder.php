<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('🌱 Starting EduConnect database seeding...');
        
        // Seed in specific order due to foreign key constraints
        $this->call([
            UserSeeder::class,
            SchoolSeeder::class,
            ProgramSeeder::class,
            ApplicationSeeder::class,
            ContactSeeder::class,
        ]);
        
        $this->command->info('✅ EduConnect database seeding completed successfully!');
        $this->command->info('');
        $this->command->info('📊 Summary:');
        $this->command->info('- Users: Admin and student accounts created');
        $this->command->info('- Schools: 8 schools with detailed information');
        $this->command->info('- Programs: Multiple programs per school');
        $this->command->info('- Applications: Sample applications with various statuses');
        $this->command->info('- Contacts: Sample contact messages and support tickets');
        $this->command->info('');
        $this->command->info('🔐 Admin Login:');
        $this->command->info('Email: admin@educonnect.fr');
        $this->command->info('Password: password123');
        $this->command->info('');
        $this->command->info('👨‍🎓 Student Login Examples:');
        $this->command->info('Email: jean.dupont@email.com');
        $this->command->info('Email: marie.martin@email.com');
        $this->command->info('Password: password123');
    }
}
