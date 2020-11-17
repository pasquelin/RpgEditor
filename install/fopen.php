<?php

/*
 * Database
 */

$config_database = "<?php
defined('SYSPATH') OR die('No direct access allowed.');
\$config['default'] = array
(
	'benchmark'     => true,
	'persistent'    => false,
	'connection'    => array
	(
		'type'     => 'mysql',
		'user'     => '$DBuserName',
		'pass'     => '$DBpassword',
		'host'     => '$DBhostname',
		'port'     => 3306,
		'socket'   => false,
		'database' => '$DBname'
	),
	'character_set' => 'utf8',
	'table_prefix'  => '$DBPrefix',
	'object'        => true,
	'cache'         => false,
	'escape'        => true
);
?>";

$canWrite_database = false;

if( ($fp = fopen( "../system/config/database.php", "w" ) ) )
{
		fputs( $fp, $config_database, strlen( $config_database ) );
		fclose( $fp );
		$canWrite_database = true;
}


/*
 * Email
 */

$config_email = "<?php defined('SYSPATH') OR die('No direct access allowed.');

\$config['driver'] = 'native';

\$config['options'] = NULL;

\$config['from'] = '".GetParam( $_POST, 'from', 'contact@monsite.com' )."';

?>";

$canWrite_email = false;

if( ($fp = fopen( "../system/config/email.php", "w" ) ) )
{
		fputs( $fp, $config_email, strlen( $config_email ) );
		fclose( $fp );
		$canWrite_email = true;
}

/*
 * Game
 */

$config_game = "<?php

defined( 'SYSPATH' ) OR die( 'No direct access allowed.' );

\$config['version'] = '3.0.0'; //Version de votre jeu

\$config['name'] = '".GetParam( $_POST, 'name', 'Créer mon jeu' )."'; //Nom de votre jeu

\$config['loginUser'] = TRUE; //Afficher la partie login

\$config['registerUser'] = TRUE; //Afficher la partie register

\$config['debug'] = FALSE; //Afficher la partie debug

\$config['cache'] = FALSE; //Activer ou non le cache

\$config['money'] = 'pts'; // money du jeu

\$config['id_article_preambule'] = 67; //Article par defaut qui presente le jeu tout au début - Si FALSE, il n'y aura pas de préambule

\$config['initialPosition'] = array( 'x' => 1, 'y' => 1, 'z' => 1, 'region' => 1 ); //position initial lors de la création d'un joueur

\$config['initialSpeed'] = 4; //Vitesse que le joueur possède lors de son initialisation

\$config['initialGravity'] = 0.7; //Gravité que le joueur possède lors de son initialisation

\$config['initialHandRight'] = 12; //Arme par defaut

\$config['initialArgent'] = 1000; //Argent que le joueur possède lors de son initialisation

\$config['initialAvatar'] = 'default.png'; //Avatar que le joueur possède lors de son initialisation

\$config['initialHP'] = 100; //HP que le joueur possède lors de son initialisation (ATTENTION la valeur vaut pour le max hp et la valeur de celui du joueur (100% au final))

\$config['initialMP'] = 10; //MP que le joueur possède lors de son initialisation (ATTENTION la valeur vaut pour le max hp et la valeur de celui du joueur (100% au final))

\$config['description'] = '<h2>Un éditeur de MMORPG en ligne</h2><p>Bienvenue sur l\'éditeur de jeux <strong>Mon RPG</strong>, vous avez toujours rêvé de faire votre jeu multijoueurs sans aucune connaissance en programmation ?</p><p><strong>Mon RPG</strong> possède des outils intuitifs et très simples à prendre en mains. De nombreuses ressources vous sont également proposés afin que vous puissiez créer le jeu de vos rêves. De nombreux modules en constantes évolutions vous sont accèssible dans la partie administration pour vous permettre de proposé à vos joueurs une expérience de jeu riche et unique.<p>'; //Description du jeu
?>";

$canWrite_game = false;

if( ($fp = fopen( "../system/config/game.php", "w" ) ) )
{
		fputs( $fp, $config_game, strlen( $config_game ) );
		fclose( $fp );
		$canWrite_game = true;
}

/*
 * Systeme public
 */

$config_config = "<?php

/*
	* Options:
	*  site_domain          - domain and installation directory
	*  site_protocol        - protocol used to access the site, usually HTTP
	*  index_page           - name of the front controller, can be removed with URL rewriting
	*  url_suffix           - an extension that will be added to all generated URLs
	*  internal_cache       - whether to store file paths and config entries across requests
	*  output_compression   - enable or disable GZIP output compression
	*  global_xss_filtering - enable or disable XSS attack filtering on all user input
	*  enable_hooks         - enable or disable hooks.
	*  log_threshold        - sets the logging threshold
	*  log_directory        - directory to save logs to
	*  display_errors       - whether to show Kohana error pages or not
	*  render_stats         - render the statistics information in the final page output
	*  extension_prefix     - filename prefix for library extensions
	*  modules              - extra Kohana resource paths,
	*/

