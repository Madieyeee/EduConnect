import React from 'react';
import clsx from 'clsx';

const Card = ({
  children,
  header,
  footer,
  className = '',
  hover = false,
  padding = true,
  ...props
}) => {
  return (
    <div
      className={clsx(
        'card',
        hover && 'card-hover',
        className
      )}
      {...props}
    >
      {header && (
        <div className="card-header">
          {header}
        </div>
      )}
      
      <div className={clsx(
        padding && 'card-body',
        !padding && 'p-0'
      )}>
        {children}
      </div>
      
      {footer && (
        <div className="card-footer">
          {footer}
        </div>
      )}
    </div>
  );
};

// Card sub-components for more flexibility
Card.Header = ({ children, className = '', ...props }) => (
  <div className={clsx('card-header', className)} {...props}>
    {children}
  </div>
);

Card.Body = ({ children, className = '', ...props }) => (
  <div className={clsx('card-body', className)} {...props}>
    {children}
  </div>
);

Card.Footer = ({ children, className = '', ...props }) => (
  <div className={clsx('card-footer', className)} {...props}>
    {children}
  </div>
);

export default Card;
