<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Écoles - EduConnect Sénégal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #4F46E5;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #4F46E5;
            margin: 0 0 10px 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .school {
            margin-bottom: 25px;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            background-color: #f9f9f9;
        }
        .school-header {
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }
        .school-name {
            font-size: 16px;
            font-weight: bold;
            color: #4F46E5;
            margin: 0 0 5px 0;
        }
        .school-city {
            color: #666;
            font-size: 14px;
        }
        .school-info {
            display: table;
            width: 100%;
        }
        .info-row {
            display: table-row;
        }
        .info-label {
            display: table-cell;
            font-weight: bold;
            width: 150px;
            padding: 3px 10px 3px 0;
            vertical-align: top;
        }
        .info-value {
            display: table-cell;
            padding: 3px 0;
            vertical-align: top;
        }
        .status-active {
            color: #059669;
            font-weight: bold;
        }
        .status-inactive {
            color: #DC2626;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .stats {
            background-color: #EEF2FF;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .stats h3 {
            margin: 0 0 10px 0;
            color: #4F46E5;
        }
        .stats-grid {
            display: table;
            width: 100%;
        }
        .stats-row {
            display: table-row;
        }
        .stats-cell {
            display: table-cell;
            padding: 5px 15px 5px 0;
            font-weight: bold;
        }
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>EduConnect Sénégal</h1>
        <p>Liste des Écoles Partenaires</p>
        <p>Généré le {{ date('d/m/Y à H:i') }}</p>
    </div>

    <div class="stats">
        <h3>Statistiques</h3>
        <div class="stats-grid">
            <div class="stats-row">
                <div class="stats-cell">Total des écoles :</div>
                <div class="stats-cell">{{ $schools->count() }}</div>
                <div class="stats-cell">Écoles actives :</div>
                <div class="stats-cell">{{ $schools->where('is_active', true)->count() }}</div>
            </div>
            <div class="stats-row">
                <div class="stats-cell">Total candidatures :</div>
                <div class="stats-cell">{{ $schools->sum(function($school) { return $school->applications->count(); }) }}</div>
                <div class="stats-cell">Écoles inactives :</div>
                <div class="stats-cell">{{ $schools->where('is_active', false)->count() }}</div>
            </div>
        </div>
    </div>

    @foreach($schools as $index => $school)
        @if($index > 0 && $index % 3 == 0)
            <div class="page-break"></div>
        @endif
        
        <div class="school">
            <div class="school-header">
                <h2 class="school-name">{{ $school->name }}</h2>
                <div class="school-city">{{ $school->city }}, Sénégal</div>
            </div>
            
            <div class="school-info">
                <div class="info-row">
                    <div class="info-label">Statut :</div>
                    <div class="info-value">
                        <span class="{{ $school->is_active ? 'status-active' : 'status-inactive' }}">
                            {{ $school->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
                
                <div class="info-row">
                    <div class="info-label">Adresse :</div>
                    <div class="info-value">{{ $school->address }}</div>
                </div>
                
                @if($school->phone)
                <div class="info-row">
                    <div class="info-label">Téléphone :</div>
                    <div class="info-value">{{ $school->phone }}</div>
                </div>
                @endif
                
                @if($school->email)
                <div class="info-row">
                    <div class="info-label">Email :</div>
                    <div class="info-value">{{ $school->email }}</div>
                </div>
                @endif
                
                @if($school->website)
                <div class="info-row">
                    <div class="info-label">Site web :</div>
                    <div class="info-value">{{ $school->website }}</div>
                </div>
                @endif
                
                <div class="info-row">
                    <div class="info-label">Domaines d'études :</div>
                    <div class="info-value">{{ implode(', ', $school->fields_of_study ?? []) }}</div>
                </div>
                
                <div class="info-row">
                    <div class="info-label">Diplômes :</div>
                    <div class="info-value">{{ implode(', ', $school->diplomas ?? []) }}</div>
                </div>
                
                <div class="info-row">
                    <div class="info-label">Accréditations :</div>
                    <div class="info-value">{{ implode(', ', $school->accreditations ?? []) }}</div>
                </div>
                
                @if($school->tuition_fee_min || $school->tuition_fee_max)
                <div class="info-row">
                    <div class="info-label">Frais de scolarité :</div>
                    <div class="info-value">
                        @if($school->tuition_fee_min && $school->tuition_fee_max)
                            {{ number_format($school->tuition_fee_min, 0, ',', ' ') }} - {{ number_format($school->tuition_fee_max, 0, ',', ' ') }} CFA
                        @elseif($school->tuition_fee_min)
                            À partir de {{ number_format($school->tuition_fee_min, 0, ',', ' ') }} CFA
                        @elseif($school->tuition_fee_max)
                            Jusqu'à {{ number_format($school->tuition_fee_max, 0, ',', ' ') }} CFA
                        @endif
                    </div>
                </div>
                @endif
                
                <div class="info-row">
                    <div class="info-label">Frais de dossier :</div>
                    <div class="info-value">{{ number_format($school->application_fee, 0, ',', ' ') }} CFA</div>
                </div>
                
                <div class="info-row">
                    <div class="info-label">Candidatures reçues :</div>
                    <div class="info-value">{{ $school->applications->count() }}</div>
                </div>
                
                @if($school->next_intake)
                <div class="info-row">
                    <div class="info-label">Prochaine rentrée :</div>
                    <div class="info-value">{{ \Carbon\Carbon::parse($school->next_intake)->format('d/m/Y') }}</div>
                </div>
                @endif
            </div>
        </div>
    @endforeach

    <div class="footer">
        <p>EduConnect Sénégal - Plateforme de référencement des écoles</p>
        <p>Document généré automatiquement le {{ date('d/m/Y à H:i') }}</p>
    </div>
</body>
</html>
