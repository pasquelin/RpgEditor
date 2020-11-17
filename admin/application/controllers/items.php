<?php

defined( 'SYSPATH' ) OR die( 'No direct access allowed.' );

class Items_Controller extends Template_Controller {

		private $item;

		public function __construct()
		{
				parent::__construct();
				parent::access( 'item' );

				$this->item = Item_Model::instance();
		}

		/**
		 * Methode : page de listing générale
		 */
		public function index()
		{
				$this->script = array( 'js/lib/jquery.dataTables', 'js/listing' );

				$this->template->titre = Kohana::lang( 'item.all_items' );

				$this->template->contenu = new View( 'items/list' );
		}

		/**
		 * Methode : page de détail d'une user
		 */
		public function show( $idItem = false )
		{
				if( !$idItem || !is_numeric( $idItem ) )
						return parent::redirect_erreur( 'items' );

				if( !$item = $this->item->select( FALSE, $idItem, TRUE ) )
						return parent::redirect_erreur( 'items' );

				$listItem = $listJob = FALSE;

				foreach( $this->item->select() as $row )
						$listItem[$row->id] = $row;

				$this->script = array( 'js/lib/jquery.validate', 'js/lib/jquery.facebox', 'js/items' );

				$this->css = array( 'form', 'item', 'facebox' );

				$this->template->titre = array( Kohana::lang( 'item.all_items' ) => 'items', Kohana::lang( 'item.show_name', ucfirst( mb_strtolower( $item->name ) ) ) => NULL );

				$this->template->button = TRUE;

				$this->template->navigation = parent::navigation( $idItem, 'id', 'items' );

				$this->template->contenu = new View( 'formulaire/form' );
				$this->template->contenu->action = 'items/save';
				$this->template->contenu->id = $idItem;
				$this->template->contenu->formulaire = new View( 'items/show' );
				$this->template->contenu->formulaire->row = $item;
				$this->template->contenu->formulaire->items = $listItem;
		}

		/**
		 * Methode : page qui va ajouter une ligne dans la BD et renvois vers la page détail
		 */
		public function insert()
		{
				$idItem = $this->item->insert( array( 'name' => 'item '.time() ) );

				return url::redirect( 'items/show/'.$idItem.'?msg='.urlencode( Kohana::lang( 'form.crea_valide' ) ) );
		}

		/**
		 * Méthode : page qui gère la sauvegarde ou le delete avec un renvois soit au détail ou listing
		 */
		public function save( $type = FALSE, $idItem = FALSE )
		{
				if( ($save = $this->input->post() ) !== FALSE )
				{
						if( $type == 'sauve' || $type == 'valid' )
								$this->item->update( $save, $idItem );
						elseif( $type == 'trash' )
								$this->item->delete( $idItem );
				}

				$url = 'items/show/'.$idItem;

				if( $type == 'annul' || $type == 'valid' || $type == 'trash' )
						$url = 'items';

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

				$arrayCol = array( 'id', 'name', 'image');

				$searchAjax = Search_Model::instance();

				$arrayResultat = $searchAjax->indexRecherche( $arrayCol, 'items', $this->input );

				$display = false;

				foreach( $arrayResultat as $row )
				{
						$url = 'items/show/'.$row->id;

						$v[] = '<center>'.$row->id.'</center>';
						$v[] = '<center><img src="'.url::base().'../images/items/'.$row->image.'" width="24" height="24" id="imageItem" class="imageItem" /></center>';
						$v[] = html::anchor( $url, $row->name );
						$v[] = '<center>'.html::anchor( $url, html::image( 'images/template/drawings.png', array( 'title' => Kohana::lang( 'form.edit' ), 'class' => 'icon_list' ) ) ).'</center>';

						$display .= '['.parent::json( $v ).'],';

						unset( $v );
				}

				echo $searchAjax->displayRecherche( $display, $this->input->get( 'sEcho' ) );
		}

		/**
		 * Methode :
		 */
		public function vignette( $img = false )
		{
				$this->auto_render = FALSE;

				if( !request::is_ajax() )
						return FALSE;

				$v = new View( 'formulaire/vignette' );
				$v->images = file::listing_dir( DOCROOT.'../images/items' );
				$v->selected = $img;
				$v->module = 'items';
				$v->width = 24;
				$v->height = 24;
				$v->render( true );
		}

		/**
		 * Methode : 
		 */
		public function delete_link( $idLink, $idItem )
		{
				$this->item->link_delete( $idLink );

				return url::redirect( 'items/show/'.$idItem );
		}

}

?>
