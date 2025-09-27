@extends('layouts.app')

@section('title', 'EduConnect - Trouvez votre école idéale')

@section('content')
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
                <a href="{{ route('schools.index') }}" class="bg-white text-indigo-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">
                    <i class="fas fa-search mr-2"></i>
                    Rechercher une école
                </a>
                @guest
                <a href="{{ route('register') }}" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-indigo-600 transition duration-300">
                    <i class="fas fa-user-plus mr-2"></i>
                    Créer un compte
                </a>
                @endguest
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

<!-- Featured Schools Section -->
@if($featuredSchools->count() > 0)
<div class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Écoles en vedette
            </h2>
            <p class="text-xl text-gray-600">
                Découvrez quelques-unes de nos écoles partenaires
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($featuredSchools as $school)
            <div class="bg-white rounded-lg shadow-md card-hover overflow-hidden">
                <div class="h-48 bg-gradient-to-r from-indigo-400 to-purple-500 flex items-center justify-center">
                    <i class="fas fa-university text-4xl text-white"></i>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-2">{{ $school->name }}</h3>
                    <p class="text-gray-600 mb-3">
                        <i class="fas fa-map-marker-alt mr-1"></i>
                        {{ $school->city }}
                    </p>
                    <p class="text-gray-700 mb-4 line-clamp-3">
                        {{ Str::limit($school->description, 120) }}
                    </p>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">
                            {{ count($school->fields_of_study) }} filière(s)
                        </span>
                        <a href="{{ route('schools.show', $school) }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition duration-300">
                            Voir plus
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-12">
            <a href="{{ route('schools.index') }}" class="bg-indigo-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition duration-300">
                Voir toutes les écoles
            </a>
        </div>
    </div>
</div>
@endif

<!-- CTA Section -->
<div class="bg-indigo-600 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">
            Prêt à commencer votre parcours ?
        </h2>
        <p class="text-xl mb-8 text-indigo-100">
            Rejoignez des milliers d'étudiants qui ont trouvé leur école idéale avec EduConnect
        </p>
        @guest
        <a href="{{ route('register') }}" class="bg-white text-indigo-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">
            <i class="fas fa-rocket mr-2"></i>
            Commencer maintenant
        </a>
        @else
        <a href="{{ route('schools.index') }}" class="bg-white text-indigo-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">
            <i class="fas fa-search mr-2"></i>
            Rechercher une école
        </a>
        @endguest
    </div>
</div>
@endsection
