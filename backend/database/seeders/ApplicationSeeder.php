<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Application;
use App\Models\User;
use App\Models\Program;
use App\Models\School;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = User::where('role', 'student')->get();
        $programs = Program::with('school')->get();

        $sampleApplications = [
            [
                'personal_statement' => 'Je suis passionné par le management et souhaite développer mes compétences en gestion d\'entreprise. Mon expérience en stage m\'a permis de découvrir les enjeux du monde des affaires et je souhaite approfondir mes connaissances pour devenir un manager efficace et responsable.',
                'academic_background' => [
                    [
                        'institution' => 'Université Paris Dauphine',
                        'degree' => 'Licence Gestion',
                        'year' => 2023,
                        'grade' => 'Mention Bien'
                    ]
                ],
                'work_experience' => [
                    [
                        'company' => 'Société Générale',
                        'position' => 'Stagiaire Analyste',
                        'start_date' => '2023-06-01',
                        'end_date' => '2023-08-31',
                        'description' => 'Analyse financière et support aux équipes commerciales'
                    ]
                ],
                'references' => [
                    [
                        'name' => 'Dr. Martin Dubois',
                        'email' => 'martin.dubois@dauphine.fr',
                        'phone' => '+33123456789',
                        'relationship' => 'Professeur'
                    ]
                ],
                'status' => 'submitted'
            ],
            [
                'personal_statement' => 'Diplômé en informatique, je souhaite me spécialiser dans l\'intelligence artificielle et les systèmes embarqués. L\'INSA Lyon représente pour moi l\'opportunité idéale de combiner excellence académique et innovation technologique.',
                'academic_background' => [
                    [
                        'institution' => 'IUT Lyon 1',
                        'degree' => 'DUT Informatique',
                        'year' => 2022,
                        'grade' => 'Mention Très Bien'
                    ]
                ],
                'work_experience' => [],
                'references' => [
                    [
                        'name' => 'Prof. Sophie Laurent',
                        'email' => 'sophie.laurent@univ-lyon1.fr',
                        'phone' => '+33478945612',
                        'relationship' => 'Directrice de département'
                    ]
                ],
                'status' => 'in_progress'
            ],
            [
                'personal_statement' => 'Ma vocation médicale s\'est affirmée lors de mes études scientifiques. Je souhaite contribuer à l\'amélioration de la santé publique et me spécialiser en médecine d\'urgence. L\'université de Marseille offre un cadre d\'excellence pour cette formation.',
                'academic_background' => [
                    [
                        'institution' => 'Lycée Thiers Marseille',
                        'degree' => 'Baccalauréat S',
                        'year' => 2023,
                        'grade' => 'Mention Très Bien'
                    ]
                ],
                'work_experience' => [
                    [
                        'company' => 'Hôpital de la Timone',
                        'position' => 'Bénévole',
                        'start_date' => '2023-01-01',
                        'end_date' => '2023-12-31',
                        'description' => 'Accompagnement des patients et soutien aux équipes soignantes'
                    ]
                ],
                'references' => [
                    [
                        'name' => 'Dr. Claire Moreau',
                        'email' => 'claire.moreau@ap-hm.fr',
                        'phone' => '+33491385678',
                        'relationship' => 'Chef de service'
                    ]
                ],
                'status' => 'accepted'
            ]
        ];

        // Create applications for the first few students
        foreach ($students->take(10) as $index => $student) {
            // Each student applies to 1-3 programs
            $studentPrograms = $programs->random(rand(1, 3));
            
            foreach ($studentPrograms as $program) {
                $applicationData = $sampleApplications[$index % count($sampleApplications)];
                
                Application::create([
                    'user_id' => $student->id,
                    'school_id' => $program->school->id,
                    'program_id' => $program->id,
                    'personal_statement' => $applicationData['personal_statement'],
                    'academic_background' => $applicationData['academic_background'],
                    'work_experience' => $applicationData['work_experience'],
                    'references' => $applicationData['references'],
                    'application_fee' => $program->school->application_fee,
                    'status' => $applicationData['status'],
                    'payment_status' => 'paid',
                    'submitted_at' => now()->subDays(rand(1, 30)),
                    'reviewed_at' => in_array($applicationData['status'], ['in_progress', 'accepted', 'rejected']) 
                        ? now()->subDays(rand(1, 15)) : null,
                    'decision_date' => in_array($applicationData['status'], ['accepted', 'rejected']) 
                        ? now()->subDays(rand(1, 7)) : null,
                ]);
            }
        }

        // Create some additional random applications with different statuses
        $remainingStudents = $students->skip(10);
        $statuses = ['submitted', 'in_progress', 'accepted', 'rejected'];
        
        foreach ($remainingStudents as $student) {
            if (rand(1, 100) <= 70) { // 70% chance of having an application
                $program = $programs->random();
                $status = $statuses[array_rand($statuses)];
                
                Application::create([
                    'user_id' => $student->id,
                    'school_id' => $program->school->id,
                    'program_id' => $program->id,
                    'personal_statement' => 'Lettre de motivation générée automatiquement pour les tests. Cette candidature démontre mon intérêt pour le programme et ma motivation à rejoindre votre établissement.',
                    'academic_background' => [
                        [
                            'institution' => 'Université de Test',
                            'degree' => 'Licence',
                            'year' => 2023,
                            'grade' => 'Mention Assez Bien'
                        ]
                    ],
                    'work_experience' => [],
                    'references' => [],
                    'application_fee' => $program->school->application_fee,
                    'status' => $status,
                    'payment_status' => rand(1, 100) <= 80 ? 'paid' : 'pending',
                    'submitted_at' => now()->subDays(rand(1, 60)),
                    'reviewed_at' => in_array($status, ['in_progress', 'accepted', 'rejected']) 
                        ? now()->subDays(rand(1, 30)) : null,
                    'decision_date' => in_array($status, ['accepted', 'rejected']) 
                        ? now()->subDays(rand(1, 15)) : null,
                    'admin_notes' => $status === 'rejected' ? 'Dossier incomplet' : null,
                    'rejection_reason' => $status === 'rejected' ? 'Critères d\'admission non remplis' : null,
                ]);
            }
        }
    }
}
