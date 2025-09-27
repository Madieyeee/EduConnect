<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\School;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schools = [
            [
                'name' => 'École Supérieure de Commerce de Paris',
                'description' => 'Une école de commerce prestigieuse située au cœur de Paris, offrant des formations d\'excellence en management, finance et marketing. Reconnue pour ses programmes innovants et ses partenariats internationaux.',
                'address' => '79 Avenue de la République',
                'city' => 'Paris',
                'country' => 'France',
                'phone' => '+33144567890',
                'email' => 'contact@escp.fr',
                'website' => 'https://www.escp.fr',
                'established_year' => 1819,
                'accreditations' => ['AACSB', 'EQUIS', 'AMBA'],
                'facilities' => ['Bibliothèque', 'Laboratoires informatiques', 'Amphithéâtres', 'Cafétéria', 'Résidence étudiante'],
                'admission_requirements' => ['Baccalauréat', 'Test d\'aptitude', 'Entretien de motivation'],
                'application_fee' => 150.00,
                'latitude' => 48.8566,
                'longitude' => 2.3522,
            ],
            [
                'name' => 'Institut National des Sciences Appliquées de Lyon',
                'description' => 'Grande école d\'ingénieurs publique reconnue pour l\'excellence de ses formations en sciences et technologies. L\'INSA Lyon forme des ingénieurs polyvalents et innovants.',
                'address' => '20 Avenue Albert Einstein',
                'city' => 'Lyon',
                'country' => 'France',
                'phone' => '+33472438383',
                'email' => 'contact@insa-lyon.fr',
                'website' => 'https://www.insa-lyon.fr',
                'established_year' => 1957,
                'accreditations' => ['CTI', 'EUR-ACE'],
                'facilities' => ['Laboratoires de recherche', 'Fab Lab', 'Centre sportif', 'Résidences', 'Restaurant universitaire'],
                'admission_requirements' => ['Baccalauréat scientifique', 'Concours d\'entrée', 'Dossier scolaire'],
                'application_fee' => 100.00,
                'latitude' => 45.7640,
                'longitude' => 4.8357,
            ],
            [
                'name' => 'Université de Médecine de Marseille',
                'description' => 'Faculté de médecine de renommée internationale, offrant des formations complètes en sciences médicales et paramédicales. Centre d\'excellence en recherche médicale.',
                'address' => '27 Boulevard Jean Moulin',
                'city' => 'Marseille',
                'country' => 'France',
                'phone' => '+33491324567',
                'email' => 'contact@univ-amu.fr',
                'website' => 'https://www.univ-amu.fr',
                'established_year' => 1409,
                'accreditations' => ['LCME', 'WFME'],
                'facilities' => ['Hôpital universitaire', 'Laboratoires', 'Bibliothèque médicale', 'Amphithéâtres', 'Centre de simulation'],
                'admission_requirements' => ['Baccalauréat', 'PACES', 'Concours de médecine'],
                'application_fee' => 200.00,
                'latitude' => 43.2965,
                'longitude' => 5.3698,
            ],
            [
                'name' => 'École d\'Architecture de Toulouse',
                'description' => 'École nationale supérieure d\'architecture formant les futurs architectes. Programmes alliant créativité, technique et développement durable.',
                'address' => '83 Rue Aristide Maillol',
                'city' => 'Toulouse',
                'country' => 'France',
                'phone' => '+33561423456',
                'email' => 'contact@toulouse.archi.fr',
                'website' => 'https://www.toulouse.archi.fr',
                'established_year' => 1969,
                'accreditations' => ['HCERES'],
                'facilities' => ['Ateliers de projet', 'Laboratoire de construction', 'Bibliothèque', 'Fab Lab', 'Galerie d\'exposition'],
                'admission_requirements' => ['Baccalauréat', 'Portfolio', 'Entretien créatif'],
                'application_fee' => 120.00,
                'latitude' => 43.6047,
                'longitude' => 1.4442,
            ],
            [
                'name' => 'Institut Européen d\'Administration des Affaires',
                'description' => 'Business school internationale de premier plan, offrant des programmes MBA et Executive Education. Campus à Fontainebleau avec une perspective globale.',
                'address' => 'Boulevard de Constance',
                'city' => 'Fontainebleau',
                'country' => 'France',
                'phone' => '+33160724000',
                'email' => 'info@insead.edu',
                'website' => 'https://www.insead.edu',
                'established_year' => 1957,
                'accreditations' => ['AACSB', 'EQUIS', 'AMBA'],
                'facilities' => ['Bibliothèque', 'Centre de conférences', 'Résidence', 'Centre sportif', 'Restaurant'],
                'admission_requirements' => ['Diplôme universitaire', 'GMAT/GRE', 'Expérience professionnelle', 'Entretiens'],
                'application_fee' => 250.00,
                'latitude' => 48.4084,
                'longitude' => 2.7019,
            ],
            [
                'name' => 'École Nationale des Beaux-Arts de Paris',
                'description' => 'Institution prestigieuse dédiée à l\'enseignement artistique. Formation d\'artistes plasticiens de haut niveau dans un environnement créatif exceptionnel.',
                'address' => '14 Rue Bonaparte',
                'city' => 'Paris',
                'country' => 'France',
                'phone' => '+33142976767',
                'email' => 'contact@beauxartsparis.fr',
                'website' => 'https://www.beauxartsparis.fr',
                'established_year' => 1648,
                'accreditations' => ['HCERES'],
                'facilities' => ['Ateliers d\'art', 'Galeries', 'Bibliothèque d\'art', 'Fonderie', 'Laboratoire photo'],
                'admission_requirements' => ['Baccalauréat', 'Portfolio artistique', 'Épreuves pratiques', 'Entretien'],
                'application_fee' => 80.00,
                'latitude' => 48.8566,
                'longitude' => 2.3522,
            ],
            [
                'name' => 'Institut de Technologie de Grenoble',
                'description' => 'École d\'ingénieurs spécialisée dans les nouvelles technologies et l\'innovation. Formation d\'excellence en informatique, électronique et systèmes embarqués.',
                'address' => '46 Avenue Félix Viallet',
                'city' => 'Grenoble',
                'country' => 'France',
                'phone' => '+33476574000',
                'email' => 'contact@grenoble-inp.fr',
                'website' => 'https://www.grenoble-inp.fr',
                'established_year' => 1900,
                'accreditations' => ['CTI', 'EUR-ACE'],
                'facilities' => ['Laboratoires high-tech', 'Incubateur', 'Centre de calcul', 'Bibliothèque', 'Espaces de coworking'],
                'admission_requirements' => ['Baccalauréat scientifique', 'Concours', 'Dossier académique'],
                'application_fee' => 110.00,
                'latitude' => 45.1885,
                'longitude' => 5.7245,
            ],
            [
                'name' => 'École de Journalisme de Lille',
                'description' => 'École de référence en journalisme et communication. Formation complète aux métiers de l\'information dans un environnement professionnel.',
                'address' => '50 Rue Gauthier de Châtillon',
                'city' => 'Lille',
                'country' => 'France',
                'phone' => '+33320304050',
                'email' => 'contact@esj-lille.fr',
                'website' => 'https://www.esj-lille.fr',
                'established_year' => 1924,
                'accreditations' => ['HCERES'],
                'facilities' => ['Studios TV/Radio', 'Rédaction', 'Laboratoire multimédia', 'Bibliothèque', 'Auditorium'],
                'admission_requirements' => ['Baccalauréat', 'Culture générale', 'Épreuves écrites', 'Entretien'],
                'application_fee' => 90.00,
                'latitude' => 50.6292,
                'longitude' => 3.0573,
            ]
        ];

        foreach ($schools as $schoolData) {
            School::create($schoolData);
        }
    }
}
