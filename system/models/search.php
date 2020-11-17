<?php

defined( 'SYSPATH' ) OR die( 'No direct access allowed.' );

/**
 * Permet de faire une recherche en JSON pour les tableaux.
 *
 * @package Search
 * @author Pasquelin Alban
 * @copyright (c) 2011
 * @license http://www.openrpg.fr/license.html
 * @version 2.0.0
 */
class Search_Model extends Model {

		/**
		 * Permet de créer une instance et donc de ne pas faire des doublons.
		 * 
		 * @var object protected
		 */
		protected static $instance;

		/**
		 * Permet de connaitre le nombre total de résultat.
		 * 
		 * @var integer private
		 */
		private $iFilteredTotal = 0;

		/**
		 * Methode : Incremente la class pour eviter les doublons d'appel.
		 * @return
		 */
		public static function instance()
		{
				if( Search_Model::$instance === NULL )
						return new Search_Model;

				return Search_Model::$instance;
		}

		/**
		 * Paramètre de la recherche.
		 *
		 * @param string liste des colonne à afficher et a rechercher
		 * @param string nom de la table
		 * @param object class input
		 * @param mixe array/string pour le where
		 * @return	 object les lignes trouvées
		 */
		public function indexRecherche( $arrayCol, $table, $input, $where = false )
		{
				$this->db->select( 'SQL_CALC_FOUND_ROWS '.implode( ', ', $arrayCol ) )->from( $table );

				//limit
				$iDisplayStart = $input->get( 'iDisplayStart' );
				$iDisplayLength = $input->get( 'iDisplayLength' );

				if( $iDisplayStart !== false && $iDisplayLength != '-1' )
						$this->db->limit( $iDisplayLength, $iDisplayStart );

				//order
				$iDisplayStart = $input->get( 'iSortCol_0' );

				if( $iDisplayStart !== false )
				{
						for( $i = 0; $i < intval( $input->get( 'iSortingCols' ) ); $i++ )
								if( $input->get( 'bSortable_'.intval( $input->get( 'iSortCol_'.$i ) ) ) == 'true' )
										$sOrder[$arrayCol[intval( $input->get( 'iSortCol_'.$i ) )]] = $input->get( 'sSortDir_'.$i );

						if( !isset( $sOrder[$arrayCol[0]] ) )
								$sOrder[$arrayCol[0]] = 'DESC';

						$this->db->orderby( $sOrder );
				}

				//where
				$sSearch = $input->get( 'sSearch' );

				if( $sSearch !== false && !empty( $sSearch ) )
				{
						for( $i = 0; $i < count( $arrayCol ); $i++ )
								$sWhere[$arrayCol[$i]] = $sSearch;

						$this->db->where( '(1=0' );
						$this->db->orlike( $sWhere );
						$this->db->where( '1=1)' );
				}

				//filtre par colonne		
				for( $i = 0; $i < count( $arrayCol ); $i++ )
				{
						$bSearchable = $input->get( 'bSearchable_'.$i );
						$sSearch = $input->get( 'sSearch_'.$i );

						if( $bSearchable == 'true' && $sSearch !== false && !empty( $sSearch ) )
								$sWhereCol[$arrayCol[$i]] = $sSearch;
				}

				if( isset( $sWhereCol ) )
						$this->db->like( $sWhereCol );

				if( $where )
						$this->db->where( $where );

				$query1 = $this->db->get();

				$iFilteredTotal = $query1->count() ? $this->db->select( 'FOUND_ROWS() as rows' )->get()->current()->rows : 0;

				$this->iFilteredTotal = $iFilteredTotal;

				return $query1;
		}

		/**
		 * On traite le résultat pour du JSON.
		 *
		 * @param string data a ajouter au fichier JSON
		 * @param integer niveau de la recherche
		 * @return	 string JSON
		 */
		public function displayRecherche( $display, $sEcho = false )
		{
				$sOutput = '{';

				if( $sEcho )
						$sOutput .= '"sEcho": '.intval( $sEcho ).', ';

				$sOutput .= '"iTotalRecords": '.$this->iFilteredTotal.',';
				$sOutput .= '"iTotalDisplayRecords": '.$this->iFilteredTotal.',';
				$sOutput .= '"aaData": [ '.substr_replace( $display, "", -1 ).']';

				$sOutput .= ' }';

				return $sOutput;
		}

}

?>
