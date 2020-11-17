<?php

defined( 'SYSPATH' ) OR die( 'No direct access allowed.' );
/**
 * Permet de connaitre toutes les prenom
 *
 * @package Name
 * @author Pasquelin Alban
 * @copyright (c) 2011
 * @license http://www.openrpg.fr/license.html
 * @version 2.0.0
 */
class Name_Model extends Model {

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
				if( Name_Model::$instance === NULL )
						return new Name_Model;

				return Name_Model::$instance;
		}

		/**
		 * Faire une sélection sur la table prenom.
		 *
		 * @param mixe les valeur du where
		 * @param bool current ou non
		 * @param integer limit de la requête
		 * @return mixe retourne un object sinon false
		 */
		public function select( $where = FALSE, $current = FALSE, $limit = FALSE )
		{
				if( $where )
						$this->db->where( $where );

				if( $limit )
						$this->db->limit( $limit );

				$query = $this->db->from( 'prenoms' )->get();

				return $query->count() ? ( $current ? $query->current() : $query ) : FALSE;
		}

		/**
		 * Faire une insertion d'une ligne SQL.
		 *
		 * @param array valeur à insérer
		 * @return	 mixe retourne soit  un ID sinon false
		 */
		public function insert( array $set )
		{
				return parent::model_insert( 'prenoms', $set );
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
				return parent::model_update( 'prenoms', $set, array(
										'id_prenom' => $id ) );
		}

		/**
		 * Supprimer une ligne.
		 *
		 * @param integer ID de la ligne
		 * @return	 bool retour false ou true
		 */
		public function delete( $id )
		{
				return parent::model_delete( 'prenoms', array(
										'id_prenom' => $id ) );
		}
}

?>
