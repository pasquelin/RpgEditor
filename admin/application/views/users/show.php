<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' ); ?>
<style type="text/css">
		.vignetteAvatar {
				background-image:url('<?php echo url::base(); ?>../images/character/<?php echo $row->avatar; ?>');
		}
</style>
<article class="module width_3_quarter">
		<header><h3 class="tabs_involved"><?php echo Kohana::lang( 'form.title_default' ); ?></h3>
		</header>
		<div class="module_content">
				<p class="form-line">
						<label for="username" class="form-label"><?php echo Kohana::lang( 'user.pseudo' ); ?> :</label>
						<input name="username" id="username" value="<?php echo $row->username; ?>" class="inputbox input-text" type="text" maxlength="50" />
				</p>
				<p class="form-line">
						<label for="password" class="form-label"><?php echo Kohana::lang( 'user.password' ); ?> :</label>
						<input name="password" id="password" value="" class="inputbox input-text" type="text" maxlength="50" />
				</p>
				<p class="form-line">
						<label for="email" class="form-label"><?php echo Kohana::lang( 'user.mail' ); ?> : <span><?php echo html::mailto( $row->email, Kohana::lang( 'form.write' ) ); ?></span></label>
						<input name="email" id="email" value="<?php echo $row->email; ?>" class="inputbox input-text" type="text" />
				</p>
				<p class="form-line">
						<label for="ip" class="form-label"><?php echo Kohana::lang( 'user.ip' ); ?> :</label>
						<input name="ip" id="ip" value="<?php echo $row->ip; ?>" class="inputbox input-text" type="text" />
				</p>
				<p class="form-line">
						<label for="role" class="form-label"><?php echo Kohana::lang( 'user.role' ); ?> :</label>
						<select name="role[]" size="7" multiple="multiple" id="role" class="inputbox input-select2">
								<?php if( isset( $roles ) ) : ?>
										<?php foreach( $roles as $val ) : ?>
												<option value="<?php echo $val->id; ?>" <?php echo isset( $roleUser[$val->id] ) ? 'selected="selected"' : FALSE; ?> title="<?php echo $val->description; ?>"><?php echo $val->name; ?></option>
										<?php endforeach ?>
								<?php endif ?>
						</select>
				<div><?php echo Kohana::lang( 'user.multi_click' ); ?><br />
						<p><em><?php echo Kohana::lang( 'user.attention' ); ?></em></p>
				</div>
				</p>	
				<p class="form-line">
						<label for="avatar" class="form-label"><?php echo Kohana::lang( 'user.avatar' ); ?> : <span><?php echo html::anchor( 'character', Kohana::lang( 'form.generate' ) ); ?></span></label>
						<input type="button" id="list_vignette_avatar" value="<?php echo Kohana::lang( 'form.selected_list' ); ?>" />
						<input type="hidden" value="<?php echo $row->avatar; ?>" id="avatar" name="avatar"/>
				</p>
				<p class="form-line">
						<label for="preambule" class="form-label"><?php echo Kohana::lang( 'user.preambule' ); ?> :</label>
						<select class="inputbox" name="preambule" id="preambule">
								<option value="1" class="vert"><?php echo Kohana::lang( 'form.yes' ); ?></option>
								<option value="0" class="rouge" <?php if( !$row->preambule )
										echo 'selected="selected"'; ?>><?php echo Kohana::lang( 'form.no' ); ?></option>
						</select>
				</p>
				<p class="form-line">
						<label for="region_id" class="form-label"><?php echo Kohana::lang( 'user.region' ); ?> :</label>
						<select name="region_id" id="region_id" class="inputbox" >
								<?php if( $regions ) : ?>
										<?php foreach( $regions as $val ) : ?>
												<option value="<?php echo $val->id; ?>" <?php echo ( $val->id == $row->region_id ) ? 'selected="selected"' : ''; ?> style="padding-left:<?php echo $val->level * 12; ?>px;"><?php echo $val->name; ?></option>
										<?php endforeach ?>
								<?php endif ?>
						</select>
				</p>
				<p class="form-line">
						<label for="x" class="form-label"><?php echo Kohana::lang( 'user.pos' ); ?> X :</label>
						<select name="x" id="x" class="inputbox" >
								<?php for( $n = 0; $n <= 50; $n++ ) : ?>
										<option value="<?php echo $n; ?>" <?php echo ( $n == $row->x ) ? 'selected="selected"' : ''; ?>><?php echo sprintf( '%02d', $n ); ?></option>
								<?php endfor ?>
						</select>
				</p>
				<p class="form-line">
						<label for="y" class="form-label"><?php echo Kohana::lang( 'user.pos' ); ?> Y :</label>
						<select name="y" id="y" class="inputbox" >
								<?php for( $n = 0; $n <= 50; $n++ ) : ?>
										<option value="<?php echo $n; ?>" <?php echo ( $n == $row->y ) ? 'selected="selected"' : ''; ?>><?php echo sprintf( '%02d', $n ); ?></option>
								<?php endfor ?>
						</select>
				</p>
				<p class="form-line">
						<label for="argent" class="form-label"><?php echo Kohana::lang( 'user.money' ); ?> :</label>
						<input name="argent" id="argent" value="<?php echo $row->argent; ?>" class="inputbox input-text" type="text" maxlength="11" />
				</p>
				<p class="form-line">
						<label for="niveau" class="form-label"><?php echo Kohana::lang( 'user.level' ); ?> :</label>
						<select name="niveau" id="niveau" class="inputbox" >
								<?php for( $n = 0; $n <= 100; $n++ ) : ?>
										<option value="<?php echo $n; ?>" <?php echo ( $n == $row->niveau ) ? 'selected="selected"' : ''; ?>><?php echo sprintf( '%02d', $n ); ?></option>
								<?php endfor ?>
						</select>
				</p>
				<p class="form-line">
						<label for="xp" class="form-label"><?php echo Kohana::lang( 'user.xp' ); ?> :</label>
						<input name="xp" id="xp" value="<?php echo $row->xp; ?>" class="inputbox input-text" type="text" maxlength="11" />
				</p>
				<p class="form-line">
						<label for="hp" class="form-label"><?php echo Kohana::lang( 'user.hp' ); ?> :</label>
						<input name="hp" id="hp" value="<?php echo $row->hp; ?>" class="inputbox input-text" type="text" maxlength="11" />
				</p>
				<p class="form-line">
						<label for="hp_max" class="form-label"><?php echo Kohana::lang( 'user.max', Kohana::lang( 'user.hp' ) ); ?> :</label>
						<input name="hp_max" id="hp_max" value="<?php echo $row->hp_max; ?>" class="inputbox input-text" type="text" maxlength="11" />
				</p>
				<p class="form-line">
						<label for="mp" class="form-label"><?php echo Kohana::lang( 'user.mp' ); ?> :</label>
						<input name="mp" id="mp" value="<?php echo $row->mp; ?>" class="inputbox input-text" type="text" maxlength="11" />
				</p>
				<p class="form-line">
						<label for="mp_max" class="form-label"><?php echo Kohana::lang( 'user.max', Kohana::lang( 'user.mp' ) ); ?> :</label>
						<input name="mp_max" id="mp_max" value="<?php echo $row->mp_max; ?>" class="inputbox input-text" type="text" maxlength="11" />
				</p>
		</div>
