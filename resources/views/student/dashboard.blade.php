@extends('layouts.app')

@section('title', 'Mon espace étudiant - EduConnect')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Bonjour, {{ Auth::user()->name }}</h1>
                    <p class="text-gray-600">Bienvenue dans votre espace personnel</p>
                </div>
                <a href="{{ route('schools.index') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition duration-300">
                    <i class="fas fa-search mr-2"></i>
                    Rechercher une école
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-file-alt text-blue-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total candidatures</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['total'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-clock text-yellow-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">En attente</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['pending'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-check text-green-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Acceptées</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['accepted'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-times text-red-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Rejetées</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['rejected'] }}</p>
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
                            <h2 class="text-lg font-semibold text-gray-900">Mes candidatures récentes</h2>
                            <a href="{{ route('student.applications') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                                Voir toutes
                            </a>
                        </div>
                    </div>
                    
                    @if($applications->count() > 0)
                        <div class="divide-y divide-gray-200">
                            @foreach($applications->take(5) as $application)
                            <div class="px-6 py-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <h3 class="text-sm font-medium text-gray-900">
                                            <a href="{{ route('student.applications.show', $application) }}" class="hover:text-indigo-600">
                                                {{ $application->school->name }}
                                            </a>
                                        </h3>
                                        <p class="text-sm text-gray-500">{{ $application->field_of_study }} - {{ $application->diploma_level }}</p>
                                        <p class="text-xs text-gray-400 mt-1">
                                            Soumise le {{ $application->submitted_at->format('d/m/Y à H:i') }}
                                        </p>
                                    </div>
                                    <div class="ml-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $application->status_badge }}">
                                            {{ $application->status_label }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="px-6 py-12 text-center">
                            <i class="fas fa-file-alt text-4xl text-gray-300 mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune candidature</h3>
                            <p class="text-gray-500 mb-6">Vous n'avez pas encore soumis de candidature.</p>
                            <a href="{{ route('schools.index') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition duration-300">
                                <i class="fas fa-search mr-2"></i>
                                Rechercher une école
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions & Profile -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions rapides</h3>
                    <div class="space-y-3">
                        <a href="{{ route('schools.index') }}" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition duration-300 text-center block">
                            <i class="fas fa-search mr-2"></i>
                            Rechercher une école
                        </a>
                        <a href="{{ route('student.applications') }}" class="w-full bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition duration-300 text-center block">
                            <i class="fas fa-file-alt mr-2"></i>
                            Mes candidatures
                        </a>
                    </div>
                </div>

                <!-- Profile Summary -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Mon profil</h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-500">Nom</p>
                            <p class="font-medium">{{ Auth::user()->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Email</p>
                            <p class="font-medium">{{ Auth::user()->email }}</p>
                        </div>
                        @if(Auth::user()->city)
                        <div>
                            <p class="text-sm text-gray-500">Ville</p>
                            <p class="font-medium">{{ Auth::user()->city }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Tips -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-blue-900 mb-2">
                        <i class="fas fa-lightbulb mr-2"></i>
                        Conseil
                    </h3>
                    <p class="text-sm text-blue-700">
                        Personnalisez votre lettre de motivation pour chaque école afin d'augmenter vos chances d'acceptation.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
