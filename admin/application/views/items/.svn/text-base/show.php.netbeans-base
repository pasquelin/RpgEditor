<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' ); ?>


<article class="module width_3_quarter">
		<header><h3 class="tabs_involved"><?php echo Kohana::lang( 'form.title_default' ); ?></h3>
		</header>
		<div class="module_content">
				<p class="form-line">
						<label for="name" class="form-label"><?php echo Kohana::lang( 'item.name' ); ?> :</label>
						<input name="name" id="name" value="<?php echo $row->name; ?>" class="inputbox input-text" type="text" maxlength="50" />
				</p>
				<p class="form-line">
						<label for="comment" class="form-label"><?php echo Kohana::lang( 'item.desc' ); ?> : <span class="p-lower"><?php echo Kohana::lang( 'form.minus' ); ?></span></label>
						<textarea name="comment" id="comment" class="inputbox input-textarea" style="height:100px;"><?php echo $row->comment; ?></textarea>
				</p>	
				<p class="form-line">
						<label class="form-label"><?php echo Kohana::lang( 'item.img' ); ?> :</label>
						<input type="button" id="list_vignette" value="<?php echo Kohana::lang( 'form.selected_list' ); ?>" />
						<input type="hidden" value="<?php echo $row->image; ?>" id="image" name="image"/>
				</p>
				<p class="form-line">
						<label for="prix" class="form-label"><?php echo Kohana::lang( 'item.price' ); ?> :</label>
						<input name="prix" id="prix" value="<?php echo $row->prix; ?>" class="inputbox input-text" type="text" maxlength="11" />
				</p>
				<p class="form-line">
						<label for="niveau" class="form-label"><?php echo Kohana::lang( 'item.level' ); ?> :</label>
						<select name="niveau" id="niveau" class="inputbox" >
								<?php for( $n = 0; $n <= 100; $n++ ) : ?>
										<option value="<?php echo $n; ?>" <?php echo ( $n == $row->niveau ) ? 'selected="selected"' : ''; ?>><?php echo sprintf( '%02d', $n ); ?></option>
								<?php endfor ?>
						</select>
				</p>
				<p class="form-line">
						<label for="quick" class="form-label"><?php echo Kohana::lang( 'item.quick' ); ?> :</label>
						<select class="inputbox" name="quick" id="quick">
								<option value="1" class="vert"><?php echo Kohana::lang( 'form.yes' ); ?></option>
								<option value="0" class="rouge" <?php if( !$row->quick )
										echo 'selected="selected"'; ?>><?php echo Kohana::lang( 'form.no' ); ?></option>
						</select>
				</p>
				<p class="form-line">
						<label for="protect" class="form-label"><?php echo Kohana::lang( 'item.protect' ); ?> :</label>
						<select class="inputbox" name="protect" id="protect">
								<option value="1" class="vert"><?php echo Kohana::lang( 'form.yes' ); ?></option>
								<option value="0" class="rouge" <?php if( !$row->protect )
														echo 'selected="selected"'; ?>><?php echo Kohana::lang( 'form.no' ); ?></option>
						</select>
				</p>
				<div id="option_objet" <?php echo!$row->protect ? 'style="display:none"' : ''; ?>>
						<p class="form-line">
								<label for="position" class="form-label"><?php echo Kohana::lang( 'item.position' ); ?> :</label>
								<select name="position" id="position" class="inputbox" >
										<option value="" >--</option>
										<?php for( $n = 1; $n <= 7; $n++ ) : ?>
												<option value="<?php echo $n; ?>" <?php if( $row->position == $n )
												echo 'selected="selected"'; ?>><?php echo Kohana::lang( 'item.position_'.$n ); ?></option>
														<?php endfor ?>
								</select>
						</p>
						<p class="form-line">
								<label for="attaque" class="form-label"><?php echo Kohana::lang( 'item.attaque' ); ?> :</label>
								<select name="attaque" id="attaque" class="inputbox" >
										<?php for( $n = 0; $n <= 100; $n++ ) : ?>
												<option value="<?php echo $n; ?>" <?php echo ( $n == $row->attaque ) ? 'selected="selected"' : ''; ?>><?php echo sprintf( '%02d', $n ); ?></option>
										<?php endfor ?>
								</select>
						</p>
						<p class="form-line">
								<label for="defense" class="form-label"><?php echo Kohana::lang( 'item.defense' ); ?> :</label>
								<select name="defense" id="defense" class="inputbox" >
										<?php for( $n = 0; $n <= 100; $n++ ) : ?>
												<option value="<?php echo $n; ?>" <?php echo ( $n == $row->defense ) ? 'selected="selected"' : ''; ?>><?php echo sprintf( '%02d', $n ); ?></option>
										<?php endfor ?>
								</select>
						</p>
				</div>
				<p class="form-line">
						<label for="hp" class="form-label"><?php echo Kohana::lang( 'user.hp' ); ?> :</label>
						<input name="hp" id="hp" value="<?php echo $row->hp; ?>" class="inputbox input-text" type="text" maxlength="11" />
				</p>
				<p class="form-line">
						<label for="mp" class="form-label"><?php echo Kohana::lang( 'user.mp' ); ?> :</label>
						<input name="mp" id="mp" value="<?php echo $row->mp; ?>" class="inputbox input-text" type="text" maxlength="11" />
				</p>
				<p class="form-line">
						<label for="cle" class="form-label"><?php echo Kohana::lang( 'item.cle' ); ?> :</label>
						<select class="inputbox" name="cle" id="cle">
								<option value="1" class="vert"><?php echo Kohana::lang( 'form.yes' ); ?></option>
								<option value="0" class="rouge" <?php if( !$row->cle )
												echo 'selected="selected"'; ?>><?php echo Kohana::lang( 'form.no' ); ?></option>
						</select>
				</p>
		</div>
