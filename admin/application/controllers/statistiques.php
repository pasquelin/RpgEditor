<?php

defined( 'SYSPATH' ) OR die( 'No direct access allowed.' );

class Statistiques_Controller extends Template_Controller {

		public function __construct()
		{
				parent::__construct();
				parent::access( 'statistique' );
		}

		/**
		 * Methode : page générale des statistiques du site
		 */
		public function index()
		{
				$this->template->titre = Kohana::lang( 'statistique.all_stat' );

				$this->template->contenu = new View( 'statistiques/view' );
				$this->template->contenu->global = statistiques_Model::instance()->general();
		}

}

?>
