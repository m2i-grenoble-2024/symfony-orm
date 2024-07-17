# Symfony With ORM
Un projet symfony avec l'ORM doctrine

## How To Use
1. Cloner le projet
2. Aller dans le dossier et faire un `composer install`
3. Créer un .env.local avec une url de connexion à une base de données
4. Créer la base de données `php bin/console do:da:cr`
5. On exécute la migration avec `php bin/console do:mi:mi`

## Exercice
### Le contrôleur de l'Article
1. Générer un contrôleur (`php bin/console ma:con`) ArticleController
2. Rajouter un constructeur avec 2 argument private, un ArticleRepository $repo et un EntityManagerInterface $em
3. Utiliser le $repo pour faire les 2 routes de GET sur /api/article et /api/article/{id}
4. Utiliser le $em->persist() suivi d'un $em->flush() pour faire le POST (comme on l'avait fait dans le projet avec les chiens)
5. Utiliser les mêmes méthodes du $em pour faire le update
6. Utiliser le $em->find et le $em->remove suivi d'un $em->flush() pour faire la suppression