</article>
<article class="module width_quarter">
		<header><h3><?php echo $row->username; ?></h3></header>
		<div class="module_content">
				<div class="message">
						<div class="label">
								<label><?php echo Kohana::lang( 'user.id_user' ); ?> :</label>
								<span id="idUser"><?php echo $row->id; ?></span></div>
						<div class="label">
								<label><?php echo Kohana::lang( 'user.last_connect' ); ?> :</label>
								<?php echo $row->last_login ? ( date::convertir_date( $row->last_login ) ) : Kohana::lang( 'user.no_connect' ); ?></div>
						<div class="label">
								<label><?php echo Kohana::lang( 'user.nb_connect' ); ?> :</label>
								<?php echo number_format( $row->logins ); ?></div>
				</div>
				<div class="spacer"></div>
				<div style="text-align:center;">
						<div class="label">
								<a href="javascript:;" id="user_list_quetes"><?php echo Kohana::lang( 'user.link_quete' ); ?></a></div>
				</div>
		</div>
		<div class="spacer"></div>
</article>
<script>
		var username_required = "<?php echo Kohana::lang( 'form.name_required' ); ?>",
		username_minlength = "<?php echo Kohana::lang( 'form.name_minlength' ); ?>",
		username_maxlength = "<?php echo Kohana::lang( 'form.name_maxlength' ); ?>",
		password_minlength = "<?php echo Kohana::lang( 'form.password_minlength' ); ?>",
		password_maxlength = "<?php echo Kohana::lang( 'form.password_maxlength' ); ?>",
		email_required = "<?php echo Kohana::lang( 'form.email_required' ); ?>",
		email_format = "<?php echo Kohana::lang( 'form.email_format' ); ?>",
		argent_required = "<?php echo Kohana::lang( 'form.argent_required' ); ?>",
		argent_max = "<?php echo Kohana::lang( 'form.argent_max' ); ?>",
		argent_number = "<?php echo Kohana::lang( 'form.argent_number' ); ?>",
		xp_required = "<?php echo Kohana::lang( 'form.xp_required', Kohana::lang( 'user.xp' ) ); ?>",
		xp_max = "<?php echo Kohana::lang( 'form.xp_max', Kohana::lang( 'user.xp' ) ); ?>",
		xp_number = "<?php echo Kohana::lang( 'form.xp_number', Kohana::lang( 'user.xp' ) ); ?>",
		hp_required = "<?php echo Kohana::lang( 'form.hp_required', Kohana::lang( 'user.hp' ) ); ?>",
		hp_max = "<?php echo Kohana::lang( 'form.hp_max', Kohana::lang( 'user.hp' ) ); ?>",
		hp_number = "<?php echo Kohana::lang( 'form.hp_number', Kohana::lang( 'user.hp' ) ); ?>",
		mp_required = "<?php echo Kohana::lang( 'form.mp_required', Kohana::lang( 'user.mp' ) ); ?>",
		mp_max = "<?php echo Kohana::lang( 'form.mp_max', Kohana::lang( 'user.mp' ) ); ?>",
		mp_number = "<?php echo Kohana::lang( 'form.mp_number', Kohana::lang( 'user.mp' ) ); ?>",
		sauv_edit = '<?php echo Kohana::lang( 'form.save' ); ?>',
		annul_edit = '<?php echo Kohana::lang( 'form.annul' ); ?>',
		laoding_edit = '<?php echo Kohana::lang( 'form.loading' ); ?>';
</script>