defined(	'SYSPATH'	)	OR	die(	'No direct access allowed.'	);
/**
	* Base path of the web site. If this includes a domain, eg: localhost/kohana/
	* then a full URL will be used, eg: http://localhost/kohana/. If it only includes
	* the path, and a site_protocol is specified, the domain will be auto-detected.
	*/
\$config['site_domain']	=	'".GetParam( $_POST, 'site_domain', $_SERVER['HTTP_HOST'] )."/';

/**
	* Force a default protocol to be used by the site. If no site_protocol is
	* specified, then the current protocol is used, or when possible, only an
	* absolute path (with no protocol/domain) is used.
	*/
\$config['site_protocol']	=	'';

/**
	* Name of the front controller for this application. Default: index.php
	*
	* This can be removed by using URL rewriting.
	*/
\$config['index_page']	=	'index.php';

/**
	* Fake file extension that will be added to all generated URLs. Example: .html
	*/
\$config['url_suffix']	=	'';

/**
	* Length of time of the internal cache in seconds. 0 or FALSE means no caching.
	* The internal cache stores file paths and config entries across requests and
	* can give significant speed improvements at the expense of delayed updating.
	*/
\$config['internal_cache']	=	TRUE;

/**
	* Internal cache directory.
	*/
\$config['internal_cache_path']	=	DOCROOT.'cache/';

/**
	* Enable internal cache encryption - speed/processing loss
	* is neglible when this is turned on. Can be turned off
	* if application directory is not in the webroot.
	*/
\$config['internal_cache_encrypt']	=	FALSE;

/**
	* Encryption key for the internal cache, only used
	* if internal_cache_encrypt is TRUE.
	*
	* Make sure you specify your own key here!
	*
	* The cache is deleted when/if the key changes.
	*/
\$config['internal_cache_key']	=	'foobar-changeme';

/**
	* Enable or disable gzip output compression. This can dramatically decrease
	* server bandwidth usage, at the cost of slightly higher CPU usage. Set to
	* the compression level (1-9) that you want to use, or FALSE to disable.
	*
	* Do not enable this option if you are using output compression in php.ini!
	*/
\$config['output_compression']	=	5;

/**
	* Enable or disable global XSS filtering of GET, POST, and SERVER data. This
	* option also accepts a string to specify a specific XSS filtering tool.
	*/
\$config['global_xss_filtering']	=	TRUE;

/**
	* Enable or disable hooks.
	*/
\$config['enable_hooks']	=	FALSE;

/**
	* Log thresholds:
	*  0 - Disable logging
	*  1 - Errors and exceptions
	*  2 - Warnings
	*  3 - Notices
	*  4 - Debugging
	*/
\$config['log_threshold']	=	1;

/**
	* Message logging directory.
	*/
\$config['log_directory']	=	DOCROOT.'logs/';

/**
	* Enable or disable displaying of Kohana error pages. This will not affect
	* logging. Turning this off will disable ALL error pages.
	*/
\$config['display_errors']	=	TRUE;

/**
	* Enable or disable statistics in the final output. Stats are replaced via
	* specific strings, such as {execution_time}.
	*
	* @see http://docs.kohanaphp.com/general/configuration
	*/
\$config['render_stats']	=	TRUE;

/**
	* Filename prefixed used to determine extensions. For example, an
	* extension to the Controller class would be named MY_Controller.php.
	*/
\$config['extension_prefix']	=	'my_';

/**
	* Additional resource paths. Each path can either be absolute
	* or relative to the docroot. Modules can include any resource that can exist
	* in your application directory, configuration files, controllers, views, etc.
	*/
\$config['modules']	=	array
		(
		MODPATH.'global',
		MODPATH.'auth',
		MODPATH.'game',
		MODPATH.'plugins',
);
?>";

$canWrite_config = false;

if( ($fp = fopen( "../application/config/config.php", "w" ) ) )
{
		fputs( $fp, $config_config, strlen( $config_config ) );
		fclose( $fp );
		$canWrite_config = true;
}

/*
 * Systeme public
 */

$config_config_admin = "<?php

