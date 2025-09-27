<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\School;
use App\Models\Application;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin EduConnect',
            'email' => 'admin@educonnect.fr',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '01 23 45 67 89',
            'city' => 'Paris',
            'postal_code' => '75001',
        ]);

        // Create sample students
        $students = [
            [
                'name' => 'Marie Dupont',
                'email' => 'marie.dupont@email.com',
                'password' => Hash::make('password'),
                'role' => 'student',
                'phone' => '06 12 34 56 78',
                'birth_date' => '2000-05-15',
                'address' => '123 rue de la République',
                'city' => 'Lyon',
                'postal_code' => '69001',
            ],
            [
                'name' => 'Pierre Martin',
                'email' => 'pierre.martin@email.com',
                'password' => Hash::make('password'),
                'role' => 'student',
                'phone' => '06 98 76 54 32',
                'birth_date' => '1999-12-03',
                'address' => '456 avenue des Champs',
                'city' => 'Marseille',
                'postal_code' => '13001',
            ],
            [
                'name' => 'Sophie Bernard',
                'email' => 'sophie.bernard@email.com',
                'password' => Hash::make('password'),
                'role' => 'student',
                'phone' => '06 11 22 33 44',
                'birth_date' => '2001-08-20',
                'address' => '789 boulevard Saint-Germain',
                'city' => 'Paris',
                'postal_code' => '75006',
            ],
        ];

        foreach ($students as $studentData) {
            User::create($studentData);
        }

        // Create sample schools
        $schools = [
            [
                'name' => 'École Supérieure de Commerce de Paris',
                'description' => 'Une école de commerce prestigieuse située au cœur de Paris, offrant des formations d\'excellence en management, finance et marketing. Reconnue pour son réseau d\'anciens élèves et ses partenariats internationaux.',
                'city' => 'Paris',
                'address' => '79 avenue de la République',
                'postal_code' => '75011',
                'phone' => '01 42 78 90 12',
                'email' => 'contact@escp.fr',
                'website' => 'https://www.escp.fr',
                'fields_of_study' => ['Management', 'Finance', 'Marketing', 'Entrepreneuriat'],
                'accreditations' => ['AACSB', 'EQUIS', 'AMBA'],
                'diplomas' => ['Bachelor', 'Master', 'MBA'],
                'tuition_fee_min' => 8000,
                'tuition_fee_max' => 15000,
                'application_fee' => 150,
                'admission_requirements' => 'Baccalauréat ou équivalent, entretien de motivation, dossier académique.',
                'next_intake' => '2024-09-01',
                'is_active' => true,
            ],
            [
                'name' => 'Institut National des Sciences Appliquées',
                'description' => 'École d\'ingénieurs reconnue pour l\'excellence de ses formations en sciences et technologies. L\'INSA forme des ingénieurs polyvalents capables de répondre aux défis technologiques contemporains.',
                'city' => 'Lyon',
                'address' => '20 avenue Albert Einstein',
                'postal_code' => '69621',
                'phone' => '04 72 43 83 83',
                'email' => 'contact@insa-lyon.fr',
                'website' => 'https://www.insa-lyon.fr',
                'fields_of_study' => ['Informatique', 'Génie Civil', 'Génie Mécanique', 'Télécommunications'],
                'accreditations' => ['CTI', 'EUR-ACE'],
                'diplomas' => ['Diplôme d\'Ingénieur', 'Master'],
                'tuition_fee_min' => 2500,
                'tuition_fee_max' => 5000,
                'application_fee' => 100,
                'admission_requirements' => 'Classes préparatoires scientifiques ou DUT/BTS + dossier.',
                'next_intake' => '2024-09-15',
                'is_active' => true,
            ],
            [
                'name' => 'École de Design et d\'Arts Appliqués',
                'description' => 'École spécialisée dans les arts appliqués et le design, proposant des formations créatives et innovantes. Nos étudiants développent leur créativité tout en acquérant les compétences techniques nécessaires.',
                'city' => 'Marseille',
                'address' => '15 rue du Design',
                'postal_code' => '13002',
                'phone' => '04 91 54 32 10',
                'email' => 'info@edaa-marseille.fr',
                'website' => 'https://www.edaa-marseille.fr',
                'fields_of_study' => ['Design Graphique', 'Design Produit', 'Architecture Intérieure', 'Arts Numériques'],
                'accreditations' => ['RNCP'],
                'diplomas' => ['Bachelor Design', 'Master Design'],
                'tuition_fee_min' => 6000,
                'tuition_fee_max' => 9000,
                'application_fee' => 80,
                'admission_requirements' => 'Portfolio créatif, entretien, baccalauréat.',
                'next_intake' => '2024-10-01',
                'is_active' => true,
            ],
            [
                'name' => 'Business School International',
                'description' => 'École de commerce internationale proposant des programmes en anglais et français. Focus sur l\'international business et l\'innovation managériale.',
                'city' => 'Nice',
                'address' => '25 promenade des Anglais',
                'postal_code' => '06000',
                'phone' => '04 93 87 65 43',
                'email' => 'admissions@bsi-nice.fr',
                'website' => 'https://www.bsi-nice.fr',
                'fields_of_study' => ['International Business', 'Digital Marketing', 'Luxury Management', 'Finance'],
                'accreditations' => ['AACSB'],
                'diplomas' => ['Bachelor', 'Master', 'Executive MBA'],
                'tuition_fee_min' => 10000,
                'tuition_fee_max' => 18000,
                'application_fee' => 200,
                'admission_requirements' => 'Baccalauréat, niveau d\'anglais B2, entretien.',
                'next_intake' => '2024-09-10',
                'is_active' => true,
            ],
            [
                'name' => 'École Supérieure d\'Informatique',
                'description' => 'École spécialisée dans l\'informatique et les nouvelles technologies. Formation complète en développement, cybersécurité, intelligence artificielle et data science.',
                'city' => 'Toulouse',
                'address' => '42 avenue de l\'Informatique',
                'postal_code' => '31000',
                'phone' => '05 61 23 45 67',
                'email' => 'contact@esi-toulouse.fr',
                'website' => 'https://www.esi-toulouse.fr',
                'fields_of_study' => ['Développement Web', 'Cybersécurité', 'Intelligence Artificielle', 'Data Science'],
                'accreditations' => ['RNCP', 'Qualiopi'],
                'diplomas' => ['Bachelor Informatique', 'Master Informatique'],
                'tuition_fee_min' => 7000,
                'tuition_fee_max' => 12000,
                'application_fee' => 120,
                'admission_requirements' => 'Baccalauréat scientifique ou technologique, tests techniques.',
                'next_intake' => '2024-09-20',
                'is_active' => true,
            ],
        ];

        foreach ($schools as $schoolData) {
            School::create($schoolData);
        }

        // Create sample applications
        $applications = [
            [
                'user_id' => 2, // Marie Dupont
                'school_id' => 1, // École Supérieure de Commerce de Paris
                'field_of_study' => 'Marketing',
                'diploma_level' => 'Master',
                'motivation_letter' => 'Je suis passionnée par le marketing digital et souhaite développer mes compétences dans ce domaine en pleine expansion. Votre école jouit d\'une excellente réputation et propose des formations de qualité qui correspondent parfaitement à mes aspirations professionnelles. Mon objectif est de devenir responsable marketing dans une entreprise innovante.',
                'status' => 'submitted',
                'commission_amount' => 150,
                'submitted_at' => now()->subDays(3),
            ],
            [
                'user_id' => 3, // Pierre Martin
                'school_id' => 2, // Institut National des Sciences Appliquées
                'field_of_study' => 'Informatique',
                'diploma_level' => 'Diplôme d\'Ingénieur',
                'motivation_letter' => 'Passionné par l\'informatique depuis mon plus jeune âge, je souhaite intégrer votre prestigieux établissement pour devenir ingénieur en informatique. Votre formation polyvalente et vos liens avec l\'industrie correspondent exactement à ce que je recherche pour construire ma carrière dans le développement logiciel.',
                'status' => 'in_progress',
                'commission_amount' => 100,
                'submitted_at' => now()->subDays(7),
            ],
            [
                'user_id' => 4, // Sophie Bernard
                'school_id' => 3, // École de Design et d\'Arts Appliqués
                'field_of_study' => 'Design Graphique',
                'diploma_level' => 'Bachelor Design',
                'motivation_letter' => 'Créative depuis toujours, je souhaite faire du design graphique mon métier. Votre école propose une approche moderne et innovante qui me permettra de développer ma créativité tout en acquérant les compétences techniques nécessaires. Mon rêve est de travailler dans une agence de communication renommée.',
                'status' => 'accepted',
                'commission_amount' => 80,
                'commission_paid' => true,
                'submitted_at' => now()->subDays(14),
                'processed_at' => now()->subDays(2),
                'admin_notes' => 'Excellent portfolio créatif. Candidature acceptée avec félicitations.',
            ],
        ];

        foreach ($applications as $applicationData) {
            Application::create($applicationData);
        }
    }
}
