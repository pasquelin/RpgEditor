<?php

defined('SYSPATH') OR die('No direct access allowed.');

$config['version'] = '1.0.0'; //Version de votre jeu

$config['name'] = 'Enigma Cube'; //Nom de votre jeu

$config['loginUser'] = TRUE; //Afficher la partie login user

$config['registerUser'] = TRUE; //Afficher la partie register user

$config['debug'] = TRUE; //Afficher la partie debug

$config['cache'] = FALSE; //Activer ou non le cache

$config['money'] = 'pts'; // money du jeu

$config['initialPosition'] = array('x' => 1, 'y' => 1, 'z' => 1, 'region' => 1); //position initial lors de la création d'un joueur

$config['initialHandRight'] = 12; //Arme par defaut

$config['initialSpeed'] = 2; //Vitesse que le joueur possède lors de son initialisation

$config['initialGravity'] = 0.7; //Gravité que le joueur possède lors de son initialisation

$config['initialArgent'] = 1000; //Argent que le joueur possède lors de son initialisation

$config['initialAvatar'] = 'default.png'; //Avatar que le joueur possède lors de son initialisation

$config['initialHP'] = 100; //HP que le joueur possède lors de son initialisation (ATTENTION la valeur vaut pour le max hp et la valeur de celui du joueur (100% au final))

?>