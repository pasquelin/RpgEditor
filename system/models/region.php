<?php

defined( 'SYSPATH' ) OR die( 'No direct access allowed.' );

/**
 * Permet de connaitre toutes les informations sur une : région.
 *
 * @package Region
 * @author Pasquelin Alban
 * @copyright (c) 2011
 * @license http://www.openrpg.fr/license.html
 * @version 2.0.0
 */
class Region_Model extends Model {

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
				if( Region_Model::$instance === NULL )
						return new Region_Model;

				return Region_Model::$instance;
		}

		/**
		 * Faire une sélection sur la table région.
		 *
		 * @param mixe les valeur du where
		 * @param integer limit de la requête
		 * @return mixe retourne un object sinon false
		 */
		public function select( $where = FALSE, $limit = FALSE )
		{
				return parent::model_select( 'regions', $where, $limit );
		}

		/**
		 * Faire une insertion d'une ligne SQL.
		 *
		 * @param array valeur à insérer
		 * @return	 mixe retourne soit  un ID sinon false
		 */
		public function insert( array $set )
		{
				return parent::model_insert( 'regions', $set );
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
				return parent::model_update( 'regions', $set, array( 'id' => $id ) );
		}

		/**
		 * Supprimer une ligne.
		 *
		 * @param integer ID de la ligne
		 * @return	 bool retour false ou true
		 */
		public function delete( $id )
		{
				return parent::model_delete( 'regions', array( 'id' => $id ) );
		}

		/**
		 * Permet de récupérer l'arborescence parent/child des régions.
		 *
		 * @return	 mixe retourne un array ou false
		 */
		public function listing_parent()
		{
				$listing = false;

				$data = parent::model_select( 'regions', FALSE, FALSE, FALSE, array( 'id_parent' => 'ASC', 'name' => 'ASC' ) );

				if( $data->count() )
				{
						$children = array( );

						foreach( $data as $v )
						{
								$list = isset( $children[$v->id_parent] ) ? $children[$v->id_parent] : array( );

								$list[] = $v;

								$children[$v->id_parent] = $list;
						}
						return self::arbo( 0, array( ), $children );
				}

				return FALSE;
		}

		/**
		 * Supprimer tous les objets d'un utilisateur.
		 *
		 * @param integer ID
		 * @param array liste global
		 * @param array liste des child
		 * @param integer niveau de profondeur du tableau
		 * @return	array listing
		 */
		private static function arbo( $id, $list, &$children, $level = 0 )
		{
				if( isset( $children[$id] ) )
				{
						++$level;
						foreach( $children[$id] as $v )
						{
								$list[$v->id] = $v;
								$list[$v->id]->children = isset( $children[$v->id] ) ? count( $children[$v->id] ) : false;
								$list[$v->id]->level = $level;

								$list = self::arbo( $v->id, $list, $children, $level );
						}
				}
				return $list;
		}

}

?>
