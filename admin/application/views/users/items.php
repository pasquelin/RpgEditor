<?php	defined(	'SYSPATH'	)	OR	die(	'No direct access allowed.'	);	?>
<form>
		<div class="titreForm">
				<div class="titreCentent"><?php	echo	Kohana::lang(	'user.title_object_user'	);	?></div>
				<div class="spacer"></div>
		</div>
		<div class="contentForm">
				<ul id="accordion"> 
						<?php	foreach(	$listItem	as	$item	)	:	?>
								<li> 
										<a href="javascript:;" class="heading"><?php	echo	$item['title'];	?></a> 
										<ul id="recent" class="invis"> 
												<li>
														<?php	foreach(	$item['data']	as	$row	)	:	?>
																<div class="row_form">
																		<label>
																				<span class="titreSpanForm"><img src="<?php	echo	url::base();	?>../images/items/<?php	echo	$row->image;	?>" width="24" height="24" id="imageItem" align="middle"/> <a href="<?php echo url::base(TRUE); ?>items/show/<?php	echo	$row->id;	?>" class="titreSpanForm"><?php	echo	$row->name;	?></a></span>
																				<select class="inputbox" name="item[<?php	echo	$row->id;	?>]" id="item_<?php	echo	$row->id;	?>">
																						<?php	if(	$row->protect	||	$row->cle	)	:	?>
																								<option value="0" class="rouge"><?php	echo	Kohana::lang(	'form.no'	);	?></option>
																								<option value="1" class="vert" <?php	if(	isset(	$userItem[$row->id]	)	&&	$userItem[$row->id]	) echo	'selected="selected"';	?>><?php	echo	Kohana::lang(	'form.yes'	);	?></option>
																						<?php	else	:	?>
																								<?php	for(	$n	=	0;	$n	<=	100;	$n++	)	:	?>
																										<option value="<?php	echo	$n;	?>" <?php	echo	isset(	$userItem[$row->id]	)	&&	$userItem[$row->id]	==	$n	?	'selected="selected"'	:	'';	?>><?php	echo	sprintf(	'%02d',	$n	);	?></option>
																								<?php	endfor	?>
																						<?php	endif	?>														
																				</select>

																		</label>
																		<div class="spacer"></div>
																</div>
														<?php	endforeach	?></li> 
										</ul>
								</li> 
						<?php	endforeach	?>
				</ul> 

		</div>
		<div class="footerForm">
				<input type="button" id="enregistrer_item" class="button button_vert close" value="<?php	echo	Kohana::lang(	'form.modif'	);	?>"/>
				<input type="button" class="button close" value="<?php	echo	Kohana::lang(	'form.annul'	);	?>"/>
		</div>
</form>

<script>
		$(function() {
				$('ul#accordion a.heading').click(function() {
						$(this).css('outline','none');
						if($(this).parent().hasClass('current')) {
								$(this).siblings('ul').slideUp('slow',function() {
										$(this).parent().removeClass('current');
								});
						} else {
								$('ul#accordion li.current ul').slideUp('slow',function() {
										$(this).parent().removeClass('current');
								});
								$(this).siblings('ul').slideToggle('slow',function() {
										$(this).parent().toggleClass('current');
								});
						}
						return;
				});
		});
</script>