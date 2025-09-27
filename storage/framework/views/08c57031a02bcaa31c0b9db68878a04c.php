<?php $__env->startSection('title', 'EduConnect - Trouvez votre école idéale'); ?>

<?php $__env->startSection('content'); ?>
<!-- Hero Section -->
<div class="gradient-bg text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">
                Trouvez votre école idéale
            </h1>
            <p class="text-xl md:text-2xl mb-8 text-indigo-100">
                EduConnect vous accompagne dans votre recherche d'établissement et simplifie vos candidatures
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="<?php echo e(route('schools.index')); ?>" class="bg-white text-indigo-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">
                    <i class="fas fa-search mr-2"></i>
                    Rechercher une école
                </a>
                <?php if(auth()->guard()->guest()): ?>
                <a href="<?php echo e(route('register')); ?>" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-indigo-600 transition duration-300">
                    <i class="fas fa-user-plus mr-2"></i>
                    Créer un compte
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Pourquoi choisir EduConnect ?
            </h2>
            <p class="text-xl text-gray-600">
                Une plateforme complète pour simplifier votre parcours éducatif
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center p-6">
                <div class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-search text-2xl text-indigo-600"></i>
                </div>
                <h3 class="text-xl font-semibold mb-3">Recherche avancée</h3>
                <p class="text-gray-600">
                    Filtrez par ville, filière, diplôme, prix et accréditations pour trouver l'école parfaite
                </p>
            </div>
            
            <div class="text-center p-6">
                <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-file-alt text-2xl text-green-600"></i>
                </div>
                <h3 class="text-xl font-semibold mb-3">Candidature simplifiée</h3>
                <p class="text-gray-600">
                    Postulez en ligne en quelques clics et suivez l'état de vos candidatures en temps réel
                </p>
            </div>
            
            <div class="text-center p-6">
                <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-chart-line text-2xl text-purple-600"></i>
                </div>
                <h3 class="text-xl font-semibold mb-3">Suivi personnalisé</h3>
                <p class="text-gray-600">
                    Tableau de bord personnel pour gérer toutes vos candidatures et communications
                </p>
            </div>
        </div>
    </div>
</div>

<!-- ISI Featured Section -->
<div class="py-16 bg-gradient-to-r from-blue-600 to-purple-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <div class="inline-flex items-center bg-yellow-400 text-yellow-900 px-4 py-2 rounded-full text-sm font-semibold mb-4">
                🏆 ÉCOLE VEDETTE
            </div>
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                Institut Supérieur d'Informatique (ISI)
            </h2>
            <p class="text-xl text-blue-100 max-w-3xl mx-auto">
                L'école de référence en informatique au Sénégal. Formation d'excellence en développement, cybersécurité, IA et data science.
            </p>
        </div>
        
        <div class="bg-white rounded-2xl shadow-2xl p-8 md:p-12">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Pourquoi choisir l'ISI ?</h3>
                    <ul class="space-y-3 mb-6">
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-3"></i>
                            <span>Taux d'insertion professionnelle de 95%</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-3"></i>
                            <span>Partenariats avec les grandes entreprises tech</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-3"></i>
                            <span>Formation pratique et projets réels</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-3"></i>
                            <span>Accréditations CAMES et CEDEAO</span>
                        </li>
                    </ul>
                    <div class="flex flex-wrap gap-2 mb-6">
                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">Génie Logiciel</span>
                        <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm">Cybersécurité</span>
                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">Intelligence Artificielle</span>
                        <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm">Data Science</span>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="<?php echo e(route('schools.show', 1)); ?>" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-300 text-center">
                            <i class="fas fa-info-circle mr-2"></i>En savoir plus
                        </a>
                        <a href="<?php echo e(route('student.apply', 1)); ?>" class="bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition duration-300 text-center">
                            <i class="fas fa-paper-plane mr-2"></i>Postuler maintenant
                        </a>
                    </div>
                </div>
                <div class="text-center">
                    <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl p-8 text-white">
                        <i class="fas fa-laptop-code text-6xl mb-4"></i>
                        <h4 class="text-xl font-bold mb-2">Frais de scolarité</h4>
                        <p class="text-3xl font-bold mb-2">600 000 - 1 500 000 CFA</p>
                        <p class="text-blue-100">Par année académique</p>
                        <div class="mt-4 pt-4 border-t border-blue-400">
                            <p class="text-sm">Frais de candidature: <strong>25 000 CFA</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Featured Schools Section -->
<?php if($featuredSchools->count() > 0): ?>
<div class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Autres écoles partenaires
            </h2>
            <p class="text-xl text-gray-600">
                Découvrez nos autres écoles d'excellence
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php $__currentLoopData = $featuredSchools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $school): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-white rounded-lg shadow-md card-hover overflow-hidden">
                <div class="h-48 bg-gradient-to-r from-indigo-400 to-purple-500 flex items-center justify-center">
                    <i class="fas fa-university text-4xl text-white"></i>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-2"><?php echo e($school->name); ?></h3>
                    <p class="text-gray-600 mb-3">
                        <i class="fas fa-map-marker-alt mr-1"></i>
                        <?php echo e($school->city); ?>

                    </p>
                    <p class="text-gray-700 mb-4 line-clamp-3">
                        <?php echo e(Str::limit($school->description, 120)); ?>

                    </p>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">
                            <?php echo e(count($school->fields_of_study)); ?> filière(s)
                        </span>
                        <a href="<?php echo e(route('schools.show', $school)); ?>" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition duration-300">
                            Voir plus
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        
        <div class="text-center mt-12">
            <a href="<?php echo e(route('schools.index')); ?>" class="bg-indigo-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition duration-300">
                Voir toutes les écoles
            </a>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- CTA Section -->
<div class="bg-indigo-600 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">
            Prêt à commencer votre parcours ?
        </h2>
        <p class="text-xl mb-8 text-indigo-100">
            Rejoignez des milliers d'étudiants qui ont trouvé leur école idéale avec EduConnect
        </p>
        <?php if(auth()->guard()->guest()): ?>
        <a href="<?php echo e(route('register')); ?>" class="bg-white text-indigo-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">
            <i class="fas fa-rocket mr-2"></i>
            Commencer maintenant
        </a>
        <?php else: ?>
        <a href="<?php echo e(route('schools.index')); ?>" class="bg-white text-indigo-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">
            <i class="fas fa-search mr-2"></i>
            Rechercher une école
        </a>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\user\EduConnect\resources\views/home.blade.php ENDPATH**/ ?>