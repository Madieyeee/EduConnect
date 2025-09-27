import React from 'react';
import { Link } from 'react-router-dom';
import { HomeIcon, AcademicCapIcon } from '@heroicons/react/24/outline';
import Button from '../../components/UI/Button';

const NotFound = () => {
  return (
    <div className="min-h-screen bg-white flex flex-col justify-center items-center px-6 py-24 sm:py-32 lg:px-8">
      <div className="text-center">
        {/* Logo */}
        <div className="flex justify-center mb-8">
          <div className="w-16 h-16 bg-primary-600 rounded-2xl flex items-center justify-center">
            <AcademicCapIcon className="w-10 h-10 text-white" />
          </div>
        </div>

        {/* 404 */}
        <p className="text-base font-semibold text-primary-600">404</p>
        <h1 className="mt-4 text-3xl font-bold tracking-tight text-secondary-900 sm:text-5xl">
          Page non trouvée
        </h1>
        <p className="mt-6 text-base leading-7 text-secondary-600 max-w-md mx-auto">
          Désolé, nous n'avons pas pu trouver la page que vous recherchez. 
          Vérifiez l'URL ou retournez à l'accueil.
        </p>

        {/* Actions */}
        <div className="mt-10 flex items-center justify-center gap-x-6">
          <Button
            as={Link}
            to="/"
            variant="primary"
            leftIcon={<HomeIcon className="w-4 h-4" />}
          >
            Retour à l'accueil
          </Button>
          <Button
            as={Link}
            to="/schools"
            variant="outline"
          >
            Voir les écoles
          </Button>
        </div>

        {/* Help links */}
        <div className="mt-16">
          <h2 className="text-sm font-semibold text-secondary-900 mb-4">
            Liens utiles
          </h2>
          <div className="flex flex-wrap justify-center gap-x-6 gap-y-2 text-sm">
            <Link
              to="/about"
              className="text-secondary-600 hover:text-primary-600 transition-colors"
            >
              À propos
            </Link>
            <Link
              to="/contact"
              className="text-secondary-600 hover:text-primary-600 transition-colors"
            >
              Contact
            </Link>
            <Link
              to="/help"
              className="text-secondary-600 hover:text-primary-600 transition-colors"
            >
              Centre d'aide
            </Link>
            <Link
              to="/faq"
              className="text-secondary-600 hover:text-primary-600 transition-colors"
            >
              FAQ
            </Link>
          </div>
        </div>
      </div>
    </div>
  );
};

export default NotFound;
