<?php	defined(	'SYSPATH'	)	OR	die(	'No direct access allowed.'	);	?>

<form>
		<div class="titreForm">
				<div class="titreCentent"><?php	echo	Kohana::lang(	'user.title_quete_user'	);	?></div>
				<div class="spacer"></div>
		</div>
		<div class="contentForm">
				<?php	if(	$listQuete	)	:	?>
						<table width="100%" cellpadding="0">
								<?php	foreach(	$listQuete	as	$row	)	:	?>
										<tr>
												<td class="left"><a href="<?php echo url::base(TRUE); ?>quetes/show/<?php	echo	$row->id_quete;	?>" class="titreSpanForm"><?php	echo	$row->title;	?></a></td>
												<td class="right"><?php	echo	$row->status	==	2	?	'<strong class="vert">Terminé</strong>'	:	'<strong class="rouge">en cours</strong>';	?></td>
										</tr>
								<?php	endforeach	?>
						</table>
				<?php	endif	?>
		</div>
		<div class="footerForm">
				<input type="button" class="button close" value="<?php	echo	Kohana::lang(	'form.annul'	);	?>"/>
		</div>
</form>
