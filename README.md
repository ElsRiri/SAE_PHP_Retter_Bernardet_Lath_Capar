SAE PHP S3C :

Retter Guillaume (gretter6)

Bernardet Nicolas (ElsRiri - Riri)

Lath Victor (Victor.L - victorLath)

Capar Sila (silacpr)

-----------------------

## A.  English documentation
## B.  Readme développement web

-----------------------

# A.  English documentation

NetVOD is a streaming website where you can watch series easily and follow your advancement . It is developed essentially in PHP and mySQL for the database.

## Sign in/Sign up
At start you can access a login page where you can enter your login and your password, if you haven't any account you can sign up with your email and a password, this password needs to have more than 10 characters.
When you click on the submit button you receive a link where you can confirm your account.
If you are a user who is already registered and you forgot your password, you can click on a link “Mot de passe oublié ? ” (forgotten password) that moves you to pages where you can change your password.

## Catalog
When the user is logged in he can click on the “Affichage du catalogue” option that displays the catalog with all the series in. You can sort the series by their name, their appearance date in the catalog, their number of episodes, their release date, their age rating and their genres by ascendant and descendant order.

## Add/Remove from Favorite
When a user selects any episode in the catalog or favorite series he can add or remove this episode to your favorite series.

## Comment and rate 
The user can rate each episode between 0 and 5, and leave a comment. Moreover, the user can check the average rating by all accounts for each series. 

## Currently watching
When the user starts a new series, it will appear in the display “Series en Cours” (Currently watched series) which allows him to carry on his series. When he finishes one of them, it will be moved to “Series Terminées” (Completed series). 

## Profil 
The user can add further information about himself such as his name, surname and his favorite genre by clicking the “Ajouter information à votre profil” option. 


# B.  Readme développement web

Fonctionnalités de base :


## 1. Identification/Authentification - Formulaire de login :

L’utilisateur se connecte à l’application en fournissant un identifiant (@mail) et un mot de passe.
Si l’authentification réussit, l’utilisateur accède à la plateforme et peut utiliser/gérer ses
informations et données personnelles : listes, profil etc...

(Nicolas Bernardet)

URL : https://webetu.iutnc.univ-lorraine.fr/www/capar7u/index.php?action=identification


## 2. Inscription sur la plateforme :

Un visiteur peut s’inscrire sur la plateforme ; il fournit un identifiant (@mail) et un mot de passe
(double saisie) dont la qualité est contrôlée. Un fois inscrit, il peut se connecter en fournissant
son couple identifiant/mot de passe.

(Nicolas Bernardet)

URL : https://webetu.iutnc.univ-lorraine.fr/www/capar7u/index.php?action=inscription


## 3. Affichage du catalogue de séries :

Une fois connecté, la page d’accueil permet à l’utilisateur de demander l’affichage du catalogue
des séries disponibles. Le catalogue est affiché sous la forme d’une liste indiquant le titre de la
série, une image représentative.

(Guillaume Retter)

URL : https://webetu.iutnc.univ-lorraine.fr/www/capar7u/index.php?action=DisplayCatalogueAction


## 4. Affichage détaillé d’une série et de la liste de ses épisodes :

Lors d’un click sur une série dans la liste, la série est affichée en détail : titre, genre, public visé,
descriptif, année de sortie, date d’ajout sur la plateforme, nombre d’épisodes. La liste des
épisodes de la série est également affichée, avec pour chaque épisode : numéro, titre, durée,
image.

(Victor Lath, Sila Capar)

URL : https://webetu.iutnc.univ-lorraine.fr/www/capar7u/index.php?action=DisplaySerieAction&idserie=2


## 5. Affichage/visionnage d’un épisode d’une série :

Lors d’un click sur un épisode dans la liste, affichage détaillé de l’épisode : image, titre, résumé,
durée.

(Sila Capar)

URL : https://webetu.iutnc.univ-lorraine.fr/www/capar7u/index.php?action=DisplayEpisode&idepisode=6


## 6. Ajout d’une série dans la liste de préférence d’un utilisateur :

Lorsqu’une série est affichée, possibilité de l’ajouter à la liste de préférence de l’utilisateur au
travers d’un bouton « ajouter à mes préférences ».

(Nicolas Bernardet / Guillaume Retter)

URL : https://webetu.iutnc.univ-lorraine.fr/www/capar7u/index.php?action=DisplaySerieAction&idserie=2

PS : Cliquer sur ajouter aux favoris après avoir cliqué sur l'url


## 7. Page d’accueil d’un utilisateur : afficher ses séries préférées

La page d’accueil d’un utilisateur affiche la liste des séries qu’il a ajouté dans ses préférences.
La liste est cliquable : on peut afficher le détail d’une série à partir de cette liste.
La page d’accueil est affichée automatiquement après le login, ou par click sur un bouton
« retour à l’accueil » depuis toutes les pages.

(Guillaume Retter / Nicolas Bernardet)

URL : https://webetu.iutnc.univ-lorraine.fr/www/capar7u/index.php

PS : Etre connecté


## 8. Lors du visionnage d’un épisode, ajouter automatiquement la série à la liste « en cours » de l’utilisateur
Lorsqu’un épisode est visionné, la série contenant l’épisode est automatiquement ajoutée à la
liste « en cours » de l’utilisateur ; Cette liste apparaît sur la page d’accueil de l’utilisateur, de
façon similaire à la liste de préférence.
- Cette fonctionnalité se trouve dans la catégorie "Vos séries en cours"