</article>
<article class="module width_quarter">
		<header><h3><?php echo $row->name; ?></h3></header>
		<div class="module_content">
				<div class="label">
						<label><?php echo Kohana::lang( 'item.id' ); ?> :</label>
						<?php echo $row->id; ?></div>
				<div class="label">
						<label><?php echo Kohana::lang( 'item.vignette' ); ?> :</label>
						<div class="clear"></div>
						<div class="center" style="margin:10px 0; display:block"> <img src="<?php echo url::base(); ?>../images/items/<?php echo $row->image; ?>" width="24" height="24" id="imageItem" class="imageItem" /></div>
				</div>
		</div>
</article>
<div class="clear"></div>
<article class="module width_full">
		<header><h3 class="tabs_involved"><?php echo Kohana::lang( 'item.couple' ); ?> <?php echo $row->name; ?></h3>
		</header>
		<div class="module_content">
				<fieldset>
						<label><?php echo Kohana::lang( 'item.nbr' ); ?>  <?php echo $row->name; ?> :</label>
						<div class="left_calcul">
								<select id="nbr_one" name="nbr_one">
										<option value="">--</option>
										<?php for( $n = 1; $n < 99; $n++ ) : ?>
												<option value="<?php echo $n; ?>"><?php echo sprintf( '%02d', $n ); ?></option>
										<?php endfor ?>
								</select>
						</div>
						<div class="clear"></div>
						<div class="spacer"></div>
						<label><?php echo Kohana::lang( 'item.width_couple' ); ?>  :</label>
						<div class="left_calcul">
								<select id="nbr_two" name="nbr_two">
										<option value="">--</option>
										<?php for( $n = 1; $n < 99; $n++ ) : ?>
												<option value="<?php echo $n; ?>"><?php echo sprintf( '%02d', $n ); ?></option>
										<?php endfor ?>
								</select>
						</div>
						<div class="left_calcul">
								<select id="items_id_two" name="items_id_two">
										<option value="">--</option>
										<?php foreach( $items as $tiem ) : ?>
												<option value="<?php echo $tiem->id; ?>"><?php echo $tiem->name; ?></option>
										<?php endforeach ?>
								</select>
						</div>
						<div class="clear"></div>
						<div class="spacer"></div>
						<label><?php echo Kohana::lang( 'item.item_couple' ); ?> :</label>
						<div class="left_calcul">
								<select id="items_id_result" name="items_id_result">
										<option value="">--</option>
										<?php foreach( $items as $tiem ) : ?>
												<option value="<?php echo $tiem->id; ?>"><?php echo $tiem->name; ?></option>
										<?php endforeach ?>
								</select>
						</div>
						<div class="clear"></div>
						<div class="spacer"></div>
						<label><?php echo Kohana::lang( 'item.choose_couple' ); ?> :</label>
						<div class="left_calcul">
								<select id="job_id" name="job_id[]"  multiple="multiple" size="5">
										<?php if( $jobs ): ?>
												<?php foreach( $jobs as $job ) : ?>
														<option title="<?php echo $job->comment; ?>" value="<?php echo $job->id; ?>"><?php echo $job->name; ?></option>
												<?php endforeach ?>
										<?php endif; ?>
								</select> 								
						</div>
						<div class="clear"></div>
						<div class="spacer"></div>
						<label><?php echo Kohana::lang( 'item.lvl_couple' ); ?> :</label>
						<div class="left_calcul">
								<select id="niveau_couple" name="niveau_couple">
										<?php for( $n = 0; $n < 99; $n++ ) : ?>
												<option value="<?php echo $n; ?>"><?php echo sprintf( '%02d', $n ); ?></option>
										<?php endfor ?>
								</select>
						</div>
						<div class="clear"></div>
						<div class="spacer"></div>
						<label><?php echo Kohana::lang( 'item.xp_couple' ); ?> :</label>
						<div class="left_calcul">
								<select id="xp_couple" name="xp_couple">
										<?php for( $n = 0; $n <= 1000; $n+=10 ) : ?>
												<option value="<?php echo $n; ?>"><?php echo sprintf( '%02d', $n ); ?></option>
										<?php endfor ?>
								</select>
						</div>
				</fieldset>
				<div class="clear"></div>
				<?php if( $couples ) : ?>
						<table width="100%">
								<?php foreach( $couples as $couple ) : ?>
										<tr>
												<td><img src="<?php echo url::base(); ?>../images/items/<?php echo $items[$couple->items_id_one]->image; ?>" width="24" height="24" /></td>
												<td><?php echo $couple->nbr_one; ?> <?php echo $items[$couple->items_id_one]->name; ?></td>
												<td>+</td>
												<td><img src="<?php echo url::base(); ?>../images/items/<?php echo $items[$couple->items_id_two]->image; ?>" width="24" height="24" /></td>
												<td><?php echo $couple->nbr_two; ?> <?php echo $items[$couple->items_id_two]->name; ?></td>
												<td>=</td>
												<td><img src="<?php echo url::base(); ?>../images/items/<?php echo $couple->image; ?>" width="24" height="24" /></td>
												<td><?php echo $couple->name; ?></td>
												<td>niv <?php echo $couple->items_link_niveau; ?></td>
												<td><?php echo $jobs[$couple->job_id]->name; ?></td>
												<td class="right"><?php echo html::anchor( 'items/delete_link/'.$couple->items_link_id.'/'.$row->id, Kohana::lang( 'form.delete' ) ); ?></td>
										</tr>
								<?php endforeach; ?>
						</table>
				<?php else : ?>
						<div><?php echo Kohana::lang( 'item.no_couple' ); ?></div>
				<?php endif; ?>
		</div>
