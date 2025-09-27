// API Configuration
export const API_BASE_URL = process.env.REACT_APP_API_URL || 'http://localhost:8000/api';
export const BASE_URL = process.env.REACT_APP_BASE_URL || 'http://localhost:3000';

// Application Configuration
export const APP_NAME = process.env.REACT_APP_NAME || 'EduConnect';
export const APP_VERSION = process.env.REACT_APP_VERSION || '1.0.0';
export const APP_DESCRIPTION = process.env.REACT_APP_DESCRIPTION || 'Plateforme de connexion entre étudiants et établissements d\'enseignement supérieur';

// File Upload Configuration
export const MAX_FILE_SIZE = parseInt(process.env.REACT_APP_MAX_FILE_SIZE) || 10485760; // 10MB
export const ALLOWED_FILE_TYPES = process.env.REACT_APP_ALLOWED_FILE_TYPES?.split(',') || ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];

// Feature Flags
export const FEATURES = {
  DARK_MODE: process.env.REACT_APP_ENABLE_DARK_MODE === 'true',
  NOTIFICATIONS: process.env.REACT_APP_ENABLE_NOTIFICATIONS === 'true',
  CHAT: process.env.REACT_APP_ENABLE_CHAT === 'true',
};

// User Roles
export const USER_ROLES = {
  ADMIN: 'admin',
  STUDENT: 'student',
};

// Application Status
export const APPLICATION_STATUS = {
  SUBMITTED: 'submitted',
  IN_PROGRESS: 'in_progress',
  ACCEPTED: 'accepted',
  REJECTED: 'rejected',
};

// Contact Status
export const CONTACT_STATUS = {
  OPEN: 'open',
  IN_PROGRESS: 'in_progress',
  RESOLVED: 'resolved',
  CLOSED: 'closed',
};

// Contact Types
export const CONTACT_TYPES = {
  GENERAL: 'general',
  APPLICATION_HELP: 'application_help',
  TECHNICAL_SUPPORT: 'technical_support',
  COMPLAINT: 'complaint',
};

// Contact Priorities
export const CONTACT_PRIORITIES = {
  LOW: 'low',
  MEDIUM: 'medium',
  HIGH: 'high',
  URGENT: 'urgent',
};

// School Types
export const SCHOOL_TYPES = {
  UNIVERSITY: 'university',
  BUSINESS_SCHOOL: 'business_school',
  ENGINEERING_SCHOOL: 'engineering_school',
  ART_SCHOOL: 'art_school',
  TECHNICAL_SCHOOL: 'technical_school',
  OTHER: 'other',
};

// Degree Levels
export const DEGREE_LEVELS = {
  BAC_2: 'bac+2',
  BAC_3: 'bac+3',
  BAC_5: 'bac+5',
  BAC_8: 'bac+8',
};

// Accreditation Types
export const ACCREDITATION_TYPES = {
  RNCP: 'rncp',
  CTI: 'cti',
  EQUIS: 'equis',
  AACSB: 'aacsb',
  AMBA: 'amba',
  OTHER: 'other',
};

// Pagination
export const PAGINATION = {
  DEFAULT_PAGE_SIZE: 10,
  PAGE_SIZE_OPTIONS: [10, 25, 50, 100],
};

// Local Storage Keys
export const STORAGE_KEYS = {
  AUTH_TOKEN: 'educonnect_auth_token',
  REFRESH_TOKEN: 'educonnect_refresh_token',
  USER_DATA: 'educonnect_user_data',
  THEME: 'educonnect_theme',
  LANGUAGE: 'educonnect_language',
};

// Routes
export const ROUTES = {
  // Public routes
  HOME: '/',
  SCHOOLS: '/schools',
  SCHOOL_DETAIL: '/schools/:id',
  ABOUT: '/about',
  CONTACT: '/contact',
  
  // Auth routes
  LOGIN: '/auth/login',
  REGISTER: '/auth/register',
  FORGOT_PASSWORD: '/auth/forgot-password',
  RESET_PASSWORD: '/auth/reset-password',
  
  // Student routes
  STUDENT_DASHBOARD: '/student/dashboard',
  STUDENT_APPLICATIONS: '/student/applications',
  STUDENT_APPLY: '/student/apply',
  STUDENT_CONTACTS: '/student/contacts',
  STUDENT_PROFILE: '/student/profile',
  
  // Admin routes
  ADMIN_DASHBOARD: '/admin/dashboard',
  ADMIN_SCHOOLS: '/admin/schools',
  ADMIN_PROGRAMS: '/admin/programs',
  ADMIN_APPLICATIONS: '/admin/applications',
  ADMIN_USERS: '/admin/users',
  ADMIN_CONTACTS: '/admin/contacts',
  ADMIN_ANALYTICS: '/admin/analytics',
  ADMIN_EXPORTS: '/admin/exports',
  ADMIN_SETTINGS: '/admin/settings',
  
  // Error routes
  NOT_FOUND: '/404',
  UNAUTHORIZED: '/unauthorized',
};

// HTTP Status Codes
export const HTTP_STATUS = {
  OK: 200,
  CREATED: 201,
  NO_CONTENT: 204,
  BAD_REQUEST: 400,
  UNAUTHORIZED: 401,
  FORBIDDEN: 403,
  NOT_FOUND: 404,
  UNPROCESSABLE_ENTITY: 422,
  INTERNAL_SERVER_ERROR: 500,
};

// Toast Messages
export const TOAST_MESSAGES = {
  SUCCESS: {
    LOGIN: 'Connexion réussie !',
    LOGOUT: 'Déconnexion réussie !',
    REGISTER: 'Inscription réussie !',
    UPDATE: 'Mise à jour réussie !',
    DELETE: 'Suppression réussie !',
    CREATE: 'Création réussie !',
    SAVE: 'Sauvegarde réussie !',
  },
  ERROR: {
    GENERIC: 'Une erreur est survenue',
    NETWORK: 'Erreur de connexion',
    UNAUTHORIZED: 'Accès non autorisé',
    VALIDATION: 'Erreur de validation',
    NOT_FOUND: 'Élément non trouvé',
  },
};

// Validation Messages
export const VALIDATION_MESSAGES = {
  REQUIRED: 'Ce champ est requis',
  EMAIL: 'Adresse email invalide',
  PASSWORD_MIN_LENGTH: 'Le mot de passe doit contenir au moins 8 caractères',
  PASSWORD_MISMATCH: 'Les mots de passe ne correspondent pas',
  PHONE: 'Numéro de téléphone invalide',
  FILE_SIZE: 'Fichier trop volumineux',
  FILE_TYPE: 'Type de fichier non autorisé',
};

// Date Formats
export const DATE_FORMATS = {
  DISPLAY: 'dd/MM/yyyy',
  API: 'yyyy-MM-dd',
  DATETIME: 'dd/MM/yyyy HH:mm',
};

// Theme Configuration
export const THEME = {
  COLORS: {
    PRIMARY: '#3b82f6',
    SECONDARY: '#64748b',
    SUCCESS: '#22c55e',
    WARNING: '#f59e0b',
    ERROR: '#ef4444',
  },
  BREAKPOINTS: {
    SM: '640px',
    MD: '768px',
    LG: '1024px',
    XL: '1280px',
  },
};
