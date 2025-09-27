<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'EduConnect - Plateforme éducative'); ?></title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="<?php echo e(route('home')); ?>" class="flex items-center">
                        <i class="fas fa-graduation-cap text-2xl text-indigo-600 mr-2"></i>
                        <span class="text-xl font-bold text-gray-900">EduConnect</span>
                    </a>
                </div>
                
                <div class="hidden md:flex items-center space-x-8">
                    <a href="<?php echo e(route('home')); ?>" class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium">
                        Accueil
                    </a>
                    <a href="<?php echo e(route('schools.index')); ?>" class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium">
                        Écoles
                    </a>
                    
                    <?php if(auth()->guard()->check()): ?>
                        <?php if(Auth::user()->isAdmin()): ?>
                            <a href="<?php echo e(route('admin.dashboard')); ?>" class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium">
                                <i class="fas fa-tachometer-alt mr-1"></i> Admin
                            </a>
                        <?php else: ?>
                            <a href="<?php echo e(route('dashboard')); ?>" class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium">
                                <i class="fas fa-user mr-1"></i> Mon espace
                            </a>
                        <?php endif; ?>
                        
                        <div class="relative group">
                            <button class="flex items-center text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium">
                                <?php echo e(Auth::user()->name); ?>

                                <i class="fas fa-chevron-down ml-1"></i>
                            </button>
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 hidden group-hover:block">
                                <?php if(Auth::user()->isStudent()): ?>
                                    <a href="<?php echo e(route('student.applications')); ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-file-alt mr-2"></i> Mes candidatures
                                    </a>
                                <?php endif; ?>
                                <form method="POST" action="<?php echo e(route('logout')); ?>" class="block">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Déconnexion
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium">
                            Connexion
                        </a>
                        <a href="<?php echo e(route('register')); ?>" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            Inscription
                        </a>
                    <?php endif; ?>
                </div>
                
                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button type="button" class="mobile-menu-button text-gray-700 hover:text-indigo-600 focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile menu -->
        <div class="mobile-menu hidden md:hidden">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white border-t">
                <a href="<?php echo e(route('home')); ?>" class="block px-3 py-2 text-gray-700 hover:text-indigo-600">Accueil</a>
                <a href="<?php echo e(route('schools.index')); ?>" class="block px-3 py-2 text-gray-700 hover:text-indigo-600">Écoles</a>
                <?php if(auth()->guard()->check()): ?>
                    <?php if(Auth::user()->isAdmin()): ?>
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="block px-3 py-2 text-gray-700 hover:text-indigo-600">Admin</a>
                    <?php else: ?>
                        <a href="<?php echo e(route('dashboard')); ?>" class="block px-3 py-2 text-gray-700 hover:text-indigo-600">Mon espace</a>
                        <a href="<?php echo e(route('student.applications')); ?>" class="block px-3 py-2 text-gray-700 hover:text-indigo-600">Mes candidatures</a>
                    <?php endif; ?>
                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="block w-full text-left px-3 py-2 text-gray-700 hover:text-indigo-600">Déconnexion</button>
                    </form>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="block px-3 py-2 text-gray-700 hover:text-indigo-600">Connexion</a>
                    <a href="<?php echo e(route('register')); ?>" class="block px-3 py-2 text-gray-700 hover:text-indigo-600">Inscription</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    <?php if(session('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mx-4 mt-4" role="alert">
            <span class="block sm:inline"><?php echo e(session('success')); ?></span>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mx-4 mt-4" role="alert">
            <span class="block sm:inline"><?php echo e(session('error')); ?></span>
        </div>
    <?php endif; ?>

    <?php if(session('info')): ?>
        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mx-4 mt-4" role="alert">
            <span class="block sm:inline"><?php echo e(session('info')); ?></span>
        </div>
    <?php endif; ?>

    <!-- Main Content -->
    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-16">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-graduation-cap text-2xl text-indigo-400 mr-2"></i>
                        <span class="text-xl font-bold">EduConnect</span>
                    </div>
                    <p class="text-gray-300 mb-4">
                        Votre plateforme de référence pour trouver l'école idéale et gérer vos candidatures en toute simplicité.
                    </p>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Liens utiles</h3>
                    <ul class="space-y-2">
                        <li><a href="<?php echo e(route('schools.index')); ?>" class="text-gray-300 hover:text-white">Rechercher une école</a></li>
                        <li><a href="<?php echo e(route('register')); ?>" class="text-gray-300 hover:text-white">Créer un compte</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">Aide</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Contact</h3>
                    <ul class="space-y-2 text-gray-300">
                        <li><i class="fas fa-envelope mr-2"></i> contact@educonnect.fr</li>
                        <li><i class="fas fa-phone mr-2"></i> +33 1 23 45 67 89</li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-300">
                <p>&copy; <?php echo e(date('Y')); ?> EduConnect. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script>
        // Mobile menu toggle
        document.querySelector('.mobile-menu-button').addEventListener('click', function() {
            document.querySelector('.mobile-menu').classList.toggle('hidden');
        });

        // Auto-hide flash messages
        setTimeout(function() {
            const alerts = document.querySelectorAll('[role="alert"]');
            alerts.forEach(function(alert) {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.remove();
                }, 500);
            });
        }, 5000);
    </script>
    
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\user\EduConnect\resources\views/layouts/app.blade.php ENDPATH**/ ?>