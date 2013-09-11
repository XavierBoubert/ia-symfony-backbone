ia
==

Petite I.A. écrite sur les frameworks Symfony et Backbone.js.

Elle copie simplement les phrases écrites par ses utilisateurs en réponses à ses phrases. Elle les garde en base de données MySQL pour y pouvoir ensuite répondre avec plus de cohérence.

Un indice de poids sur le nombre de réponses souvent utilisées ajoute également un peu plus de cohérence.


Demo
--------

Vous pouvez tester l'I.A. sur cette page et tenter de dialoguer avec elle : http://ia-symfony.xavierboubert.fr

Et vous pouvez regarder le graphique des réponses apprises sur cette page : http://ia-symfony.xavierboubert.fr/graph.php


Installation
--------

- Récupérez les fichiers sur votre serveur.
- Créez une base de données MySQL puis executez-y le fichier ia.sql (vous pouvez ensuite supprimer ce fichier)
- Mettez à jour le fichier 'engine/config.php' avec les infos de connexion de votre base.