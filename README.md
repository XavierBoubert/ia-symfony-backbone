ia
==

Petite I.A. écrite sur les frameworks Symfony et Backbone.js.

Elle copie simplement les phrases écrites par ses utilisateurs en réponses à ses phrases. Elle les garde en base de données MySQL pour y pouvoir ensuite répondre avec plus de cohérence.

Un indice de poids sur le nombre de réponses souvent utilisées ajoute également un peu plus de cohérence.


Demo
--------

Vous pouvez tester l'I.A. sur cette page et tenter de dialoguer avec elle : http://ia-symfony.xavierboubert.fr

L'API REST pour lui parler : http://ia-symfony.xavierboubert.fr/actions

Vous pouvez regarder le graphique des réponses apprises sur cette page : http://ia-symfony.xavierboubert.fr/graph

Vous pouvez également tester la version de DEV sur http://ia-symfony.xavierboubert.fr/app_dev.php/

Technologies
--------

Utilisation de ces différentes technologies :

- Symfony 2.x
- Doctrine
- Twig
- PHPUnit
- Assetic
- Compression des fichiers CSS et JavaScript avec la YUI Compressor
- API REST


Installation
--------

- Récupérez les fichiers sur votre serveur.
- Pour installer les dépendances de Symfony, utilisez la commande 'php composer.phar install' à la racine du projet.

**Création de la base de données :**

- Mettez à jour le fichier 'app/config/parameters.yml.dist' avec les infos de connexion de votre serveur MySQL.
- **Soit** vous pouvez créer une base de données MySQL puis y executer le fichier ia.sql
- **Soit** vous pouvez utiliser Doctrine pour la créer à votre place en utilisant les commandes suivantes (à la racine du projet) :
	- 'php app/console doctrine:database:create' *qui créera la base de données.*
	- 'php app/console doctrine:schema:update --force' *qui créera les tables du projet correspondantes aux entitées ORM*.

Dans tous les cas, supprimez ensuite le fichier 'ia.sql'.



Mise en PROD
--------

Utilisez le script 'app/mep.sh pour executer la mise en production du site (cela reset le cache et compile les fichiers JavaScript et CSS)


Tests Unitaires
--------

Utilisez le script 'app/unittesting.sh' pour executer la génération des tests unitaires