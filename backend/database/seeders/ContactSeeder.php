<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Contact;
use App\Models\User;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Get some users
        $students = User::where('role', 'student')->take(5)->get();
        $admin = User::where('role', 'admin')->first();

        $contacts = [
            [
                'user_id' => $students->first()->id ?? null,
                'name' => 'Marie Dubois',
                'email' => 'marie.dubois@email.com',
                'phone' => '+33 6 12 34 56 78',
                'subject' => 'Question sur les frais de dossier',
                'message' => 'Bonjour, j\'aimerais savoir si les frais de dossier sont remboursables en cas de refus de candidature. Merci pour votre réponse.',
                'type' => 'application_help',
                'priority' => 'medium',
                'status' => 'resolved',
                'assigned_to' => $admin->id ?? null,
                'admin_response' => 'Bonjour Marie, les frais de dossier ne sont malheureusement pas remboursables, même en cas de refus. Cependant, ils permettent de traiter votre candidature dans les meilleures conditions.',
                'responded_at' => now()->subDays(2),
                'created_at' => now()->subDays(5),
            ],
            [
                'user_id' => $students->skip(1)->first()->id ?? null,
                'name' => 'Pierre Martin',
                'email' => 'pierre.martin@email.com',
                'phone' => '+33 6 87 65 43 21',
                'subject' => 'Problème technique avec le formulaire',
                'message' => 'Je n\'arrive pas à télécharger mes documents sur la plateforme. Le bouton ne répond pas quand je clique dessus.',
                'type' => 'technical_support',
                'priority' => 'high',
                'status' => 'in_progress',
                'assigned_to' => $admin->id ?? null,
                'created_at' => now()->subDays(3),
            ],
            [
                'user_id' => null,
                'name' => 'Sophie Laurent',
                'email' => 'sophie.laurent@email.com',
                'phone' => '+33 6 11 22 33 44',
                'subject' => 'Informations sur les programmes disponibles',
                'message' => 'Bonjour, je souhaiterais avoir plus d\'informations sur les programmes de master en informatique disponibles dans vos écoles partenaires.',
                'type' => 'general',
                'priority' => 'low',
                'status' => 'open',
                'created_at' => now()->subDays(1),
            ],
            [
                'user_id' => $students->skip(2)->first()->id ?? null,
                'name' => 'Thomas Rousseau',
                'email' => 'thomas.rousseau@email.com',
                'phone' => '+33 6 55 44 33 22',
                'subject' => 'Délai de traitement des candidatures',
                'message' => 'Ma candidature est en cours depuis 3 semaines. Pouvez-vous me donner une estimation du délai de traitement ?',
                'type' => 'application_help',
                'priority' => 'medium',
                'status' => 'resolved',
                'assigned_to' => $admin->id ?? null,
                'admin_response' => 'Bonjour Thomas, le délai moyen de traitement est de 2 à 4 semaines. Votre candidature est actuellement en cours d\'évaluation par l\'école. Vous recevrez une réponse sous peu.',
                'responded_at' => now()->subHours(12),
                'created_at' => now()->subDays(4),
            ],
            [
                'user_id' => $students->skip(3)->first()->id ?? null,
                'name' => 'Emma Leroy',
                'email' => 'emma.leroy@email.com',
                'phone' => '+33 6 99 88 77 66',
                'subject' => 'Réclamation - Erreur dans le traitement',
                'message' => 'Ma candidature a été rejetée par erreur. J\'ai tous les documents requis et je remplis les critères d\'admission. Je demande une révision de ma candidature.',
                'type' => 'complaint',
                'priority' => 'urgent',
                'status' => 'in_progress',
                'assigned_to' => $admin->id ?? null,
                'created_at' => now()->subHours(6),
            ],
            [
                'user_id' => null,
                'name' => 'Lucas Moreau',
                'email' => 'lucas.moreau@email.com',
                'phone' => '+33 6 77 66 55 44',
                'subject' => 'Partenariat avec une nouvelle école',
                'message' => 'Je représente l\'École Supérieure de Commerce de Lyon et j\'aimerais discuter d\'un éventuel partenariat avec EduConnect.',
                'type' => 'general',
                'priority' => 'medium',
                'status' => 'open',
                'created_at' => now()->subHours(2),
            ],
            [
                'user_id' => $students->skip(4)->first()->id ?? null,
                'name' => 'Camille Petit',
                'email' => 'camille.petit@email.com',
                'phone' => '+33 6 33 22 11 00',
                'subject' => 'Modification de candidature',
                'message' => 'Je souhaiterais modifier ma candidature pour changer de programme. Est-ce possible après soumission ?',
                'type' => 'application_help',
                'priority' => 'medium',
                'status' => 'resolved',
                'assigned_to' => $admin->id ?? null,
                'admin_response' => 'Bonjour Camille, il est possible de modifier votre candidature dans les 48h suivant la soumission. Passé ce délai, vous devrez soumettre une nouvelle candidature.',
                'responded_at' => now()->subDays(1),
                'created_at' => now()->subDays(3),
            ],
            [
                'user_id' => null,
                'name' => 'Antoine Bernard',
                'email' => 'antoine.bernard@email.com',
                'phone' => '+33 6 44 55 66 77',
                'subject' => 'Question sur les bourses d\'études',
                'message' => 'Existe-t-il des programmes de bourses ou d\'aides financières pour les étudiants en situation précaire ?',
                'type' => 'general',
                'priority' => 'low',
                'status' => 'open',
                'created_at' => now()->subHours(8),
            ],
        ];

        foreach ($contacts as $contactData) {
            Contact::create($contactData);
        }

        $this->command->info('Contact seeder completed successfully!');
    }
}
