# EduConnect Frontend

Interface utilisateur moderne et responsive pour la plateforme EduConnect, développée avec React et Tailwind CSS.

## 🚀 Technologies Utilisées

- **React 18** - Bibliothèque UI avec hooks modernes
- **React Router v6** - Navigation et routage
- **React Query** - Gestion des données et cache
- **Tailwind CSS** - Framework CSS utilitaire
- **React Hook Form** - Gestion des formulaires
- **Framer Motion** - Animations fluides
- **Axios** - Client HTTP
- **React Hot Toast** - Notifications
- **Headless UI** - Composants accessibles
- **Heroicons** - Icônes SVG

## 📁 Structure du Projet

```
src/
├── components/          # Composants réutilisables
│   ├── Auth/           # Composants d'authentification
│   ├── Common/         # Composants communs
│   ├── Forms/          # Composants de formulaires
│   ├── Layout/         # Composants de mise en page
│   └── UI/             # Composants d'interface
├── contexts/           # Contextes React
│   ├── AuthContext.js  # Gestion de l'authentification
│   └── ThemeContext.js # Gestion du thème
├── hooks/              # Hooks personnalisés
├── pages/              # Pages de l'application
│   ├── admin/          # Pages administrateur
│   ├── auth/           # Pages d'authentification
│   ├── public/         # Pages publiques
│   └── student/        # Pages étudiant
├── services/           # Services API
├── utils/              # Utilitaires
└── styles/             # Styles globaux
```

## 🛠️ Installation et Configuration

### Prérequis

- Node.js 16+ et npm/yarn
- Backend Laravel en cours d'exécution

### Installation

1. **Cloner le repository et naviguer vers le frontend**
   ```bash
   cd frontend
   ```

2. **Installer les dépendances**
   ```bash
   npm install
   # ou
   yarn install
   ```

3. **Configurer les variables d'environnement**
   ```bash
   cp .env.example .env
   ```
   
   Modifier le fichier `.env` avec vos configurations :
   ```env
   REACT_APP_API_URL=http://localhost:8000/api
   REACT_APP_BASE_URL=http://localhost:3000
   ```

4. **Démarrer le serveur de développement**
   ```bash
   npm start
   # ou
   yarn start
   ```

L'application sera accessible sur `http://localhost:3000`

## 📱 Fonctionnalités

### Pages Publiques
- **Accueil** - Présentation de la plateforme
- **Écoles** - Catalogue des établissements
- **Détail École** - Informations complètes sur un établissement
- **Contact** - Formulaire de contact
- **À Propos** - Présentation d'EduConnect

### Espace Étudiant
- **Dashboard** - Vue d'ensemble des candidatures
- **Candidatures** - Gestion des demandes d'inscription
- **Nouvelle Candidature** - Formulaire de candidature
- **Profil** - Gestion du profil utilisateur
- **Mes Contacts** - Historique des messages

### Espace Administrateur
- **Dashboard** - Statistiques et vue d'ensemble
- **Gestion Écoles** - CRUD des établissements
- **Gestion Programmes** - CRUD des programmes
- **Gestion Candidatures** - Traitement des demandes
- **Support Client** - Gestion des contacts
- **Exports** - Extraction des données
- **Utilisateurs** - Gestion des comptes

### Fonctionnalités Transversales
- **Authentification JWT** - Connexion sécurisée
- **Recherche Avancée** - Filtres multiples
- **Mode Sombre** - Thème adaptatif
- **Responsive Design** - Compatible mobile/desktop
- **Notifications** - Alertes en temps réel
- **Upload de Fichiers** - Gestion des documents

## 🎨 Design System

### Couleurs Principales
- **Primary** : Bleu (#3b82f6)
- **Secondary** : Gris (#64748b)
- **Success** : Vert (#22c55e)
- **Warning** : Orange (#f59e0b)
- **Error** : Rouge (#ef4444)

### Typographie
- **Heading** : Poppins (titres)
- **Body** : Inter (texte)

### Composants Réutilisables
- Boutons avec variantes (primary, secondary, outline)
- Cards avec effets hover
- Formulaires avec validation
- Modales et dropdowns
- Tables avec pagination
- Badges de statut

## 🔧 Scripts Disponibles

```bash
# Développement
npm start                 # Démarrer le serveur de dev
npm run build            # Build de production
npm test                 # Lancer les tests
npm run eject            # Éjecter la configuration

# Qualité de code
npm run lint             # Vérifier le code
npm run lint:fix         # Corriger automatiquement
npm run format           # Formater avec Prettier
```

## 🚀 Déploiement

### Build de Production

```bash
npm run build
```

Les fichiers optimisés seront générés dans le dossier `build/`.

### Variables d'Environnement de Production

```env
REACT_APP_API_URL=https://api.educonnect.fr/api
REACT_APP_BASE_URL=https://educonnect.fr
NODE_ENV=production
GENERATE_SOURCEMAP=false
```

### Déploiement sur Netlify/Vercel

1. Connecter le repository GitHub
2. Configurer les variables d'environnement
3. Définir la commande de build : `npm run build`
4. Définir le dossier de publication : `build`

## 🧪 Tests

```bash
# Tests unitaires
npm test

# Tests avec couverture
npm test -- --coverage

# Tests en mode watch
npm test -- --watch
```

## 📦 Optimisations

### Performance
- **Code Splitting** - Chargement à la demande
- **Lazy Loading** - Composants différés
- **Image Optimization** - Formats modernes
- **Bundle Analysis** - Analyse de la taille

### SEO
- **Meta Tags** - Optimisation des métadonnées
- **Structured Data** - Données structurées
- **Sitemap** - Plan du site
- **Open Graph** - Partage social

### Accessibilité
- **ARIA Labels** - Étiquettes d'accessibilité
- **Keyboard Navigation** - Navigation clavier
- **Screen Reader** - Compatible lecteurs d'écran
- **Color Contrast** - Contraste des couleurs

## 🤝 Contribution

1. Fork le projet
2. Créer une branche feature (`git checkout -b feature/AmazingFeature`)
3. Commit les changements (`git commit -m 'Add AmazingFeature'`)
4. Push vers la branche (`git push origin feature/AmazingFeature`)
5. Ouvrir une Pull Request

## 📄 Licence

Ce projet est sous licence MIT. Voir le fichier `LICENSE` pour plus de détails.

## 📞 Support

Pour toute question ou problème :
- Email : support@educonnect.fr
- Documentation : [docs.educonnect.fr](https://docs.educonnect.fr)
- Issues GitHub : [github.com/educonnect/issues](https://github.com/educonnect/issues)
