<?php	if(	isset(	$navigation	)	&&	isset(	$navigationURL	)	)	:	?>
		<div class="buttonNavigation">
				<?php	if(	$navigation['previous']	)	:	?>
						<a href="<?php	echo	url::base(TRUE).$navigationURL.'/'.$navigation['previous'];	?>">
						<div class="button_valide_icon" style="margin-left:0;"><img src="<?php echo url::base(); ?>images/buttons/previous.png" height="15" style="margin:4px 6px 2px 5px" title="<?php	echo	Kohana::lang(	'form.precedent'	);	?>" /></div>
						</a>
				<?php	endif	?>
				<?php	if(	$navigation['next']	)	:	?>
						<a href="<?php	echo	url::base(TRUE).$navigationURL.'/'.$navigation['next'];	?>">
						<div class="button_valide_icon"><img src="<?php echo url::base(); ?>images/buttons/next.png" height="15" style="margin:4px 5px 2px 6px" title="<?php	echo	Kohana::lang(	'form.suivant'	);	?>" /></div>
						</a>
				<?php	endif	?>
		</div>
<?php	endif	?>
<?php	if(	!isset(	$add	)	)	:	?>
		<div class="button_valide_icon btn_annuler"><span class="titre_menu rouge"><?php	echo	Kohana::lang(	'form.annul'	);	?></span></div>
		<div class="button_valide_icon btn_validation"><span class="titre_menu vert"><?php	echo	Kohana::lang(	'form.save_quit'	);	?></span></div>
		<div class="button_valide_icon btn_sauvegarde"><span class="titre_menu vert"><?php	echo	Kohana::lang(	'form.save'	);	?></span></div>
		<div class="button_valide_icon btn_trash"><span class="titre_menu vert"><?php	echo	Kohana::lang(	'form.delete'	);	?></span></div>
		<?php	if(	isset(	$add_sauv	)	)	:	?>
				<div class="button_valide_icon btn_menu_button_ajout_element"><span class="titre_menu vert"><?php	echo	Kohana::lang(	'form.save_add'	);	?></span></div>
		<?php	endif	?>
<?php	endif	?>
<?php	if(	isset(	$add	)	)	:	?>
		<a href="<?php	echo	$add;	?>">
		<div class="button_valide_icon"><span class="titre_menu vert"><?php	echo	Kohana::lang(	'form.new'	);	?></span></div>
		</a>
		<?php

 endif ?>
