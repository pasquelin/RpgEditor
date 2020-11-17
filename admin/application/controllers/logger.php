<?php

defined( 'SYSPATH' ) or die( 'No direct access allowed.' );

class Logger_Controller extends Controller {

		/**
		 * Méthode : pour empêcher un utilisateur d'accéder directement à ce controller
		 */
		public function index()
		{
				return self::redirection( Kohana::lang( 'logger.no_acces' ) );
		}

		/**
		 * Méthode : formulaire d'authentification a l'administration
		 */
		public function auth()
		{
				$template = new View( 'template/no_html' );

				$template->css = html::stylesheet( 'index.php/css_'.base64_encode( implode( '--', array( 'core', 'auth' ) ) ) );

				$template->contenu = new View( 'auth/form' );

				$template->render( true );
		}

		/**
		 * Méthode : Login un utilisateur après vérification des données POST
		 */
		public function login()
		{
				if( $_POST )
				{
						if( ($username = $this->input->post( 'username' )) && ($password = $this->input->post( 'password' )) )
						{
								$user = ORM::factory( 'user', $username );

								if( $user->loaded )
								{
										$authentic = Auth::instance();

										if( $authentic->login( $username, $password ) )
										{
												$user = $authentic->get_user();

												$role = $user->roles->select_list( 'id', 'name' );

												if( !in_array( 'admin', $role ) && !in_array( 'modo', $role ) )
														return self::redirection( Kohana::lang( 'logger.no_autorise' ) );
												else
														return url::redirect( '?msg='.urlencode( Kohana::lang( 'logger.identify' ) ) );
										}
										else
												return self::redirection( Kohana::lang( 'logger.error_password' ) );
								}
								else
										return self::redirection( Kohana::lang( 'logger.no_user' ) );
						}
						else
								return self::redirection( Kohana::lang( 'logger.no_username_password' ) );
				}
				
				return self::redirection( Kohana::lang( 'logger.no_acces' ) );
		}

		/**
		 * Méthode : Logout un utilisateur via le lien quitter de menu top
		 */
		public function logout()
		{
				$authentic = Auth::instance();

				if( $authentic->logged_in() )
						$authentic->logout( true );

				return self::redirection( Kohana::lang( 'logger.disconnect' ) );
		}

		/**
		 * Méthode : redirection avec un message d'alerte
		 */
		public function redirection( $msg = false )
		{
				return url::redirect( 'auth?msg='.urlencode( $msg ) );
		}

}

?>