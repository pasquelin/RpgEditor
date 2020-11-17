<?php

defined( 'SYSPATH' ) or die( 'No direct access allowed.' );

class Home_Controller extends Template_Controller {

		public function __construct()
		{
				parent::__construct();
				parent::login();
		}

		/**
		 * Méthode : page par défaut de l'administration (panel)
		 */
		public function index()
		{
				$this->script = array( 'js/home' );

				$this->css = array( 'home' );

				$this->template->contenu = new View( 'home/panel' );

				$this->template->contenu->menu = array( array( 'title' => Kohana::lang( 'menu.users' ),
								'href' => url::base( TRUE ).'users',
								'img' => 'icon-48-admin.png' ),
						array( 'title' => Kohana::lang( 'menu.map' ),
								'href' => url::base( TRUE ).'regions',
								'img' => 'icon-48-map.png' ),
						array( 'title' => Kohana::lang( 'menu.quete_ligth' ),
								'href' => url::base( TRUE ).'quetes',
								'img' => 'icon-48-static.png' ),
						array( 'title' => Kohana::lang( 'menu.config' ),
								'href' => url::base( TRUE ).'config',
								'img' => 'icon-48-cpanel.png' ),
						array( 'title' => Kohana::lang( 'menu.mailing' ),
								'href' => url::base( TRUE ).'mailing',
								'img' => 'icon-48-massmail.png' ),
						array( 'title' => Kohana::lang( 'menu.stat' ),
								'href' => url::base( TRUE ).'statistiques',
								'img' => 'icon-48-stats.png' ),
						array( 'title' => Kohana::lang( 'menu.article_light' ),
								'href' => url::base( TRUE ).'articles',
								'img' => 'icon-48-article.png' ),
						array( 'title' => Kohana::lang( 'menu.cache_light' ),
								'href' => url::base( TRUE ).'cache/deleteAll',
								'img' => 'icon-48-alert.png' )
				);

				$this->template->contenu->stats = new View( 'statistiques/light' );
				$this->template->contenu->stats->global = statistiques_Model::instance()->general();

				$this->template->contenu->version = FALSE;

				$versionXML = @simplexml_load_file( 'http://www.openrpg.fr/xml/cmj.xml' );

				if( isset( $versionXML->channel->item ) )
				{
						foreach( $versionXML->channel->item as $item )
						{
								if( $item->version != Kohana::config( 'game.version' ) )
										$this->template->contenu->version = $item->version;
								break;
						}
				}
		}

}

?>