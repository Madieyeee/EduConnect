@extends('layouts.app')

@section('title', 'Candidature - ' . $application->user->name . ' - Admin EduConnect')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center">
                <a href="{{ route('admin.applications.index') }}" class="text-indigo-600 hover:text-indigo-800 mr-4">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div class="flex-1">
                    <h1 class="text-2xl font-bold text-gray-900">Candidature de {{ $application->user->name }}</h1>
                    <p class="text-gray-600">{{ $application->school->name }} - {{ $application->field_of_study }}</p>
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
                <!-- Student Information -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Informations de l'étudiant</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Nom complet</label>
                            <p class="text-lg font-medium text-gray-900">{{ $application->user->name }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Email</label>
                            <p class="text-lg font-medium text-gray-900">{{ $application->user->email }}</p>
                        </div>
                        
                        @if($application->user->phone)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Téléphone</label>
                            <p class="text-lg font-medium text-gray-900">{{ $application->user->phone }}</p>
                        </div>
                        @endif
                        
                        @if($application->user->city)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Ville</label>
                            <p class="text-lg font-medium text-gray-900">{{ $application->user->city }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Application Details -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Détails de la candidature</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">École</label>
                            <p class="text-lg font-medium text-gray-900">{{ $application->school->name }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Ville de l'école</label>
                            <p class="text-lg font-medium text-gray-900">{{ $application->school->city }}</p>
                        </div>
                        
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

                <!-- Status Update Form -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Mettre à jour le statut</h3>
                    
                    <form method="POST" action="{{ route('admin.applications.update-status', $application) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nouveau statut
                                </label>
                                <select id="status" name="status" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="submitted" {{ $application->status == 'submitted' ? 'selected' : '' }}>Soumise</option>
                                    <option value="in_progress" {{ $application->status == 'in_progress' ? 'selected' : '' }}>En cours</option>
                                    <option value="accepted" {{ $application->status == 'accepted' ? 'selected' : '' }}>Acceptée</option>
                                    <option value="rejected" {{ $application->status == 'rejected' ? 'selected' : '' }}>Rejetée</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <label for="admin_notes" class="block text-sm font-medium text-gray-700 mb-2">
                                Notes administratives
                            </label>
                            <textarea id="admin_notes" name="admin_notes" rows="4"
                                      placeholder="Ajoutez des notes sur cette candidature..."
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">{{ $application->admin_notes }}</textarea>
                        </div>
                        
                        <div class="mt-6">
                            <button type="submit" 
                                    class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 transition duration-300">
                                <i class="fas fa-save mr-2"></i>
                                Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions rapides</h3>
                    <div class="space-y-3">
                        @if($application->status === 'submitted')
                            <form method="POST" action="{{ route('admin.applications.update-status', $application) }}" class="w-full">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="in_progress">
                                <button type="submit" class="w-full bg-yellow-600 text-white px-4 py-2 rounded-md hover:bg-yellow-700 transition duration-300">
                                    <i class="fas fa-eye mr-2"></i>
                                    Marquer en cours
                                </button>
                            </form>
                        @endif
                        
                        @if(in_array($application->status, ['submitted', 'in_progress']))
                            <form method="POST" action="{{ route('admin.applications.update-status', $application) }}" class="w-full">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="accepted">
                                <button type="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition duration-300">
                                    <i class="fas fa-check mr-2"></i>
                                    Accepter
                                </button>
                            </form>
                            
                            <form method="POST" action="{{ route('admin.applications.update-status', $application) }}" class="w-full">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit" class="w-full bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition duration-300"
                                        onclick="return confirm('Êtes-vous sûr de vouloir rejeter cette candidature ?')">
                                    <i class="fas fa-times mr-2"></i>
                                    Rejeter
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <!-- Financial Info -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informations financières</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Commission EduConnect:</span>
                            <span class="font-medium">{{ number_format($application->commission_amount, 0, ',', ' ') }} CFA</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Statut paiement:</span>
                            @if($application->commission_paid)
                                <span class="text-green-600 font-medium">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Payée
                                </span>
                            @else
                                <span class="text-yellow-600 font-medium">
                                    <i class="fas fa-clock mr-1"></i>
                                    En attente
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

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
                    
                    <div class="space-y-2 text-sm">
                        @if($application->school->phone)
                            <div class="flex items-center">
                                <i class="fas fa-phone text-gray-400 w-4 mr-2"></i>
                                <span>{{ $application->school->phone }}</span>
                            </div>
                        @endif
                        @if($application->school->email)
                            <div class="flex items-center">
                                <i class="fas fa-envelope text-gray-400 w-4 mr-2"></i>
                                <span>{{ $application->school->email }}</span>
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

                <!-- Timeline -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Historique</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center">
                            <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                            <div>
                                <p class="font-medium">Candidature soumise</p>
                                <p class="text-gray-500">{{ $application->submitted_at->format('d/m/Y à H:i') }}</p>
                            </div>
                        </div>
                        
                        @if($application->processed_at)
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                                <div>
                                    <p class="font-medium">Candidature traitée</p>
                                    <p class="text-gray-500">{{ $application->processed_at->format('d/m/Y à H:i') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
