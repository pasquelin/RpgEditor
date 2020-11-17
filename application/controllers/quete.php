<?php

defined( 'SYSPATH' ) or die( 'No direct access allowed.' );

/**
 * Controller public des quêtes. Cela permet de connaitre
 * les quête effectué ou non d'un joueur.
 *
 * @package Quête
 * @author Pasquelin Alban
 * @copyright	 (c) 2011
 * @license http://www.openrpg.fr/license.html
 */
class Quete_Controller extends Template_Controller {

		public function __construct()
		{
				parent::__construct();
				parent::login();
		}

		/**
		 * Listing des quetes du joueur.
		 * 
		 * @return  void
		 */
		public function index()
		{
				$quete_start = $quete_stop = FALSE;

				if( ($quetes_user = Quete_Model::instance()->quete_user_join( $this->user->id )) !== FALSE )
						foreach( $quetes_user as $row )
								if( $row->status == 2 )
										$quete_stop[] = $row;
								else
										$quete_start[] = $row;

				$this->template->content = new View( 'quete/index' );
				$this->template->content->start = $quete_start;
				$this->template->content->stop = $quete_stop;
		}

}

?>