<?php

defined( 'SYSPATH' ) OR die( 'No direct access allowed.' );

class Cache_Controller extends Authentic_Controller {

		/**
		 * Méthode : pour empêcher un utilisateur d'accéder directement à ce controller
		 */
		public function index()
		{
				return self::redirection( Kohana::lang( 'logger.no_acces' ) );
		}

		/**
		 * Methode : purger tout les caches
		 */
		public function deleteAll()
		{
				Cache::instance()->delete_all();
				return url::redirect( '?msg='.urlencode( Kohana::lang( 'cache.all_cache' ) ) );
		}
}

?>
