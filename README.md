# TP1 — Introduction au Framework Symfony 8.1

Module : Développement Web — Framework PHP 
Projet :`tp1_symfony` 
Environnement :Ubuntu, PHP, Symfony CLI, MySQL, Doctrine ORM, Twig et Git/GitHub.

## Objectif du TP

Ce TP permet de créer une application Symfony, de comprendre son architecture, de définir des contrôleurs et des routes, d'utiliser les templates Twig et de persister des données avec Doctrine ORM.

## Réponses aux questions

### Question 1 — Avertissements de `symfony check:requirements`

La commande `symfony check:requirements` vérifie si l'environnement possède les éléments nécessaires au fonctionnement de Symfony : version de PHP et extensions requises, entre autres.

### Question 2 — Rôle de `public/` et de `index.php`

Le dossier `public/` contient les fichiers accessibles publiquement par le navigateur, notamment les ressources publiques et le point d'entrée de l'application.

Le fichier `public/index.php` est le point d'entrée HTTP de Symfony. Les requêtes adressées à l'application passent par ce fichier, qui initialise l'application et transmet la requête au noyau Symfony. Le noyau traite ensuite la requête et produit une réponse.

### Question 3 — Variable qui contrôle le mode de l'application

La variable d'environnement est **`APP_ENV`

Elle indique l'environnement dans lequel l'application s'exécute, par exemple `dev` pour le développement ou `prod` pour la production. Elle est généralement définie dans le fichier `.env` ou dans la configuration de l'environnement.

### Question 4 — Accès à `/profil/abc`

La route du TP impose une contrainte numérique au paramètre `id` avec `requirements: ['id' => '\d+']`

L'URL `/profil/abc` ne correspond donc pas à cette route, car `abc` ne contient pas un identifiant numérique. Symfony ne sélectionne pas cette route et renvoie une erreur 404 si aucune autre route ne correspond à cette URL.

### Question 5 — Nombre et origine des routes

La commande permettant de lister les routes est :

```bash
php bin/console debug:router
```

Les routes créées dans le projet incluent notamment les routes de l'accueil, des articles et des tâches. Symfony peut également fournir des routes techniques liées au profiler et à la barre de débogage en environnement de développement.
Il y a 18 routes (version symfony 8.1)

### Question 6 — Différence entre `loop.index` et `loop.index0`

Dans une boucle `{% for %}` de Twig :

- `loop.index` donne la position de l'élément en commençant à 1.
- `loop.index0` donne la position de l'élément en commençant à 0.

Par exemple, pour le premier élément, `loop.index` vaut `1` et `loop.index0` vaut `0`

### Question 7 — Requête SQL contenue dans la migration Doctrine

La migration générée pour l'entité `Article` contient une instruction SQL `CREATE TABLE article` qui crée la table `article` dans la base de données. Elle définit les colonnes correspondant aux propriétés de l'entité, notamment :

- `id` : identifiant de l'article ;
- `titre` : titre ;
- `contenu` : contenu ;
- `auteur` : auteur ;
- `date_creation` : date de création ;
- `publie` : statut de publication.

### Question 8 — ParamConverter et recherche via Repository

Le ParamConverter est le nom utilisé dans le TP pour le mécanisme qui convertit automatiquement un paramètre de route, comme `{id}`, en objet entité Doctrine correspondant. Dans le contrôleur, on peut ainsi recevoir directement un objet `Article` au lieu de rechercher manuellement cet article à partir de son identifiant.
Son avantage est de réduire le code répétitif : il évite d'écrire soi-même la recherche dans le Repository et la vérification de l'existence de l'article. Si l'entité demandée n'est pas trouvée, le mécanisme de résolution de l'entité peut provoquer une réponse 404. Dans les versions récentes de Symfony, ce comportement est assuré par le résolveur d'entités Doctrine ; 

## Réalisations pratiques

### Partie 2 — Contrôleurs et routage

- Création d'un contrôleur d'accueil.
- Définition de routes avec paramètres.
- Vérification des routes avec `php bin/console debug:router`.

### Partie 3 — Templates Twig

- Création d'un template parent `templates/base.html.twig`.
- Utilisation de l'héritage Twig avec `{% extends 'base.html.twig' %}`.
- Création d'une page de liste d'articles avec boucle `{% for %}` et condition `{% if %}`.
- Ajout d'une barre de navigation.

### Partie 4 — Doctrine ORM et articles

- Création de l'entité `Article` et de son Repository.
- Création et exécution d'une migration Doctrine.
- Insertion d'un article en base de données.
- Affichage de la liste des articles depuis la base de données.
- Affichage du détail d'un article par son identifiant.

### Partie 5 — Mini-projet To-Do List

- Création de l'entité `Tache` avec `titre`, `description`, `terminee` et `dateCreation`.
- Génération et exécution de la migration.
- Création des routes pour lister, ajouter et afficher le détail des tâches.
- Création des templates Twig et ajout du lien « Mes tâches » dans la navigation.
- Bonus réalisé : terminer une tâche, barrer le titre des tâches terminées et afficher les tâches non terminées en premier.

## Commandes utiles

```bash
# Vérifier l'environnement Symfony
symfony check:requirements

# Lancer le serveur local
symfony server:start

# Lister les routes
php bin/console debug:router

# Générer une entité
php bin/console make:entity NomEntite

# Générer une migration
php bin/console make:migration

# Exécuter les migrations
php bin/console doctrine:migrations:migrate

# Vérifier l'état de Git
git status
```

## Git et GitHub

Le travail a été développé dans des branches de fonctionnalités puis envoyé sur GitHub. Les branches utilisées comprennent `feature-controllers`, `feature-twig-templates`, `feature-doctrine-articles` et `feature-taches`.

Les Pull Requests doivent être fusionnées dans `main` conformément au workflow demandé dans le TP.
