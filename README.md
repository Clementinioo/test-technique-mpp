## Test Technique MonPetitPlacement

Faire une app To Do List avec API 

Temps passé dessus approximativement : ~4-5h 

## Librairies utilisées

API Platform pour la simplicité de la mise en place de l'API REST (/api)
Security/Registration pour l'authentification 

## Fonctionnalités

- Inscription
- Authentification login/pw / Déconnexion
- Création de liste
- Création de tâche
- Suppression en cascade : Si liste supprimé comportant des tâches, alors tâches également supprimé
- Edition/Suppression d'une liste/tâche uniquement possible pour son propriétaire
- Visualisation de toutes les listes et toutes les taches par tous les utilisateurs

## Difficultés rencontrées 

- Structure des données : 
    * Manque de dépendance ManyToOne entre List-Users et Task-List
    * Le fait de devoir rentrer l'Id d'une liste afin de rattacher une tâche à une liste. (Difficulté sur le ChoiceTypeField du formulaire de création de tâche)

## Motivations

Je reste très motivé à l'idée de rejoindre MonPetitPlacement dans l'idée de débuter ma carrière professionnelle, et en tant que développeur Junior, progresser et apprendre autour d'une équipe expérimentée. J'ai la volonté et la curiosité d'en apprendre davantage sur les bonnes techniques et les façon de coder à adopter avec Symfony et toute la stack technique. Je souhaite pouvoir développer mes compétences techniques et humaines au sein d'une bonne ambiance de travail.

