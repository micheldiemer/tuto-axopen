# Symfony Tutoriel AX Open

## Installation

- Installer php ou xampp
- Installer composer
- Installer et configurer symfony et symfony-cli
- Installer nodejs (version 14 LTS recommandée)
- Installer yarn (ou utiliser npm)
- Exécuter `npm install` ou bien `yarn` pour télécharger les dépendences nodejs
- Exécuter `composer update` pour télécharger les démendances php
- Installer un serveur de base de doonées, par exemple mysql
- Créer une base de données vide ou créer un utilisatuer sur le serveur de base de données
- Mettre à jour la variable `DATABASE_URL` dans le fichier `.env`
- Créer la base de données : `php bin/console make:migration`
- Exécuter les migrations : `php bin/console doctrine:migrations:migrate`
- Compiler le CSS et le Javascript : `yarn dev` ou `yarn build`
- Lancer le serveur webpack : `yarn encore dev-server`
- Lancer le serveur symfony : `symfony serve --no-tls`
