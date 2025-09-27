@extends('layouts.app')

@section('title', 'Candidature - ' . $application->school->name . ' - EduConnect')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center">
                <a href="{{ route('student.applications') }}" class="text-indigo-600 hover:text-indigo-800 mr-4">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div class="flex-1">
                    <h1 class="text-2xl font-bold text-gray-900">Candidature - {{ $application->school->name }}</h1>
                    <p class="text-gray-600">{{ $application->school->city }}</p>
                </div>
                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium {{ $application->status_badge }}">
                    {{ $application->status_label }}
                </span>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Application Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Application Info -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Détails de la candidature</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Filière souhaitée</label>
                            <p class="text-lg font-medium text-gray-900">{{ $application->field_of_study }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Niveau de diplôme</label>
                            <p class="text-lg font-medium text-gray-900">{{ $application->diploma_level }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Date de soumission</label>
                            <p class="text-lg font-medium text-gray-900">{{ $application->submitted_at->format('d/m/Y à H:i') }}</p>
                        </div>
                        
                        @if($application->processed_at)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Date de traitement</label>
                            <p class="text-lg font-medium text-gray-900">{{ $application->processed_at->format('d/m/Y à H:i') }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Motivation Letter -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Lettre de motivation</h3>
                    <div class="prose max-w-none">
                        <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-indigo-500">
                            {!! nl2br(e($application->motivation_letter)) !!}
                        </div>
                    </div>
                </div>

                <!-- Admin Notes -->
                @if($application->admin_notes)
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-comment-alt mr-2 text-blue-600"></i>
                        Notes de l'équipe EduConnect
                    </h3>
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <p class="text-blue-800">{!! nl2br(e($application->admin_notes)) !!}</p>
                    </div>
                </div>
                @endif

                <!-- Status Timeline -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Suivi de la candidature</h3>
                    
                    <div class="flow-root">
                        <ul class="-mb-8">
                            <li>
                                <div class="relative pb-8">
                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white">
                                                <i class="fas fa-check text-white text-sm"></i>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm text-gray-500">Candidature soumise</p>
                                            </div>
                                            <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                {{ $application->submitted_at->format('d/m/Y à H:i') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            
                            @if(in_array($application->status, ['in_progress', 'accepted', 'rejected']))
                            <li>
                                <div class="relative pb-8">
                                    @if(in_array($application->status, ['accepted', 'rejected']))
                                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                    @endif
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center ring-8 ring-white">
                                                <i class="fas fa-eye text-white text-sm"></i>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm text-gray-500">Candidature en cours d'examen</p>
                                            </div>
                                            <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                @if($application->processed_at)
                                                    {{ $application->processed_at->format('d/m/Y à H:i') }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endif
                            
                            @if(in_array($application->status, ['accepted', 'rejected']))
                            <li>
                                <div class="relative">
                                    <div class="relative flex space-x-3">
                                        <div>
                                            @if($application->status === 'accepted')
                                                <span class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white">
                                                    <i class="fas fa-check text-white text-sm"></i>
                                                </span>
                                            @else
                                                <span class="h-8 w-8 rounded-full bg-red-500 flex items-center justify-center ring-8 ring-white">
                                                    <i class="fas fa-times text-white text-sm"></i>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm text-gray-500">
                                                    Candidature {{ $application->status === 'accepted' ? 'acceptée' : 'rejetée' }}
                                                </p>
                                            </div>
                                            <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                @if($application->processed_at)
                                                    {{ $application->processed_at->format('d/m/Y à H:i') }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- School Info -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">École</h3>
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-university text-indigo-600"></i>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900">{{ $application->school->name }}</h4>
                            <p class="text-sm text-gray-500">{{ $application->school->city }}</p>
                        </div>
                    </div>
                    
                    <div class="space-y-3 text-sm">
                        @if($application->commission_amount > 0)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Frais de dossier:</span>
                                <span class="font-medium">{{ number_format($application->commission_amount, 0, ',', ' ') }} CFA</span>
                            </div>
                        @endif
                    </div>
                    
                    <div class="mt-4">
                        <a href="{{ route('schools.show', $application->school) }}" 
                           class="w-full bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition duration-300 text-center block">
                            <i class="fas fa-eye mr-2"></i>
                            Voir l'école
                        </a>
                    </div>
                </div>

                <!-- Status Info -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Statut actuel</h3>
                    <div class="text-center">
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-lg font-medium {{ $application->status_badge }}">
                            {{ $application->status_label }}
                        </span>
                        
                        <div class="mt-4 text-sm text-gray-600">
                            @switch($application->status)
                                @case('submitted')
                                    <p>Votre candidature a été soumise avec succès. Elle sera bientôt examinée par notre équipe.</p>
                                    @break
                                @case('in_progress')
                                    <p>Votre candidature est actuellement en cours d'examen. Nous vous tiendrons informé de l'évolution.</p>
                                    @break
                                @case('accepted')
                                    <p>Félicitations ! Votre candidature a été acceptée. Vous devriez recevoir plus d'informations prochainement.</p>
                                    @break
                                @case('rejected')
                                    <p>Malheureusement, votre candidature n'a pas été retenue cette fois-ci. N'hésitez pas à postuler à d'autres écoles.</p>
                                    @break
                            @endswitch
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                @if($application->status === 'rejected')
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                    <h3 class="font-semibold text-blue-900 mb-2">
                        <i class="fas fa-lightbulb mr-2"></i>
                        Que faire maintenant ?
                    </h3>
                    <p class="text-sm text-blue-700 mb-4">
                        Ne vous découragez pas ! Explorez d'autres écoles qui pourraient correspondre à votre profil.
                    </p>
                    <a href="{{ route('schools.index') }}" 
                       class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-300 text-center block">
                        <i class="fas fa-search mr-2"></i>
                        Rechercher d'autres écoles
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
