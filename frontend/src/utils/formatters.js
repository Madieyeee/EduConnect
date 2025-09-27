// Date formatters
export const formatDate = (date, options = {}) => {
  if (!date) return '';
  
  const defaultOptions = {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    ...options
  };
  
  return new Intl.DateTimeFormat('fr-FR', defaultOptions).format(new Date(date));
};

export const formatDateShort = (date) => {
  return formatDate(date, { 
    year: 'numeric', 
    month: 'short', 
    day: 'numeric' 
  });
};

export const formatDateTime = (date) => {
  if (!date) return '';
  
  return new Intl.DateTimeFormat('fr-FR', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  }).format(new Date(date));
};

export const formatTimeAgo = (date) => {
  if (!date) return '';
  
  const now = new Date();
  const diffInSeconds = Math.floor((now - new Date(date)) / 1000);
  
  if (diffInSeconds < 60) {
    return 'À l\'instant';
  }
  
  const diffInMinutes = Math.floor(diffInSeconds / 60);
  if (diffInMinutes < 60) {
    return `Il y a ${diffInMinutes} min`;
  }
  
  const diffInHours = Math.floor(diffInMinutes / 60);
  if (diffInHours < 24) {
    return `Il y a ${diffInHours}h`;
  }
  
  const diffInDays = Math.floor(diffInHours / 24);
  if (diffInDays < 7) {
    return `Il y a ${diffInDays} jour${diffInDays > 1 ? 's' : ''}`;
  }
  
  return formatDateShort(date);
};

// Price formatters
export const formatPrice = (price, currency = 'EUR') => {
  if (price === null || price === undefined) return '';
  
  return new Intl.NumberFormat('fr-FR', {
    style: 'currency',
    currency: currency,
    minimumFractionDigits: 0,
    maximumFractionDigits: 2
  }).format(price);
};

export const formatPriceRange = (minPrice, maxPrice, currency = 'EUR') => {
  if (!minPrice && !maxPrice) return 'Prix non communiqué';
  if (!maxPrice || minPrice === maxPrice) return formatPrice(minPrice, currency);
  
  return `${formatPrice(minPrice, currency)} - ${formatPrice(maxPrice, currency)}`;
};

// Number formatters
export const formatNumber = (number, options = {}) => {
  if (number === null || number === undefined) return '';
  
  return new Intl.NumberFormat('fr-FR', options).format(number);
};

export const formatPercentage = (value, decimals = 1) => {
  if (value === null || value === undefined) return '';
  
  return new Intl.NumberFormat('fr-FR', {
    style: 'percent',
    minimumFractionDigits: decimals,
    maximumFractionDigits: decimals
  }).format(value / 100);
};

// Text formatters
export const truncateText = (text, maxLength = 100) => {
  if (!text) return '';
  if (text.length <= maxLength) return text;
  
  return text.substring(0, maxLength).trim() + '...';
};

export const capitalizeFirst = (text) => {
  if (!text) return '';
  return text.charAt(0).toUpperCase() + text.slice(1).toLowerCase();
};

export const formatName = (firstName, lastName) => {
  if (!firstName && !lastName) return '';
  if (!lastName) return firstName;
  if (!firstName) return lastName;
  
  return `${firstName} ${lastName}`;
};

// Phone formatter
export const formatPhone = (phone) => {
  if (!phone) return '';
  
  // Remove all non-digit characters
  const cleaned = phone.replace(/\D/g, '');
  
  // Format French phone number
  if (cleaned.length === 10) {
    return cleaned.replace(/(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/, '$1 $2 $3 $4 $5');
  }
  
  return phone;
};

// File size formatter
export const formatFileSize = (bytes) => {
  if (bytes === 0) return '0 Bytes';
  
  const k = 1024;
  const sizes = ['Bytes', 'KB', 'MB', 'GB'];
  const i = Math.floor(Math.log(bytes) / Math.log(k));
  
  return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
};

// Address formatter
export const formatAddress = (address) => {
  if (!address) return '';
  
  const parts = [];
  
  if (address.street) parts.push(address.street);
  if (address.city) parts.push(address.city);
  if (address.postal_code) parts.push(address.postal_code);
  if (address.country && address.country !== 'France') parts.push(address.country);
  
  return parts.join(', ');
};

// Status formatter
export const formatStatus = (status) => {
  const statusMap = {
    'submitted': 'Soumise',
    'in_progress': 'En cours',
    'accepted': 'Acceptée',
    'rejected': 'Rejetée',
    'open': 'Ouvert',
    'closed': 'Fermé',
    'resolved': 'Résolu',
    'pending': 'En attente',
    'paid': 'Payé',
    'failed': 'Échec'
  };
  
  return statusMap[status] || status;
};

// School type formatter
export const formatSchoolType = (type) => {
  const typeMap = {
    'university': 'Université',
    'business_school': 'École de Commerce',
    'engineering_school': 'École d\'Ingénieur',
    'art_school': 'École d\'Art',
    'technical_school': 'École Technique',
    'other': 'Autre'
  };
  
  return typeMap[type] || type;
};

// Degree level formatter
export const formatDegreeLevel = (level) => {
  const levelMap = {
    'bac+2': 'Bac+2',
    'bac+3': 'Bac+3 (Licence)',
    'bac+5': 'Bac+5 (Master)',
    'bac+8': 'Bac+8 (Doctorat)'
  };
  
  return levelMap[level] || level;
};
