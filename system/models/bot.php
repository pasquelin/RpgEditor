<?php

defined( 'SYSPATH' ) OR die( 'No direct access allowed.' );

/**
 * Permet de connaitre toutes les informations sur un : bot.
 *
 * @package Bot
 * @author Pasquelin Alban
 * @copyright (c) 2011
 * @license http://www.openrpg.fr/license.html
 * @version 2.0.0
 */
class Bot_Model extends Model {

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
				if( Bot_Model::$instance === NULL )
						return new Bot_Model;

				return Bot_Model::$instance;
		}

		/**
		 * Faire une sélection sur la table bot.
		 *
		 * @param mixe les valeur du where
		 * @param integer limit de la requête
		 * @return mixe retourne un object sinon false
		 */
		public function select( $where = FALSE, $limit = FALSE )
		{
				return parent::model_select( 'bots', $where, $limit );
		}

		/**
		 * Faire une insertion d'une ligne SQL.
		 *
		 * @param array valeur à insérer
		 * @return	 mixe retourne soit  un ID sinon false
		 */
		public function insert( array $set )
		{
				return parent::model_insert( 'bots', $set );
		}

		/**
		 * Faire une mise à jour d'une ligne.
		 *
		 * @param array valeur à mettre à jour
		 * @param integer ID de la ligne
		 * @return mixe retourne un object sinon false
		 */
		public function update( array $set, $where )
		{
				if( !is_array( $where ) )
						$where = array( 'id' => $where );

				return parent::model_update( 'bots', $set, $where );
		}

		/**
		 * Supprimer une ligne bot.
		 *
		 * @param integer ID de la ligne
		 * @return	 bool retour false ou true
		 */
		public function delete( $id )
		{
				return parent::model_delete( 'bots', array( 'id' => $id ) );
		}

}

?>
