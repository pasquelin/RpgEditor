<?php

defined( 'SYSPATH' ) OR die( 'No direct access allowed.' );

/**
 * Permet de connaitre toutes les informations sur la : map.
 *
 * @package Map
 * @author Pasquelin Alban
 * @copyright (c) 2011
 * @license http://www.openrpg.fr/license.html
 * @version 2.0.0
 */
class Map_Model extends Model {

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
				if( Map_Model::$instance === NULL )
						return new Map_Model;

				return Map_Model::$instance;
		}

		/**
		 * Faire une sélection sur la table element_map.
		 *
		 * @param array les valeur du where
		 * @param integer limit de la requête
		 * @param string colonne sur le trie
		 * @param string colonne sélectionné
		 * @return mixe retourne un object sinon false
		 */
		public function select( $set = NULL, $limit = NULL, $orderby = NULL, $select = NULL )
		{
				if( $orderby )
						$orderby = array( $orderby => 'ASC' );

				return parent::model_select( 'map', $set, $limit, $select, $orderby );
		}

		/**
		 * Faire une insertion d'une ligne SQL.
		 *
		 * @param array valeur à insérer
		 * @return	 mixe retourne soit  un ID sinon false
		 */
		public function insert( array $set )
		{
				return parent::model_insert( 'map', $set );
		}

		/**
		 * Faire une mise à jour d'une ligne.
		 *
		 * @param array valeur à mettre à jour
		 * @param array valeur pour le where
		 * @return mixe retourne un object sinon false
		 */
		public function update( array $set, array $where )
		{
				return parent::model_update( 'map', $set, $where );
		}

		/**
		 * Supprimer une ligne.
		 *
		 * @param mixe string/array pour le where
		 * @return	 bool retour false ou true
		 */
		public function delete( $where )
		{
				return parent::model_delete( 'map', $where );
		}
}

?>
