<?php

defined( 'SYSPATH' ) or die( 'No direct access allowed.' );

/**
 * Afficher du HTML sur la map.
 *
 * @package Action_HTML
 * @author Pasquelin Alban
 * @copyright (c) 2011
 * @license http://www.openrpg.fr/license.html
 */
class Plugin_Html_Controller extends Action_Controller {

		/**
		 * Affiche le code HTML dans l'alerte.
		 * 
		 * @return  void
		 */
		public function index()
		{
				$v = new View( 'html/plugin' );
				$v->html = isset( $this->data->action_map->html ) ? $this->data->action_map->html : FALSE;
				$v->render( TRUE );
		}

}

?>