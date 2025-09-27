import React, { createContext, useContext, useReducer, useEffect } from 'react';

// Initial state
const initialState = {
  theme: 'light', // 'light' or 'dark'
  systemPreference: false, // Follow system preference
};

// Action types
const THEME_ACTIONS = {
  SET_THEME: 'SET_THEME',
  TOGGLE_THEME: 'TOGGLE_THEME',
  SET_SYSTEM_PREFERENCE: 'SET_SYSTEM_PREFERENCE',
};

// Reducer
function themeReducer(state, action) {
  switch (action.type) {
    case THEME_ACTIONS.SET_THEME:
      return {
        ...state,
        theme: action.payload,
        systemPreference: false,
      };

    case THEME_ACTIONS.TOGGLE_THEME:
      return {
        ...state,
        theme: state.theme === 'light' ? 'dark' : 'light',
        systemPreference: false,
      };

    case THEME_ACTIONS.SET_SYSTEM_PREFERENCE:
      return {
        ...state,
        systemPreference: action.payload,
        theme: action.payload ? getSystemTheme() : state.theme,
      };

    default:
      return state;
  }
}

// Helper function to get system theme
function getSystemTheme() {
  if (typeof window !== 'undefined' && window.matchMedia) {
    return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
  }
  return 'light';
}

// Create context
const ThemeContext = createContext();

// Custom hook to use theme context
export const useTheme = () => {
  const context = useContext(ThemeContext);
  if (!context) {
    throw new Error('useTheme must be used within a ThemeProvider');
  }
  return context;
};

// Theme provider component
export const ThemeProvider = ({ children }) => {
  const [state, dispatch] = useReducer(themeReducer, initialState);

  // Initialize theme from localStorage or system preference
  useEffect(() => {
    const savedTheme = localStorage.getItem('educonnect_theme');
    const savedSystemPref = localStorage.getItem('educonnect_system_preference') === 'true';

    if (savedSystemPref) {
      dispatch({
        type: THEME_ACTIONS.SET_SYSTEM_PREFERENCE,
        payload: true,
      });
    } else if (savedTheme) {
      dispatch({
        type: THEME_ACTIONS.SET_THEME,
        payload: savedTheme,
      });
    } else {
      // Default to system preference on first visit
      dispatch({
        type: THEME_ACTIONS.SET_SYSTEM_PREFERENCE,
        payload: true,
      });
    }
  }, []);

  // Listen for system theme changes
  useEffect(() => {
    if (!state.systemPreference) return;

    const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
    
    const handleChange = (e) => {
      dispatch({
        type: THEME_ACTIONS.SET_THEME,
        payload: e.matches ? 'dark' : 'light',
      });
    };

    mediaQuery.addEventListener('change', handleChange);
    
    return () => {
      mediaQuery.removeEventListener('change', handleChange);
    };
  }, [state.systemPreference]);

  // Apply theme to document
  useEffect(() => {
    const root = document.documentElement;
    
    if (state.theme === 'dark') {
      root.classList.add('dark');
    } else {
      root.classList.remove('dark');
    }

    // Save to localStorage
    if (!state.systemPreference) {
      localStorage.setItem('educonnect_theme', state.theme);
    }
    localStorage.setItem('educonnect_system_preference', state.systemPreference.toString());
  }, [state.theme, state.systemPreference]);

  // Set specific theme
  const setTheme = (theme) => {
    dispatch({
      type: THEME_ACTIONS.SET_THEME,
      payload: theme,
    });
  };

  // Toggle between light and dark
  const toggleTheme = () => {
    dispatch({ type: THEME_ACTIONS.TOGGLE_THEME });
  };

  // Set system preference
  const setSystemPreference = (useSystem) => {
    dispatch({
      type: THEME_ACTIONS.SET_SYSTEM_PREFERENCE,
      payload: useSystem,
    });
  };

  // Check if current theme is dark
  const isDark = () => {
    return state.theme === 'dark';
  };

  // Get theme colors based on current theme
  const getThemeColors = () => {
    return {
      primary: state.theme === 'dark' ? '#60a5fa' : '#3b82f6',
      secondary: state.theme === 'dark' ? '#e2e8f0' : '#64748b',
      background: state.theme === 'dark' ? '#0f172a' : '#f8fafc',
      surface: state.theme === 'dark' ? '#1e293b' : '#ffffff',
      text: state.theme === 'dark' ? '#f1f5f9' : '#1e293b',
      textSecondary: state.theme === 'dark' ? '#cbd5e1' : '#64748b',
      border: state.theme === 'dark' ? '#334155' : '#e2e8f0',
      success: state.theme === 'dark' ? '#4ade80' : '#22c55e',
      warning: state.theme === 'dark' ? '#fbbf24' : '#f59e0b',
      error: state.theme === 'dark' ? '#f87171' : '#ef4444',
    };
  };

  // Context value
  const value = {
    // State
    theme: state.theme,
    systemPreference: state.systemPreference,
    
    // Actions
    setTheme,
    toggleTheme,
    setSystemPreference,
    
    // Helpers
    isDark,
    getThemeColors,
  };

  return (
    <ThemeContext.Provider value={value}>
      {children}
    </ThemeContext.Provider>
  );
};
