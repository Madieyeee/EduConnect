import React from 'react';
import clsx from 'clsx';
import LoadingSpinner from './LoadingSpinner';

const Button = ({
  children,
  variant = 'primary',
  size = 'md',
  type = 'button',
  disabled = false,
  loading = false,
  fullWidth = false,
  leftIcon = null,
  rightIcon = null,
  className = '',
  as: Component = 'button',
  onClick,
  ...props
}) => {
  const baseClasses = 'btn';
  
  const variantClasses = {
    primary: 'btn-primary',
    secondary: 'btn-secondary',
    success: 'btn-success',
    warning: 'btn-warning',
    error: 'btn-error',
    outline: 'btn-outline-primary',
    ghost: 'text-primary-600 hover:bg-primary-50 border-transparent',
    link: 'text-primary-600 hover:text-primary-700 underline bg-transparent border-transparent p-0 h-auto',
  };

  const sizeClasses = {
    sm: 'btn-sm',
    md: '',
    lg: 'btn-lg',
  };

  const isDisabled = disabled || loading;

  // If it's a link component, don't pass button-specific props
  const componentProps = Component === 'button' 
    ? { type, disabled: isDisabled, onClick }
    : { onClick };

  return (
    <Component
      className={clsx(
        baseClasses,
        variantClasses[variant],
        sizeClasses[size],
        fullWidth && 'w-full',
        isDisabled && 'opacity-50 cursor-not-allowed',
        className
      )}
      {...componentProps}
      {...props}
    >
      <div className="flex items-center justify-center space-x-2">
        {loading ? (
          <LoadingSpinner 
            size="sm" 
            color={variant === 'primary' || variant === 'success' || variant === 'warning' || variant === 'error' ? 'white' : 'primary'} 
          />
        ) : (
          <>
            {leftIcon && (
              <span className="flex-shrink-0">
                {leftIcon}
              </span>
            )}
            <span>{children}</span>
            {rightIcon && (
              <span className="flex-shrink-0">
                {rightIcon}
              </span>
            )}
          </>
        )}
      </div>
    </Component>
  );
};

export default Button;
