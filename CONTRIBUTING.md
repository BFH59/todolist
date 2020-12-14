## COMMENT CONTRIBUER AU PROJET :

- Réaliser un fork (copie) du répertoire Github du projet
- Cloner localement votre fork

Commande: 
```
git clone https://github.com/Pseudo/todolist.git
```

- Installer le projet et ses dépendances (https://github.com/BFH59/todolist/blob/main/README.md)
- Créer une branche pour la feature sur laquelle vous travaillez:

Commande: 
```
git checkout -b nom-de-la-branche
```
-  Poussez la branche sur votre fork

Commande: 
```
git push origin nom-de-la-branche
```
- Ouvrir une pull request sur le répertoire Github du projet


## PROCESS DE QUALITE :

-  Suivre les coding standard de symfony 4.4 : https://symfony.com/doc/4.4/contributing/code/standards.html
-  Avant de réaliser votre PR, réalisez vos tests unitaire et fonctionnels avec un code coverage via PHP Unit

Commande : 
```
php bin/phpunit --coverage-html coverage
```

- Réalisation de tests : 
Se referer à la documentation officielle Symfony 4.4 : https://symfony.com/doc/4.4/testing.html
	Info: Dama doctrine bundle est installé avec le projet afin de ne pas persister les données en BDD.
