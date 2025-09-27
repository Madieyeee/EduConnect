<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Étudiants - EduConnect Sénégal</title>
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
        .student {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            background-color: #f9f9f9;
        }
        .student-header {
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }
        .student-name {
            font-size: 16px;
            font-weight: bold;
            color: #4F46E5;
            margin: 0 0 5px 0;
        }
        .student-email {
            color: #666;
            font-size: 14px;
        }
        .student-info {
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
        .applications {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
        }
        .applications h4 {
            margin: 0 0 10px 0;
            color: #4F46E5;
            font-size: 14px;
        }
        .application {
            background-color: #fff;
            border: 1px solid #e5e5e5;
            border-radius: 4px;
            padding: 10px;
            margin-bottom: 8px;
        }
        .application-school {
            font-weight: bold;
            color: #333;
        }
        .application-status {
            font-size: 11px;
            padding: 2px 6px;
            border-radius: 3px;
            color: white;
        }
        .status-submitted { background-color: #3B82F6; }
        .status-in_progress { background-color: #F59E0B; }
        .status-accepted { background-color: #10B981; }
        .status-rejected { background-color: #EF4444; }
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
        .no-applications {
            color: #666;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>EduConnect Sénégal</h1>
        <p>Liste des Étudiants Inscrits</p>
        <p>Généré le <?php echo e(date('d/m/Y à H:i')); ?></p>
    </div>

    <div class="stats">
        <h3>Statistiques</h3>
        <div class="stats-grid">
            <div class="stats-row">
                <div class="stats-cell">Total étudiants :</div>
                <div class="stats-cell"><?php echo e($students->count()); ?></div>
                <div class="stats-cell">Total candidatures :</div>
                <div class="stats-cell"><?php echo e($students->sum(function($student) { return $student->applications->count(); })); ?></div>
            </div>
            <div class="stats-row">
                <div class="stats-cell">Candidatures acceptées :</div>
                <div class="stats-cell"><?php echo e($students->flatMap->applications->where('status', 'accepted')->count()); ?></div>
                <div class="stats-cell">Candidatures en cours :</div>
                <div class="stats-cell"><?php echo e($students->flatMap->applications->where('status', 'in_progress')->count()); ?></div>
            </div>
        </div>
    </div>

    <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($index > 0 && $index % 4 == 0): ?>
            <div class="page-break"></div>
        <?php endif; ?>
        
        <div class="student">
            <div class="student-header">
                <h2 class="student-name"><?php echo e($student->name); ?></h2>
                <div class="student-email"><?php echo e($student->email); ?></div>
            </div>
            
            <div class="student-info">
                <?php if($student->phone): ?>
                <div class="info-row">
                    <div class="info-label">Téléphone :</div>
                    <div class="info-value"><?php echo e($student->phone); ?></div>
                </div>
                <?php endif; ?>
                
                <?php if($student->birth_date): ?>
                <div class="info-row">
                    <div class="info-label">Date de naissance :</div>
                    <div class="info-value"><?php echo e(\Carbon\Carbon::parse($student->birth_date)->format('d/m/Y')); ?></div>
                </div>
                <?php endif; ?>
                
                <?php if($student->address): ?>
                <div class="info-row">
                    <div class="info-label">Adresse :</div>
                    <div class="info-value"><?php echo e($student->address); ?></div>
                </div>
                <?php endif; ?>
                
                <?php if($student->city): ?>
                <div class="info-row">
                    <div class="info-label">Ville :</div>
                    <div class="info-value"><?php echo e($student->city); ?></div>
                </div>
                <?php endif; ?>
                
                <?php if($student->postal_code): ?>
                <div class="info-row">
                    <div class="info-label">Code postal :</div>
                    <div class="info-value"><?php echo e($student->postal_code); ?></div>
                </div>
                <?php endif; ?>
                
                <div class="info-row">
                    <div class="info-label">Pays :</div>
                    <div class="info-value"><?php echo e($student->country ?? 'Sénégal'); ?></div>
                </div>
                
                <div class="info-row">
                    <div class="info-label">Inscrit le :</div>
                    <div class="info-value"><?php echo e($student->created_at->format('d/m/Y à H:i')); ?></div>
                </div>
            </div>
            
            <div class="applications">
                <h4>Candidatures (<?php echo e($student->applications->count()); ?>)</h4>
                <?php if($student->applications->count() > 0): ?>
                    <?php $__currentLoopData = $student->applications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $application): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="application">
                            <div class="application-school"><?php echo e($application->school->name); ?></div>
                            <div style="margin-top: 5px;">
                                <span class="application-status status-<?php echo e($application->status); ?>">
                                    <?php switch($application->status):
                                        case ('submitted'): ?> Soumise <?php break; ?>
                                        <?php case ('in_progress'): ?> En cours <?php break; ?>
                                        <?php case ('accepted'): ?> Acceptée <?php break; ?>
                                        <?php case ('rejected'): ?> Rejetée <?php break; ?>
                                        <?php default: ?> <?php echo e($application->status); ?>

                                    <?php endswitch; ?>
                                </span>
                                <span style="margin-left: 10px; font-size: 11px; color: #666;">
                                    Domaine: <?php echo e($application->field_of_study); ?>

                                </span>
                                <span style="margin-left: 10px; font-size: 11px; color: #666;">
                                    Niveau: <?php echo e($application->diploma_level); ?>

                                </span>
                            </div>
                            <div style="margin-top: 5px; font-size: 11px; color: #666;">
                                Soumise le <?php echo e($application->submitted_at->format('d/m/Y')); ?>

                                <?php if($application->processed_at): ?>
                                    - Traitée le <?php echo e($application->processed_at->format('d/m/Y')); ?>

                                <?php endif; ?>
                            </div>
                            <?php if($application->commission_amount > 0): ?>
                                <div style="margin-top: 5px; font-size: 11px; color: #666;">
                                    Commission: <?php echo e(number_format($application->commission_amount, 0, ',', ' ')); ?> CFA
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <div class="no-applications">Aucune candidature soumise</div>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <div class="footer">
        <p>EduConnect Sénégal - Plateforme de référencement des écoles</p>
        <p>Document généré automatiquement le <?php echo e(date('d/m/Y à H:i')); ?></p>
    </div>
</body>
</html>
<?php /**PATH C:\Users\user\EduConnect\resources\views/admin/exports/students-pdf.blade.php ENDPATH**/ ?>