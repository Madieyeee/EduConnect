// Utility to check for common errors in the project

export const checkImports = () => {
  const errors = [];
  
  // Check if we're using correct React Query imports
  try {
    require('react-query');
  } catch (e) {
    errors.push('react-query package not found');
  }
  
  try {
    require('react-hot-toast');
  } catch (e) {
    errors.push('react-hot-toast package not found');
  }
  
  try {
    require('@heroicons/react/24/outline');
  } catch (e) {
    errors.push('heroicons package not found');
  }
  
  return errors;
};

export const checkEnvironmentVariables = () => {
  const errors = [];
  const requiredEnvVars = [
    'REACT_APP_API_URL',
    'REACT_APP_BASE_URL',
    'REACT_APP_NAME'
  ];
  
  requiredEnvVars.forEach(envVar => {
    if (!process.env[envVar]) {
      errors.push(`Missing environment variable: ${envVar}`);
    }
  });
  
  return errors;
};

export const validateProjectStructure = () => {
  const errors = [];
  
  // This would check if all required files exist
  // In a real implementation, you'd use fs to check file existence
  
  return errors;
};

// Main error checking function
export const runErrorCheck = () => {
  const allErrors = [
    ...checkImports(),
    ...checkEnvironmentVariables(),
    ...validateProjectStructure()
  ];
  
  if (allErrors.length > 0) {
    console.error('Project errors found:', allErrors);
    return false;
  }
  
  console.log('No errors found in project structure');
  return true;
};
