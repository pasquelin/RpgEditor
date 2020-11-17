<?php

defined( 'SYSPATH' ) or die( 'No direct access allowed.' );

abstract class Template_Controller extends Authentic_Controller {

		public $template = 'template/global';
		public $auto_render = true;
		public $script = FALSE;
		protected $my_script = FALSE;
		public $script_lib = FALSE;
		public $css = FALSE;

		public function __construct()
		{
				parent::__construct();

				if( !$this->role || (!in_array( 'login', $this->role->name ) || ( count( $this->role->name ) ) <= 1 && url::current() != 'auth' ) )
						return url::redirect( 'auth' );

				if( $this->input->get( 'no_html' ) )
						$this->template = 'template/no_html';

				$this->template = new View( $this->template );

				if( $this->user )
				{
						$this->template->menu = new View( 'template/menu' );
						$this->template->menu->acces = array( );

						if( isset( $this->user->username ) )
								$this->template->username = $this->user->username;

						if( isset( $this->role->name ) )
								$this->template->menu->acces = $this->role->name;
				}

				$this->template->titre = false;

				$this->template->button = false;

				$this->template->add_element_button = false;

				$this->template->add_sauv = false;

				$this->template->navigation = false;

				$this->template->navigationURL = false;

				$this->template->msg = $this->input->get( 'msg' );

				if( $this->auto_render == true )
						Event::add( 'system.post_controller', array( $this, '_render' ) );
		}

		/**
		 * Methode : pour gérer la redirection après une sauvegarde de donnée
		 */
		protected function redirect( $url, $type = false )
		{
				if( $type == 'annul' )
						$txt = Kohana::lang( 'form.post_annul' );
				elseif( $type == 'trash' )
						$txt = Kohana::lang( 'form.post_delete' );
				else
						$txt = Kohana::lang( 'form.post_regist' );

				return url::redirect( $url.'?msg='.urlencode( $txt ) );
		}

		/**
		 * Methode : permet la redirection avec le message d'erreur
		 */
		protected function redirect_erreur( $url )
		{
				return url::redirect( $url.'?msg='.urlencode( Kohana::lang( 'form.post_error' ) ) );
		}

		/**
		 * Methode : compresse les donnée en JSON
		 */
		protected function json( array $txtArray )
		{
				foreach( $txtArray as $txt )
						$display[] = json_encode( $txt );

				return implode( ',', $display );
		}

		/**
		 * Methode : permet la navigation entre 2 element d'une meme table
		 */
		protected function navigation( $id, $cal, $table )
		{
				return Model_Core::navigation( $id, $cal, $table );
		}

		/**
		 * Méthode : on vérifie le render 
		 */
		public function _render()
		{
				if( $this->auto_render )
				{
						if( $this->template->button !== false || $this->template->add_element_button !== false )
								$this->template->button = new View( 'template/button_valide' );

						if( $this->template->add_element_button !== false )
								$this->template->button->add = $this->template->add_element_button;

						if( $this->template->add_sauv !== false )
								$this->template->button->add_sauv = true;

						if( $this->template->navigation !== false )
						{
								$this->template->button->navigation = $this->template->navigation;

								$base = explode( '/', url::current() );

								if( isset( $base[0] ) )
										$this->template->button->navigationURL = $base[0];

								if( isset( $base[1] ) )
										$this->template->button->navigationURL .= '/'.$base[1];
						}

						if( $this->template->navigationURL !== false )
								$this->template->button->navigationURL = $this->template->navigationURL;

						$ariane = html::anchor( FALSE, Kohana::lang( 'menu.home' ) );

						if( is_array( $this->template->titre ) )
						{
								foreach( $this->template->titre as $label => $link )
								{
										$ariane .= '<div class="breadcrumb_divider"></div>';
										$ariane .= html::anchor( $link ? $link : '#top', $label, array( 'class' => 'current' ) );
								}
						}
						elseif( $this->template->titre )
						{
								$ariane .= '<div class="breadcrumb_divider"></div>';
								$ariane.= html::anchor( '#top', $this->template->titre, array( 'class' => 'current' ) );
						}

						$this->template->titre = $ariane;

						$script = array( 'index.php/js_phpjs', 'js/lib/jquery', 'js/loading', 'js/lib/jquery.tipsy' );

						$css = array( 'core', 'menu' );

						if( $this->script && is_array( $this->script ) )
								$script = array_merge( $script, $this->script );

						if( $this->css && is_array( $this->css ) )
								$css = array_merge( $css, $this->css );
						
						$this->template->script = html::script( $script );

						if( $this->my_script )
								$this->template->script .= html::script( $this->my_script, TRUE );

						$this->template->css = html::stylesheet( 'index.php/css_'.base64_encode( implode( '--', $css ) ) );

						$this->template->render( true );
				}
		}
}

?>