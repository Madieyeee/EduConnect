# EduConnect Sénégal - Plateforme Éducative

**EduConnect Sénégal** est une plateforme web centralisée conçue pour le référencement d'établissements d'enseignement supérieur au Sénégal et la gestion simplifiée des candidatures étudiantes. Ce projet a été spécialement adapté pour un hackathon, avec un focus sur le contexte sénégalais.

## ✨ Contexte du Hackathon

Cette version d'EduConnect a été entièrement "sénégalisée" :
- **Monnaie** : Toutes les transactions et tous les frais sont en **Francs CFA (CFA)**.
- **Données** : Les écoles, étudiants et adresses sont basés au Sénégal.
- **Contenu** : Les emails, numéros de téléphone et autres informations sont adaptés au contexte local.
- **Écoles Vedettes** : Met en avant des institutions sénégalaises renommées comme l'Institut Supérieur d'Informatique (ISI).

## 🚀 Fonctionnalités

### Pour les Étudiants
- **Inscription et Connexion** : Créez un compte étudiant sécurisé.
- **Recherche d'Écoles** : Filtrez les écoles par ville, domaine d'études, accréditations, frais de scolarité et diplômes.
- **Profils d'Écoles Détaillés** : Consultez toutes les informations pertinentes sur un établissement.
- **Candidature en Ligne** : Soumettez vos candidatures directement depuis la plateforme.
- **Suivi des Candidatures** : Suivez en temps réel le statut de vos dossiers (Soumise, En cours, Acceptée, Rejetée).

### Pour l'Admin (EduConnect)
- **Tableau de Bord Complet** : Visualisez des statistiques clés (nombre d'écoles, d'étudiants, de candidatures, commissions totales).
- **Gestion des Écoles (CRUD)** : Ajoutez, modifiez et supprimez des écoles.
- **Gestion des Candidatures** : Acceptez, rejetez ou marquez les candidatures comme "en cours de traitement".
- **Export PDF** : Générez des rapports PDF pour la liste complète des écoles ou des étudiants inscrits.

## 🛠️ Stack Technique
- **Backend** : Laravel (PHP)
- **Frontend** : Blade, Tailwind CSS, JavaScript
- **Base de données** : MySQL
- **PDF** : `barryvdh/laravel-dompdf`

## ⚙️ Installation et Lancement

1.  **Cloner le dépôt**
    ```bash
    git clone https://github.com/Madieyeee/EduConnect.git
    cd EduConnect
    ```

2.  **Installer les dépendances**
    ```bash
    composer install
    ```

3.  **Configurer l'environnement**
    - Copiez le fichier `.env.example` en `.env`.
    - Configurez vos identifiants de base de données (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).
    - Générez la clé d'application :
    ```bash
    php artisan key:generate
    ```

4.  **Lancer les migrations et le seeding**
    Cette commande créera les tables et les remplira avec des données de test 100% sénégalaises.
    ```bash
    php artisan migrate --seed
    ```

5.  **Démarrer le serveur**
    ```bash
    php artisan serve
    ```
    La plateforme sera accessible à `http://127.0.0.1:8000`.

## 👤 Utilisateurs par Défaut

Après avoir lancé le seeder, vous pouvez utiliser les comptes suivants pour tester :

- **Compte Administrateur**
  - **Email** : `admin@educonnect.sn`
  - **Mot de passe** : `password`

- **Comptes Étudiants**
  - **Email** : `aminata.diallo@example.com`
  - **Mot de passe** : `password`
  
  - **Email** : `moussa.ndiaye@example.com`
  - **Mot de passe** : `password`

## 🧑‍💻 Développeurs

