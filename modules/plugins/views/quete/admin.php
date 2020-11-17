<?php	defined(	'SYSPATH'	)	OR	die(	'No direct access allowed.'	);	?>
<p><?php	echo	Kohana::lang(	'action.quete_expli_1'	);	?></p>
<div class="row_form">
    <label>
        <span class="titreSpanForm"><?php	echo	Kohana::lang(	'action.bot'	);	?></span>
        <select name="bot" class="input-select" >
            <option value="0" <?php	echo	isset(	$data->bot	)	&& 0	==	$data->bot	?	'selected="selected"'	:	'';	?> >Non</option>
            <option value="1" <?php	echo	isset(	$data->bot	)	&& 1	==	$data->bot	?	'selected="selected"'	:	'';	?> >Oui</option>
        </select>
    </label>
    <div class="clear"></div>
</div>
<ul>
		<li><?php	echo	Kohana::lang(	'action.quete_expli_2'	);	?></li>
		<li><?php	echo	Kohana::lang(	'action.quete_expli_3'	);	?></li>
		<li><?php	echo	Kohana::lang(	'action.quete_expli_4'	);	?></li>
</ul>
<p><?php	echo	Kohana::lang(	'action.quete_expli_5'	);	?></p>