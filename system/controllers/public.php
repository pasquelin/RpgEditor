<?php

defined( 'SYSPATH' ) OR die( 'No direct access allowed.' );

class Public_Controller extends Controller {

		/**
		 * Methode : génération du fichier JS en crypté
		 */
		public function js( $files, $dir = false )
		{
				header( 'Content-type: text/javascript' );
				header( 'Expires: Sat, 01 Jul '.(date( 'Y' ) + 2).' 01:00:00 GMT' );

				$cache = Cache::instance();

				if( !$display = $cache->get( $files ) )
				{
						$array = false;

						foreach( explode( '--', base64_decode( $files ) ) as $file )
						{
								if( file_exists( DOCROOT.($dir ? $dir.'/' : $dir).'js/'.$file.'.js' ) )
										$array[] = $file.'.js';
								
								if( file_exists( DOCROOT.($dir ? $dir.'/' : $dir).'js/class/'.$file.'.js' ) )
										$display .= implode( '', file( DOCROOT.($dir ? $dir.'/' : $dir).'js/class/'.$file.'.js' ) )."\n";

								elseif( file_exists( DOCROOT.($dir ? $dir.'/' : $dir).'js/lib/'.$file.'.js' ) )
										$display .= implode( '', file( DOCROOT.($dir ? $dir.'/' : $dir).'js/lib/'.$file.'.js' ) )."\n";
						}

						if( $array )
						{
								$jsCompressor = new JSCompressor_Core( ($dir ? $dir.'/' : $dir).'js/', $array );
								$display .= $jsCompressor->pack();
						}

						$cache->set( $files, $display, array( 'js' ), ( 3600 * 24 * 30 ) );
				}
				echo $display;
		}

		/**
		 * Methode : génération du fichier css compress
		 */
		public function css( $files, $dir = false )
		{
				header( 'Content-type: text/css' );
				header( 'Expires: Sat, 01 Jul '.(date( 'Y' ) + 2).' 01:00:00 GMT' );

				$cache = Cache::instance();

				if( !$display = $cache->get( $files ) )
				{
						foreach( explode( '--', base64_decode( $files ) ) as $file )
						{
								if( file_exists( DOCROOT.($dir ? $dir.'/' : $dir).'css/'.$file.'.css' ) )
										$display .= implode( "", file( DOCROOT.($dir ? $dir.'/' : $dir).'css/'.$file.'.css' ) );
						}

						$display = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $display );
						$display = str_replace( array( "\r\n", "\r", "\n", "\t", '  ', '    ', '    ' ), '', $display );


						$cache->set( $files, $display, array( 'css' ), ( 3600 * 24 * 30 ) );
				}

				echo $display;
		}

		/**
		 * Methode : génération du fichier JS core php_js
		 */
		public function php_js()
		{
				header( 'Content-type: text/javascript' );
				header( 'Expires: Sat, 01 Jul '.(date( 'Y' ) + 2).' 01:00:00 GMT' );

				$cache = Cache::instance();

				if( !$display = $cache->get( 'php_js' ) )
				{
						$v = new View( 'php_js' );
						$display = $v->render( false );

						$cache->set( 'php_js', $display, array( 'page' ), ( 3600 * 24 * 30 ) );
				}

				echo $display;
		}

}

