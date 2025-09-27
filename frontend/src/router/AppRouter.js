import React, { Suspense } from 'react';
import { BrowserRouter, Routes, Route, Navigate } from 'react-router-dom';
import { ProtectedRoute, AdminRoute } from '../components/Auth';
import { Layout, PublicLayout } from '../components/Layout';
import { LoadingSpinner } from '../components/UI';
import { ROUTES } from '../utils/constants';

// Lazy load pages for better performance
const Home = React.lazy(() => import('../pages/public/Home'));
const Schools = React.lazy(() => import('../pages/public/Schools'));
const SchoolDetail = React.lazy(() => import('../pages/public/SchoolDetail'));
const About = React.lazy(() => import('../pages/public/About'));
const Contact = React.lazy(() => import('../pages/public/Contact'));

// Auth pages
const Login = React.lazy(() => import('../pages/auth/Login'));
const Register = React.lazy(() => import('../pages/auth/Register'));
const ForgotPassword = React.lazy(() => import('../pages/auth/ForgotPassword'));
const ResetPassword = React.lazy(() => import('../pages/auth/ResetPassword'));

// Student pages
const StudentDashboard = React.lazy(() => import('../pages/student/Dashboard'));
const StudentApplications = React.lazy(() => import('../pages/student/Applications'));
const StudentApply = React.lazy(() => import('../pages/student/Apply'));
const StudentContacts = React.lazy(() => import('../pages/student/Contacts'));
const StudentProfile = React.lazy(() => import('../pages/student/Profile'));

// Admin pages
const AdminDashboard = React.lazy(() => import('../pages/admin/Dashboard'));
const AdminSchools = React.lazy(() => import('../pages/admin/Schools'));
const AdminPrograms = React.lazy(() => import('../pages/admin/Programs'));
const AdminApplications = React.lazy(() => import('../pages/admin/Applications'));
const AdminUsers = React.lazy(() => import('../pages/admin/Users'));
const AdminContacts = React.lazy(() => import('../pages/admin/Contacts'));
const AdminAnalytics = React.lazy(() => import('../pages/admin/Analytics'));
const AdminExports = React.lazy(() => import('../pages/admin/Exports'));
const AdminSettings = React.lazy(() => import('../pages/admin/Settings'));

// Error pages
const NotFound = React.lazy(() => import('../pages/errors/NotFound'));
const Unauthorized = React.lazy(() => import('../pages/errors/Unauthorized'));

// Loading component
const PageLoader = () => (
  <div className="min-h-screen flex items-center justify-center bg-secondary-50">
    <LoadingSpinner size="lg" text="Chargement..." />
  </div>
);

const AppRouter = () => {
  return (
    <BrowserRouter>
      <Suspense fallback={<PageLoader />}>
        <Routes>
          {/* Public Routes */}
          <Route path="/" element={<PublicLayout />}>
            <Route index element={<Home />} />
            <Route path={ROUTES.SCHOOLS} element={<Schools />} />
            <Route path={ROUTES.SCHOOL_DETAIL} element={<SchoolDetail />} />
            <Route path={ROUTES.ABOUT} element={<About />} />
            <Route path={ROUTES.CONTACT} element={<Contact />} />
          </Route>

          {/* Auth Routes */}
          <Route path="/auth">
            <Route path="login" element={<Login />} />
            <Route path="register" element={<Register />} />
            <Route path="forgot-password" element={<ForgotPassword />} />
            <Route path="reset-password" element={<ResetPassword />} />
          </Route>

          {/* Protected Routes */}
          <Route path="/dashboard" element={
            <ProtectedRoute>
              <Navigate to="/student/dashboard" replace />
            </ProtectedRoute>
          } />

          {/* Student Routes */}
          <Route path="/student" element={
            <ProtectedRoute>
              <Layout />
            </ProtectedRoute>
          }>
            <Route path="dashboard" element={<StudentDashboard />} />
            <Route path="applications" element={<StudentApplications />} />
            <Route path="apply" element={<StudentApply />} />
            <Route path="contacts" element={<StudentContacts />} />
            <Route path="profile" element={<StudentProfile />} />
          </Route>

          {/* Admin Routes */}
          <Route path="/admin" element={
            <AdminRoute>
              <Layout />
            </AdminRoute>
          }>
            <Route path="dashboard" element={<AdminDashboard />} />
            <Route path="schools" element={<AdminSchools />} />
            <Route path="programs" element={<AdminPrograms />} />
            <Route path="applications" element={<AdminApplications />} />
            <Route path="users" element={<AdminUsers />} />
            <Route path="contacts" element={<AdminContacts />} />
            <Route path="analytics" element={<AdminAnalytics />} />
            <Route path="exports" element={<AdminExports />} />
            <Route path="settings" element={<AdminSettings />} />
          </Route>

          {/* Error Routes */}
          <Route path="/unauthorized" element={<Unauthorized />} />
          <Route path="/404" element={<NotFound />} />
          <Route path="*" element={<NotFound />} />
        </Routes>
      </Suspense>
    </BrowserRouter>
  );
};

export default AppRouter;
