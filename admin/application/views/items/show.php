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
						<label for="hp" class="form-label"><?php echo Kohana::lang( 'user.hp' ); ?> :</label>
						<input name="hp" id="hp" value="<?php echo $row->hp; ?>" class="inputbox input-text" type="text" maxlength="11" />
				</p>
				<p class="form-line">
						<label for="mp" class="form-label"><?php echo Kohana::lang( 'user.ammo' ); ?> :</label>
						<input name="mp" id="mp" value="<?php echo $row->ammo; ?>" class="inputbox input-text" type="text" maxlength="11" />
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
