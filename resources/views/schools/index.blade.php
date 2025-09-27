@extends('layouts.app')

@section('title', 'Rechercher une école - EduConnect')

@section('content')
<div class="bg-white">
    <!-- Search Header -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl md:text-4xl font-bold mb-4">Rechercher une école</h1>
            <p class="text-xl text-indigo-100">Trouvez l'établissement qui correspond à vos ambitions</p>
        </div>
    </div>

    <!-- Search Filters -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <form method="GET" action="{{ route('schools.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Recherche</label>
                        <input type="text" id="search" name="search" value="{{ request('search') }}" 
                               placeholder="Nom d'école, ville..." 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 mb-1">Ville</label>
                        <select id="city" name="city" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Toutes les villes</option>
                            @foreach($cities as $city)
                                <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>
                                    {{ $city }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label for="field" class="block text-sm font-medium text-gray-700 mb-1">Filière</label>
                        <select id="field" name="field" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Toutes les filières</option>
                            @foreach($allFields as $field)
                                <option value="{{ $field }}" {{ request('field') == $field ? 'selected' : '' }}>
                                    {{ $field }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label for="max_fee" class="block text-sm font-medium text-gray-700 mb-1">Prix max (CFA)</label>
                        <input type="number" id="max_fee" name="max_fee" value="{{ request('max_fee') }}" 
                               placeholder="Ex: 10000" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-3">
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 transition duration-300">
                        <i class="fas fa-search mr-2"></i>
                        Rechercher
                    </button>
                    <a href="{{ route('schools.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-300 transition duration-300 text-center">
                        <i class="fas fa-times mr-2"></i>
                        Effacer les filtres
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Results -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">
                {{ $schools->total() }} école(s) trouvée(s)
            </h2>
        </div>

        @if($schools->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($schools as $school)
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
                        
                        <div class="space-y-2 mb-4">
                            <div class="flex flex-wrap gap-1">
                                @foreach(array_slice($school->fields_of_study, 0, 2) as $field)
                                    <span class="bg-indigo-100 text-indigo-800 text-xs px-2 py-1 rounded">
                                        {{ $field }}
                                    </span>
                                @endforeach
                                @if(count($school->fields_of_study) > 2)
                                    <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded">
                                        +{{ count($school->fields_of_study) - 2 }}
                                    </span>
                                @endif
                            </div>
                            
                            @if($school->tuition_fee_range !== 'Non spécifié')
                                <p class="text-sm text-gray-600">
                                    <i class="fas fa-euro-sign mr-1"></i>
                                    {{ $school->tuition_fee_range }}
                                </p>
                            @endif
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">
                                {{ count($school->diplomas) }} diplôme(s)
                            </span>
                            <a href="{{ route('schools.show', $school) }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition duration-300">
                                Voir plus
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $schools->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-search text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucune école trouvée</h3>
                <p class="text-gray-600 mb-6">Essayez de modifier vos critères de recherche</p>
                <a href="{{ route('schools.index') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-md hover:bg-indigo-700 transition duration-300">
                    Voir toutes les écoles
                </a>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    // Auto-submit form on filter change
    document.querySelectorAll('#city, #field').forEach(function(select) {
        select.addEventListener('change', function() {
            this.form.submit();
        });
    });
</script>
@endpush
@endsection