(Victor Lath)

URL : https://webetu.iutnc.univ-lorraine.fr/www/capar7u/index.php?action=DisplaySerieEnCoursAction


## 9. Lors du visionnage d’un épisode d’une série, noter et commenter la série
Lors du visionnage d’un épisode d’une série, l’utilisateur peut saisir une note (1 à 5) et un
commentaire. La note et le commentaire concerne la série complète. Il n’y a qu’une note et un
seul commentaire par utilisateur pour une série.

(Guillaume Retter)

URL : https://webetu.iutnc.univ-lorraine.fr/www/capar7u/index.php?action=DisplayEpisode&idepisode=6

PS : note en bas


## 10. Lors de l’affichage d’une série, indiquer sa note moyenne et donner accès aux commentaires
Lors de l’affichage détaillé d’une série, la note moyenne obtenue par la série, calculée à partir
des notes attribuées par les utilisateurs, est affichée. Un lien permet d’accéder à l’affichage des
commentaires déposés par les utilisateurs ayant visionné la série.

(Sila Capar)

URL : https://webetu.iutnc.univ-lorraine.fr/www/capar7u/index.php?action=DisplaySerieAction&idserie=2

PS : Cliquer sur voir les commentaires



# Fonctionnalités étendues :


## 11. Activation de compte

Après inscription, un compte doit être activé pour être utilisable. Pour ce faire, une url contenant
un token unique, aléatoire et éphémère (courte durée d’utilisation) est générée. L’utilisateur doit
cliquer sur cette url pour activer son nouveau compte et pouvoir se connecter.
En principe, cette url est envoyée par mail ; pour simplifier le processus, elle est affichée sur la
page comme résultat de l’inscription.

(Guillaume Retter)

URL : https://webetu.iutnc.univ-lorraine.fr/www/capar7u/index.php?action=inscription


## 17. gestion du profil de l’utilisateur : ajouter des informations (nom, prénom, genre préféré ...)

L’utilisateur peut renseigner des informations le concernant dans son profil : nom, prénom,
genre préféré etc...

(Nicolas Bernardet, Sila Capar)

URL : https://webetu.iutnc.univ-lorraine.fr/www/capar7u/index.php?action=ajouterinfo


## 12. Recherche dans le catalogue par mots clés

Lors de l’affichage du catalogue, l’utilisateur peut saisir un ou plusieurs mots. Seules les séries
contenant ces mots dans le titre ou le descriptif sont affichées.

(Sila Capar)

URL : https://webetu.iutnc.univ-lorraine.fr/www/capar7u/index.php?action=DisplayCatalogueAction


## 13. Tri dans le catalogue

Lors de l’affichage du catalogue, possibilité de trier la liste affichée selon différents critères :
titre, date d’ajout sur la plateforme, nombre d’épisodes ...
- Cette option se trouve dans la catégorie "Catalogue"
(Victor Lath)

URL : https://webetu.iutnc.univ-lorraine.fr/www/capar7u/index.php?action=DisplayCatalogueAction


## 14. filtrage du catalogue par genre, par public

Lors de l’affichage du catalogue, filtrer le résultat selon le genre, ou selon le public.

(Sila Capar)

URL : https://webetu.iutnc.univ-lorraine.fr/www/capar7u/index.php?action=DisplayCatalogueAction


## 15. gestion de la liste de préférence : retrait

L’utilisateur peut supprimer des éléments de sa liste de préférence.

(Nicolas Bernardet)

URL : https://webetu.iutnc.univ-lorraine.fr/www/capar7u/index.php?action=DisplaySerieAction&idserie=2

PS : Cliquer sur le bouton Ajouter/Retirer des favs


## 16. Gestion de la liste « déjà visionnées »

Lorsque tous les épisodes d’une série ont été visualisés, la série est déplacée de la liste « en
cours » à la liste « déjà visionnées » ; Dans sa page d’accueil, l’utilisateur peut accéder à la
visualisation de cette liste.
- Les séries déjà visionnés se trouve dans la catégorie "Vos séries terminées".
(Victor Lath)

URL : https://webetu.iutnc.univ-lorraine.fr/www/capar7u/index.php?action=DisplaySerieTermine


## 18. accès direct à l’épisode à visionner lorsque l’on visualise une série qui est dans la liste « en cours »
- on peut accéder au dernier épisode regardé de la série à partir du catalogue et en cliquant ensuite sur la série, un bouton permettra d'accéder au dernier episode

(Victor Lath)


URL : https://webetu.iutnc.univ-lorraine.fr/www/capar7u/index.php?action=DisplaySerieEnCoursAction


## 19. Tri dans le catalogue selon la note moyenne
Cette option ce trouve dans le menu déroulant dans la catégorie catalogue 
(Sila Capar, Victor Lath, Nicolas Bernardet, Guillaume Retter)

URL : https://webetu.iutnc.univ-lorraine.fr/www/capar7u/index.php?action=DisplayCatalogueAction


## 20. mot de passe oublié

Lorsqu’un utilisateur a oublié son mot de passe, il peut accéder à une fonctionnalité de création
d’un nouveau mot de passe. Pour cela, il fourni son identifiant (@mail) et une url contenant un
token unique, aléatoire et éphémère est générée. En cliquant sur cette url, l’utilisateur accès à
un formulaire lui permettant de saisir un nouveau mot de passe.

(Guillaume Retter)

URL : https://webetu.iutnc.univ-lorraine.fr/www/capar7u/index.php?action=identification
