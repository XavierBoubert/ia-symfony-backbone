ia
==

Petite I.A. écrite sur les frameworks Symfony et Backbone.js.

Elle copie simplement les phrases écrites par ses utilisateurs en réponses à ses phrases. Elle les garde en base de données MySQL pour y pouvoir ensuite répondre avec plus de cohérence.

Un indice de poids sur le nombre de réponses souvent utilisées ajoute également un peu plus de cohérence.


Demo
--------

Vous pouvez tester l'I.A. sur cette page et tenter de dialoguer avec elle : http://ia-symfony.xavierboubert.fr
L'API REST pour lui parler : http://ia-symfony.xavierboubert.fr

Vous pouvez regarder le graphique des réponses apprises sur cette page : http://ia-symfony.xavierboubert.fr/graph

Vous pouvez également tester la version de DEV sur http://ia-symfony.xavierboubert.fr/app_dev/

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
- Créez une base de données MySQL puis executez-y le fichier ia.sql (vous pouvez ensuite supprimer ce fichier)
- Mettez à jour le fichier 'app/config/parameters.yml' avec les infos de connexion de votre base.


Mise en PROD
--------

Utilisez le script 'app/mep.sh pour executer la mise en production du site (cela reset le cache et compile les fichiers JavaScript et CSS)


Tests Unitaires
--------

Utilisez le script 'app/unittesting.sh' pour executer la génération des tests unitaires