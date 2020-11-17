<?php

 defined( 'SYSPATH' ) OR die( 'No direct access allowed.' );

 /**
	* Passerel pour créer une requête SQL en générale.
	*
	* @package Requete SQL
	* @author Pasquelin Alban
	* @copyright (c) 2011
	* @license http://www.openrpg.fr/license.html
	* @version 2.0.0
	*/
 class Model_Core {

	 /**
		* Permet de faire passer l'object database.
		* 
		* @var object protected
		*/
	 protected $db = false;
	 /**
		* Permet de faire passer l'object cache.
		* 
		* @var object protected
		*/
	 protected $cache = false;

	 public function __construct()
	 {
		 if( !is_object( $this->db ) )
			 $this->db = Database::instance( 'default' );

		 if( !is_object( $this->cache ) )
			 $this->cache = Cache::instance();
	 }

	 /**
		* Permet de connaitre l'élément qui l'ID suivant/précédent.
		* 
		* exemple = navigation(100,'id','table');
		*
		* @param integer ID élément
		* @param string colonne SQL qui permet de faire la liaison
		* @param string nom de la table
		* @return	 array ligne SQL de l'élément suivant/précédent
		*/
	 public function navigation( $id, $col, $from )
	 {
		 $array['previous'] = $array['next'] = false;

		 $sql = '(SELECT '.$col.' FROM '.$from.' WHERE '.$col.' < '.$id.' ORDER BY '.$col.' DESC LIMIT 1)
						UNION
						(SELECT '.$col.' FROM '.$from.' WHERE '.$col.' > '.$id.' LIMIT 1)';

		 $query = Database::instance( 'default' )->query( $sql );

		 if( isset( $query->current()->$col ) )
			 $array['previous'] = $query->current()->$col;

		 $query->next();

		 if( isset( $query->current()->$col ) )
			 $array['next'] = $query->current()->$col;

		 if( $array['previous'] > $id )
		 {
			 $array['next'] = $array['previous'];
			 $array['previous'] = false;
		 }

		 return $array;
	 }

	 /**
		* Sélection SQL selon des paramètres donnés.
		*
		* @param string nom de la table
		* @param mixe condition dexecution array/string
		* @param integer nombre de ligne à retourner (limit)
		* @param string nom des colonnes à sélectionner
		* @param array ordre de la selection
		* @return	 object informations de/des ligne(s) trouvée(s)
		*/
	 protected function model_select( $from, $where = FALSE, $limit = FALSE, $select = FALSE, $orderby = FALSE )
	 {
		 if( $select )
			 $this->db->select( $select );

		 if( $where )
			 $this->db->where( $where );

		 if( $limit )
			 $this->db->limit( $limit );

		 if( $orderby )
			 $this->db->orderby( $orderby );

		 $query = $this->db->from( $from )->get();

		 return $query->count() ? ( $limit && $limit < 2 ? $query->current() : $query ) : FALSE;
	 }

	 /**
		* Update SQL selon des paramètres donnés.
		*
		* @param string nom de la table
		* @param array set à mettre à jour
		* @param mixe condition d'execution array/string
		* @return	 bool si execution est true ou false
		*/
	 protected function model_update( $from, array $array, $where )
	 {
		 return $this->db->update( $from, $array, $where );
	 }

	 /**
		* insert SQL selon des paramètres donnés.
		*
		* @param string nom de la table
		* @param array set à inserer
		* @return	 mixe si execution est true ça retourne ID ou false
		*/
	 protected function model_insert( $from, $array )
	 {
		 if( ($query = $this->db->insert( $from, $array ) ) !== FALSE )
			 return $query->insert_id();

		 return FALSE;
	 }

	 /**
		* delete SQL selon des paramètres donnés.
		*
		* @param string nom de la table
		* @param mixe condition d'execution array/string
		* @return	 bool si execution est true ou false
		*/
	 protected function model_delete( $from, $where )
	 {
		 return $this->db->delete( $from, $where );
	 }

 }

?>