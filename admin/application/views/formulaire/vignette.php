<?php	defined(	'SYSPATH'	)	OR	die(	'No direct access allowed.'	);	?>

<div class="titreForm">
		<?php	if(	isset(	$module	)	&&	$module	)	:	?>
				<div style="float:right; margin-top:3px;"><a href="<?php echo url::base(TRUE); ?>ftp?dir=/images/<?php	echo	$module;	?>"><?php echo html::image('images/template/icn_folder.png'); ?></a></div>
		<?php	endif	?>
		<div class="titreCentent"><?php	echo	Kohana::lang(	'form.title_selected'	);	?></div>
</div>
<div class="contentForm">
		<?php	if(	$images	)	:	?>
				<?php	foreach(	$images	as	$val	)	:	?>
						<img src="<?php	echo	url::base();	?>../images/<?php	echo	$module;	?>/<?php	echo	$val;	?>" id="<?php	echo	$val;	?>" width="<?php	echo	$width;	?>" height="<?php	echo	$height;	?>" alt="" class="vign_mod <?php	echo	isset(	$class	)	&&	$class	?	$class	:	'';	?> close <?php	echo	$val	==	$selected	?	'selected'	:	false;	?>" />
				<?php	endforeach	?>
		<?php	endif	?>
		<div class="spacer"></div>
</div>
<div class="footerForm">
		<input type="button" class="button close" value="<?php	echo	Kohana::lang(	'form.annul'	);	?>"/>
</div>
