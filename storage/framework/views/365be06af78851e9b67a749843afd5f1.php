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
        <p>Généré le <?php echo e(date('d/m/Y à H:i')); ?></p>
    </div>

    <div class="stats">
        <h3>Statistiques</h3>
        <div class="stats-grid">
            <div class="stats-row">
                <div class="stats-cell">Total des écoles :</div>
                <div class="stats-cell"><?php echo e($schools->count()); ?></div>
                <div class="stats-cell">Écoles actives :</div>
                <div class="stats-cell"><?php echo e($schools->where('is_active', true)->count()); ?></div>
            </div>
            <div class="stats-row">
                <div class="stats-cell">Total candidatures :</div>
                <div class="stats-cell"><?php echo e($schools->sum(function($school) { return $school->applications->count(); })); ?></div>
                <div class="stats-cell">Écoles inactives :</div>
                <div class="stats-cell"><?php echo e($schools->where('is_active', false)->count()); ?></div>
            </div>
        </div>
    </div>

    <?php $__currentLoopData = $schools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $school): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($index > 0 && $index % 3 == 0): ?>
            <div class="page-break"></div>
        <?php endif; ?>
        
        <div class="school">
            <div class="school-header">
                <h2 class="school-name"><?php echo e($school->name); ?></h2>
                <div class="school-city"><?php echo e($school->city); ?>, Sénégal</div>
            </div>
            
            <div class="school-info">
                <div class="info-row">
                    <div class="info-label">Statut :</div>
                    <div class="info-value">
                        <span class="<?php echo e($school->is_active ? 'status-active' : 'status-inactive'); ?>">
                            <?php echo e($school->is_active ? 'Active' : 'Inactive'); ?>

                        </span>
                    </div>
                </div>
                
                <div class="info-row">
                    <div class="info-label">Adresse :</div>
                    <div class="info-value"><?php echo e($school->address); ?></div>
                </div>
                
                <?php if($school->phone): ?>
                <div class="info-row">
                    <div class="info-label">Téléphone :</div>
                    <div class="info-value"><?php echo e($school->phone); ?></div>
                </div>
                <?php endif; ?>
                
                <?php if($school->email): ?>
                <div class="info-row">
                    <div class="info-label">Email :</div>
                    <div class="info-value"><?php echo e($school->email); ?></div>
                </div>
                <?php endif; ?>
                
                <?php if($school->website): ?>
                <div class="info-row">
                    <div class="info-label">Site web :</div>
                    <div class="info-value"><?php echo e($school->website); ?></div>
                </div>
                <?php endif; ?>
                
                <div class="info-row">
                    <div class="info-label">Domaines d'études :</div>
                    <div class="info-value"><?php echo e(implode(', ', $school->fields_of_study ?? [])); ?></div>
                </div>
                
                <div class="info-row">
                    <div class="info-label">Diplômes :</div>
                    <div class="info-value"><?php echo e(implode(', ', $school->diplomas ?? [])); ?></div>
                </div>
                
                <div class="info-row">
                    <div class="info-label">Accréditations :</div>
                    <div class="info-value"><?php echo e(implode(', ', $school->accreditations ?? [])); ?></div>
                </div>
                
                <?php if($school->tuition_fee_min || $school->tuition_fee_max): ?>
                <div class="info-row">
                    <div class="info-label">Frais de scolarité :</div>
                    <div class="info-value">
                        <?php if($school->tuition_fee_min && $school->tuition_fee_max): ?>
                            <?php echo e(number_format($school->tuition_fee_min, 0, ',', ' ')); ?> - <?php echo e(number_format($school->tuition_fee_max, 0, ',', ' ')); ?> CFA
                        <?php elseif($school->tuition_fee_min): ?>
                            À partir de <?php echo e(number_format($school->tuition_fee_min, 0, ',', ' ')); ?> CFA
                        <?php elseif($school->tuition_fee_max): ?>
                            Jusqu'à <?php echo e(number_format($school->tuition_fee_max, 0, ',', ' ')); ?> CFA
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <div class="info-row">
                    <div class="info-label">Frais de dossier :</div>
                    <div class="info-value"><?php echo e(number_format($school->application_fee, 0, ',', ' ')); ?> CFA</div>
                </div>
                
                <div class="info-row">
                    <div class="info-label">Candidatures reçues :</div>
                    <div class="info-value"><?php echo e($school->applications->count()); ?></div>
                </div>
                
                <?php if($school->next_intake): ?>
                <div class="info-row">
                    <div class="info-label">Prochaine rentrée :</div>
                    <div class="info-value"><?php echo e(\Carbon\Carbon::parse($school->next_intake)->format('d/m/Y')); ?></div>
                </div>
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
<?php /**PATH C:\Users\user\EduConnect\resources\views/admin/exports/schools-pdf.blade.php ENDPATH**/ ?>