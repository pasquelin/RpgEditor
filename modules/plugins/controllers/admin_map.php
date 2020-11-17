<?php

defined( 'SYSPATH' ) or die( 'No direct access allowed.' );

/**
 * Changement des maps en image (global) sur la map.
 *
 * @package Action_map
 * @author Pasquelin Alban
 * @copyright (c) 2011
 * @license http://www.openrpg.fr/license.html
 */
class Admin_Map_Controller extends Controller {

		/**
		 * Méthode :
		 */
		public function index( &$view )
		{
				$view->region = Region_Model::instance()->listing_parent();
		}

}

?>