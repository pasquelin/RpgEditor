<?php

defined( 'SYSPATH' ) OR die( 'No direct access allowed.' );

class Actions_Controller extends Template_Controller {

		public function __construct()
		{
				parent::__construct();
				parent::access( 'editeur' );
		}

		/**
		 * Méthode : pour empêcher un utilisateur d'accéder directement à ce controller
		 */
		public function index()
		{
				return self::redirection( Kohana::lang( 'logger.no_acces' ) );
		}

		/**
		 * Methode public : gestion du détail pour le formulaire
		 */
		public function form( $file, $id_region, $x, $y, $z )
		{
				$this->auto_render = FALSE;

				if( !request::is_ajax() )
						return FALSE;

				if( !file_exists( MODPATH.'plugins/views/'.$file.'/admin.php' ) )
				{
						echo '<h4 class="alert_error">'.Kohana::lang( 'action.alert_view', $file ).'</h4>';
						return FALSE;
				}

				$data = false;

				if( ( $select = Map_Model::instance()->select( array( 'region_id' => $id_region, 'x' => $x, 'y' => $y, 'z' => $z ), 1 ) ) && $select->action_map )
						$data = @unserialize( $select->action_map );

				$view = new View( $file.'/admin' );

				if( file_exists( MODPATH.'plugins/controllers/admin_'.$file.EXT ) )
						eval( 'Admin_'.ucfirst( $file ).'_Controller::index( $view );' );

				$view->row = $select;
				$view->data = $data;
				$view->render( true );
		}

}

?>