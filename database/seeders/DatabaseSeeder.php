<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;
use App\Models\School;
use App\Models\Application;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Administrateur EduConnect',
            'email' => 'admin@educonnect.sn',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '+221 33 123 45 67',
            'birth_date' => '1985-01-15',
            'address' => 'Plateau, Avenue Léopold Sédar Senghor',
            'city' => 'Dakar',
            'postal_code' => '10700',
            'country' => 'Sénégal',
        ]);

        // Create sample students - Étudiants sénégalais
        $students = [
            [
                'name' => 'Aminata Diallo',
                'email' => 'aminata.diallo@gmail.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password'),
                'role' => 'student',
                'phone' => '+221 77 123 45 67',
                'birth_date' => '1998-05-15',
                'address' => 'Cité Keur Gorgui, Villa 123',
                'city' => 'Dakar',
                'postal_code' => '10700',
                'country' => 'Sénégal',
            ],
            [
                'name' => 'Moussa Ndiaye',
                'email' => 'moussa.ndiaye@gmail.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password'),
                'role' => 'student',
                'phone' => '+221 76 987 65 43',
                'birth_date' => '1999-08-22',
                'address' => 'Quartier Médina, Rue 15',
                'city' => 'Dakar',
                'postal_code' => '10700',
                'country' => 'Sénégal',
            ],
            [
                'name' => 'Fatou Sall',
                'email' => 'fatou.sall@gmail.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password'),
                'role' => 'student',
                'phone' => '+221 78 112 233 44',
                'birth_date' => '1997-12-03',
                'address' => 'Parcelles Assainies, Unité 25',
                'city' => 'Dakar',
                'postal_code' => '10700',
                'country' => 'Sénégal',
            ],
        ];

        foreach ($students as $studentData) {
            User::create($studentData);
        }

        // Create sample schools - Écoles sénégalaises
        $schools = [
            [
                'name' => 'Institut Supérieur d\'Informatique (ISI)',
                'description' => '🏆 ÉCOLE VEDETTE - L\'Institut Supérieur d\'Informatique (ISI) est l\'école de référence en informatique au Sénégal. Formation d\'excellence en développement, cybersécurité, IA et data science. Partenariats avec les grandes entreprises tech sénégalaises et internationales. Taux d\'insertion professionnelle de 95%.',
                'city' => 'Dakar',
                'address' => 'Sacré-Cœur 3, VDN, BP 15532',
                'postal_code' => '10700',
                'phone' => '+221 33 867 12 34',
                'email' => 'contact@isi.edu.sn',
                'website' => 'https://www.isi.edu.sn',
                'fields_of_study' => ['Génie Logiciel', 'Cybersécurité', 'Intelligence Artificielle', 'Data Science', 'Développement Mobile', 'DevOps'],
                'accreditations' => ['CAMES', 'CEDEAO', 'ISO 9001'],
                'diplomas' => ['Licence Informatique', 'Master Tech', 'Ingénieur Informatique'],
                'tuition_fee_min' => 600000,
                'tuition_fee_max' => 1500000,
                'application_fee' => 25000,
                'admission_requirements' => 'Baccalauréat série S ou équivalent, test technique, entretien de motivation.',
                'next_intake' => '2024-10-01',
                'is_active' => true,
            ],
            [
                'name' => 'École Supérieure Polytechnique de Dakar (ESP)',
                'description' => 'École d\'ingénieurs de référence au Sénégal, l\'ESP forme des ingénieurs de haut niveau dans diverses spécialités. Reconnue pour son excellence académique et ses partenariats avec l\'industrie sénégalaise.',
                'city' => 'Dakar',
                'address' => 'Avenue Cheikh Anta Diop, BP 5085',
                'postal_code' => '10700',
                'phone' => '+221 33 859 56 00',
                'email' => 'contact@esp.sn',
                'website' => 'https://www.esp.sn',
                'fields_of_study' => ['Génie Informatique', 'Génie Civil', 'Génie Électromécanique', 'Génie Chimique'],
                'accreditations' => ['CAMES', 'CEDEAO'],
                'diplomas' => ['Diplôme d\'Ingénieur', 'Master', 'Doctorat'],
                'tuition_fee_min' => 500000,
                'tuition_fee_max' => 1200000,
                'application_fee' => 25000,
                'admission_requirements' => 'Baccalauréat série S ou équivalent, concours d\'entrée, dossier académique.',
                'next_intake' => '2024-10-01',
                'is_active' => true,
            ],
            [
                'name' => 'Institut Supérieur de Management (ISM)',
                'description' => 'École de commerce et de management leader en Afrique de l\'Ouest. L\'ISM forme les futurs leaders économiques du Sénégal avec des programmes adaptés aux réalités africaines.',
                'city' => 'Dakar',
                'address' => 'Route de la Corniche Ouest, BP 3007',
                'postal_code' => '10700',
                'phone' => '+221 33 859 89 00',
                'email' => 'info@ism.edu.sn',
                'website' => 'https://www.ism.edu.sn',
                'fields_of_study' => ['Management', 'Finance', 'Marketing', 'Commerce International'],
                'accreditations' => ['CAMES', 'AACSB'],
                'diplomas' => ['Bachelor', 'Master', 'MBA'],
                'tuition_fee_min' => 800000,
                'tuition_fee_max' => 2000000,
                'application_fee' => 30000,
                'admission_requirements' => 'Baccalauréat ou équivalent, entretien de motivation, test d\'aptitude.',
                'next_intake' => '2024-09-15',
                'is_active' => true,
            ],
            [
                'name' => 'École Supérieure d\'Économie Appliquée (ESEA)',
                'description' => 'École spécialisée en économie et gestion, l\'ESEA forme des cadres compétents pour le développement économique du Sénégal. Focus sur l\'économie numérique et l\'entrepreneuriat.',
                'city' => 'Saint-Louis',
                'address' => 'Avenue Jean Mermoz, BP 234',
                'postal_code' => '32000',
                'phone' => '+221 33 961 23 45',
                'email' => 'contact@esea.edu.sn',
                'website' => 'https://www.esea.edu.sn',
                'fields_of_study' => ['Économie Numérique', 'Gestion', 'Entrepreneuriat', 'Développement Local'],
                'accreditations' => ['CAMES'],
                'diplomas' => ['Bachelor', 'Master'],
                'tuition_fee_min' => 400000,
                'tuition_fee_max' => 750000,
                'application_fee' => 20000,
                'admission_requirements' => 'Baccalauréat série L ou ES, entretien de motivation, dossier académique.',
                'next_intake' => '2024-10-01',
                'is_active' => true,
            ],
            [
                'name' => 'Université Cheikh Anta Diop - École de Médecine',
                'description' => 'Faculté de médecine de l\'UCAD, formant les futurs médecins et professionnels de santé du Sénégal. Excellence académique et formation pratique dans les hôpitaux de Dakar.',
                'city' => 'Dakar',
                'address' => 'Avenue Cheikh Anta Diop, BP 5005',
                'postal_code' => '10700',
                'phone' => '+221 33 824 23 79',
                'email' => 'medecine@ucad.edu.sn',
                'website' => 'https://www.ucad.sn',
                'fields_of_study' => ['Médecine Générale', 'Pharmacie', 'Odontologie', 'Sage-femme'],
                'accreditations' => ['CAMES', 'OMS'],
                'diplomas' => ['Doctorat en Médecine', 'Master Santé Publique'],
                'tuition_fee_min' => 300000,
                'tuition_fee_max' => 600000,
                'application_fee' => 15000,
                'admission_requirements' => 'Baccalauréat série S, concours d\'entrée très sélectif.',
                'next_intake' => '2024-10-15',
                'is_active' => true,
            ],
            [
                'name' => 'Institut Africain de Management (IAM)',
                'description' => 'École de management panafricaine basée à Dakar, spécialisée dans la formation des leaders africains. Focus sur l\'entrepreneuriat et le développement durable.',
                'city' => 'Dakar',
                'address' => 'Rue de Thiong, Plateau, BP 3802',
                'postal_code' => '10700',
                'phone' => '+221 33 823 87 64',
                'email' => 'contact@iam.edu.sn',
                'website' => 'https://www.iam.edu.sn',
                'fields_of_study' => ['Leadership Africain', 'Entrepreneuriat', 'Développement Durable', 'Agribusiness'],
                'accreditations' => ['CAMES', 'AACSB'],
                'diplomas' => ['Bachelor Management', 'MBA Africain', 'Executive MBA'],
                'tuition_fee_min' => 1000000,
                'tuition_fee_max' => 2500000,
                'application_fee' => 35000,
                'admission_requirements' => 'Baccalauréat, expérience professionnelle recommandée, entretien.',
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
                'submitted_at' => Carbon::now()->subDays(3),
            ],
            [
                'user_id' => 3, // Pierre Martin
                'school_id' => 2, // Institut National des Sciences Appliquées
                'field_of_study' => 'Informatique',
                'diploma_level' => 'Diplôme d\'Ingénieur',
                'motivation_letter' => 'Passionné par l\'informatique depuis mon plus jeune âge, je souhaite intégrer votre prestigieux établissement pour devenir ingénieur en informatique. Votre formation polyvalente et vos liens avec l\'industrie correspondent exactement à ce que je recherche pour construire ma carrière dans le développement logiciel.',
                'status' => 'in_progress',
                'commission_amount' => 100,
                'submitted_at' => Carbon::now()->subDays(7),
            ],
            [
                'user_id' => 2, // Aminata Diallo
                'school_id' => 1, // Institut Supérieur d'Informatique
                'field_of_study' => 'Informatique',
                'diploma_level' => 'Master',
                'motivation_letter' => 'Je suis passionnée par l\'informatique et souhaite développer mes compétences dans ce domaine en pleine expansion au Sénégal. L\'ISI jouit d\'une excellente réputation et propose des formations de qualité qui correspondent parfaitement à mes aspirations professionnelles. Mon objectif est de devenir développeuse dans une entreprise innovante.',
                'status' => 'submitted',
                'commission_amount' => 25000,
                'submitted_at' => Carbon::now()->subDays(3),
            ],
            [
                'user_id' => 3, // Moussa Ndiaye
                'school_id' => 2, // École Supérieure Polytechnique
                'field_of_study' => 'Génie Informatique',
                'diploma_level' => 'Diplôme d\'Ingénieur',
                'motivation_letter' => 'Passionné par l\'ingénierie depuis mon plus jeune âge, je souhaite intégrer votre prestigieux établissement pour devenir ingénieur en informatique. Votre formation polyvalente et vos liens avec l\'industrie correspondent exactement à ce que je recherche pour construire ma carrière dans le développement technologique au Sénégal.',
                'status' => 'in_progress',
                'commission_amount' => 30000,
                'submitted_at' => Carbon::now()->subDays(7),
            ],
            [
                'user_id' => 4, // Fatou Sall
                'school_id' => 3, // Institut Supérieur de Management
                'field_of_study' => 'Management',
                'diploma_level' => 'Master Management',
                'motivation_letter' => 'Créative et ambitieuse, je souhaite faire du management mon métier. Votre école propose une approche moderne et innovante qui me permettra de développer mes compétences en leadership tout en acquérant les compétences techniques nécessaires. Mon rêve est de diriger une entreprise sénégalaise.',
                'status' => 'accepted',
                'commission_amount' => 20000,
                'commission_paid' => true,
                'submitted_at' => Carbon::now()->subDays(14),
                'processed_at' => Carbon::now()->subDays(2),
                'admin_notes' => 'Excellent dossier de candidature. Candidature acceptée avec félicitations.',
            ],
        ];

        foreach ($applications as $applicationData) {
            Application::create($applicationData);
        }
    }
}
