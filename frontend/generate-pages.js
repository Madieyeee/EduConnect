const fs = require('fs');
const path = require('path');

// Template for placeholder pages
const createPageTemplate = (componentName, title) => `import React from 'react';

const ${componentName} = () => {
  return (
    <div className="min-h-screen bg-white">
      <div className="container mx-auto px-4 py-16">
        <h1 className="text-3xl font-bold text-gray-900 mb-8">${title}</h1>
        <div className="bg-blue-50 border border-blue-200 rounded-lg p-6">
          <p className="text-blue-800">🚧 Page en cours de développement</p>
        </div>
      </div>
    </div>
  );
};

export default ${componentName};
`;

// Pages to create
const pages = [
  // Public pages
  { dir: 'src/pages/public', file: 'SchoolDetail.js', component: 'SchoolDetail', title: 'Détail École' },
  { dir: 'src/pages/public', file: 'About.js', component: 'About', title: 'À Propos' },
  { dir: 'src/pages/public', file: 'Contact.js', component: 'Contact', title: 'Contact' },
  
  // Auth pages
  { dir: 'src/pages/auth', file: 'ForgotPassword.js', component: 'ForgotPassword', title: 'Mot de passe oublié' },
  { dir: 'src/pages/auth', file: 'ResetPassword.js', component: 'ResetPassword', title: 'Réinitialiser le mot de passe' },
  
  // Student pages
  { dir: 'src/pages/student', file: 'Dashboard.js', component: 'StudentDashboard', title: 'Dashboard Étudiant' },
  { dir: 'src/pages/student', file: 'Applications.js', component: 'StudentApplications', title: 'Mes Candidatures' },
  { dir: 'src/pages/student', file: 'Apply.js', component: 'StudentApply', title: 'Nouvelle Candidature' },
  { dir: 'src/pages/student', file: 'Contacts.js', component: 'StudentContacts', title: 'Mes Contacts' },
  { dir: 'src/pages/student', file: 'Profile.js', component: 'StudentProfile', title: 'Mon Profil' },
  
  // Admin pages
  { dir: 'src/pages/admin', file: 'Dashboard.js', component: 'AdminDashboard', title: 'Dashboard Admin' },
  { dir: 'src/pages/admin', file: 'Schools.js', component: 'AdminSchools', title: 'Gestion Écoles' },
  { dir: 'src/pages/admin', file: 'Programs.js', component: 'AdminPrograms', title: 'Gestion Programmes' },
  { dir: 'src/pages/admin', file: 'Applications.js', component: 'AdminApplications', title: 'Gestion Candidatures' },
  { dir: 'src/pages/admin', file: 'Users.js', component: 'AdminUsers', title: 'Gestion Utilisateurs' },
  { dir: 'src/pages/admin', file: 'Contacts.js', component: 'AdminContacts', title: 'Support Client' },
  { dir: 'src/pages/admin', file: 'Analytics.js', component: 'AdminAnalytics', title: 'Statistiques' },
  { dir: 'src/pages/admin', file: 'Exports.js', component: 'AdminExports', title: 'Exports' },
  { dir: 'src/pages/admin', file: 'Settings.js', component: 'AdminSettings', title: 'Paramètres' },
];

// Create directories and files
pages.forEach(page => {
  const dirPath = path.join(__dirname, page.dir);
  const filePath = path.join(dirPath, page.file);
  
  // Create directory if it doesn't exist
  if (!fs.existsSync(dirPath)) {
    fs.mkdirSync(dirPath, { recursive: true });
    console.log(`Created directory: ${dirPath}`);
  }
  
  // Create file if it doesn't exist
  if (!fs.existsSync(filePath)) {
    const content = createPageTemplate(page.component, page.title);
    fs.writeFileSync(filePath, content);
    console.log(`Created file: ${filePath}`);
  } else {
    console.log(`File already exists: ${filePath}`);
  }
});

console.log('✅ All placeholder pages have been generated!');
console.log('🚀 You can now run npm start to test the application.');
