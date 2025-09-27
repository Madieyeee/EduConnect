import React from 'react';
import { Link, useLocation } from 'react-router-dom';
import { XMarkIcon } from '@heroicons/react/24/outline';
import {
  HomeIcon,
  AcademicCapIcon,
  DocumentTextIcon,
  UserIcon,
  ChatBubbleLeftRightIcon,
  Cog6ToothIcon,
  UsersIcon,
  ChartBarIcon,
  DocumentArrowDownIcon,
  BuildingOfficeIcon,
} from '@heroicons/react/24/outline';
import clsx from 'clsx';

const Sidebar = ({ isOpen, onClose, userRole }) => {
  const location = useLocation();

  // Navigation items based on user role
  const getNavigationItems = () => {
    const commonItems = [
      {
        name: 'Dashboard',
        href: '/dashboard',
        icon: HomeIcon,
      },
    ];

    if (userRole === 'admin') {
      return [
        ...commonItems,
        {
          name: 'Écoles',
          href: '/admin/schools',
          icon: BuildingOfficeIcon,
        },
        {
          name: 'Programmes',
          href: '/admin/programs',
          icon: AcademicCapIcon,
        },
        {
          name: 'Candidatures',
          href: '/admin/applications',
          icon: DocumentTextIcon,
        },
        {
          name: 'Utilisateurs',
          href: '/admin/users',
          icon: UsersIcon,
        },
        {
          name: 'Support Client',
          href: '/admin/contacts',
          icon: ChatBubbleLeftRightIcon,
        },
        {
          name: 'Statistiques',
          href: '/admin/analytics',
          icon: ChartBarIcon,
        },
        {
          name: 'Exports',
          href: '/admin/exports',
          icon: DocumentArrowDownIcon,
        },
        {
          name: 'Paramètres',
          href: '/admin/settings',
          icon: Cog6ToothIcon,
        },
      ];
    } else {
      // Student navigation
      return [
        ...commonItems,
        {
          name: 'Mes Candidatures',
          href: '/student/applications',
          icon: DocumentTextIcon,
        },
        {
          name: 'Nouvelle Candidature',
          href: '/student/apply',
          icon: AcademicCapIcon,
        },
        {
          name: 'Mes Contacts',
          href: '/student/contacts',
          icon: ChatBubbleLeftRightIcon,
        },
        {
          name: 'Mon Profil',
          href: '/student/profile',
          icon: UserIcon,
        },
      ];
    }
  };

  const navigationItems = getNavigationItems();

  const isActiveLink = (href) => {
    return location.pathname === href || location.pathname.startsWith(href + '/');
  };

  return (
    <>
      {/* Desktop sidebar */}
      <div className="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-64 lg:flex-col">
        <div className="flex grow flex-col gap-y-5 overflow-y-auto bg-white border-r border-secondary-200 px-6 pb-4">
          {/* Logo */}
          <div className="flex h-16 shrink-0 items-center">
            <Link to="/" className="flex items-center space-x-2">
              <div className="w-8 h-8 bg-primary-600 rounded-lg flex items-center justify-center">
                <AcademicCapIcon className="w-5 h-5 text-white" />
              </div>
              <span className="text-xl font-bold text-secondary-900">
                EduConnect
              </span>
            </Link>
          </div>

          {/* Navigation */}
          <nav className="flex flex-1 flex-col">
            <ul role="list" className="flex flex-1 flex-col gap-y-7">
              <li>
                <ul role="list" className="-mx-2 space-y-1">
                  {navigationItems.map((item) => (
                    <li key={item.name}>
                      <Link
                        to={item.href}
                        className={clsx(
                          'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold transition-colors',
                          isActiveLink(item.href)
                            ? 'bg-primary-50 text-primary-600'
                            : 'text-secondary-700 hover:text-primary-600 hover:bg-secondary-50'
                        )}
                      >
                        <item.icon
                          className={clsx(
                            'h-6 w-6 shrink-0',
                            isActiveLink(item.href)
                              ? 'text-primary-600'
                              : 'text-secondary-400 group-hover:text-primary-600'
                          )}
                          aria-hidden="true"
                        />
                        {item.name}
                      </Link>
                    </li>
                  ))}
                </ul>
              </li>
            </ul>
          </nav>
        </div>
      </div>

      {/* Mobile sidebar */}
      <div className={clsx(
        'relative z-50 lg:hidden',
        isOpen ? 'block' : 'hidden'
      )}>
        <div className="fixed inset-0 flex">
          <div className="relative mr-16 flex w-full max-w-xs flex-1">
            <div className="absolute left-full top-0 flex w-16 justify-center pt-5">
              <button
                type="button"
                className="-m-2.5 p-2.5"
                onClick={onClose}
              >
                <span className="sr-only">Fermer la sidebar</span>
                <XMarkIcon className="h-6 w-6 text-white" aria-hidden="true" />
              </button>
            </div>

            <div className="flex grow flex-col gap-y-5 overflow-y-auto bg-white px-6 pb-4">
              {/* Logo */}
              <div className="flex h-16 shrink-0 items-center">
                <Link to="/" className="flex items-center space-x-2" onClick={onClose}>
                  <div className="w-8 h-8 bg-primary-600 rounded-lg flex items-center justify-center">
                    <AcademicCapIcon className="w-5 h-5 text-white" />
                  </div>
                  <span className="text-xl font-bold text-secondary-900">
                    EduConnect
                  </span>
                </Link>
              </div>

              {/* Navigation */}
              <nav className="flex flex-1 flex-col">
                <ul role="list" className="flex flex-1 flex-col gap-y-7">
                  <li>
                    <ul role="list" className="-mx-2 space-y-1">
                      {navigationItems.map((item) => (
                        <li key={item.name}>
                          <Link
                            to={item.href}
                            onClick={onClose}
                            className={clsx(
                              'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold transition-colors',
                              isActiveLink(item.href)
                                ? 'bg-primary-50 text-primary-600'
                                : 'text-secondary-700 hover:text-primary-600 hover:bg-secondary-50'
                            )}
                          >
                            <item.icon
                              className={clsx(
                                'h-6 w-6 shrink-0',
                                isActiveLink(item.href)
                                  ? 'text-primary-600'
                                  : 'text-secondary-400 group-hover:text-primary-600'
                              )}
                              aria-hidden="true"
                            />
                            {item.name}
                          </Link>
                        </li>
                      ))}
                    </ul>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </>
  );
};

export default Sidebar;
