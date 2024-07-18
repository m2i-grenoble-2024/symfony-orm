# Symfony With ORM
Un projet symfony avec l'ORM doctrine

## How To Use
1. Cloner le projet
2. Aller dans le dossier et faire un `composer install`
3. Créer un .env.local avec une url de connexion à une base de données
4. Créer la base de données `php bin/console do:da:cr`
5. On exécute la migration avec `php bin/console do:mi:mi`

## Les commandes principales et quand les utiliser

`bin/console make:entity` (ou ma:en) : pour créer une entité via le cli avec ses propriétés et ses relations avec les autres entités (crée aussi les repositories). Peut également être utilisée pour modifier une entité existante.

`bin/console make:migration` (ou ma:mi) : Pour créer un fichier de migration qui contiendra les requête SQL à exécuter pour passer de l'état actuel de la base de données à ce qu'on a définit dans nos entités. Je conseil de faire une migration une première fois quand on a définit toutes nos entités, puis d'en refaire seulement si en cours de projet on se rend compte qu'on a oublié des choses ou qu'on doit modifier notre structure de bdd

`bin/console doctrine:migrations:migrate` (ou do:mi:mi) : Exécute toutes les migrations du projet, à exécuter quand on clone ou qu'on pull un projet, ou après avoir créer une migration avec ma:mi

`bin/console doctrine:database:create` (ou do:da:cr) : Crée la base de données en se basant sur la DATABASE_URL

`bin/console doctrine:database:drop` (ou do:da:dr) : Drop la base de données

### Workflow possible
1. Créer le .env.local avec mon DATABASE_URL
2. Créer la bdd avec do:da:cr
3. Créer les différentes entités avec leurs propriétés propres avec ma:en
4. Modifier les entités pour rajouter les relations (à nouveau avec ma:en en choisissant les entités existantes auxquelles on veut rajouter des relations)
5. Créer une migration avec ma:mi
6. Exécuter la migration avec do:mi:mi
7. Organiser un grand square dance pour fêter la création de notre couche data

## Exercice
### Le contrôleur de l'Article
1. Générer un contrôleur (`php bin/console ma:con`) ArticleController
2. Rajouter un constructeur avec 2 arguments private, un ArticleRepository $repo et un EntityManagerInterface $em
3. Utiliser le $this->repo pour faire les 2 routes de GET sur /api/article et /api/article/{id}
4. Utiliser le $this->em->persist() suivi d'un $this->em->flush() pour faire le POST (comme on l'avait fait dans le projet avec les chiens). Avant de persist, pourquoi pas assigner la date de maintenant au createdAt.
5. Utiliser les mêmes méthodes du $this->em pour faire le PUT
6. Utiliser le $this->em->find et le $this->em->remove suivi d'un $this->em->flush() pour faire la suppression
7. Pour le plaisir, pourquoi pas faire de la validation : le title et le content ne doivent pas être vides, et on va dire que le title doit faire entre 3 et 100 caractères