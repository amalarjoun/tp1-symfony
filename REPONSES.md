# TP2 — Formulaires, Validation et Relations Doctrine avec Symfony

## Question 1 : Pourquoi utiliser une classe FormType séparée ?

L'utilisation d'une classe FormType permet de séparer la logique du formulaire du contrôleur.

Ses avantages :
- Organiser le code.
- Faciliter la maintenance.
- Réutiliser le même formulaire dans plusieurs méthodes.
- Rendre le contrôleur plus simple et lisible.

## Question 2 : Expliquer le cycle de vie d'un formulaire Symfony.

Le cycle de vie d'un formulaire Symfony se déroule en plusieurs étapes :

1. Création du formulaire avec `createForm()`.
2. Affichage du formulaire dans le template Twig.
3. L'utilisateur remplit et soumet le formulaire.
4. `handleRequest()` récupère les données envoyées.
5. `isSubmitted()` vérifie si le formulaire a été soumis.
6. `isValid()` vérifie les données avec les contraintes de validation.
7. Si les données sont valides, `persist()` et `flush()` enregistrent les données dans la base de données.
8. Une redirection et un message de confirmation sont ensuite affichés.

## Question 3 : Quelle est la différence entre form_row() et form_label() + form_widget() ?

`form_row()` affiche automatiquement le label, le champ et les erreurs de validation.

`form_label()` et `form_widget()` permettent de personnaliser séparément l'affichage du label et du champ.

On utilise généralement `form_row()` pour simplifier le code et `form_label()` avec `form_widget()` lorsqu'on souhaite personnaliser davantage le formulaire.

## Question 4 : Quelle est la différence entre la validation côté client et côté serveur ?

La validation côté client utilise HTML5 et JavaScript pour vérifier les données directement dans le navigateur avant leur envoi.

La validation côté serveur utilise Symfony Validator pour vérifier les données reçues par le serveur.

La validation côté serveur est indispensable car la validation côté client peut être contournée. Elle garantit donc une meilleure sécurité et l'intégrité des données enregistrées.

## Question 5 : Quelle modification SQL crée la relation ? Qu'est-ce qu'une clé étrangère ?

La migration Doctrine ajoute une colonne `categorie_id` dans la table `article` et crée une clé étrangère qui référence la colonne `id` de la table `categorie`.

Une clé étrangère est un champ qui permet de relier deux tables et de garantir la cohérence des relations entre leurs données.

La relation ManyToOne signifie que plusieurs articles peuvent appartenir à une seule catégorie.

## Question 6 : Quels sont les avantages et les inconvénients de createFormBuilder() ?

**Avantages :**
- Simple et rapide à utiliser.
- Ne nécessite pas de créer une classe FormType séparée.
- Adapté aux petits formulaires.

**Inconvénients :**
- Le contrôleur devient plus long.
- Le code est moins organisé.
- Le formulaire est moins facile à réutiliser et à maintenir.

Une classe FormType séparée est préférable pour les formulaires complexes ou réutilisables.

## Question 7 : Pourquoi ne faut-il pas appeler persist() lors de la modification d'une entité existante ?

Lorsqu'une entité existante est récupérée depuis la base de données, Doctrine la considère comme une entité gérée (*Managed*).

Doctrine surveille automatiquement ses modifications.

Il suffit donc d'appeler `flush()` pour enregistrer les changements dans la base de données. Il n'est pas nécessaire d'appeler `persist()`.

## Question 8 : Qu'est-ce que CSRF ? Pourquoi utiliser POST au lieu de GET pour supprimer ?

CSRF signifie **Cross-Site Request Forgery**. C'est une attaque qui consiste à faire exécuter une action non souhaitée à un utilisateur authentifié.

Le token CSRF permet de vérifier que la requête provient bien du formulaire attendu.

On utilise POST pour supprimer une ressource car GET doit être réservé à la consultation des données et ne doit pas déclencher une action qui modifie ou supprime des informations.

La protection CSRF renforce la sécurité de cette opération.