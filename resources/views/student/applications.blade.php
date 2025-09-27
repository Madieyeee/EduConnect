@extends('layouts.app')

@section('title', 'Mes candidatures - EduConnect')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Mes candidatures</h1>
                    <p class="text-gray-600">Suivez l'évolution de toutes vos candidatures</p>
                </div>
                <a href="{{ route('schools.index') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition duration-300">
                    <i class="fas fa-plus mr-2"></i>
                    Nouvelle candidature
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if($applications->count() > 0)
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">
                        {{ $applications->total() }} candidature(s) au total
                    </h2>
                </div>
                
                <div class="divide-y divide-gray-200">
                    @foreach($applications as $application)
                    <div class="px-6 py-6 hover:bg-gray-50 transition duration-150">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mr-4">
                                        <i class="fas fa-university text-indigo-600"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-gray-900">
                                            <a href="{{ route('student.applications.show', $application) }}" class="hover:text-indigo-600">
                                                {{ $application->school->name }}
                                            </a>
                                        </h3>
                                        <p class="text-sm text-gray-600">
                                            <i class="fas fa-map-marker-alt mr-1"></i>
                                            {{ $application->school->city }}
                                        </p>
                                        <div class="mt-2 flex flex-wrap gap-2">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $application->field_of_study }}
                                            </span>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                {{ $application->diploma_level }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="ml-6 flex flex-col items-end">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $application->status_badge }}">
                                    {{ $application->status_label }}
                                </span>
                                <p class="text-xs text-gray-500 mt-2">
                                    Soumise le {{ $application->submitted_at->format('d/m/Y') }}
                                </p>
                                @if($application->processed_at)
                                    <p class="text-xs text-gray-500">
                                        Traitée le {{ $application->processed_at->format('d/m/Y') }}
                                    </p>
                                @endif
                                <a href="{{ route('student.applications.show', $application) }}" 
                                   class="mt-3 bg-indigo-600 text-white px-4 py-1 rounded text-sm hover:bg-indigo-700 transition duration-300">
                                    Voir détails
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $applications->links() }}
            </div>
        @else
            <div class="bg-white rounded-lg shadow p-12 text-center">
                <i class="fas fa-file-alt text-6xl text-gray-300 mb-6"></i>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Aucune candidature</h3>
                <p class="text-gray-600 mb-8 max-w-md mx-auto">
                    Vous n'avez pas encore soumis de candidature. Commencez par rechercher une école qui vous intéresse.
                </p>
                <a href="{{ route('schools.index') }}" 
                   class="bg-indigo-600 text-white px-6 py-3 rounded-md hover:bg-indigo-700 transition duration-300">
                    <i class="fas fa-search mr-2"></i>
                    Rechercher une école
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
