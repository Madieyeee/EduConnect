import { useState, useCallback } from 'react';

const useForm = (initialValues = {}, validationRules = {}) => {
  const [values, setValues] = useState(initialValues);
  const [errors, setFieldErrors] = useState({});
  const [touched, setTouched] = useState({});
  const [isSubmitting, setIsSubmitting] = useState(false);

  // Validation function
  const validateField = useCallback((name, value) => {
    const rules = validationRules[name];
    if (!rules) return '';

    for (const rule of rules) {
      const error = rule(value, values);
      if (error) return error;
    }
    return '';
  }, [validationRules, values]);

  // Validate all fields
  const validateForm = useCallback(() => {
    const newErrors = {};
    let isValid = true;

    Object.keys(validationRules).forEach(fieldName => {
      const error = validateField(fieldName, values[fieldName]);
      if (error) {
        newErrors[fieldName] = error;
        isValid = false;
      }
    });

    setFieldErrors(newErrors);
    return isValid;
  }, [validationRules, values, validateField]);

  // Handle input change
  const handleChange = useCallback((name, value) => {
    setValues(prev => ({ ...prev, [name]: value }));
    
    // Clear error when user starts typing
    if (errors[name]) {
      setFieldErrors(prev => ({ ...prev, [name]: '' }));
    }
  }, [errors]);

  // Handle input blur
  const handleBlur = useCallback((name) => {
    setTouched(prev => ({ ...prev, [name]: true }));
    
    // Validate field on blur
    const error = validateField(name, values[name]);
    setFieldErrors(prev => ({ ...prev, [name]: error }));
  }, [validateField, values]);

  // Handle form submission
  const handleSubmit = useCallback(async (onSubmit) => {
    setIsSubmitting(true);
    
    // Mark all fields as touched
    const allTouched = {};
    Object.keys(validationRules).forEach(key => {
      allTouched[key] = true;
    });
    setTouched(allTouched);

    // Validate form
    const isValid = validateForm();
    
    if (isValid) {
      try {
        await onSubmit(values);
      } catch (error) {
        console.error('Form submission error:', error);
        throw error;
      }
    }
    
    setIsSubmitting(false);
    return isValid;
  }, [values, validationRules, validateForm]);

  // Reset form
  const reset = useCallback((newValues = initialValues) => {
    setValues(newValues);
    setFieldErrors({});
    setTouched({});
    setIsSubmitting(false);
  }, [initialValues]);

  // Set field value
  const setValue = useCallback((name, value) => {
    setValues(prev => ({ ...prev, [name]: value }));
  }, []);

  // Set field error
  const setFieldError = useCallback((name, error) => {
    setFieldErrors(prev => ({ ...prev, [name]: error }));
  }, []);

  // Set multiple errors (useful for server-side validation)
  const setFieldErrors = useCallback((newErrors) => {
    setFieldErrors(prev => ({ ...prev, ...newErrors }));
  }, []);

  // Get field props for input components
  const getFieldProps = useCallback((name) => ({
    value: values[name] || '',
    error: touched[name] ? errors[name] : '',
    onChange: (e) => {
      const value = e.target ? e.target.value : e;
      handleChange(name, value);
    },
    onBlur: () => handleBlur(name),
  }), [values, errors, touched, handleChange, handleBlur]);

  // Check if form is valid
  const isValid = Object.keys(errors).length === 0 && 
                  Object.keys(touched).length > 0;

  // Check if form has been modified
  const isDirty = JSON.stringify(values) !== JSON.stringify(initialValues);

  return {
    values,
    errors,
    touched,
    isSubmitting,
    isValid,
    isDirty,
    handleChange,
    handleBlur,
    handleSubmit,
    reset,
    setValue,
    setError: setFieldError,
    setErrors: setFieldErrors,
    getFieldProps,
    validateForm,
  };
};

// Common validation rules
export const validationRules = {
  required: (message = 'Ce champ est requis') => (value) => {
    if (!value || (typeof value === 'string' && !value.trim())) {
      return message;
    }
    return '';
  },

  email: (message = 'Adresse email invalide') => (value) => {
    if (value && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
      return message;
    }
    return '';
  },

  minLength: (min, message) => (value) => {
    if (value && value.length < min) {
      return message || `Minimum ${min} caractères requis`;
    }
    return '';
  },

  maxLength: (max, message) => (value) => {
    if (value && value.length > max) {
      return message || `Maximum ${max} caractères autorisés`;
    }
    return '';
  },

  pattern: (regex, message) => (value) => {
    if (value && !regex.test(value)) {
      return message || 'Format invalide';
    }
    return '';
  },

  phone: (message = 'Numéro de téléphone invalide') => (value) => {
    if (value && !/^(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}$/.test(value)) {
      return message;
    }
    return '';
  },

  confirmPassword: (passwordField, message = 'Les mots de passe ne correspondent pas') => (value, allValues) => {
    if (value && value !== allValues[passwordField]) {
      return message;
    }
    return '';
  },
};

export default useForm;