/*
	* Options:
	*  site_domain          - domain and installation directory
	*  site_protocol        - protocol used to access the site, usually HTTP
	*  index_page           - name of the front controller, can be removed with URL rewriting
	*  url_suffix           - an extension that will be added to all generated URLs
	*  internal_cache       - whether to store file paths and config entries across requests
	*  output_compression   - enable or disable GZIP output compression
	*  global_xss_filtering - enable or disable XSS attack filtering on all user input
	*  enable_hooks         - enable or disable hooks.
	*  log_threshold        - sets the logging threshold
	*  log_directory        - directory to save logs to
	*  display_errors       - whether to show Kohana error pages or not
	*  render_stats         - render the statistics information in the final page output
	*  extension_prefix     - filename prefix for library extensions
	*  modules              - extra Kohana resource paths,
	*/

defined(	'SYSPATH'	)	OR	die(	'No direct access allowed.'	);
/**
	* Base path of the web site. If this includes a domain, eg: localhost/kohana/
	* then a full URL will be used, eg: http://localhost/kohana/. If it only includes
	* the path, and a site_protocol is specified, the domain will be auto-detected.
	*/
\$config['site_domain']	=	'".GetParam( $_POST, 'site_domain', $_SERVER['HTTP_HOST'] )."/admin/';

/**
	* Force a default protocol to be used by the site. If no site_protocol is
	* specified, then the current protocol is used, or when possible, only an
	* absolute path (with no protocol/domain) is used.
	*/
\$config['site_protocol']	=	'';

/**
	* Name of the front controller for this application. Default: index.php
	*
	* This can be removed by using URL rewriting.
	*/
\$config['index_page']	=	'index.php';

/**
	* Fake file extension that will be added to all generated URLs. Example: .html
	*/
\$config['url_suffix']	=	'';

/**
	* Length of time of the internal cache in seconds. 0 or FALSE means no caching.
	* The internal cache stores file paths and config entries across requests and
	* can give significant speed improvements at the expense of delayed updating.
	*/
\$config['internal_cache']	=	TRUE;

/**
	* Internal cache directory.
	*/
\$config['internal_cache_path']	=	DOCROOT.'../cache/';

/**
	* Enable internal cache encryption - speed/processing loss
	* is neglible when this is turned on. Can be turned off
	* if application directory is not in the webroot.
	*/
\$config['internal_cache_encrypt']	=	FALSE;

/**
	* Encryption key for the internal cache, only used
	* if internal_cache_encrypt is TRUE.
	*
	* Make sure you specify your own key here!
	*
	* The cache is deleted when/if the key changes.
	*/
\$config['internal_cache_key']	=	'foobar-changeme';

/**
	* Enable or disable gzip output compression. This can dramatically decrease
	* server bandwidth usage, at the cost of slightly higher CPU usage. Set to
	* the compression level (1-9) that you want to use, or FALSE to disable.
	*
	* Do not enable this option if you are using output compression in php.ini!
	*/
\$config['output_compression']	=	5;

/**
	* Enable or disable global XSS filtering of GET, POST, and SERVER data. This
	* option also accepts a string to specify a specific XSS filtering tool.
	*/
\$config['global_xss_filtering']	=	TRUE;

/**
	* Enable or disable hooks.
	*/
\$config['enable_hooks']	=	FALSE;

/**
	* Log thresholds:
	*  0 - Disable logging
	*  1 - Errors and exceptions
	*  2 - Warnings
	*  3 - Notices
	*  4 - Debugging
	*/
\$config['log_threshold']	=	1;

/**
	* Message logging directory.
	*/
\$config['log_directory']	=	DOCROOT.'../logs/';

/**
	* Enable or disable displaying of Kohana error pages. This will not affect
	* logging. Turning this off will disable ALL error pages.
	*/
\$config['display_errors']	=	TRUE;

/**
	* Enable or disable statistics in the final output. Stats are replaced via
	* specific strings, such as {execution_time}.
	*
	* @see http://docs.kohanaphp.com/general/configuration
	*/
\$config['render_stats']	=	TRUE;

/**
	* Filename prefixed used to determine extensions. For example, an
	* extension to the Controller class would be named MY_Controller.php.
	*/
\$config['extension_prefix']	=	'my_';

/**
	* Additional resource paths. Each path can either be absolute
	* or relative to the docroot. Modules can include any resource that can exist
	* in your application directory, configuration files, controllers, views, etc.
	*/
\$config['modules']	=	array
		(
		MODPATH.'global',
		MODPATH.'auth',
		MODPATH.'admin',
		MODPATH.'plugins',
);
?>";

$canWrite_config_admin = false;

if( ($fp = fopen( "../admin/application/config/config.php", "w" ) ) )
{
		fputs( $fp, $config_config_admin, strlen( $config_config_admin ) );
		fclose( $fp );
		$canWrite_config_admin = true;
}
?>