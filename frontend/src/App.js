import React from 'react';
import { BrowserRouter as Router, Routes, Route, Navigate } from 'react-router-dom';
import { QueryClient, QueryClientProvider } from 'react-query';
import { ReactQueryDevtools } from 'react-query/devtools';
import { Toaster } from 'react-hot-toast';
import { HelmetProvider } from 'react-helmet-async';

// Context Providers
import { AuthProvider } from './contexts/AuthContext';
import { ThemeProvider } from './contexts/ThemeContext';

// Layout Components
import Layout from './components/Layout/Layout';
import PublicLayout from './components/Layout/PublicLayout';

// Public Pages
import HomePage from './pages/public/HomePage';
import SchoolsPage from './pages/public/SchoolsPage';
import SchoolDetailPage from './pages/public/SchoolDetailPage';
import AboutPage from './pages/public/AboutPage';
import ContactPage from './pages/public/ContactPage';

// Auth Pages
import LoginPage from './pages/auth/LoginPage';
import RegisterPage from './pages/auth/RegisterPage';

// Student Pages
import StudentDashboard from './pages/student/StudentDashboard';
import ApplicationsPage from './pages/student/ApplicationsPage';
import ApplicationDetailPage from './pages/student/ApplicationDetailPage';
import NewApplicationPage from './pages/student/NewApplicationPage';
import ProfilePage from './pages/student/ProfilePage';
import MyContactsPage from './pages/student/MyContactsPage';

// Admin Pages
import AdminDashboard from './pages/admin/AdminDashboard';
import AdminSchoolsPage from './pages/admin/AdminSchoolsPage';
import AdminProgramsPage from './pages/admin/AdminProgramsPage';
import AdminApplicationsPage from './pages/admin/AdminApplicationsPage';
import AdminContactsPage from './pages/admin/AdminContactsPage';
import AdminExportsPage from './pages/admin/AdminExportsPage';
import AdminUsersPage from './pages/admin/AdminUsersPage';

// Protected Route Components
import ProtectedRoute from './components/Auth/ProtectedRoute';
import AdminRoute from './components/Auth/AdminRoute';

// Error Pages
import NotFoundPage from './pages/errors/NotFoundPage';
import UnauthorizedPage from './pages/errors/UnauthorizedPage';

// Create a client for React Query
const queryClient = new QueryClient({
  defaultOptions: {
    queries: {
      retry: 1,
      refetchOnWindowFocus: false,
      staleTime: 5 * 60 * 1000, // 5 minutes
    },
  },
});

function App() {
  return (
    <HelmetProvider>
      <QueryClientProvider client={queryClient}>
        <ThemeProvider>
          <AuthProvider>
            <Router>
              <div className="App min-h-screen bg-secondary-50">
                <Routes>
                  {/* Public Routes */}
                  <Route path="/" element={<PublicLayout />}>
                    <Route index element={<HomePage />} />
                    <Route path="schools" element={<SchoolsPage />} />
                    <Route path="schools/:id" element={<SchoolDetailPage />} />
                    <Route path="about" element={<AboutPage />} />
                    <Route path="contact" element={<ContactPage />} />
                  </Route>

                  {/* Auth Routes */}
                  <Route path="/auth/login" element={<LoginPage />} />
                  <Route path="/auth/register" element={<RegisterPage />} />

                  {/* Protected Student Routes */}
                  <Route path="/student" element={
                    <ProtectedRoute>
                      <Layout />
                    </ProtectedRoute>
                  }>
                    <Route index element={<Navigate to="/student/dashboard" replace />} />
                    <Route path="dashboard" element={<StudentDashboard />} />
                    <Route path="applications" element={<ApplicationsPage />} />
                    <Route path="applications/new" element={<NewApplicationPage />} />
                    <Route path="applications/:id" element={<ApplicationDetailPage />} />
                    <Route path="profile" element={<ProfilePage />} />
                    <Route path="contacts" element={<MyContactsPage />} />
                  </Route>

                  {/* Protected Admin Routes */}
                  <Route path="/admin" element={
                    <AdminRoute>
                      <Layout />
                    </AdminRoute>
                  }>
                    <Route index element={<Navigate to="/admin/dashboard" replace />} />
                    <Route path="dashboard" element={<AdminDashboard />} />
                    <Route path="schools" element={<AdminSchoolsPage />} />
                    <Route path="programs" element={<AdminProgramsPage />} />
                    <Route path="applications" element={<AdminApplicationsPage />} />
                    <Route path="contacts" element={<AdminContactsPage />} />
                    <Route path="users" element={<AdminUsersPage />} />
                    <Route path="exports" element={<AdminExportsPage />} />
                  </Route>

                  {/* Error Routes */}
                  <Route path="/unauthorized" element={<UnauthorizedPage />} />
                  <Route path="*" element={<NotFoundPage />} />
                </Routes>

                {/* Global Toast Notifications */}
                <Toaster
                  position="top-right"
                  toastOptions={{
                    duration: 4000,
                    style: {
                      background: '#fff',
                      color: '#374151',
                      boxShadow: '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)',
                      border: '1px solid #e5e7eb',
                      borderRadius: '0.75rem',
                      padding: '16px',
                    },
                    success: {
                      iconTheme: {
                        primary: '#10b981',
                        secondary: '#fff',
                      },
                    },
                    error: {
                      iconTheme: {
                        primary: '#ef4444',
                        secondary: '#fff',
                      },
                    },
                  }}
                />
              </div>
            </Router>

            {/* React Query Devtools (only in development) */}
            {process.env.NODE_ENV === 'development' && (
              <ReactQueryDevtools initialIsOpen={false} />
            )}
          </AuthProvider>
        </ThemeProvider>
      </QueryClientProvider>
    </HelmetProvider>
  );
}

export default App;
