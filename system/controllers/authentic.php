<?php

defined( 'SYSPATH' ) or die( 'No direct access allowed.' );

class Authentic_Controller extends Controller {

		protected $user = false;
		protected $role = false;
		protected $administrateurs = false;

		/**
		 * Méthode : récuperer les informations utilisateur
		 */
		public function __construct()
		{
				parent::__construct();				

				if( !request::is_ajax() )
						cookie::set( 'urlAdminUrl', url::current() );

				$authentic = new Auth;

				if( $authentic->logged_in() )
				{
						$this->user = $authentic->get_user();

						$this->role->name = $this->user->roles->select_list( 'id', 'name' );

						$this->role->description = $this->user->roles->select_list( 'id', 'description' );

						if( Kohana::config( 'game.debug' ) && !in_array( 'admin', $this->role->name ) )
						{
								$authentic = Auth::instance();

								if( $authentic->logged_in() )
										$authentic->logout( TRUE );

								return url::redirect( 'auth?msg='.urlencode( Kohana::lang( 'form.maintenance' ) ) );
						}
						elseif( !in_array( 'login', $this->role->name ) )
								return url::redirect( 'auth' );
				}
		}

		/**
		 * Méthode : renvois vers la home page avec un message d'erreur
		 */
		protected function redirection( $txt = false, $javascript = FALSE )
		{
				if( $javascript )
						echo '<script>redirect( \''.url::site().'?msg='.urlencode( $txt ).'\' );</script>';

				return url::redirect( '?msg='.urlencode( $txt ) );
		}

		/**
		 * Méthode : renvois vers la home page avec un message d'erreur
		 */
		protected function access( $type )
		{
				$this->login();

				if( (!in_array( $type, $this->role->name ) && !in_array( 'admin', $this->role->name ) ) )
						return url::redirect( 'auth' );
		}

		/**
		 * Méthode : verifie qu'on est login
		 */
		protected function login()
		{
				if( !$this->user )
						if( request::is_ajax() )
								die( html::anchor( NULL, 'Veuillez vous identifier' ) );
						else
								return url::redirect( 'auth' );
		}

}

?>