<?php

defined( 'SYSPATH' ) OR die( 'No direct access allowed.' );

class Quetes_Controller extends Template_Controller {

		private $quete;

		public function __construct()
		{
				parent::__construct();
				parent::access( 'quete' );

				$this->quete = Quete_Model::instance();
		}

		/**
		 * Methode : page de listing générale
		 */
		public function index()
		{
				$this->script = array( 'js/lib/jquery.dataTables', 'js/listing' );

				$this->template->titre = Kohana::lang( 'quete.all_quetes' );

				$this->template->contenu = new View( 'quetes/list' );
		}

		/**
		 * Methode : page de détail d'une user
		 */
		public function show( $idQuete = false )
		{
				if( !$idQuete || !is_numeric( $idQuete ) )
						return parent::redirect_erreur( 'quetes' );

				cookie::set( 'UserFilesPath', url::base().'../images/quetes/'.$idQuete );
				cookie::set( 'UserFilesAbsolutePath', DOCROOT.'../images/quetes/'.$idQuete );

				if( !cookie::get( 'UserFilesPath' ) )
						return url::redirect( 'quetes/show/'.$idQuete );

				if( !$quete = $this->quete->select( array( 'id_quete' => $idQuete ), 1 ) )
						return parent::redirect_erreur( 'quetes' );

				if( !$module = Map_Model::instance()->select( array( 'module_map' => 'quete' ), false ) )
						return url::redirect( 'regions?msg='.urlencode( Kohana::lang( 'quete.no_module' ) ) );

				$this->script = array( 'js/lib/jquery.validate', 'js/lib/jquery.facebox', 'js/quetes' );

				$this->css = array( 'form', 'quete', 'facebox' );

				$this->template->titre = array( Kohana::lang( 'quete.all_quetes' ) => 'quetes',
						Kohana::lang( 'quete.show_title', ucfirst( mb_strtolower( $quete->title ) ) ) => NULL );

				$this->template->button = TRUE;

				$this->template->navigation = parent::navigation( $idQuete, 'id_quete', 'quetes' );

				$this->template->contenu = new View( 'formulaire/form' );
				$this->template->contenu->action = 'quetes/save';
				$this->template->contenu->id = $idQuete;
				$this->template->contenu->formulaire = new View( 'quetes/show' );
				$this->template->contenu->formulaire->row = $quete;
				$this->template->contenu->formulaire->module = $module;
				$this->template->contenu->formulaire->bots = Map_Model::instance()->select( array( 'module_map' => 'fight' ), false );
				$this->template->contenu->formulaire->quete = $this->quete->select( array( 'id_quete !=' => $idQuete ) );
		}

		/**
		 * Methode : page qui va ajouter une ligne dans la BD et renvois vers la page détail
		 */
		public function insert()
		{
				$idQuete = $this->quete->insert( array( 'title' => Kohana::lang( 'quete.no_title' ) ) );

				return url::redirect( 'quetes/show/'.$idQuete.'?msg='.urlencode( Kohana::lang( 'form.crea_valide' ) ) );
		}

		/**
		 * Méthode : page qui gère la sauvegarde ou le delete avec un renvois soit au détail ou listing
		 */
		public function save( $type = FALSE, $idQuete = FALSE )
		{
				if( ($save = $this->input->post() ) !== FALSE )
				{
						if( isset( $save['id_objet'] ) && $save['id_objet'] )
								$save['id_objet'] = implode( ',', $save['id_objet'] );

						if( isset( $save['id_bot'] ) && $save['id_bot'] )
								$save['id_bot'] = implode( ',', $save['id_bot'] );

						if( isset( $save['fonction'] ) && ( trim( $save['fonction'] ) == '' || $save['fonction'] == '<?php ?>' ) )
								$save['fonction'] = '';

						if( $type == 'sauve' || $type == 'valid' )
								$this->quete->update( $save, $idQuete );
						elseif( $type == 'trash' )
								$this->quete->delete( $idQuete );
				}

				$url = 'quetes/show/'.$idQuete;

				if( $type == 'annul' || $type == 'valid' || $type == 'trash' )
						$url = 'quetes';

				return parent::redirect( $url, $type );
		}

		/**
		 * Methode : gestion du listing en ajax
		 */
		public function resultatAjax()
		{
				$this->auto_render = FALSE;

				if( !request::is_ajax() )
						return FALSE;

				$arrayCol = array( 'id_quete', 'title', 'element_detail_id_start', 'element_detail_id_stop', 'niveau', 'argent', 'status' );

				$searchAjax = Search_Model::instance();

				$arrayResultat = $searchAjax->indexRecherche( $arrayCol, 'quetes', $this->input );

				if( ($module = Map_Model::instance()->select( array( 'module_map' => 'quete' ), false ) ) !== FALSE )
						foreach( $module as $row )
								$showModule[$row->id] = $row;

				$display = false;

				foreach( $arrayResultat as $row )
				{
						$url = 'quetes/show/'.$row->id_quete;

						$v[] = '<center>'.$row->id_quete.'</center>';
						$v[] = html::anchor( $url, $row->title );
						$v[] = (isset( $showModule[$row->element_detail_id_start] ) ? $showModule[$row->element_detail_id_start]->title : Kohana::lang( 'form.inconnu' ) );
						$v[] = (isset( $showModule[$row->element_detail_id_stop] ) ? $showModule[$row->element_detail_id_stop]->title : Kohana::lang( 'form.inconnu' ));
						$v[] = $row->niveau;
						$v[] = number_format( $row->argent ).' '.Kohana::config( 'game.money' );
						$v[] = $row->status ? '<strong class="vert">'.Kohana::lang( 'form.actif' ).'</strong>' : '<strong class="rouge">'.Kohana::lang( 'form.no_actif' ).'</strong>';
						$v[] = '<center>'.html::anchor( $url, html::image( 'images/template/drawings.png', array( 'title' => Kohana::lang( 'form.edit' ), 'class' => 'icon_list' ) ) ).'</center>';

						$display .= '['.parent::json( $v ).'],';

						unset( $v );
				}

				echo $searchAjax->displayRecherche( $display, $this->input->get( 'sEcho' ) );
		}

}

?>
