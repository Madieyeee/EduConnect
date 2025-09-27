@extends('layouts.app')

@section('title', $school->name . ' - EduConnect')

@section('content')
<div class="bg-white">
    <!-- School Header -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                <div class="w-24 h-24 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-university text-3xl text-white"></i>
                </div>
                <div class="flex-1">
                    <h1 class="text-3xl md:text-4xl font-bold mb-2">{{ $school->name }}</h1>
                    <p class="text-xl text-indigo-100 mb-4">
                        <i class="fas fa-map-marker-alt mr-2"></i>
                        {{ $school->address }}, {{ $school->city }} {{ $school->postal_code }}
                    </p>
                    <div class="flex flex-wrap gap-4 text-sm">
                        @if($school->phone)
                            <span><i class="fas fa-phone mr-1"></i> {{ $school->phone }}</span>
                        @endif
                        @if($school->email)
                            <span><i class="fas fa-envelope mr-1"></i> {{ $school->email }}</span>
                        @endif
                        @if($school->website)
                            <a href="{{ $school->website }}" target="_blank" class="hover:text-indigo-200">
                                <i class="fas fa-globe mr-1"></i> Site web
                            </a>
                        @endif
                    </div>
                </div>
                @auth
                    @if(Auth::user()->isStudent())
                        <div>
                            <a href="{{ route('student.apply', $school) }}" 
                               class="bg-white text-indigo-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">
                                <i class="fas fa-paper-plane mr-2"></i>
                                Postuler maintenant
                            </a>
                        </div>
                    @endif
                @else
                    <div>
                        <a href="{{ route('register') }}" 
                           class="bg-white text-indigo-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">
                            <i class="fas fa-user-plus mr-2"></i>
                            S'inscrire pour postuler
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>

    <!-- School Details -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Description -->
                <div class="bg-white rounded-lg shadow-sm border p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">À propos de l'école</h2>
                    <div class="prose max-w-none text-gray-700">
                        {!! nl2br(e($school->description)) !!}
                    </div>
                </div>

                <!-- Fields of Study -->
                <div class="bg-white rounded-lg shadow-sm border p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Filières d'étude</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @foreach($school->fields_of_study as $field)
                            <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-3">
                                <i class="fas fa-book text-indigo-600 mr-2"></i>
                                {{ $field }}
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Diplomas -->
                <div class="bg-white rounded-lg shadow-sm border p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Diplômes proposés</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @foreach($school->diplomas as $diploma)
                            <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                                <i class="fas fa-certificate text-green-600 mr-2"></i>
                                {{ $diploma }}
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Accreditations -->
                @if(count($school->accreditations) > 0)
                <div class="bg-white rounded-lg shadow-sm border p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Accréditations</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @foreach($school->accreditations as $accreditation)
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                                <i class="fas fa-award text-yellow-600 mr-2"></i>
                                {{ $accreditation }}
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Admission Requirements -->
                @if($school->admission_requirements)
                <div class="bg-white rounded-lg shadow-sm border p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Conditions d'admission</h2>
                    <div class="prose max-w-none text-gray-700">
                        {!! nl2br(e($school->admission_requirements)) !!}
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Quick Info -->
                <div class="bg-white rounded-lg shadow-sm border p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informations pratiques</h3>
                    <div class="space-y-3">
                        @if($school->tuition_fee_range !== 'Non spécifié')
                            <div class="flex items-center">
                                <i class="fas fa-euro-sign text-gray-400 w-5"></i>
                                <span class="ml-3 text-sm text-gray-600">Frais de scolarité</span>
                            </div>
                            <p class="ml-8 text-sm font-medium text-gray-900">{{ $school->tuition_fee_range }}</p>
                        @endif

                        @if($school->application_fee > 0)
                            <div class="flex items-center">
                                <i class="fas fa-file-invoice text-gray-400 w-5"></i>
                                <span class="ml-3 text-sm text-gray-600">Frais de dossier</span>
                            </div>
                            <p class="ml-8 text-sm font-medium text-gray-900">{{ number_format($school->application_fee, 0, ',', ' ') }} CFA</p>
                        @endif

                        @if($school->next_intake)
                            <div class="flex items-center">
                                <i class="fas fa-calendar text-gray-400 w-5"></i>
                                <span class="ml-3 text-sm text-gray-600">Prochaine rentrée</span>
                            </div>
                            <p class="ml-8 text-sm font-medium text-gray-900">{{ $school->next_intake->format('d/m/Y') }}</p>
                        @endif
                    </div>
                </div>

                <!-- Application CTA -->
                @auth
                    @if(Auth::user()->isStudent())
                        <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-indigo-900 mb-2">Prêt à postuler ?</h3>
                            <p class="text-sm text-indigo-700 mb-4">
                                Soumettez votre candidature en quelques minutes et suivez son évolution en temps réel.
                            </p>
                            <a href="{{ route('student.apply', $school) }}" 
                               class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition duration-300 text-center block">
                                <i class="fas fa-paper-plane mr-2"></i>
                                Postuler maintenant
                            </a>
                        </div>
                    @endif
                @else
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Vous souhaitez postuler ?</h3>
                        <p class="text-sm text-gray-600 mb-4">
                            Créez votre compte pour postuler à cette école et suivre vos candidatures.
                        </p>
                        <div class="space-y-2">
                            <a href="{{ route('register') }}" 
                               class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition duration-300 text-center block">
                                <i class="fas fa-user-plus mr-2"></i>
                                Créer un compte
                            </a>
                            <a href="{{ route('login') }}" 
                               class="w-full bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition duration-300 text-center block">
                                <i class="fas fa-sign-in-alt mr-2"></i>
                                Se connecter
                            </a>
                        </div>
                    </div>
                @endauth

                <!-- Contact -->
                <div class="bg-white rounded-lg shadow-sm border p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Contact</h3>
                    <div class="space-y-3 text-sm">
                        <div>
                            <i class="fas fa-map-marker-alt text-gray-400 w-5"></i>
                            <span class="ml-3 text-gray-600">{{ $school->address }}</span>
                        </div>
                        <div>
                            <span class="ml-8 text-gray-600">{{ $school->city }} {{ $school->postal_code }}</span>
                        </div>
                        @if($school->phone)
                            <div>
                                <i class="fas fa-phone text-gray-400 w-5"></i>
                                <span class="ml-3 text-gray-600">{{ $school->phone }}</span>
                            </div>
                        @endif
                        @if($school->email)
                            <div>
                                <i class="fas fa-envelope text-gray-400 w-5"></i>
                                <a href="mailto:{{ $school->email }}" class="ml-3 text-indigo-600 hover:text-indigo-800">{{ $school->email }}</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