</article>
<script>
		var name_required = "<?php echo Kohana::lang( 'form.name_required' ); ?>",
		name_minlength = "<?php echo Kohana::lang( 'form.name_minlength' ); ?>",
		name_maxlength = "<?php echo Kohana::lang( 'form.name_maxlength' ); ?>",
		comment_required = "<?php echo Kohana::lang( 'form.comment_required' ); ?>",
		comment_minlength = "<?php echo Kohana::lang( 'form.comment_minlength' ); ?>",
		comment_maxlength = "<?php echo Kohana::lang( 'form.comment_maxlength' ); ?>",
		image_required = "<?php echo Kohana::lang( 'form.image_required' ); ?>",
		prix_required = "<?php echo Kohana::lang( 'form.prix_required' ); ?>",
		prix_max = "<?php echo Kohana::lang( 'form.prix_max' ); ?>",
		prix_number = "<?php echo Kohana::lang( 'form.prix_number' ); ?>",
		hp_min = "<?php echo Kohana::lang( 'form.hp_min', Kohana::lang( 'user.hp' ) ); ?>",
		hp_max = "<?php echo Kohana::lang( 'form.hp_max', Kohana::lang( 'user.hp' ) ); ?>",
		hp_number = "<?php echo Kohana::lang( 'form.hp_number', Kohana::lang( 'user.hp' ) ); ?>",
		mp_min = "<?php echo Kohana::lang( 'form.mp_min', Kohana::lang( 'user.mp' ) ); ?>",
		mp_max = "<?php echo Kohana::lang( 'form.mp_max', Kohana::lang( 'user.mp' ) ); ?>",
		mp_number = "<?php echo Kohana::lang( 'form.mp_number' ), Kohana::lang( 'user.mp' ); ?>";
</script> 
