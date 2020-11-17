<?php	defined(	'SYSPATH'	)	or	die(	'No direct access allowed.'	);	?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
		<body>
				<p><?php	echo	isset(	$name	)	?	$name	:	false;	?>,</p>
				<p><?php	echo	isset(	$content	)	?	$content	:	false;	?></p>
		</body>
</html>