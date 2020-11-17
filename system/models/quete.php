<?php

 defined( 'SYSPATH' ) OR die( 'No direct access allowed.' );

 /**
	* Permet de connaitre toutes les informations sur une : quête.
	*
	* @package Quete
	* @author Pasquelin Alban
	* @copyright (c) 2011
	* @license http://www.openrpg.fr/license.html
	* @version 2.0.0
	*/
 class Quete_Model extends Model {

	 /**
		* Permet de créer une instance et donc de ne pas faire des doublons.
		* 
		* @var object protected
		*/
	 protected static $instance;

	 /**
		* Permet de ne pas faire des multi appel d'object.
		*
		* @return class return la classe construite
		*/
	 public static function instance()
	 {
		 if( Quete_Model::$instance === NULL )
			 return new Quete_Model;

		 return Quete_Model::$instance;
	 }

	 /**
		* Faire une sélection sur la table quete.
		*
		* @param mixe les valeur du where
		* @param integer limit de la requête
		* @return mixe retourne un object sinon false
		*/
	 public function select( $where = FALSE, $limit = FALSE )
	 {
		 return parent::model_select( 'quetes', $where, $limit );
	 }

	 /**
		* Faire une insertion d'une ligne SQL.
		*
		* @param array valeur à insérer
		* @return	 mixe retourne soit  un ID sinon false
		*/
	 public function insert( array $set )
	 {
		 return parent::model_insert( 'quetes', $set );
	 }

	 /**
		* Faire une mise à jour d'une ligne.
		*
		* @param array valeur à mettre à jour
		* @param integer ID de la ligne
		* @return mixe retourne un object sinon false
		*/
	 public function update( array $set, $id )
	 {
		 return parent::model_update( 'quetes', $set, array( 'id_quete' => $id ) );
	 }

	 /**
		* Supprimer une ligne.
		*
		* @param integer ID de la ligne
		* @return	 bool retour false ou true
		*/
	 public function delete( $id )
	 {
		 return parent::model_delete( 'quetes', array( 'id_quete' => $id ) );
	 }

	 /**
		* Permet de connaitre les quêtes d'un utilisateur
		* sans les informations sur la quête uniquement ID.
		*
		* @param integer ID de l'utilisateur
		* @param integer ID de la quete pour verifier si l'utilisateur l'a
		* @return	 mixe retourne un object ou false
		*/
	 public function quete_user( $user_id, $id_quete = FALSE )
	 {
		 $set = array( 'user_id' => $user_id );

		 if( $id_quete )
			 $set['quete_id'] = $id_quete;

		 return parent::model_select( 'users_quetes', $set, $id_quete ? 1 : FALSE );
	 }

	 /**
		* Permet de connaitre les quêtes d'un utilisateur 
		* avec une jointure pour avoir les informations de la quête.
		*
		* @param integer ID de l'utilisateur
		* @return	 mixe retourne un object ou false
		*/
	 public function quete_user_join( $user_id )
	 {
		 $query = $this->db->select( '*, users_quetes.status as status' )
				 ->from( 'users_quetes' )
				 ->join( 'quetes', 'quetes.id_quete', 'users_quetes.quete_id' )
				 ->where( 'users_quetes.user_id', $user_id )
				 ->get();

		 return $query->count() ? $query : FALSE;
	 }

	 /**
		* Insertion q'une quête pour un utilisateur
		*
		* @param integer ID de l'utilisateur
		* @param integer ID de la quête
		* @return mixe retourne ID de la ligne ou false
		*/
	 public function quete_insert( $user_id, $quete_id )
	 {
		 return parent::model_insert( 'users_quetes', array( 'user_id' => $user_id, 'quete_id' => $quete_id ) );
	 }

	 /**
		* Suppression q'une quête pour un utilisateur
		*
		* @param integer ID de l'utilisateur
		* @param integer ID de la quête
		* @return bool true ou false
		*/
	 public function quete_delete( $user_id, $quete_id )
	 {
		 return $this->db->query( 'DELETE FROM users_quetes WHERE user_id = '.$user_id.' AND quete_id = '.$quete_id.' LIMIT 1' );
	 }

	 /**
		* Mise à jour d'une quête pour un utilisateur
		*
		* @param array valeur à mettre à jour
		* @param integer ID de l'utilisateur
		* @param integer ID de la quête
		* @return bool true ou false
		*/
	 public function quete_update( array $array, $user_id, $quete_id )
	 {
		 return parent::model_update( 'users_quetes', $array, array( 'user_id' => $user_id, 'quete_id' => $quete_id ) );
	 }

 }

?>
