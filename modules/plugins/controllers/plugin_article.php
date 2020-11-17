<?php

defined( 'SYSPATH' ) or die( 'No direct access allowed.' );

/**
 * Action de lire un article sur la map.
 *
 * @package Action_article
 * @author Pasquelin Alban
 * @copyright (c) 2011
 * @license http://www.openrpg.fr/license.html
 */
class Plugin_Article_Controller extends Action_Controller {

		/**
		 * Afficher l'article en rapport a la case.
		 * 
		 * @return  void
		 */
		public function index()
		{
				if( !isset( $this->data->action_map->id_article )
								|| ( $article = Article_Model::instance()->select( array( 'id_article' => $this->data->action_map->id_article, 'article_category_id' => 2, 'status' => 1 ), 1 )) === FALSE )
						return FALSE;

				$v = new View( 'article/plugin' );
				$v->article = $article;
				$v->data = $this->data;
				$v->admin = in_array( 'admin', $this->role->name );
				$v->username = $this->user->username;
				$v->render( TRUE );
		}

}

?>