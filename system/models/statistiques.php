<?php

 defined( 'SYSPATH' ) OR die( 'No direct access allowed.' );

 /**
	* Permet de connaitre toutes les statistiques.
	*
	* @package Statistique
	* @author Pasquelin Alban
	* @copyright (c) 2011
	* @license http://www.openrpg.fr/license.html
	* @version 2.0.0
	*/
 class Statistiques_Model extends Model {

	 /**
		* Permet de créer une instance et donc de ne pas faire des doublons.
		* 
		* @var object protected
		*/
	 protected static $instance;

	 /**
		* Permet de ne pas faire des multi appel d'object
		*
		* @return class return la classe construite
		*/
	 public static function instance()
	 {
		 if( Statistiques_Model::$instance === NULL )
			 return new Statistiques_Model;

		 return Statistiques_Model::$instance;
	 }

	 /**
		* Permet de connaitre toutes les stats concernant le jeu
		*
		* @return object retourne la ligne avec toutes les valeurs des stats
		*/
	 public function general()
	 {
		 $sql = 'SELECT
							( SELECT count(*) FROM users ) as nb_user,
							( SELECT count(*) FROM regions ) as nb_region,
							( SELECT count(*) FROM articles ) as nb_article,
							( SELECT count(*) FROM articles_category ) as nb_cat_article,
							( SELECT count(*) FROM roles ) as nb_role,
							( SELECT count(*) FROM quetes ) as nb_quete,
							( SELECT count(*) FROM map WHERE module_map IS NOT NULL ) as nb_module,
							( SELECT count(*) FROM map WHERE module_map = \'obstacle\' ) as nb_module_obstacle,
							( SELECT count(*) FROM map WHERE module_map = \'article\' ) as nb_module_article,
							( SELECT count(*) FROM map WHERE module_map = \'html\' ) as nb_module_html,
							( SELECT count(*) FROM map WHERE module_map = \'move\' ) as nb_module_move,
							( SELECT count(*) FROM map WHERE module_map = \'object\' ) as nb_module_object,
							( SELECT count(*) FROM map WHERE module_map = \'quete\' ) as nb_module_quete';

		 return $this->db->query( $sql )->current();
	 }

	 /**
		* Permet de connaitre une partie des stats concernant le jeu
		*
		* @return object retourne la ligne avec certaines valeurs des stats
		*/
	 public function general_lite()
	 {
		 $sql = 'SELECT
							( SELECT count(*) FROM users ) as nb_user,
							( SELECT count(*) FROM regions ) as nb_region,
							( SELECT count(*) FROM articles ) as nb_article,
							( SELECT count(*) FROM quetes ) as nb_quete,
							( SELECT count(*) FROM map WHERE module_map IS NOT NULL ) as nb_module';

		 return $this->db->query( $sql )->current();
	 }

	 /**
		* Permet de connaitre le top user 
		*
		* @return object retourne les 3 meilleurs joueurs du jeu
		*/
	 public function top_user()
	 {
		 $query = $this->db->from( 'users' )->orderby( array( 'argent' => 'DESC', 'niveau' => 'DESC', 'xp' => 'DESC' ) )->limit( 10 )->get();

		 return $query->count() ? $query : FALSE;
	 }

	 /**
		* Permet de connaitre les stats d'un utilisateur
		*
		* @return object retourne la ligne avec certaines valeurs des stats
		*/
	 public function user_show( $id_user )
	 {
		 $sql = 'SELECT
							( SELECT count(*) FROM users_history WHERE type_element = \'change_map\' AND user_id = '.$id_user.' ) as nb_change_map,
							( SELECT count(*) FROM users_history WHERE type_element = \'quete_annul\' AND user_id = '.$id_user.' ) as nb_quete_annul,
							( SELECT count(*) FROM users_history WHERE type_element = \'quete_valide\' AND user_id = '.$id_user.' ) as nb_quete_valide,
							( SELECT count(*) FROM users_history WHERE type_element = \'gameover_bot_module\' AND user_id = '.$id_user.' ) as nb_gameover_bot_module,
							( SELECT count(*) FROM users_history WHERE type_element = \'gameover_bot\' AND user_id = '.$id_user.' ) as nb_gameover_bot';

		 return $this->db->query( $sql )->current();
	 }

 }

?>
