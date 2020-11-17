<?php

defined( 'SYSPATH' ) OR die( 'No direct access allowed.' );

class Purge_Controller extends Template_Controller {

		public function __construct()
		{
				parent::__construct();
				parent::access( 'admin' );
		}

		/**
		 * Methode : page générale de la purge
		 */
		public function index()
		{
				$this->template->titre = Kohana::lang( 'purge.initialisation' );

				$this->template->contenu = new View( 'purge/index' );
		}

		/**
		 * Methode : on purge la selection
		 */
		public function send()
		{
				$this->auto_render = FALSE;

				$db = Database::instance();

				if( $this->input->post( 'article' ) )
						$db->query( "TRUNCATE TABLE `articles`" );

				if( $this->input->post( 'bot' ) )
						$db->query( "TRUNCATE TABLE `bots`" );

				if( $this->input->post( 'object' ) )
						$db->query( "TRUNCATE TABLE `items`" );

				if( $this->input->post( 'quete' ) )
						$db->query( "TRUNCATE TABLE `quetes`" );

				if( $this->input->post( 'sort' ) )
						$db->query( "TRUNCATE TABLE `sorts`" );

				if( $this->input->post( 'caract_user' ) )
				{
						$db->query( "TRUNCATE TABLE `users_history`" );
						$db->query( "TRUNCATE TABLE `users_items`" );
						$db->query( "TRUNCATE TABLE `users_quetes`" );
						$db->query( "TRUNCATE TABLE `users_sorts`" );
				}

				if( $this->input->post( 'map' ) )
				{
						$db->query( "TRUNCATE TABLE `map`" );
						$db->query( "TRUNCATE TABLE `regions`" );
						$db->query( "INSERT INTO `regions` (`name`, `comment`, `x`, `y`, `id_parent`, `background`, `fight_terrain`, `bot_nbr_min`, `bot_nbr_max`, `bot_hp_min`, `bot_hp_max`, `bot_mp_min`, `bot_mp_max`, `bot_xp_min`, `bot_xp_max`, `bot_argent_min`, `bot_argent_max`, `bot_niveau`, `bot_attaque_min`, `bot_attaque_max`, `bot_defense_min`, `bot_defense_max`) VALUES ('Maison du héros', 'la maison où a grandit notre héros', 19, 19, 0, '005-Beach01.png', 2, 0, 0, 5, 10, 5, 10, 0, 0, 100, 200, 1, 0, 0, 0, 0)" );
						$db->query( "UPDATE  `users` SET  `x` =  '1', `y` =  '1', `region_id` =  '1'" );
				}

				if( $this->input->post( 'user' ) )
				{
						$db->query( "TRUNCATE TABLE `users`" );
						$db->query( "TRUNCATE TABLE `roles_users`" );
						$db->query( "INSERT INTO `users` (`email`, `username`, `password`, `logins`, `last_login`, `last_action`, `preambule`, `avatar`, `x`, `y`, `region_id`, `ip`, `argent`, `niveau`, `xp`, `hp`, `hp_max`, `mp`, `mp_max`) VALUES('admin@monrpg.fr', 'admin', '0cbd8c105586b8fae257f5a4e3acb392ab3ec8c945572ff057', 0, 0, 0, 0, 'default.png', 1, 1, 1, '', 10000, 0, 0, 100, 100, 100, 100)" );
						$db->query( "INSERT INTO `roles_users` (`user_id`, `role_id`) VALUES (1, 1), (1, 2)" );
				}

				Cache::instance()->delete_all();

				return url::redirect( 'purge?msg='.urlencode( Kohana::lang( 'purge.valid_purge' ) ) );
		}

}

?>
