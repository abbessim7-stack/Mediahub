# Rapport de Qualité - MediaHub

## 1. Tests Automatisés
- **Nombre de tests écrits** : 9 tests fonctionnels.
- **Taux de réussite** : 100% (9 passed, 21 assertions).
- **Couverture** :
  - CRUD des catégories (création par admin).
  - Authentification (inscription réussie, échec de connexion).
  - Autorisation (un auteur peut modifier sa publication, mais pas celle d'un autre).
  - API (lecture publique, création refusée sans jeton).

## 2. Optimisation des requêtes (Problème N+1)
- **Requête identifiée** : La page de liste des publications (`/contenus`) exécutait une requête SQL supplémentaire pour chaque publication afin de récupérer sa catégorie et son auteur.
- **Correction** : Ajout du chargement anticipé (Eager Loading) avec `with(['categorie', 'auteur'])` et `withCount('commentaires')` dans la méthode `index()` du `ContenuController`.
- **Résultat** : Le nombre de requêtes SQL est passé de 20 (pour 9 publications) à seulement 3 requêtes fixes, quel que soit le nombre de publications.

## 3. Mise en cache
- **Donnée mise en cache** : La liste des catégories (`categories.liste`).
- **Durée de validité** : 3600 secondes (1 heure).
- **Invalidation** : Le cache est automatiquement vidé (`Cache::forget`) lors de la création, modification ou suppression d'une catégorie pour garantir des données à jour.
