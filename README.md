ToDoList
========

Base du projet #8 : Améliorez un projet existant

https://openclassrooms.com/projects/ameliorer-un-projet-existant-1

INSTALLATION :

1/ Clonez le projet:

Commande: git clone https://github.com/BFH59/todolist.git

2/ Configuration :

Définissez vos variables d'environnement (connexion bdd, clé secrete..) en créant un fichier .env.local à la racine de votre projet. Vous pouvez réaliser une copie du fichier .env de démo présent dans ce repo git.

3/Télécharger et installer les dépendances liées au projet :

Commande : composer install

4/Création de la base de données :

Commande : php bin/console doctrine:database:create

5/Création des tables de la base de données avec les scripts de migrations :

Commande : php bin/console doctrine:migrations:migrate

6/ Créer les fixtures (jeu de données test) :

Commande : 

php app/console doctrine:fixtures:load
