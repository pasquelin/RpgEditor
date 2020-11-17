<?php

defined( 'SYSPATH' ) OR die( 'No direct access allowed.' );

class Badge_Core {

		/**
		 * Methode : pour afficher l'img du badge
		 */
		public function img( $type, $valeur )
		{
				$conf = Kohana::config( 'users.badge.'.$type );
				$img = 0;

				if( $conf[1] <= $valeur && $conf[2] > $valeur )
						$img = 1;
				elseif( $conf[2] <= $valeur && $conf[3] > $valeur )
						$img = 2;
				elseif( $conf[3] <= $valeur && $conf[4] > $valeur )
						$img = 3;
				elseif( $conf[4] <= $valeur && $conf[5] > $valeur )
						$img = 4;
				elseif( $conf[5] <= $valeur && $conf[6] > $valeur )
						$img = 5;
				elseif( $conf[6] < $valeur )
						$img = 6;


				return html::image( 'images/medal/'.$img.'.png', array('width' => 15) );
		}

}