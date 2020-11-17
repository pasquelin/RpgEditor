<?php

defined( 'SYSPATH' ) or die( 'No direct access allowed.' );

/**
 * Changement de position sur la map.
 *
 * @package Action_move
 * @author Pasquelin Alban
 * @copyright (c) 2011
 * @license http://www.openrpg.fr/license.html
 */
class Admin_Move_Controller extends Controller {

		/**
		 * Méthode :
		 */
		public function index( &$view )
		{
				$view->region = Region_Model::instance()->listing_parent();
		}

}

?>