<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' ); ?>
<div class="row_form">
    <label>
        <span class="titreSpanForm"><?php	echo	Kohana::lang(	'action.item'	);	?></span>
        <select name="id_item" class="input-select" >
            <?php	if(	$items	)	:	?>
                <?php	foreach(	$items	as	$val	)	:	?>
                    <option value="<?php	echo	$val->id;	?>" <?php	echo	isset(	$data->id_item	)	&&	$val->id	==	$data->id_item	?	'selected="selected"'	:	'';	?> ><?php	echo	$val->name;	?></option>
                <?php	endforeach	?>
            <?php	endif	?>
        </select>
    </label>
    <div class="clear"></div>
</div>
