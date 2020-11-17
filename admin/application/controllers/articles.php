<?php

defined( 'SYSPATH' ) OR die( 'No direct access allowed.' );

class Articles_Controller extends Template_Controller {

		private $acticles = FALSE;

		public function __construct()
		{
				parent::__construct();
				parent::access( 'article' );

				$this->acticles = Article_Model::instance();
		}

		/**
		 * Methode : page de listing générale
		 */
		public function index()
		{
				$this->script = array( 'js/lib/jquery.dataTables', 'js/listing' );

				$this->template->titre = Kohana::lang( 'article.all_article' );

				$this->template->contenu = new View( 'articles/list' );
		}

		/**
		 * Methode : page de détail d'un article
		 */
		public function show( $idActualite = FALSE )
		{
				if( !$idActualite || !is_numeric( $idActualite ) )
						return parent::redirect_erreur( 'articles' );

				cookie::set( 'UserFilesPath', url::base().'../images/articles/'.$idActualite );
				cookie::set( 'UserFilesAbsolutePath', DOCROOT.'../images/articles/'.$idActualite );

				if( !cookie::get( 'UserFilesPath' ) )
						return url::redirect( 'articles/show/'.$idActualite );

				if( !$actualite = $this->acticles->select( array( 'id_article' => $idActualite ), TRUE ) )
						return parent::redirect_erreur( 'articles' );

				$actualiteCategories = $this->acticles->selectListeCategories();

				$this->script = array( 'js/lib/jquery.validate', 'js/articles' );

				$this->css = array( 'form', 'article' );

				$this->template->titre = array( Kohana::lang( 'article.all_article' ) => 'articles',
						$actualite->title => NULL );

				$this->template->button = TRUE;

				$this->template->navigation = $this->acticles->navigation( $idActualite, 'id_article', 'articles' );
				$this->template->navigationURL = 'articles/show';

				$this->template->contenu = new View( 'formulaire/form' );
				$this->template->contenu->action = 'articles/save';
				$this->template->contenu->id = $idActualite;
				$this->template->contenu->formulaire = new View( 'articles/show' );
				$this->template->contenu->formulaire->row = $actualite;
				$this->template->contenu->formulaire->actualiteCategories = $actualiteCategories;
                $this->template->contenu->formulaire->regions = Region_Model::instance()->listing_parent();
		}

		/**
		 * Methode : page qui va ajouter une ligne dans la BD et renvois vers la page détail
		 */
		public function insert()
		{
				$idActualite = $this->acticles->insert( array( 'title' => Kohana::lang( 'article.no_title' ), 'article_category_id' => 1 ) );

				$oldumask = umask( 0 );
				mkdir( DOCROOT.'../images/articles/'.$idActualite, 0777, TRUE );
				umask( $oldumask );

				return url::redirect( 'articles/show/'.$idActualite.'?msg='.urlencode( Kohana::lang( 'form.crea_valide' ) ) );
		}

		/**
		 * Méthode : page qui gère la sauvegarde ou le delete avec un renvois soit au détail ou listing
		 */
		public function save( $type = FALSE, $idActualite = FALSE )
		{
				if( ($save = $this->input->post() ) !== FALSE )
				{
						if( isset( $_POST['article'] ) )
								$save['article'] = stripslashes( $_POST['article'] );

						if( $type == 'sauve' || $type == 'valid' )
								$this->acticles->update( $save, $idActualite );
						elseif( $type == 'trash' )
								$this->acticles->delete( $idActualite );
				}

				$url = 'articles/show/'.$idActualite;

				if( $type == 'annul' || $type == 'valid' || $type == 'trash' )
						$url = 'articles';

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

				$arrayCol = array( 'id_article', 'title', 'article_category_id', 'status' );

				$searchAjax = Search_Model::instance();

				$arrayResultat = $searchAjax->indexRecherche( $arrayCol, 'articles', $this->input );

				$display = false;

				foreach( $this->acticles->selectListeCategories() as $list )
						$categorie[$list->id_article_category] = $list->name;

				foreach( $arrayResultat as $row )
				{
						$url = 'articles/show/'.$row->id_article;

						$v[] = '<center>'.html::anchor( $url, $row->id_article ).'</center>';
						$v[] = html::anchor( $url, $row->title );
						$v[] = $row->article_category_id ? $categorie[$row->article_category_id] : Kohana::lang( 'article.no_category' );
						$v[] = $row->status ? '<center class="vert">'.Kohana::lang( 'form.actif' ).'</center>' : '<center class="rouge">'.Kohana::lang( 'form.no_actif' ).'</center>';
						$v[] = '<center>'.html::anchor( $url, html::image( 'images/template/drawings.png', array( 'title' => Kohana::lang( 'form.edit' ), 'class' => 'icon_list' ) ) ).'</center>';

						$display .= '['.parent::json( $v ).'],';

						unset( $v );
				}

				echo $searchAjax->displayRecherche( $display, $this->input->get( 'sEcho' ) );
		}

}

?>