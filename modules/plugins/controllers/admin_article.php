<?php

defined( 'SYSPATH' ) or die( 'No direct access allowed.' );

/**
 * Changement des articles sur la map.
 *
 * @package Action_article
 * @author Pasquelin Alban
 * @copyright (c) 2011
 * @license http://www.openrpg.fr/license.html
 */
class Admin_Article_Controller extends Controller {

		/**
		 * Méthode :
		 */
		public function index( &$view )
		{
				$view->article = Article_Model::instance()->select( array( 'article_category_id' => 2, 'status' => 1 ) );
		}

}

?>