import React from 'react';
import { Link } from 'react-router-dom';
import { 
  AcademicCapIcon, 
  MagnifyingGlassIcon, 
  UserGroupIcon,
  CheckCircleIcon,
  StarIcon,
  ArrowRightIcon
} from '@heroicons/react/24/outline';

const Home = () => {
  const features = [
    {
      icon: MagnifyingGlassIcon,
      title: 'Recherche Avancée',
      description: 'Trouvez l\'école parfaite selon vos critères : ville, domaine, prix, accréditation.'
    },
    {
      icon: AcademicCapIcon,
      title: 'Écoles Certifiées',
      description: 'Toutes nos écoles partenaires sont vérifiées et accréditées.'
    },
    {
      icon: UserGroupIcon,
      title: 'Accompagnement',
      description: 'Notre équipe vous accompagne dans votre processus d\'inscription.'
    },
    {
      icon: CheckCircleIcon,
      title: 'Suivi Candidature',
      description: 'Suivez l\'état de vos candidatures en temps réel.'
    }
  ];

  const testimonials = [
    {
      name: 'Marie Dubois',
      school: 'École de Commerce Paris',
      rating: 5,
      comment: 'Grâce à EduConnect, j\'ai trouvé l\'école de mes rêves en quelques clics !'
    },
    {
      name: 'Ahmed Ben Ali',
      school: 'Institut Technologique Lyon',
      rating: 5,
      comment: 'Le processus d\'inscription était simple et rapide. Je recommande !'
    },
    {
      name: 'Sophie Martin',
      school: 'Université de Médecine Marseille',
      rating: 5,
      comment: 'Excellent service client et suivi personnalisé de ma candidature.'
    }
  ];

  const stats = [
    { number: '500+', label: 'Écoles Partenaires' },
    { number: '10,000+', label: 'Étudiants Inscrits' },
    { number: '95%', label: 'Taux de Satisfaction' },
    { number: '50+', label: 'Villes Couvertes' }
  ];

  return (
    <div className="min-h-screen bg-white">
      {/* Hero Section */}
      <section className="bg-gradient-to-br from-primary-600 to-primary-800 text-white">
        <div className="container mx-auto px-4 py-20">
          <div className="text-center max-w-4xl mx-auto">
            <h1 className="text-5xl md:text-6xl font-bold mb-6">
              Trouvez Votre École Idéale
            </h1>
            <p className="text-xl md:text-2xl mb-8 text-primary-100">
              EduConnect connecte les étudiants aux meilleures institutions éducatives. 
              Recherchez, comparez et postulez en toute simplicité.
            </p>
            <div className="flex flex-col sm:flex-row gap-4 justify-center">
              <Link 
                to="/schools" 
                className="btn btn-lg bg-white text-primary-600 hover:bg-primary-50 px-8 py-4 rounded-lg font-semibold inline-flex items-center"
              >
                <MagnifyingGlassIcon className="w-5 h-5 mr-2" />
                Rechercher des Écoles
              </Link>
              <Link 
                to="/register" 
                className="btn btn-lg border-2 border-white text-white hover:bg-white hover:text-primary-600 px-8 py-4 rounded-lg font-semibold inline-flex items-center"
              >
                <UserGroupIcon className="w-5 h-5 mr-2" />
                Créer un Compte
              </Link>
            </div>
          </div>
        </div>
      </section>

      {/* Stats Section */}
      <section className="py-16 bg-gray-50">
        <div className="container mx-auto px-4">
          <div className="grid grid-cols-2 md:grid-cols-4 gap-8">
            {stats.map((stat, index) => (
              <div key={index} className="text-center">
                <div className="text-3xl md:text-4xl font-bold text-primary-600 mb-2">
                  {stat.number}
                </div>
                <div className="text-gray-600 font-medium">
                  {stat.label}
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Features Section */}
      <section className="py-20">
        <div className="container mx-auto px-4">
          <div className="text-center mb-16">
            <h2 className="text-4xl font-bold text-gray-900 mb-4">
              Pourquoi Choisir EduConnect ?
            </h2>
            <p className="text-xl text-gray-600 max-w-2xl mx-auto">
              Nous simplifions votre recherche d'établissement scolaire avec des outils innovants 
              et un accompagnement personnalisé.
            </p>
          </div>
          
          <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            {features.map((feature, index) => (
              <div key={index} className="text-center p-6 rounded-lg hover:shadow-lg transition-shadow">
                <div className="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                  <feature.icon className="w-8 h-8 text-primary-600" />
                </div>
                <h3 className="text-xl font-semibold text-gray-900 mb-3">
                  {feature.title}
                </h3>
                <p className="text-gray-600">
                  {feature.description}
                </p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* How it Works Section */}
      <section className="py-20 bg-gray-50">
        <div className="container mx-auto px-4">
          <div className="text-center mb-16">
            <h2 className="text-4xl font-bold text-gray-900 mb-4">
              Comment Ça Marche ?
            </h2>
            <p className="text-xl text-gray-600">
              En 3 étapes simples, trouvez et intégrez l'école de vos rêves
            </p>
          </div>
          
          <div className="grid md:grid-cols-3 gap-8">
            <div className="text-center">
              <div className="w-20 h-20 bg-primary-600 text-white rounded-full flex items-center justify-center mx-auto mb-6 text-2xl font-bold">
                1
              </div>
              <h3 className="text-xl font-semibold text-gray-900 mb-3">
                Recherchez
              </h3>
              <p className="text-gray-600">
                Utilisez nos filtres avancés pour trouver les écoles qui correspondent à vos critères.
              </p>
            </div>
            
            <div className="text-center">
              <div className="w-20 h-20 bg-primary-600 text-white rounded-full flex items-center justify-center mx-auto mb-6 text-2xl font-bold">
                2
              </div>
              <h3 className="text-xl font-semibold text-gray-900 mb-3">
                Comparez
              </h3>
              <p className="text-gray-600">
                Consultez les détails, prix, programmes et avis pour chaque établissement.
              </p>
            </div>
            
            <div className="text-center">
              <div className="w-20 h-20 bg-primary-600 text-white rounded-full flex items-center justify-center mx-auto mb-6 text-2xl font-bold">
                3
              </div>
              <h3 className="text-xl font-semibold text-gray-900 mb-3">
                Postulez
              </h3>
              <p className="text-gray-600">
                Soumettez votre candidature en ligne et suivez son évolution en temps réel.
              </p>
            </div>
          </div>
        </div>
      </section>

      {/* Testimonials Section */}
      <section className="py-20">
        <div className="container mx-auto px-4">
          <div className="text-center mb-16">
            <h2 className="text-4xl font-bold text-gray-900 mb-4">
              Ce Que Disent Nos Étudiants
            </h2>
            <p className="text-xl text-gray-600">
              Des milliers d'étudiants nous font confiance
            </p>
          </div>
          
          <div className="grid md:grid-cols-3 gap-8">
            {testimonials.map((testimonial, index) => (
              <div key={index} className="bg-white p-6 rounded-lg shadow-lg">
                <div className="flex items-center mb-4">
                  {[...Array(testimonial.rating)].map((_, i) => (
                    <StarIcon key={i} className="w-5 h-5 text-yellow-400 fill-current" />
                  ))}
                </div>
                <p className="text-gray-600 mb-4 italic">
                  "{testimonial.comment}"
                </p>
                <div>
                  <div className="font-semibold text-gray-900">
                    {testimonial.name}
                  </div>
                  <div className="text-sm text-gray-500">
                    {testimonial.school}
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* CTA Section */}
      <section className="py-20 bg-primary-600 text-white">
        <div className="container mx-auto px-4 text-center">
          <h2 className="text-4xl font-bold mb-4">
            Prêt à Commencer Votre Parcours ?
          </h2>
          <p className="text-xl mb-8 text-primary-100">
            Rejoignez des milliers d'étudiants qui ont trouvé leur école idéale avec EduConnect
          </p>
          <Link 
            to="/register" 
            className="btn btn-lg bg-white text-primary-600 hover:bg-primary-50 px-8 py-4 rounded-lg font-semibold inline-flex items-center"
          >
            Commencer Maintenant
            <ArrowRightIcon className="w-5 h-5 ml-2" />
          </Link>
        </div>
      </section>
    </div>
  );
};

export default Home;