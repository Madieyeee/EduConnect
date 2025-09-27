import React, { useEffect } from 'react';
import { createPortal } from 'react-dom';
import { XMarkIcon } from '@heroicons/react/24/outline';
import clsx from 'clsx';
import Button from './Button';

const Modal = ({
  isOpen,
  onClose,
  title,
  children,
  footer,
  size = 'md',
  closeOnOverlayClick = true,
  showCloseButton = true,
  className = '',
}) => {
  const sizeClasses = {
    sm: 'max-w-md',
    md: 'max-w-lg',
    lg: 'max-w-2xl',
    xl: 'max-w-4xl',
    full: 'max-w-full mx-4',
  };

  // Handle escape key
  useEffect(() => {
    const handleEscape = (event) => {
      if (event.key === 'Escape' && isOpen) {
        onClose();
      }
    };

    if (isOpen) {
      document.addEventListener('keydown', handleEscape);
      document.body.style.overflow = 'hidden';
    }

    return () => {
      document.removeEventListener('keydown', handleEscape);
      document.body.style.overflow = 'unset';
    };
  }, [isOpen, onClose]);

  if (!isOpen) return null;

  const handleOverlayClick = (event) => {
    if (event.target === event.currentTarget && closeOnOverlayClick) {
      onClose();
    }
  };

  const modalContent = (
    <div className="modal-overlay" onClick={handleOverlayClick}>
      <div
        className={clsx(
          'modal-content',
          sizeClasses[size],
          className
        )}
        onClick={(e) => e.stopPropagation()}
      >
        {/* Header */}
        {(title || showCloseButton) && (
          <div className="flex items-center justify-between p-6 border-b border-secondary-200">
            {title && (
              <h3 className="text-lg font-semibold text-secondary-900">
                {title}
              </h3>
            )}
            {showCloseButton && (
              <Button
                variant="ghost"
                size="sm"
                onClick={onClose}
                className="p-1 hover:bg-secondary-100 rounded-md"
              >
                <XMarkIcon className="w-5 h-5" />
              </Button>
            )}
          </div>
        )}

        {/* Body */}
        <div className="p-6">
          {children}
        </div>

        {/* Footer */}
        {footer && (
          <div className="flex items-center justify-end space-x-3 p-6 border-t border-secondary-200 bg-secondary-50">
            {footer}
          </div>
        )}
      </div>
    </div>
  );

  return createPortal(modalContent, document.body);
};

// Modal sub-components for more flexibility
Modal.Header = ({ children, className = '', onClose, showCloseButton = true }) => (
  <div className={clsx('flex items-center justify-between p-6 border-b border-secondary-200', className)}>
    <div className="flex-1">
      {children}
    </div>
    {showCloseButton && onClose && (
      <Button
        variant="ghost"
        size="sm"
        onClick={onClose}
        className="p-1 hover:bg-secondary-100 rounded-md ml-4"
      >
        <XMarkIcon className="w-5 h-5" />
      </Button>
    )}
  </div>
);

Modal.Body = ({ children, className = '' }) => (
  <div className={clsx('p-6', className)}>
    {children}
  </div>
);

Modal.Footer = ({ children, className = '' }) => (
  <div className={clsx('flex items-center justify-end space-x-3 p-6 border-t border-secondary-200 bg-secondary-50', className)}>
    {children}
  </div>
);

export default Modal;
