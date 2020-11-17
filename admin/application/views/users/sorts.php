<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' ); ?>

<form>
		<div class="titreForm">
				<div class="titreCentent"><?php echo Kohana::lang( 'user.title_sort_user' ); ?></div>
				<div class="spacer"></div>
		</div>
		<div class="contentForm">
				<table width="100%" cellpadding="0">
						<?php foreach( $listSort as $row ) : ?>
								<tr>
										<td><label for="sort_<?php echo $row->id; ?>"><img src="<?php echo url::base(); ?>../images/sorts/<?php echo $row->image; ?>" width="24" height="24" id="imageItem" align="middle"/> <a href="<?php echo url::base( TRUE ); ?>sorts/show/<?php echo $row->id; ?>" class="titreSpanForm"><?php echo $row->name; ?></a></label></td>
										<td align="right" width="70"><select class="inputbox" name="sort[<?php echo $row->id; ?>]" id="sort_<?php echo $row->id; ?>">
														<option value="0" class="rouge"><?php echo Kohana::lang( 'form.no' ); ?></option>
														<option value="1" class="vert" <?php if( isset( $userSort[$row->id] ) && $userSort[$row->id] ) echo 'selected="selected"'; ?>><?php echo Kohana::lang( 'form.yes' ); ?></option>
												</select></td>
								</tr>
						<?php endforeach ?>
				</table>
		</div>
		<div class="footerForm">
				<input type="button" id="enregistrer_sort" class="button button_vert close" value="<?php echo Kohana::lang( 'form.modif' ); ?>"/>
				<input type="button" class="button close" value="<?php echo Kohana::lang( 'form.annul' ); ?>"/>
		</div>
</form>