# Guide de déploiement sur Render

## Problème résolu : Erreur 500 Server Error

L'erreur 500 était causée par plusieurs problèmes de configuration :

1. **APP_KEY manquante** - Laravel nécessite une clé d'application
2. **Configuration de base de données incorrecte** - Render utilise PostgreSQL, pas MySQL
3. **Variables d'environnement de production mal configurées**
4. **Migration fresh qui supprimait les données à chaque redémarrage**

## Configuration requise sur Render

### 1. Variables d'environnement à configurer manuellement

Dans le dashboard Render, allez dans **Environment** et ajoutez :

```
APP_KEY=base64:VOTRE_CLE_GENEREE
```

**IMPORTANT** : Pour générer la clé APP_KEY :
```bash
php artisan key:generate --show
```

Copiez la valeur générée et ajoutez-la dans Render.

### 2. Configuration de la base de données

Le fichier `render.yaml` crée automatiquement une base de données PostgreSQL gratuite.
La variable `DATABASE_URL` sera automatiquement configurée.

### 3. URL de l'application

Mettez à jour `APP_URL` avec votre URL Render :
```
APP_URL=https://educonnect-9lt7.onrender.com
```

## Fichiers modifiés

- ✅ `render.yaml` - Configuration du service Render
- ✅ `start.sh` - Script de démarrage optimisé
- ✅ `Dockerfile` - Utilise le nouveau script de démarrage

## Étapes de déploiement

1. **Commit et push des changements** :
```bash
git add render.yaml start.sh Dockerfile RENDER_DEPLOYMENT.md
git commit -m "Fix: Configuration pour déploiement Render"
git push origin main
```

2. **Sur Render Dashboard** :
   - Le redéploiement devrait se déclencher automatiquement
   - Ou cliquez sur "Manual Deploy" > "Deploy latest commit"

3. **Configurer APP_KEY** :
   - Allez dans Environment
   - Ajoutez la variable `APP_KEY` avec la valeur générée
   - Sauvegardez et redéployez

4. **Première migration** (une seule fois) :
   - Connectez-vous au shell Render
   - Exécutez : `php artisan migrate:fresh --seed --force`
   - Cette commande ne s'exécutera plus automatiquement

## Vérification

Une fois déployé, vérifiez :
- ✅ L'application charge sans erreur 500
- ✅ La base de données est connectée
- ✅ Les routes fonctionnent correctement

## Dépannage

Si l'erreur 500 persiste :

1. **Vérifier les logs** :
   - Dans Render Dashboard > Logs
   - Cherchez les erreurs Laravel

2. **Variables d'environnement** :
   - Vérifiez que `APP_KEY` est définie
   - Vérifiez que `DATABASE_URL` est présente

3. **Permissions** :
   - Les dossiers `storage/` et `bootstrap/cache/` doivent être accessibles en écriture

## Support PostgreSQL

Le projet utilise maintenant PostgreSQL en production. Configuration dans `config/database.php` :

```php
'pgsql' => [
    'driver' => 'pgsql',
    'url' => env('DATABASE_URL'),
    // ...
]
```

## Notes importantes

- Le plan gratuit de Render peut avoir des temps de démarrage lents (cold starts)
- La base de données gratuite a une limite de 90 jours d'inactivité
- Les fichiers uploadés dans `storage/` seront perdus lors des redéploiements (utilisez un service de stockage externe pour la production)
