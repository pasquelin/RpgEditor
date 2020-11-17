<?php

defined(	'SYSPATH'	)	OR	die(	'No direct access allowed.'	);

class	Article_Core	{

		/**
			* Methode : pour remplir le contenu personnalisé pour les textes
			*/
		public	function	edit_user(	$txt,	$username = FALSE	)
		{
				return	$username ? str_replace(	array( '&lt;joueur&gt;', '<joueur>'),	'<strong>'.$username.'</strong>',	$txt	) : $txt;
		}

}