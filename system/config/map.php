<?php
/*
 * ATTENTION POUR LES VALEUR DE TAILLE PENSEZ A MODIFIER LES CSS
 * car ils ne sont pas gérés en PHP donc par défaut 32 pour toutes les valeurs.
 * Si vous changer les paramètres de taille, aucun test et aucune validation ont été effectué RISQUE DE BUG !
 */

 defined( 'SYSPATH' ) OR die( 'No direct access allowed.' );

 $config['taille_map_visible_x'] = 992; //hauteur  (carré donc égale) de la map qui est visible
 
 $config['taille_map_visible_y'] = 480; //largeur  (carré donc égale) de la map qui est visible

 $config['taille_case'] = 32; //largeur et hauteur sont egale (carré) ATTENTION Si on divise la taille visible par la valeur d'un case on doit avoir un entier impaire car on retire une case pour le joueur au centre. ICI : ( ( 608 / 32 ) - 1) / 2 ce qui nous fait 9 case de chaque coté du joueur quand il est au centre

 $config['last_time_other_user'] = 120; //temps en seconde max pour savoir si on affiche ou non un autre joueur selon le temps de sa derniere action

 $config['taille_character_x'] = 32; //largeur du personnage sur la map
 
 $config['taille_character_y'] = 32; //hauteur du personnage sur la map
 
 $config['sound_map'] = 50; //volume en pourcentage de l'audio
?>