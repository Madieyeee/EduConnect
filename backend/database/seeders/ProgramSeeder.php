<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Program;
use App\Models\School;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schools = School::all();

        $programs = [
            // École Supérieure de Commerce de Paris
            [
                'school_name' => 'École Supérieure de Commerce de Paris',
                'programs' => [
                    [
                        'name' => 'Master en Management',
                        'description' => 'Programme de master en management général couvrant tous les aspects de la gestion d\'entreprise moderne.',
                        'level' => 'master',
                        'duration_months' => 24,
                        'tuition_fee' => 15000.00,
                        'currency' => 'EUR',
                        'requirements' => ['Licence ou équivalent', 'TOEFL/IELTS', 'Lettre de motivation'],
                        'career_prospects' => ['Consultant', 'Manager', 'Entrepreneur', 'Analyste financier'],
                        'application_deadline' => '2024-06-30',
                        'start_date' => '2024-09-01',
                        'language_of_instruction' => 'Français/Anglais',
                        'mode_of_study' => 'full-time',
                    ],
                    [
                        'name' => 'MBA Executive',
                        'description' => 'Programme MBA pour cadres expérimentés souhaitant développer leurs compétences managériales.',
                        'level' => 'master',
                        'duration_months' => 18,
                        'tuition_fee' => 45000.00,
                        'currency' => 'EUR',
                        'requirements' => ['5 ans d\'expérience', 'Diplôme supérieur', 'Entretien'],
                        'career_prospects' => ['Directeur général', 'Consultant senior', 'Entrepreneur'],
                        'application_deadline' => '2024-05-15',
                        'start_date' => '2024-09-15',
                        'language_of_instruction' => 'Anglais',
                        'mode_of_study' => 'part-time',
                    ]
                ]
            ],
            // Institut National des Sciences Appliquées de Lyon
            [
                'school_name' => 'Institut National des Sciences Appliquées de Lyon',
                'programs' => [
                    [
                        'name' => 'Ingénieur Informatique',
                        'description' => 'Formation d\'ingénieur en informatique et systèmes d\'information avec spécialisations en IA et cybersécurité.',
                        'level' => 'master',
                        'duration_months' => 60,
                        'tuition_fee' => 8000.00,
                        'currency' => 'EUR',
                        'requirements' => ['Baccalauréat S', 'Concours INSA', 'Dossier scolaire'],
                        'career_prospects' => ['Ingénieur logiciel', 'Architecte système', 'Chef de projet IT'],
                        'application_deadline' => '2024-04-30',
                        'start_date' => '2024-09-01',
                        'language_of_instruction' => 'Français',
                        'mode_of_study' => 'full-time',
                    ],
                    [
                        'name' => 'Ingénieur Génie Civil',
                        'description' => 'Formation complète en génie civil et construction durable.',
                        'level' => 'master',
                        'duration_months' => 60,
                        'tuition_fee' => 7500.00,
                        'currency' => 'EUR',
                        'requirements' => ['Baccalauréat S', 'Concours INSA', 'Mathématiques renforcées'],
                        'career_prospects' => ['Ingénieur BTP', 'Architecte', 'Chef de chantier'],
                        'application_deadline' => '2024-04-30',
                        'start_date' => '2024-09-01',
                        'language_of_instruction' => 'Français',
                        'mode_of_study' => 'full-time',
                    ]
                ]
            ],
            // Université de Médecine de Marseille
            [
                'school_name' => 'Université de Médecine de Marseille',
                'programs' => [
                    [
                        'name' => 'Doctorat en Médecine',
                        'description' => 'Formation médicale complète menant au diplôme de docteur en médecine.',
                        'level' => 'phd',
                        'duration_months' => 72,
                        'tuition_fee' => 12000.00,
                        'currency' => 'EUR',
                        'requirements' => ['PACES validée', 'Concours médecine', 'Aptitudes médicales'],
                        'career_prospects' => ['Médecin généraliste', 'Spécialiste', 'Chercheur médical'],
                        'application_deadline' => '2024-07-15',
                        'start_date' => '2024-09-01',
                        'language_of_instruction' => 'Français',
                        'mode_of_study' => 'full-time',
                    ],
                    [
                        'name' => 'Master en Sciences Biomédicales',
                        'description' => 'Programme de recherche en sciences biomédicales et biotechnologies.',
                        'level' => 'master',
                        'duration_months' => 24,
                        'tuition_fee' => 6000.00,
                        'currency' => 'EUR',
                        'requirements' => ['Licence sciences', 'Projet de recherche', 'Entretien'],
                        'career_prospects' => ['Chercheur', 'Ingénieur biomédical', 'Consultant scientifique'],
                        'application_deadline' => '2024-06-01',
                        'start_date' => '2024-09-15',
                        'language_of_instruction' => 'Français/Anglais',
                        'mode_of_study' => 'full-time',
                    ]
                ]
            ],
            // École d'Architecture de Toulouse
            [
                'school_name' => 'École d\'Architecture de Toulouse',
                'programs' => [
                    [
                        'name' => 'Diplôme d\'Architecte',
                        'description' => 'Formation complète en architecture alliant créativité, technique et développement durable.',
                        'level' => 'master',
                        'duration_months' => 60,
                        'tuition_fee' => 9000.00,
                        'currency' => 'EUR',
                        'requirements' => ['Baccalauréat', 'Portfolio créatif', 'Épreuves artistiques'],
                        'career_prospects' => ['Architecte', 'Urbaniste', 'Designer d\'intérieur'],
                        'application_deadline' => '2024-05-30',
                        'start_date' => '2024-09-01',
                        'language_of_instruction' => 'Français',
                        'mode_of_study' => 'full-time',
                    ]
                ]
            ],
            // Institut Européen d'Administration des Affaires
            [
                'school_name' => 'Institut Européen d\'Administration des Affaires',
                'programs' => [
                    [
                        'name' => 'MBA Global Executive',
                        'description' => 'Programme MBA de niveau mondial pour dirigeants expérimentés.',
                        'level' => 'master',
                        'duration_months' => 17,
                        'tuition_fee' => 89000.00,
                        'currency' => 'EUR',
                        'requirements' => ['8+ ans expérience', 'GMAT 650+', 'Leadership prouvé'],
                        'career_prospects' => ['CEO', 'Directeur général', 'Consultant stratégique'],
                        'application_deadline' => '2024-04-15',
                        'start_date' => '2024-08-15',
                        'language_of_instruction' => 'Anglais',
                        'mode_of_study' => 'part-time',
                    ]
                ]
            ],
            // École Nationale des Beaux-Arts de Paris
            [
                'school_name' => 'École Nationale des Beaux-Arts de Paris',
                'programs' => [
                    [
                        'name' => 'Diplôme National Supérieur d\'Expression Plastique',
                        'description' => 'Formation artistique de haut niveau en arts plastiques et visuels.',
                        'level' => 'master',
                        'duration_months' => 60,
                        'tuition_fee' => 5000.00,
                        'currency' => 'EUR',
                        'requirements' => ['Portfolio artistique', 'Épreuves pratiques', 'Entretien créatif'],
                        'career_prospects' => ['Artiste', 'Professeur d\'art', 'Commissaire d\'exposition'],
                        'application_deadline' => '2024-03-31',
                        'start_date' => '2024-09-01',
                        'language_of_instruction' => 'Français',
                        'mode_of_study' => 'full-time',
                    ]
                ]
            ]
        ];

        foreach ($programs as $schoolPrograms) {
            $school = $schools->where('name', $schoolPrograms['school_name'])->first();
            
            if ($school) {
                foreach ($schoolPrograms['programs'] as $programData) {
                    Program::create(array_merge($programData, [
                        'school_id' => $school->id
                    ]));
                }
            }
        }
    }
}
