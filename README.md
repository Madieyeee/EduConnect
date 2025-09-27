# EduConnect

Une application web moderne pour connecter les étudiants aux établissements d'enseignement supérieur.

## 🎯 Description

EduConnect est une plateforme qui permet aux étudiants de rechercher et postuler dans des écoles, tout en offrant aux administrateurs un système de gestion complet des candidatures et des établissements.

## 👥 Acteurs

### Étudiant
- Création de compte et connexion
- Recherche d'écoles par critères (ville, filière, accréditation, prix, diplôme)
- Consultation des fiches détaillées des écoles
- Soumission de demandes d'inscription en ligne
- Suivi du statut des candidatures
- Contact avec EduConnect

### Admin EduConnect
- Gestion complète des écoles (CRUD)
- Configuration des frais de dossier
- Gestion des candidatures par école
- Mise à jour des statuts de candidature
- Suivi des commissions générées
- Export des données

## 🛠️ Stack Technique

- **Frontend**: React.js (responsive design)
- **Backend**: Laravel (API REST)
- **Base de données**: MySQL
- **Authentification**: JWT
- **Architecture**: Frontend et Backend séparés

## 📁 Structure du Projet

```
EduConnect/
├── backend/          # API Laravel
├── frontend/         # Application React
├── docs/            # Documentation
└── README.md        # Ce fichier
```

## 🚀 Installation

### Prérequis
- Node.js (v16+)
- PHP (v8.1+)
- Composer
- MySQL

### Backend (Laravel)
```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

### Frontend (React)
```bash
cd frontend
npm install
npm start
```

## 📊 Fonctionnalités Principales

### Pour les Étudiants
- ✅ Système d'authentification sécurisé
- ✅ Recherche avancée d'écoles
- ✅ Consultation des fiches établissements
- ✅ Candidature en ligne
- ✅ Suivi des demandes
- ✅ Interface responsive

### Pour les Administrateurs
- ✅ Dashboard de gestion
- ✅ CRUD des écoles
- ✅ Gestion des candidatures
- ✅ Suivi des commissions
- ✅ Rapports et exports

## 🔐 Sécurité

- Authentification JWT
- Validation des données côté serveur
- Protection CSRF
- Hashage sécurisé des mots de passe
- Autorisation basée sur les rôles

## 📱 Design

- Interface moderne et intuitive
- Design responsive (mobile-first)
- Accessibilité optimisée
- UX/UI soignée

## 🤝 Contribution

1. Fork le projet
2. Créer une branche feature (`git checkout -b feature/AmazingFeature`)
3. Commit les changements (`git commit -m 'Add some AmazingFeature'`)
4. Push vers la branche (`git push origin feature/AmazingFeature`)
5. Ouvrir une Pull Request

## 📄 Licence

Ce projet est sous licence MIT. Voir le fichier `LICENSE` pour plus de détails.

## 📞 Contact

Pour toute question ou suggestion, n'hésitez pas à nous contacter.

---

**EduConnect** - Connecter l'avenir de l'éducation 🎓
