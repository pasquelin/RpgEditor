<?php

defined( 'SYSPATH' ) OR die( 'No direct access allowed.' );

class Mailing_Controller extends Template_Controller {

		public function __construct()
		{
				parent::__construct();
				parent::access( 'mailing' );
		}

		/**
		 * Methode : page générale de l'envois de mailing pour les membres du site
		 */
		public function index()
		{
				$this->script = array( 'js/lib/jquery.validate' );

				$this->template->titre = Kohana::lang( 'mailing.send_mailing' );

				$this->template->contenu = new View( 'mailing/view' );
		}

		/**
		 * Methode : page envoyer le mailing
		 */
		public function envoyer()
		{
				if( $_POST )
				{
						$texte = $this->input->post( 'texte' );
						$format = $this->input->post( 'format' );
						$sujet = $this->input->post( 'sujet' );

						$format = $format == 1 ? TRUE : FALSE;

						$users = $this->user->select();

						$nbr_envois = 0;

						foreach( $users as $user )
						{
								if( $format )
								{
										$view = new View( 'mailing/template' );
										$view->name = ucfirst( mb_strtolower( $user->username ) );
										$view->content = $texte;
										$message = $view->render();
								}
								else
										$message = $texte;

								if( email::send( $user->email, Kohana::config( 'email.from' ), $sujet, $message, $format ) )
										$nbr_envois++;
						}

						return url::redirect( 'mailing?msg='.urlencode( Kohana::lang( 'mailing.send_valide', number_format( $nbr_envois ) ) ) );
				}
				else
						return parent::redirect_erreur( 'mailing' );
		}

}

?>
