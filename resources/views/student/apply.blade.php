@extends('layouts.app')

@section('title', 'Postuler à ' . $school->name . ' - EduConnect')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center">
                <a href="{{ route('schools.show', $school) }}" class="text-indigo-600 hover:text-indigo-800 mr-4">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Postuler à {{ $school->name }}</h1>
                    <p class="text-gray-600">{{ $school->city }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Application Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Formulaire de candidature</h2>
                    
                    <form method="POST" action="{{ route('student.apply', $school) }}" class="space-y-6">
                        @csrf
                        
                        <div>
                            <label for="field_of_study" class="block text-sm font-medium text-gray-700 mb-2">
                                Filière souhaitée <span class="text-red-500">*</span>
                            </label>
                            <select id="field_of_study" name="field_of_study" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('field_of_study') border-red-500 @enderror">
                                <option value="">Sélectionnez une filière</option>
                                @foreach($school->fields_of_study as $field)
                                    <option value="{{ $field }}" {{ old('field_of_study') == $field ? 'selected' : '' }}>
                                        {{ $field }}
                                    </option>
                                @endforeach
                            </select>
                            @error('field_of_study')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="diploma_level" class="block text-sm font-medium text-gray-700 mb-2">
                                Niveau de diplôme souhaité <span class="text-red-500">*</span>
                            </label>
                            <select id="diploma_level" name="diploma_level" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('diploma_level') border-red-500 @enderror">
                                <option value="">Sélectionnez un niveau</option>
                                @foreach($school->diplomas as $diploma)
                                    <option value="{{ $diploma }}" {{ old('diploma_level') == $diploma ? 'selected' : '' }}>
                                        {{ $diploma }}
                                    </option>
                                @endforeach
                            </select>
                            @error('diploma_level')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="motivation_letter" class="block text-sm font-medium text-gray-700 mb-2">
                                Lettre de motivation <span class="text-red-500">*</span>
                            </label>
                            <textarea id="motivation_letter" name="motivation_letter" rows="8" required
                                      placeholder="Expliquez pourquoi vous souhaitez intégrer cette école et cette filière. Parlez de vos motivations, vos objectifs professionnels et ce qui vous attire dans cette formation..."
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('motivation_letter') border-red-500 @enderror">{{ old('motivation_letter') }}</textarea>
                            <p class="mt-1 text-sm text-gray-500">Minimum 100 caractères</p>
                            @error('motivation_letter')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4">
                            <div class="flex">
                                <i class="fas fa-info-circle text-yellow-400 mt-0.5 mr-3"></i>
                                <div>
                                    <h3 class="text-sm font-medium text-yellow-800">Information importante</h3>
                                    <p class="mt-1 text-sm text-yellow-700">
                                        Une fois votre candidature soumise, vous pourrez suivre son évolution dans votre espace personnel. 
                                        L'équipe EduConnect traitera votre demande et vous tiendra informé des prochaines étapes.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-between items-center pt-6 border-t">
                            <a href="{{ route('schools.show', $school) }}" 
                               class="bg-gray-200 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-300 transition duration-300">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Retour
                            </a>
                            <button type="submit" 
                                    class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 transition duration-300">
                                <i class="fas fa-paper-plane mr-2"></i>
                                Soumettre ma candidature
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- School Info Sidebar -->
            <div class="space-y-6">
                <!-- School Summary -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-university text-indigo-600"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">{{ $school->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $school->city }}</p>
                        </div>
                    </div>
                    
                    <div class="space-y-3 text-sm">
                        @if($school->application_fee > 0)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Frais de dossier:</span>
                                <span class="font-medium">{{ number_format($school->application_fee, 0, ',', ' ') }} CFA</span>
                            </div>
                        @endif
                        
                        @if($school->next_intake)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Prochaine rentrée:</span>
                                <span class="font-medium">{{ $school->next_intake->format('d/m/Y') }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Application Process -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                    <h3 class="font-semibold text-blue-900 mb-3">
                        <i class="fas fa-info-circle mr-2"></i>
                        Processus de candidature
                    </h3>
                    <div class="space-y-3 text-sm text-blue-800">
                        <div class="flex items-start">
                            <div class="w-6 h-6 bg-blue-200 rounded-full flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                                <span class="text-xs font-medium">1</span>
                            </div>
                            <p>Soumission de votre candidature</p>
                        </div>
                        <div class="flex items-start">
                            <div class="w-6 h-6 bg-blue-200 rounded-full flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                                <span class="text-xs font-medium">2</span>
                            </div>
                            <p>Examen par l'équipe EduConnect</p>
                        </div>
                        <div class="flex items-start">
                            <div class="w-6 h-6 bg-blue-200 rounded-full flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                                <span class="text-xs font-medium">3</span>
                            </div>
                            <p>Transmission à l'école</p>
                        </div>
                        <div class="flex items-start">
                            <div class="w-6 h-6 bg-blue-200 rounded-full flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                                <span class="text-xs font-medium">4</span>
                            </div>
                            <p>Réponse de l'école</p>
                        </div>
                    </div>
                </div>

                <!-- Tips -->
                <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                    <h3 class="font-semibold text-green-900 mb-3">
                        <i class="fas fa-lightbulb mr-2"></i>
                        Conseils
                    </h3>
                    <ul class="space-y-2 text-sm text-green-800">
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-600 mr-2 mt-1 text-xs"></i>
                            Personnalisez votre lettre de motivation
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-600 mr-2 mt-1 text-xs"></i>
                            Mettez en avant vos expériences pertinentes
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-600 mr-2 mt-1 text-xs"></i>
                            Expliquez clairement vos objectifs
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Character counter for motivation letter
    const textarea = document.getElementById('motivation_letter');
    const counter = document.createElement('div');
    counter.className = 'text-sm text-gray-500 mt-1';
    textarea.parentNode.appendChild(counter);

    function updateCounter() {
        const length = textarea.value.length;
        counter.textContent = `${length} caractères (minimum 100)`;
        
        if (length < 100) {
            counter.className = 'text-sm text-red-500 mt-1';
        } else {
            counter.className = 'text-sm text-green-600 mt-1';
        }
    }

    textarea.addEventListener('input', updateCounter);
    updateCounter();
</script>
@endpush
@endsection
