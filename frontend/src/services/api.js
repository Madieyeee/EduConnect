import axios from 'axios';
import Cookies from 'js-cookie';
import toast from 'react-hot-toast';

// Base API configuration
const API_BASE_URL = process.env.REACT_APP_API_URL || 'http://localhost:8000/api';

// Create axios instance
const api = axios.create({
  baseURL: API_BASE_URL,
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  },
});

// Request interceptor to add auth token
api.interceptors.request.use(
  (config) => {
    const token = Cookies.get('auth_token');
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  (error) => {
    return Promise.reject(error);
  }
);

// Response interceptor for error handling
api.interceptors.response.use(
  (response) => {
    return response;
  },
  async (error) => {
    const originalRequest = error.config;

    // Handle 401 errors (unauthorized)
    if (error.response?.status === 401 && !originalRequest._retry) {
      originalRequest._retry = true;

      try {
        // Try to refresh token
        const refreshResponse = await api.post('/auth/refresh');
        const newToken = refreshResponse.data.access_token;
        
        // Update token in cookie
        Cookies.set('auth_token', newToken, { 
          expires: 7,
          secure: process.env.NODE_ENV === 'production',
          sameSite: 'strict'
        });

        // Retry original request with new token
        originalRequest.headers.Authorization = `Bearer ${newToken}`;
        return api(originalRequest);
      } catch (refreshError) {
        // Refresh failed, redirect to login
        Cookies.remove('auth_token');
        window.location.href = '/auth/login';
        return Promise.reject(refreshError);
      }
    }

    // Handle other errors
    if (error.response?.status >= 500) {
      toast.error('Erreur serveur. Veuillez réessayer plus tard.');
    } else if (error.response?.status === 403) {
      toast.error('Accès non autorisé');
    } else if (error.response?.status === 404) {
      toast.error('Ressource non trouvée');
    }

    return Promise.reject(error);
  }
);

// Authentication API
export const authAPI = {
  login: (credentials) => api.post('/auth/login', credentials),
  register: (userData) => api.post('/auth/register', userData),
  logout: () => api.post('/auth/logout'),
  me: () => api.get('/auth/me'),
  refresh: () => api.post('/auth/refresh'),
  updateProfile: (profileData) => api.put('/auth/profile', profileData),
  changePassword: (passwordData) => api.put('/auth/password', passwordData),
};

// Schools API
export const schoolsAPI = {
  // Public endpoints
  getAll: (params) => api.get('/public/schools', { params }),
  getById: (id) => api.get(`/public/schools/${id}`),
  search: (params) => api.get('/public/schools/search', { params }),
  
  // Admin endpoints
  create: (schoolData) => api.post('/admin/schools', schoolData),
  update: (id, schoolData) => api.put(`/admin/schools/${id}`, schoolData),
  delete: (id) => api.delete(`/admin/schools/${id}`),
  getStatistics: (id) => api.get(`/admin/schools/${id}/statistics`),
  uploadLogo: (id, formData) => api.post(`/admin/schools/${id}/upload-logo`, formData, {
    headers: { 'Content-Type': 'multipart/form-data' }
  }),
  uploadBanner: (id, formData) => api.post(`/admin/schools/${id}/upload-banner`, formData, {
    headers: { 'Content-Type': 'multipart/form-data' }
  }),
};

// Programs API
export const programsAPI = {
  // Public endpoints
  getAll: (params) => api.get('/public/programs', { params }),
  getById: (id) => api.get(`/public/programs/${id}`),
  getBySchool: (schoolId, params) => api.get(`/public/schools/${schoolId}/programs`, { params }),
  search: (params) => api.get('/public/programs/search', { params }),
  
  // Admin endpoints
  create: (programData) => api.post('/admin/programs', programData),
  update: (id, programData) => api.put(`/admin/programs/${id}`, programData),
  delete: (id) => api.delete(`/admin/programs/${id}`),
  getStatistics: (id) => api.get(`/admin/programs/${id}/statistics`),
};

// Applications API
export const applicationsAPI = {
  // Student endpoints
  getMyApplications: (params) => api.get('/applications', { params }),
  getById: (id) => api.get(`/applications/${id}`),
  create: (applicationData) => api.post('/applications', applicationData),
  update: (id, applicationData) => api.put(`/applications/${id}`, applicationData),
  delete: (id) => api.delete(`/applications/${id}`),
  downloadDocument: (id, document) => api.get(`/applications/${id}/documents/${document}`, {
    responseType: 'blob'
  }),
  getMyStatistics: () => api.get('/applications/my/statistics'),
  
  // Admin endpoints
  getAllApplications: (params) => api.get('/admin/applications', { params }),
  updateStatus: (id, statusData) => api.put(`/admin/applications/${id}/status`, statusData),
  getStatistics: () => api.get('/admin/applications/statistics/overview'),
  getStatisticsBySchool: (params) => api.get('/admin/applications/statistics/by-school', { params }),
  getStatisticsByProgram: (params) => api.get('/admin/applications/statistics/by-program', { params }),
  getBySchool: (schoolId, params) => api.get(`/admin/schools/${schoolId}/applications`, { params }),
  getByProgram: (programId, params) => api.get(`/admin/programs/${programId}/applications`, { params }),
};

// Contacts API
export const contactsAPI = {
  // Public endpoint
  create: (contactData) => api.post('/contact', contactData),
  
  // Student endpoints
  getMyContacts: (params) => api.get('/contacts/my', { params }),
  
  // Admin endpoints
  getAll: (params) => api.get('/admin/contacts', { params }),
  getById: (id) => api.get(`/admin/contacts/${id}`),
  update: (id, contactData) => api.put(`/admin/contacts/${id}`, contactData),
  assign: (id, adminData) => api.post(`/admin/contacts/${id}/assign`, adminData),
  getStatistics: () => api.get('/admin/contacts/statistics/overview'),
};

// Export API
export const exportAPI = {
  getStatistics: () => api.get('/admin/export/statistics'),
  exportStudents: (params) => api.get('/admin/export/students', { params }),
  exportApplications: (params) => api.get('/admin/export/applications', { params }),
  exportSchools: (params) => api.get('/admin/export/schools', { params }),
  exportContacts: (params) => api.get('/admin/export/contacts', { params }),
  exportFinancialReport: (params) => api.get('/admin/export/financial-report', { params }),
};

// Dashboard API
export const dashboardAPI = {
  getOverview: () => api.get('/admin/dashboard/overview'),
  getRecentApplications: (params) => api.get('/admin/dashboard/recent-applications', { params }),
  getRecentContacts: (params) => api.get('/admin/dashboard/recent-contacts', { params }),
  getCommissionSummary: (params) => api.get('/admin/dashboard/commission-summary', { params }),
};

// File upload helper
export const uploadFile = async (file, endpoint, onProgress) => {
  const formData = new FormData();
  formData.append('file', file);

  return api.post(endpoint, formData, {
    headers: {
      'Content-Type': 'multipart/form-data',
    },
    onUploadProgress: (progressEvent) => {
      if (onProgress) {
        const percentCompleted = Math.round(
          (progressEvent.loaded * 100) / progressEvent.total
        );
        onProgress(percentCompleted);
      }
    },
  });
};

// Download file helper
export const downloadFile = async (url, filename) => {
  try {
    const response = await api.get(url, {
      responseType: 'blob',
    });

    const blob = new Blob([response.data]);
    const downloadUrl = window.URL.createObjectURL(blob);
    const link = document.createElement('a');
    link.href = downloadUrl;
    link.download = filename || 'download';
    document.body.appendChild(link);
    link.click();
    link.remove();
    window.URL.revokeObjectURL(downloadUrl);
  } catch (error) {
    toast.error('Erreur lors du téléchargement du fichier');
    throw error;
  }
};

// Export the main api instance
export default api;
