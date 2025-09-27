<?php $__env->startSection('title', 'Tableau de bord Admin - EduConnect'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Tableau de bord Admin</h1>
                    <p class="text-gray-600">Gestion de la plateforme EduConnect</p>
                </div>
                <div class="flex space-x-3">
                    <a href="<?php echo e(route('admin.schools.create')); ?>" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition duration-300">
                        <i class="fas fa-plus mr-2"></i>
                        Ajouter une école
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-university text-blue-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Écoles totales</p>
                        <p class="text-2xl font-semibold text-gray-900"><?php echo e($stats['total_schools']); ?></p>
                        <p class="text-sm text-green-600"><?php echo e($stats['active_schools']); ?> actives</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-file-alt text-yellow-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Candidatures totales</p>
                        <p class="text-2xl font-semibold text-gray-900"><?php echo e($stats['total_applications']); ?></p>
                        <p class="text-sm text-yellow-600"><?php echo e($stats['pending_applications']); ?> en attente</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-users text-green-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Étudiants inscrits</p>
                        <p class="text-2xl font-semibold text-gray-900"><?php echo e($stats['total_students']); ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-euro-sign text-purple-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Commissions totales</p>
                        <p class="text-2xl font-semibold text-gray-900"><?php echo e(number_format($stats['total_commission'], 0, ',', ' ')); ?> CFA</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Recent Applications -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-gray-900">Candidatures récentes</h2>
                            <a href="<?php echo e(route('admin.applications.index')); ?>" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                                Voir toutes
                            </a>
                        </div>
                    </div>
                    
                    <?php if($recentApplications->count() > 0): ?>
                        <div class="divide-y divide-gray-200">
                            <?php $__currentLoopData = $recentApplications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $application): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="px-6 py-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center mr-3">
                                                <i class="fas fa-user text-indigo-600"></i>
                                            </div>
                                            <div>
                                                <h3 class="text-sm font-medium text-gray-900">
                                                    <?php echo e($application->user->name); ?>

                                                </h3>
                                                <p class="text-sm text-gray-500">
                                                    <?php echo e($application->school->name); ?> - <?php echo e($application->field_of_study); ?>

                                                </p>
                                                <p class="text-xs text-gray-400">
                                                    <?php echo e($application->submitted_at->diffForHumans()); ?>

                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ml-4 flex items-center space-x-3">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($application->status_badge); ?>">
                                            <?php echo e($application->status_label); ?>

                                        </span>
                                        <a href="<?php echo e(route('admin.applications.show', $application)); ?>" 
                                           class="text-indigo-600 hover:text-indigo-800 text-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="px-6 py-12 text-center">
                            <i class="fas fa-file-alt text-4xl text-gray-300 mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune candidature</h3>
                            <p class="text-gray-500">Les nouvelles candidatures apparaîtront ici.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Quick Actions & Stats -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions rapides</h3>
                    <div class="space-y-3">
                        <a href="<?php echo e(route('admin.schools.create')); ?>" 
                           class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition duration-300 text-center block">
                            <i class="fas fa-plus mr-2"></i>
                            Ajouter une école
                        </a>
                        <a href="<?php echo e(route('admin.schools.index')); ?>" 
                           class="w-full bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition duration-300 text-center block">
                            <i class="fas fa-university mr-2"></i>
                            Gérer les écoles
                        </a>
                        <a href="<?php echo e(route('admin.applications.index')); ?>" 
                           class="w-full bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition duration-300 text-center block">
                            <i class="fas fa-file-alt mr-2"></i>
                            Gérer les candidatures
                        </a>
                    </div>
                </div>

                <!-- Application Status Breakdown -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Répartition des candidatures</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">En attente</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                <?php echo e($stats['pending_applications']); ?>

                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Total</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                <?php echo e($stats['total_applications']); ?>

                            </span>
                        </div>
                    </div>
                </div>

                <!-- System Info -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                    <h3 class="font-semibold text-blue-900 mb-2">
                        <i class="fas fa-info-circle mr-2"></i>
                        Informations système
                    </h3>
                    <div class="text-sm text-blue-800 space-y-1">
                        <p>Version: EduConnect v1.0</p>
                        <p>Dernière mise à jour: <?php echo e(now()->format('d/m/Y')); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\user\EduConnect\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>