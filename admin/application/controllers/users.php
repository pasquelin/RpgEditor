<?php

defined( 'SYSPATH' ) OR die( 'No direct access allowed.' );

class Users_Controller extends Template_Controller {

		public function __construct()
		{
				parent::__construct();
				parent::access( 'user' );
		}

		/**
		 * Methode : page de listing générale des utilisateur
		 */
		public function index()
		{
				$this->script = array( 'js/lib/jquery.dataTables', 'js/listing' );

				$this->template->titre = Kohana::lang( 'user.all_user' );

				$this->template->contenu = new View( 'users/list' );
		}

		/**
		 * Methode : page de détail d'un utilisateur
		 */
		public function show( $idUser )
		{
				if( !$user = $this->user->select( array( 'id' => $idUser ), TRUE ) )
						parent::redirect_erreur( 'users' );

				$role = new Roles_Model;

				$listeRole = $role->liste();

				$roleUser = $role->selectUser( $idUser );

				$this->script = array( 'js/lib/jquery.validate', 'js/lib/jquery.facebox', 'js/users' );

				$this->css = array( 'form', 'facebox', 'user' );

				$this->template->titre = array( Kohana::lang( 'user.all_user' ) => 'users', Kohana::lang( 'user.show_name', ucfirst( mb_strtolower( $user->username ) ) ) => NULL );

				$this->template->button = TRUE;

				$this->template->navigation = parent::navigation( $idUser, 'id', 'users' );

				$this->template->contenu = new View( 'formulaire/form' );
				$this->template->contenu->action = 'users/save';
				$this->template->contenu->id = $idUser;
				$this->template->contenu->formulaire = new View( 'users/show' );
				$this->template->contenu->formulaire->row = $user;
				$this->template->contenu->formulaire->roles = $listeRole;
				$this->template->contenu->formulaire->roleUser = $roleUser;
				$this->template->contenu->formulaire->regions = Region_Model::instance()->listing_parent();
				$this->template->contenu->formulaire->avatar = file::listing_dir( DOCROOT.'../images/character' );
		}

		/**
		 * Methode : connaitre les objet d'un user
		 */
		public function show_items( $idUser )
		{
				$this->auto_render = FALSE;

				if( !request::is_ajax() )
						return false;

				$item = Item_Model::instance();

				$listing_items = false;

				if( ($items_user = $item->select( $idUser ) ) !== FALSE )
						foreach( $items_user as $row )
								$listing_items[$row->id] = $row->nbr;

				$v = new View( 'users/items' );
				$v->userItem = $listing_items;
				$v->listItem = $item->tableau_type_tiem();
				$v->render( true );
		}

		/**
		 * Methode : connaitre les sorts d'un user
		 */
		public function show_sorts( $idUser )
		{
				$this->auto_render = FALSE;

				if( !request::is_ajax() )
						return false;

				$sort = Sort_Model::instance();

				$listing_sorts = false;

				if( ($sorts_user = $sort->user( $idUser ) ) !== FALSE )
						foreach( $sorts_user as $row )
								$listing_sorts[$row->id] = $row;

				$v = new View( 'users/sorts' );
				$v->userSort = $listing_sorts;
				$v->listSort = $sort->select();
				$v->render( true );
		}

		/**
		 * Methode : connaitre les sorts d'un user
		 */
		public function show_quetes( $idUser )
		{
				$this->auto_render = FALSE;

				if( !request::is_ajax() )
						return false;

				$v = new View( 'users/quetes' );
				$v->listQuete = Quete_Model::instance()->quete_user_join( $idUser );
				$v->render( true );
		}

		/**
		 * Page qui affiche les avatars pour modifier
		 * 
		 * @return  void
		 */
		public function listing_avatar()
		{
				$this->auto_render = FALSE;

				if( !request::is_ajax() )
						return FALSE;

				$v = new View( 'users/avatar' );
				$v->avatar = file::listing_dir( DOCROOT.'../images/character/' );
				$v->render( TRUE );
		}

		/**
		 * Methode : page qui va ajouter un utilisateur dans la BD et renvois vers la page détail
		 */
		public function insert()
		{
				$idUser = $this->user->insert( array( 'email' => time().'@site.com', 'username' => 'user_'.time() ) );

				return url::redirect( 'users/show/'.$idUser.'?msg='.urlencode( Kohana::lang( 'form.crea_valide' ) ) );
		}

		/**
		 * Methode : sauver les données d'un user et de ses objets
		 */
		public function save_items( $idUser )
		{
				$this->auto_render = FALSE;

				if( !request::is_ajax() )
						return false;

				if( ($value = $this->input->post( 'item' ) ) !== FALSE )
				{
						$item = Item_Model::instance();
						$item->user_delete_all( $idUser );

						foreach( $value as $key => $row )
								if( $row > 0 )
										for( $n = 0; $n < $row; $n++ )
												$item->user_insert( $idUser, $key );
				}
		}

		/**
		 * Methode : sauver les données d'un user et de ses sorts
		 */
		public function save_sorts( $idUser )
		{
				$this->auto_render = FALSE;

				if( !request::is_ajax() )
						return false;

				if( ($value = $this->input->post( 'sort' ) ) !== FALSE )
				{
						$sort = Sort_Model::instance();
						$sort->user_delete_all( $idUser );

						foreach( $value as $key => $row )
								if( $row )
										$sort->insert_user( $idUser, $key );
				}
		}

		/**
		 * Méthode : page qui gère la sauvegarde ou le delete avec un renvois soit au détail ou listing
		 */
		public function save( $type = FALSE, $idUser = FALSE )
		{
				if( ($save = $this->input->post() ) !== FALSE )
				{
						if( $save['password'] )
								$save['password'] = Auth::instance()->hash_password( $save['password'] );
						else
								unset( $save['password'] );

						if( $save['role'] )
						{
								$role = new Roles_Model;

								$role->deleteUser( $idUser );

								foreach( $save['role'] as $val )
										$role->insertUser( $idUser, $val );
						}

						unset( $save['role'] );

						if( $type == 'sauve' || $type == 'valid' )
								$this->user->update( $save, $idUser );
						elseif( $type == 'trash' )
								$this->user->delete( $idUser );
				}

				$url = 'users/show/'.$idUser;

				if( $type == 'annul' || $type == 'valid' || $type == 'trash' )
						$url = 'users';

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

				$arrayCol = array( 'id', 'username', 'last_login', 'email' );

				$searchAjax = Search_Model::instance();

				$arrayResultat = $searchAjax->indexRecherche( $arrayCol, 'users', $this->input );

				$display = false;

				foreach( $arrayResultat as $row )
				{
						$url = 'users/show/'.$row->id;

						$v[] = '<center>'.$row->id.'</center>';
						$v[] = html::anchor( $url, $row->username );
						$v[] = date::FormatDate( date::unix2mysql( $row->last_login ) );
						$v[] = $row->email;
						$v[] = '<center>'.html::anchor( $url, html::image( 'images/template/drawings.png', array( 'title' => Kohana::lang( 'form.edit' ), 'class' => 'icon_list' ) ) ).'</center>';

						$display .= '['.parent::json( $v ).'],';

						unset( $v );
				}

				echo $searchAjax->displayRecherche( $display, $this->input->get( 'sEcho' ) );
		}

}

?>
