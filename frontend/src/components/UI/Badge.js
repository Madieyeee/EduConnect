import React from 'react';
import clsx from 'clsx';

const Badge = ({
  children,
  variant = 'primary',
  size = 'md',
  className = '',
  ...props
}) => {
  const baseClasses = 'badge';
  
  const variantClasses = {
    primary: 'badge-primary',
    secondary: 'badge-secondary',
    success: 'badge-success',
    warning: 'badge-warning',
    error: 'badge-error',
    // Status-specific badges
    submitted: 'status-submitted',
    'in-progress': 'status-in-progress',
    accepted: 'status-accepted',
    rejected: 'status-rejected',
  };

  const sizeClasses = {
    sm: 'px-2 py-0.5 text-xs',
    md: 'px-2.5 py-0.5 text-xs',
    lg: 'px-3 py-1 text-sm',
  };

  return (
    <span
      className={clsx(
        baseClasses,
        variantClasses[variant],
        sizeClasses[size],
        className
      )}
      {...props}
    >
      {children}
    </span>
  );
};

// Helper function to get status badge variant
export const getStatusVariant = (status) => {
  const statusMap = {
    submitted: 'submitted',
    'in_progress': 'in-progress',
    'in-progress': 'in-progress',
    accepted: 'accepted',
    rejected: 'rejected',
    // Contact statuses
    open: 'warning',
    resolved: 'success',
    closed: 'secondary',
    // Payment statuses
    pending: 'warning',
    paid: 'success',
    failed: 'error',
  };
  
  return statusMap[status] || 'secondary';
};

// Helper function to get status text
export const getStatusText = (status) => {
  const statusTextMap = {
    submitted: 'Soumise',
    'in_progress': 'En cours',
    'in-progress': 'En cours',
    accepted: 'Acceptée',
    rejected: 'Rejetée',
    // Contact statuses
    open: 'Ouvert',
    resolved: 'Résolu',
    closed: 'Fermé',
    // Payment statuses
    pending: 'En attente',
    paid: 'Payé',
    failed: 'Échec',
  };
  
  return statusTextMap[status] || status;
};

export default Badge;
