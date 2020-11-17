<?php	defined(	'SYSPATH'	)	OR	die(	'No direct access allowed.'	);	?>
<div class="row_form">
		<label>
				<span class="titreSpanForm"><?php	echo	Kohana::lang(	'action.choose_article'	);	?></span>
				<select name="id_article" class="input-select" >
						<?php	if(	$article	)	:	?>
								<?php	foreach(	$article	as	$val	)	:	?>
										<option value="<?php	echo	$val->id_article;	?>" <?php	echo	isset(	$data->id_article	)	&&	$val->id_article	==	$data->id_article	?	'selected="selected"'	:	'';	?> ><?php	echo	$val->title;	?></option>
								<?php	endforeach	?>
						<?php	endif	?>
				</select>
		</label>
		<div class="clear"></div>
</div>
