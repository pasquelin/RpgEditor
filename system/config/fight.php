<?php

 defined( 'SYSPATH' ) OR die( 'No direct access allowed.' );

 $config['sort_defalut_bot'] = '17_5'; //effet par defaut que possède un bot 17_5 => nom de l'image le _5 veut dire qu'il y a 5 séquence sur l'image

 $config['score_min_attack'] = 1; //c'est le score le plus petit que peut faire un bot ou un joueur

 $config['pourcentage_dodge'] = 10; //Pourcentage de chance d'esquiver une attaque

 $config['game_over_argent'] = 2; //En cas de mort on divise l'argent par 2 sinon false pour ne pas modifier l'argent du joueur

 $config['taille_barre_info_for_fight'] = 120; //taille en pixel des barre info qui se trouve en haut de l image de combat
?>	