import React, { useState, useRef, useEffect } from 'react';
import { Link } from 'react-router-dom';
import {
  Bars3Icon,
  BellIcon,
  UserCircleIcon,
  SunIcon,
  MoonIcon,
  ArrowRightOnRectangleIcon,
  Cog6ToothIcon,
} from '@heroicons/react/24/outline';
import { useAuth } from '../../contexts/AuthContext';
import { useTheme } from '../../contexts/ThemeContext';
import Button from '../UI/Button';
import clsx from 'clsx';

const Header = ({ onMenuClick, user }) => {
  const [showUserMenu, setShowUserMenu] = useState(false);
  const [showNotifications, setShowNotifications] = useState(false);
  const { logout } = useAuth();
  const { theme, toggleTheme } = useTheme();
  const userMenuRef = useRef(null);
  const notificationsRef = useRef(null);

  // Close dropdowns when clicking outside
  useEffect(() => {
    const handleClickOutside = (event) => {
      if (userMenuRef.current && !userMenuRef.current.contains(event.target)) {
        setShowUserMenu(false);
      }
      if (notificationsRef.current && !notificationsRef.current.contains(event.target)) {
        setShowNotifications(false);
      }
    };

    document.addEventListener('mousedown', handleClickOutside);
    return () => {
      document.removeEventListener('mousedown', handleClickOutside);
    };
  }, []);

  const handleLogout = async () => {
    try {
      await logout();
    } catch (error) {
      console.error('Erreur lors de la déconnexion:', error);
    }
  };

  // Mock notifications - in real app, this would come from API
  const notifications = [
    {
      id: 1,
      title: 'Nouvelle candidature',
      message: 'Une nouvelle candidature a été soumise',
      time: '5 min',
      unread: true,
    },
    {
      id: 2,
      title: 'Candidature acceptée',
      message: 'Votre candidature à été acceptée par l\'école',
      time: '1h',
      unread: true,
    },
    {
      id: 3,
      title: 'Message reçu',
      message: 'Vous avez reçu un nouveau message',
      time: '2h',
      unread: false,
    },
  ];

  const unreadCount = notifications.filter(n => n.unread).length;

  return (
    <div className="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-secondary-200 bg-white px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">
      {/* Mobile menu button */}
      <button
        type="button"
        className="-m-2.5 p-2.5 text-secondary-700 lg:hidden"
        onClick={onMenuClick}
      >
        <span className="sr-only">Ouvrir la sidebar</span>
        <Bars3Icon className="h-6 w-6" aria-hidden="true" />
      </button>

      {/* Separator */}
      <div className="h-6 w-px bg-secondary-200 lg:hidden" aria-hidden="true" />

      <div className="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
        {/* Search bar - placeholder for future implementation */}
        <div className="relative flex flex-1">
          {/* This could be a search component in the future */}
        </div>

        <div className="flex items-center gap-x-4 lg:gap-x-6">
          {/* Theme toggle */}
          <Button
            variant="ghost"
            size="sm"
            onClick={toggleTheme}
            className="p-2"
            title={theme === 'dark' ? 'Mode clair' : 'Mode sombre'}
          >
            {theme === 'dark' ? (
              <SunIcon className="h-5 w-5" />
            ) : (
              <MoonIcon className="h-5 w-5" />
            )}
          </Button>

          {/* Notifications */}
          <div className="relative" ref={notificationsRef}>
            <Button
              variant="ghost"
              size="sm"
              onClick={() => setShowNotifications(!showNotifications)}
              className="p-2 relative"
            >
              <BellIcon className="h-6 w-6" />
              {unreadCount > 0 && (
                <span className="absolute -top-1 -right-1 h-4 w-4 rounded-full bg-error-500 text-xs text-white flex items-center justify-center">
                  {unreadCount}
                </span>
              )}
            </Button>

            {/* Notifications dropdown */}
            {showNotifications && (
              <div className="absolute right-0 z-10 mt-2 w-80 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                <div className="px-4 py-2 border-b border-secondary-200">
                  <h3 className="text-sm font-semibold text-secondary-900">
                    Notifications
                  </h3>
                </div>
                <div className="max-h-64 overflow-y-auto">
                  {notifications.map((notification) => (
                    <div
                      key={notification.id}
                      className={clsx(
                        'px-4 py-3 hover:bg-secondary-50 cursor-pointer border-b border-secondary-100 last:border-b-0',
                        notification.unread && 'bg-primary-50'
                      )}
                    >
                      <div className="flex justify-between items-start">
                        <div className="flex-1 min-w-0">
                          <p className="text-sm font-medium text-secondary-900 truncate">
                            {notification.title}
                          </p>
                          <p className="text-sm text-secondary-500 mt-1">
                            {notification.message}
                          </p>
                        </div>
                        <span className="text-xs text-secondary-400 ml-2">
                          {notification.time}
                        </span>
                      </div>
                    </div>
                  ))}
                </div>
                <div className="px-4 py-2 border-t border-secondary-200">
                  <Link
                    to="/notifications"
                    className="text-sm text-primary-600 hover:text-primary-500"
                    onClick={() => setShowNotifications(false)}
                  >
                    Voir toutes les notifications
                  </Link>
                </div>
              </div>
            )}
          </div>

          {/* Separator */}
          <div className="hidden lg:block lg:h-6 lg:w-px lg:bg-secondary-200" aria-hidden="true" />

          {/* Profile dropdown */}
          <div className="relative" ref={userMenuRef}>
            <Button
              variant="ghost"
              size="sm"
              onClick={() => setShowUserMenu(!showUserMenu)}
              className="flex items-center space-x-2 p-1"
            >
              <span className="sr-only">Ouvrir le menu utilisateur</span>
              <UserCircleIcon className="h-8 w-8 text-secondary-400" />
              <span className="hidden lg:flex lg:items-center">
                <span className="ml-2 text-sm font-semibold leading-6 text-secondary-900">
                  {user?.first_name} {user?.last_name}
                </span>
              </span>
            </Button>

            {/* User menu dropdown */}
            {showUserMenu && (
              <div className="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                <div className="px-4 py-2 border-b border-secondary-200">
                  <p className="text-sm font-medium text-secondary-900">
                    {user?.first_name} {user?.last_name}
                  </p>
                  <p className="text-sm text-secondary-500">{user?.email}</p>
                  <span className="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-primary-100 text-primary-800 mt-1">
                    {user?.role === 'admin' ? 'Administrateur' : 'Étudiant'}
                  </span>
                </div>

                <Link
                  to={user?.role === 'admin' ? '/admin/settings' : '/student/profile'}
                  className="flex items-center px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-100"
                  onClick={() => setShowUserMenu(false)}
                >
                  <Cog6ToothIcon className="mr-3 h-4 w-4" />
                  {user?.role === 'admin' ? 'Paramètres' : 'Mon Profil'}
                </Link>

                <button
                  onClick={handleLogout}
                  className="flex w-full items-center px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-100"
                >
                  <ArrowRightOnRectangleIcon className="mr-3 h-4 w-4" />
                  Se déconnecter
                </button>
              </div>
            )}
          </div>
        </div>
      </div>
    </div>
  );
};

export default Header;
