<?php	defined(	'SYSPATH'	)	or	die(	'No direct access allowed.'	);	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
		<head>
				<title><?php	echo	html::specialchars(	Kohana::config(	'config.name_site'	)	)	?></title>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
				<script type="text/javascript" src="<?php echo url::base(); ?>js/jquery.js"></script>
				<?php
				echo	isset(	$script	)	?	$script	:	'';
				echo	isset(	$css	)	?	$css	:	'';
				?>
		</head>
		<body class="bodyNoHTML">
				<?php	echo	isset(	$contenu	)	?	$contenu	:	'';	?>
		</body>
</html>