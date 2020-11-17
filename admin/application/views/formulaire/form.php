<?php	defined(	'SYSPATH'	)	OR	die(	'No direct access allowed.'	);	?>
<?php	if(	$urlLien	=	$this->input->get(	'retour'	)	)	:	?>
		<div class="lienRetour">
				<?php	echo	html::anchor(	$urlLien,	Kohana::lang(	'form.return_url'	)	);	?>
		</div>
<?php	endif	?>
<form action="<?php	echo	isset(	$action	)	?	$action	:	false;	?>" onsubmit="return false" method="post" name="form" id="form" class="form-css">
		<?php	echo	isset(	$formulaire	)	?	$formulaire	:	false;	?>
  <input id="id" type="hidden" value="<?php	echo	isset(	$id	)	?	$id	:	0;	?>" />
</form>
<?php	echo	isset(	$option	)	?	$option	:	false;	?>