Ce projet a été développé par :
- **Madieyeee** - [GitHub](https://github.com/Madieyeee)
- **Dionecena** - [GitHub](https://github.com/Dionecena)


EduConnect est une plateforme centralisée qui référence les écoles, permet aux étudiants de postuler, et permet à EduConnect de suivre les candidatures et gérer la commission.

## 🎯 Objectifs

- Offrir une plateforme clé en main pour référencer les écoles et gérer les inscriptions des étudiants
- Les écoles n'ont pas à gérer leur profil (elles sont passives)
- EduConnect renseigne toutes les informations et suit les inscriptions
- À chaque inscription validée, une commission est perçue par EduConnect

## 👥 Acteurs

- **Étudiant** : consulte, postule, suit l'état de sa candidature
- **EduConnect (Admin plateforme)** : gère les fiches écoles, traite les candidatures, met à jour les statuts
- **Écoles** : entités passives (pas d'interaction directe avec le système)

## ✨ Fonctionnalités

### Pour les Étudiants
- ✅ Créer un compte (inscription + connexion avec Laravel Auth)
- ✅ Rechercher une école (ville, filière, accréditation, prix, diplôme, etc.)
- ✅ Consulter une fiche école (description, accréditations, prix, diplômes, rentrée, conditions)
- ✅ Faire une demande d'inscription en ligne (formulaire)
- ✅ Suivre sa demande (statuts : Soumise, En cours, Acceptée, Rejetée)
- ✅ Dashboard personnel avec statistiques

### Pour l'Admin EduConnect
- ✅ Tableau de bord admin avec statistiques
- ✅ Ajouter / modifier / supprimer une école
- ✅ Définir les frais de dossier par école
- ✅ Gérer les candidatures (voir, trier, mettre à jour statut)
- ✅ Suivre les commissions générées (basées sur les frais de dossier)
- ✅ Interface complète de gestion

## 🛠 Technologies utilisées

- **Framework** : Laravel 10 (PHP 8.1+)
- **Base de données** : MySQL
- **Front-end** : Blade Templates + Tailwind CSS + JavaScript
- **Authentification** : Laravel Auth intégré

## 📋 Prérequis

- PHP 8.1 ou supérieur
- Composer
- MySQL 5.7 ou supérieur
- Node.js et npm (optionnel, pour les assets)

## 🚀 Installation

### 1. Cloner le projet
```bash
git clone <repository-url>
cd EduConnect
```

### 2. Installer les dépendances
```bash
composer install
```

### 3. Configuration de l'environnement
```bash
# Copier le fichier d'environnement
copy .env.example .env

# Générer la clé d'application
php artisan key:generate
```

### 4. Configuration de la base de données
Modifiez le fichier `.env` avec vos paramètres de base de données :
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=educonnect
DB_USERNAME=root
DB_PASSWORD=votre_mot_de_passe
```

### 5. Créer la base de données
```sql
CREATE DATABASE educonnect CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 6. Exécuter les migrations et seeders
```bash
# Exécuter les migrations
php artisan migrate

# Peupler la base avec des données d'exemple
php artisan db:seed
```

### 7. Lancer le serveur de développement
```bash
php artisan serve
```

L'application sera accessible à l'adresse : `http://localhost:8000`

## 👤 Comptes de test

Après avoir exécuté les seeders, vous pouvez utiliser ces comptes :

### Administrateur
- **Email** : admin@educonnect.sn
- **Mot de passe** : password

### Étudiants
- **Email** : aminata.diallo@gmail.com | **Mot de passe** : password
- **Email** : moussa.ndiaye@gmail.com | **Mot de passe** : password
- **Email** : fatou.sall@gmail.com | **Mot de passe** : password

## 📊 Structure de la base de données

### Tables principales

#### `users`
- Stocke les informations des utilisateurs (étudiants et admins)
- Champs : name, email, password, role, phone, birth_date, address, city, postal_code

#### `schools`
- Contient toutes les informations des écoles
- Champs : name, description, city, address, fields_of_study (JSON), accreditations (JSON), diplomas (JSON), tuition_fees, application_fee

#### `applications`
- Gère les candidatures des étudiants
- Champs : user_id, school_id, field_of_study, diploma_level, motivation_letter, status, commission_amount

## 🎨 Interface utilisateur

L'interface utilise **Tailwind CSS** pour un design moderne et responsive :
- Design adaptatif (mobile-first)
- Composants réutilisables
- Animations et transitions fluides
- Interface intuitive et accessible

## 🔐 Sécurité

- Authentification Laravel intégrée
- Protection CSRF sur tous les formulaires
- Validation des données côté serveur
- Middleware de sécurité
- Hashage sécurisé des mots de passe

## 📱 Fonctionnalités JavaScript

- Recherche dynamique d'écoles avec filtres
- Compteur de caractères pour les lettres de motivation
- Menu mobile responsive
- Messages flash auto-disparaissants
- Formulaires dynamiques (ajout/suppression de champs)

## 🚀 Déploiement

### Configuration pour la production

1. **Variables d'environnement** :
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://votre-domaine.com
```

2. **Optimisations** :
```bash
# Cache des configurations
php artisan config:cache

# Cache des routes
php artisan route:cache

# Cache des vues
php artisan view:cache

# Optimisation de l'autoloader
composer install --optimize-autoloader --no-dev
```

3. **Permissions** :
```bash
# Permissions pour les dossiers storage et bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

## 📈 Fonctionnalités avancées

### Système de commissions
- Calcul automatique des commissions basé sur les frais de dossier
- Suivi des paiements de commissions
- Statistiques financières dans le dashboard admin

### Gestion des statuts
- **Soumise** : Candidature nouvellement créée
- **En cours** : Candidature en cours d'examen
- **Acceptée** : Candidature acceptée (commission générée)
- **Rejetée** : Candidature refusée

### Recherche avancée
- Filtres multiples (ville, filière, diplôme, prix)
- Recherche textuelle
- Pagination des résultats
- Tri et affichage optimisés

## 🔧 Maintenance

### Commandes utiles
```bash
# Nettoyer le cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Vérifier l'état de l'application
php artisan about

# Exécuter les tests (si configurés)
php artisan test
```

### Logs
Les logs de l'application sont stockés dans `storage/logs/laravel.log`

## 🤝 Contribution

1. Fork le projet
2. Créer une branche pour votre fonctionnalité (`git checkout -b feature/AmazingFeature`)
3. Commit vos changements (`git commit -m 'Add some AmazingFeature'`)
4. Push vers la branche (`git push origin feature/AmazingFeature`)
5. Ouvrir une Pull Request

## 📝 Licence

Ce projet est sous licence MIT. Voir le fichier `LICENSE` pour plus de détails.

## 📞 Support

Pour toute question ou problème :
- Email :madieyepro@gmail.com
- Documentation : [Wiki du projet]
- Issues : [GitHub Issues](https://github.com/Madieyeee/EduConnect/issues)

## 🎉 Remerciements

Merci à tous les contributeurs qui ont participé à ce projet !

---

**EduConnect** - Votre plateforme de référence pour l'éducation supérieure 🎓
