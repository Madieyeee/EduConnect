@extends('layouts.app')

@section('title', 'Ajouter une école - Admin EduConnect')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center">
                <a href="{{ route('admin.schools.index') }}" class="text-indigo-600 hover:text-indigo-800 mr-4">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Ajouter une école</h1>
                    <p class="text-gray-600">Créer une nouvelle école partenaire</p>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-lg shadow p-6">
            <form method="POST" action="{{ route('admin.schools.store') }}" class="space-y-6">
                @csrf
                
                <!-- Basic Information -->
                <div class="border-b border-gray-200 pb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informations générales</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nom de l'école <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="name" name="name" required value="{{ old('name') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700 mb-2">
                                Ville <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="city" name="city" required value="{{ old('city') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('city') border-red-500 @enderror">
                            @error('city')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Description <span class="text-red-500">*</span>
                        </label>
                        <textarea id="description" name="description" rows="4" required
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Address Information -->
                <div class="border-b border-gray-200 pb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Adresse</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-2">
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                                Adresse <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="address" name="address" required value="{{ old('address') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('address') border-red-500 @enderror">
                            @error('address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-2">
                                Code postal <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="postal_code" name="postal_code" required value="{{ old('postal_code') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('postal_code') border-red-500 @enderror">
                            @error('postal_code')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="border-b border-gray-200 pb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Contact</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Téléphone</label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('phone') border-red-500 @enderror">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('email') border-red-500 @enderror">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="website" class="block text-sm font-medium text-gray-700 mb-2">Site web</label>
                            <input type="url" id="website" name="website" value="{{ old('website') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('website') border-red-500 @enderror">
                            @error('website')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Academic Information -->
                <div class="border-b border-gray-200 pb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informations académiques</h3>
                    
                    <div class="space-y-6">
                        <div>
                            <label for="fields_of_study" class="block text-sm font-medium text-gray-700 mb-2">
                                Filières d'étude <span class="text-red-500">*</span>
                            </label>
                            <div id="fields_container" class="space-y-2">
                                <div class="flex items-center space-x-2">
                                    <input type="text" name="fields_of_study[]" placeholder="Ex: Informatique"
                                           class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                    <button type="button" onclick="removeField(this)" class="text-red-600 hover:text-red-800">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <button type="button" onclick="addField('fields_container', 'fields_of_study[]', 'Ex: Management')" 
                                    class="mt-2 text-indigo-600 hover:text-indigo-800 text-sm">
                                <i class="fas fa-plus mr-1"></i> Ajouter une filière
                            </button>
                            @error('fields_of_study')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="diplomas" class="block text-sm font-medium text-gray-700 mb-2">
                                Diplômes proposés <span class="text-red-500">*</span>
                            </label>
                            <div id="diplomas_container" class="space-y-2">
                                <div class="flex items-center space-x-2">
                                    <input type="text" name="diplomas[]" placeholder="Ex: Bachelor"
                                           class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                    <button type="button" onclick="removeField(this)" class="text-red-600 hover:text-red-800">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <button type="button" onclick="addField('diplomas_container', 'diplomas[]', 'Ex: Master')" 
                                    class="mt-2 text-indigo-600 hover:text-indigo-800 text-sm">
                                <i class="fas fa-plus mr-1"></i> Ajouter un diplôme
                            </button>
                            @error('diplomas')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="accreditations" class="block text-sm font-medium text-gray-700 mb-2">
                                Accréditations <span class="text-red-500">*</span>
                            </label>
                            <div id="accreditations_container" class="space-y-2">
                                <div class="flex items-center space-x-2">
                                    <input type="text" name="accreditations[]" placeholder="Ex: AACSB"
                                           class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                    <button type="button" onclick="removeField(this)" class="text-red-600 hover:text-red-800">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <button type="button" onclick="addField('accreditations_container', 'accreditations[]', 'Ex: EQUIS')" 
                                    class="mt-2 text-indigo-600 hover:text-indigo-800 text-sm">
                                <i class="fas fa-plus mr-1"></i> Ajouter une accréditation
                            </button>
                            @error('accreditations')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Financial Information -->
                <div class="border-b border-gray-200 pb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informations financières</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="tuition_fee_min" class="block text-sm font-medium text-gray-700 mb-2">
                                Frais de scolarité min (CFA)
                            </label>
                            <input type="number" id="tuition_fee_min" name="tuition_fee_min" min="0" step="100" value="{{ old('tuition_fee_min') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('tuition_fee_min') border-red-500 @enderror">
                            @error('tuition_fee_min')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="tuition_fee_max" class="block text-sm font-medium text-gray-700 mb-2">
                                Frais de scolarité max (CFA)
                            </label>
                            <input type="number" id="tuition_fee_max" name="tuition_fee_max" min="0" step="100" value="{{ old('tuition_fee_max') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('tuition_fee_max') border-red-500 @enderror">
                            @error('tuition_fee_max')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="application_fee" class="block text-sm font-medium text-gray-700 mb-2">
                                Frais de dossier (CFA) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="application_fee" name="application_fee" min="0" step="10" required value="{{ old('application_fee', 0) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('application_fee') border-red-500 @enderror">
                            @error('application_fee')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Additional Information -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informations complémentaires</h3>
                    
                    <div class="space-y-6">
                        <div>
                            <label for="admission_requirements" class="block text-sm font-medium text-gray-700 mb-2">
                                Conditions d'admission
                            </label>
                            <textarea id="admission_requirements" name="admission_requirements" rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('admission_requirements') border-red-500 @enderror">{{ old('admission_requirements') }}</textarea>
                            @error('admission_requirements')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="next_intake" class="block text-sm font-medium text-gray-700 mb-2">
                                Prochaine rentrée
                            </label>
                            <input type="date" id="next_intake" name="next_intake" value="{{ old('next_intake') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('next_intake') border-red-500 @enderror">
                            @error('next_intake')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-between items-center pt-6 border-t">
                    <a href="{{ route('admin.schools.index') }}" 
                       class="bg-gray-200 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-300 transition duration-300">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Annuler
                    </a>
                    <button type="submit" 
                            class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 transition duration-300">
                        <i class="fas fa-save mr-2"></i>
                        Créer l'école
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function addField(containerId, fieldName, placeholder) {
        const container = document.getElementById(containerId);
        const div = document.createElement('div');
        div.className = 'flex items-center space-x-2';
        div.innerHTML = `
            <input type="text" name="${fieldName}" placeholder="${placeholder}"
                   class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            <button type="button" onclick="removeField(this)" class="text-red-600 hover:text-red-800">
                <i class="fas fa-times"></i>
            </button>
        `;
        container.appendChild(div);
    }

    function removeField(button) {
        const container = button.closest('.space-y-2');
        if (container.children.length > 1) {
            button.parentElement.remove();
        }
    }
</script>
@endpush
@endsection
