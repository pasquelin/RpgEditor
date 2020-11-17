Enigma Cube
========
![1](https://f.cloud.github.com/assets/4077369/492751/e9cdff50-bae5-11e2-9402-00c6e70b44a7.jpg)

[Site officiel](http://www.enigmacube.com) — [Documentation](http://docs.openrpg.fr) — [Forum](http://www.openrpg.fr/forums/85-enigma-cube)

[Voir la vidéo de présentation](http://youtu.be/hSYKtFSRMsU)

#### Jeu en javascript et PHP ####

Enigma Cube est un jeu en WebGL s'appyant sur les frameworks THREE et sur KOHANA.

[Site officiel de THREE](http://threejs.org/) — [Documentation de THREE](http://threejs.org/docs/) — [Site officiel de KOHANA](http://kohanaframework.org/) — [Documentation de KOHANA](http://docs.openrpg.fr/creer-son-jeu)

Vous devrez résoudre des enigmes pour évoluer dans un monde n'utilisant que des cubes dans le principe de Minecraft et du PixelArt.
Vous aurez aussi l'occassion de discuter avec des habitants qui vous posseront des questions ou vous donneront des informations plus ou moins interressantes.
Il vous faudra donc accomplir des petits défis pour augmenter votre score et figurer dans le top 10 qui se trouve sur la page d'accueil.

### Administration ###

Une administration qui reste dans le principe de tous les CMS mais avec un éditeur 3D pour construire vos différentes carte et y placer des modules tel que la possibilité de changer de carte, placer un défi ou un simple checkpoint.

### Usage ###

Télécharger le script ou se connecter au repository
Vérifier que le fichier de configuration n'est pas présent :

```html
/System/config/database.php
```

Si c'est le cas, veuillez le supprimer

Lancer la page web index.php et vous serez redirectionné vers l'installateur qui s'occupera de faire la configuration de votre jeu.

Vous avez aussi la possibilité de lancer votre server node pour le multi-joueur qui est en cours de création.


### Change log ###
25 mai 2013 - **r12**

* Mise à jour des vignettes
* Ajout de nouveaux objets
* Respiration sous l'eau est prise en compte
* Amélioration déplacement dans l'eau
* Mise en place des skybox
* Mise en place du soleil (lumière)
* Image du sol prise en compte
* Correction bug couleur background
* Nettoyage panorama par skybox
* Correction Mysql
* Couleur ambience editable
* Correction far camera


20 mai 2013 - **r11**

* Gestion des bloc d'eau (On peut nager + audio)
* Affichage des objets ajouté manuellement sur l'éditeur de map
* Gestion de block transparent pour empecher un user de passer
* Ajout des objets 3D de blender
* Amélioration suppression geometry memory
* Possibilité d'éditer un objet et de le sauvegarder
* Mise a jour base de données
* Correction CSS GUI
* Retrait des zone
* Ajout de petit cube
* Base de donnée modifié
* Gestion des collision avec petit cube
* Image de chargement
* Ajout d'une classe qui gère les collisions
* Correctif bot, ils savent monter les marches
* Correction et prise en charge de l'environnement pour les PNJ pour l'attaque
* Correction PNJ déplacement
* Correction tire sur PNJ a travers décor
* Optimisation images
* Correction texte alerte
* Création vignette objet 3D
* Admin retrait regenerate map
* Ajout du profil
* Ajout du module de game over avec un nouvelle objet piège a pointe
* Amélioration UI mapping
* Mise a jour des objets (de nouveaux)


10 mai 2013 - **r10**

* Refonte de la partie audio, correction du bug lors de la premiere lecture et purge des fichiers inutiles
* Ajout de la parole sur les PNJ
* Amélioration sonore
* Retrait du clique continu dans l'admin de carte Issue #21
* Correction du déplacement d'un PNJ Issue #18
* Correction wireframe Ray en cas d'éloignement...
* Amélioration AI des PNJ pour les attaques
* Correction collision PNJ
* Correction performance PNJ non visible
* Mise à jour de la base de donnée voir dossier install/SQL
* Supprimer un PNJ mort de la scène au bout de X cycle
* Optimisation squelette PNJ
* Changement de homepage login
* Audio homepage
* Correction image template
* Correction bug sur les items.
* Module de son avec sauvegarde lors du passage
* Gestion des lumières
* Ajout de la dégradation de map et de sa fréquence
* Effet de jour/nuit Issue #23
* Ajout de la possibilité de personnaliser le JS via l'administration
* Correction administration
* Correction langues


05 mai 2013 - **r9**

* Correction avec les bloc à position Y
* Ajout de la capture d'écran avec la touche P sur toutes les cartes dans ladministration et le jeu.
* Touche G pour afficher ou masquer la grille dans ladministration.
* Correction clique continu sur les modules
* Correction supprimer élément dans l'admin
* Ajout d'images
* Prise en charge es caractère en HD
* Correction transparence
* Correction selection class animal
* Mise a jour data
* Mise en place d'une lumière pour les coups de feu
* Amélioration admin bot (choix entre person, ours ou chien) Issue #16
* Gestion des items a ramasser sur la map
* Mise en place de nouveau sons
* Correction option quête - possibilité de rajouter un humain sur une quête


26 avril 2013 - **r8**

* Ajout du clique continu pour l'éditeur admin/public
* Admin + editor du jeu amélioré et prise en charge du bouton ESC pour déplacement de caméra
* Prise en compte de module uniquement pour placer les bots (fini le aléatoire)
* Ajout d'un champ réponse dans la partie article
* Amélioration visuel et éditorial
* Correctif de lien


22 avril 2013 - **r7**

* Read Me
* Mise en place d'un nouvelle position du personnage quand t'il s'agrippe.
* Correctif du grab
* Correctif de l'affichage


21 avril 2013 - **r6**

* Correction bug JUMP
* Correction déplacement
* Calcul différent pour collision entre bots


21 avril 2013 - **r5**

* Variables avec Math.PI
* Loader
* Retrait du gamepad car inutile à mon gout pour le moment (evite de polluer le code)
* Mise à jour SQL
* Correction wording


20 avril 2013 - **r4**

* Correction UI
* Score UI
* Gestion des scores
* Mise à jour des commentaires dans le code


19 avril 2013 - **r3**

* Mise a jour login et browser + mise en place de JQuery 2


17 avril 2013 - **r2**

* Refonte global de la page de login
* optimisation variables


8 avril 2013 - **r1**

* Refonte changement carte
* Réorganisation des fichiers


** Mise en ligne **