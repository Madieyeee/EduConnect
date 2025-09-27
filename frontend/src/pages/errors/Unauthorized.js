import React from 'react';
import { Link, useNavigate } from 'react-router-dom';
import { 
  HomeIcon, 
  AcademicCapIcon, 
  ShieldExclamationIcon,
  ArrowLeftIcon 
} from '@heroicons/react/24/outline';
import { useAuth } from '../../contexts/AuthContext';
import Button from '../../components/UI/Button';

const Unauthorized = () => {
  const navigate = useNavigate();
  const { user, isAuthenticated } = useAuth();

  const handleGoBack = () => {
    navigate(-1);
  };

  const getDashboardLink = () => {
    if (!isAuthenticated) return '/auth/login';
    return user?.role === 'admin' ? '/admin/dashboard' : '/student/dashboard';
  };

  const getDashboardText = () => {
    if (!isAuthenticated) return 'Se connecter';
    return user?.role === 'admin' ? 'Dashboard Admin' : 'Dashboard Étudiant';
  };

  return (
    <div className="min-h-screen bg-white flex flex-col justify-center items-center px-6 py-24 sm:py-32 lg:px-8">
      <div className="text-center">
        {/* Logo */}
        <div className="flex justify-center mb-8">
          <div className="w-16 h-16 bg-error-600 rounded-2xl flex items-center justify-center">
            <ShieldExclamationIcon className="w-10 h-10 text-white" />
          </div>
        </div>

        {/* 403 */}
        <p className="text-base font-semibold text-error-600">403</p>
        <h1 className="mt-4 text-3xl font-bold tracking-tight text-secondary-900 sm:text-5xl">
          Accès non autorisé
        </h1>
        <p className="mt-6 text-base leading-7 text-secondary-600 max-w-md mx-auto">
          Vous n'avez pas les permissions nécessaires pour accéder à cette page. 
          {!isAuthenticated && ' Veuillez vous connecter avec un compte autorisé.'}
          {isAuthenticated && ' Contactez un administrateur si vous pensez qu\'il s\'agit d\'une erreur.'}
        </p>

        {/* User info if authenticated */}
        {isAuthenticated && (
          <div className="mt-6 p-4 bg-secondary-50 rounded-lg max-w-sm mx-auto">
            <p className="text-sm text-secondary-700">
              Connecté en tant que : <span className="font-medium">{user?.first_name} {user?.last_name}</span>
            </p>
            <p className="text-sm text-secondary-500">
              Rôle : {user?.role === 'admin' ? 'Administrateur' : 'Étudiant'}
            </p>
          </div>
        )}

        {/* Actions */}
        <div className="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
          <Button
            onClick={handleGoBack}
            variant="outline"
            leftIcon={<ArrowLeftIcon className="w-4 h-4" />}
          >
            Retour
          </Button>
          
          <Button
            as={Link}
            to={getDashboardLink()}
            variant="primary"
          >
            {getDashboardText()}
          </Button>

          <Button
            as={Link}
            to="/"
            variant="ghost"
            leftIcon={<HomeIcon className="w-4 h-4" />}
          >
            Accueil
          </Button>
        </div>

        {/* Help section */}
        <div className="mt-16 p-6 bg-secondary-50 rounded-lg max-w-lg mx-auto">
          <h2 className="text-sm font-semibold text-secondary-900 mb-3">
            Besoin d'aide ?
          </h2>
          <div className="space-y-2 text-sm text-secondary-600">
            <p>• Vérifiez que vous êtes connecté avec le bon compte</p>
            <p>• Contactez votre administrateur pour obtenir les permissions</p>
            <p>• Consultez notre centre d'aide pour plus d'informations</p>
          </div>
          <div className="mt-4 flex flex-wrap justify-center gap-x-4 gap-y-2 text-sm">
            <Link
              to="/contact"
              className="text-primary-600 hover:text-primary-700 transition-colors"
            >
              Nous contacter
            </Link>
            <Link
              to="/help"
              className="text-primary-600 hover:text-primary-700 transition-colors"
            >
              Centre d'aide
            </Link>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Unauthorized;
