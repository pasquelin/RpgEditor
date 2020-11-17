<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' ); ?>
<article class="module width_full relative">
		<header><h3 class="tabs_involved"><?php echo $row->name; ?> - <a href="<?php echo url::base( TRUE ); ?>mapping/panel/<?php echo $row->id; ?>" ><?php echo Kohana::lang( 'region.edit_map' ); ?></a></h3>
		</header>
		<div class="module_content">
				<p class="form-line">
						<label for="name" class="form-label"><?php echo Kohana::lang( 'region.name' ); ?> :</label>
						<input name="name" id="name" value="<?php echo $row->name; ?>" class="inputbox input-text" type="text" maxlength="50" />
				</p>
				<p class="form-line">
						<label for="comment" class="form-label"><?php echo Kohana::lang( 'region.desc' ); ?> : <span class="p-lower"><?php echo Kohana::lang( 'form.minus' ); ?></span></label>
						<textarea name="comment" id="comment" class="inputbox input-textarea" style="height:100px;"><?php echo $row->comment; ?></textarea>
				</p>
				<p class="form-line">
						<label for="id_parent" class="form-label"><?php echo Kohana::lang( 'region.parent_map' ); ?> :</label>
						<select name="id_parent" id="id_parent" class="inputbox" >
								<option value="" ><?php echo Kohana::lang( 'region.prim_map' ); ?></option>
								<?php if( $listing ) : ?>
										<?php foreach( $listing as $val ) : ?>
												<option value="<?php echo $val->id; ?>" <?php
								if( $val->id == $row->id_parent )
										echo 'selected="selected"';
												?> <?php
								if( $val->id == $row->id )
										echo 'disabled="disabled""';
												?> style="padding-left:<?php echo $val->level * 12; ?>px;"><?php echo $val->name; ?></option>
														<?php endforeach ?>
												<?php endif ?>
						</select>
				</p>
				<p class="form-line">
						<label for="x" class="form-label"><?php echo Kohana::lang( 'region.nbr_case' ); ?> X :</label>
						<input name="x" id="x" value="<?php echo $row->x; ?>" class="inputbox input-text" type="text" maxlength="50" />
				</p>
				<p class="form-line">
						<label for="y" class="form-label"><?php echo Kohana::lang( 'region.nbr_case' ); ?> Y :</label>
						<input name="y" id="y" value="<?php echo $row->y; ?>" class="inputbox input-text" type="text" maxlength="50" />
				</p>
            <p class="form-line">
                <label for="z" class="form-label"><?php echo Kohana::lang( 'region.nbr_case' ); ?> Z :</label>
                <input name="z" id="z" value="<?php echo $row->z; ?>" class="inputbox input-text" type="text" maxlength="50" />
            </p>

            <p class="form-line">
                <label for="degradation" class="form-label"><?php echo Kohana::lang( 'region.degradation' ); ?> :</label>
                <select name="degradation" id="degradation" class="inputbox" >
                    <?php for( $n = 0; $n <= 5; $n++ ) : ?>
                        <option value="<?php echo $n; ?>" <?php echo ( $n == $row->degradation ) ? 'selected="selected"' : ''; ?>><?php echo sprintf( '%02d', $n ); ?></option>
                    <?php endfor ?>
                </select>
            </p>

            <p class="form-line">
                <label for="frequence" class="form-label"><?php echo Kohana::lang( 'region.frequence' ); ?> :</label>
                <select name="frequence" id="frequence" class="inputbox" >
                    <?php for( $n = 0; $n <=100; $n++ ) : ?>
                        <option value="<?php echo $n; ?>" <?php echo ( $n == $row->frequence ) ? 'selected="selected"' : ''; ?>><?php echo sprintf( '%02d', $n ); ?></option>
                    <?php endfor ?>
                </select>
            </p>

            <p class="form-line">
                <label for="background_color" class="form-label"><?php echo Kohana::lang( 'region.color' ); ?> :</label>
                <input name="background_color" id="background_color" value="<?php echo str_replace('0x', '#',$row->background_color); ?>" class="inputbox input-text" type="color" maxlength="50" />
            </p>

            <p class="form-line">
                <label for="ambiance" class="form-label"><?php echo Kohana::lang( 'region.ambiance' ); ?> :</label>
                <input name="ambiance" id="ambiance" value="<?php echo str_replace('0x', '#',$row->ambiance); ?>" class="inputbox input-text" type="color" maxlength="50" />
            </p>

            <p class="form-line">
                <label for="sun" class="form-label"><?php echo Kohana::lang( 'region.sun' ); ?> :</label>
                <select class="inputbox" name="sun" id="sun">
                    <option value="1" class="vert"><?php echo Kohana::lang( 'form.yes' ); ?></option>
                    <option value="0" class="rouge" <?php if( !$row->sun ) echo 'selected="selected"'; ?>><?php echo Kohana::lang( 'form.no' ); ?></option>
                </select>
            </p>

            <p class="form-line">
                <label for="skybox" class="form-label"><?php echo Kohana::lang( 'region.skybox' ); ?> :</label>
                <select name="skybox" id="skybox" class="inputbox" >
                    <option value="0"><?php echo Kohana::lang( 'region.noSkybox' ); ?></option>
                    <?php if( $skybox ) : ?>
                        <?php foreach( $skybox as $val ) : ?>
                            <option value="<?php echo $val; ?>" <?php echo ( $val == $row->skybox ) ? 'selected="selected"' : ''; ?>><?php echo $val; ?></option>
                        <?php endforeach ?>
                    <?php endif ?>
                </select>
            </p>

				<p class="form-line">
						<label class="form-label"><?php echo Kohana::lang( 'region.image_bg' ); ?> :</label>
						<input type="button" id="list_vignette_background" class="button" value="<?php echo Kohana::lang( 'form.selected_list' ); ?>" />
						<input type="hidden" value="<?php echo $row->background; ?>" id="background" name="background"/>
				</p>

				<p class="form-line">
						<label for="music" class="form-label"><?php echo Kohana::lang( 'region.music' ); ?> :</label>
						<select name="music" id="music" class="inputbox" >
								<option value="" ><?php echo Kohana::lang( 'region.no_music' ); ?></option>
								<?php if( $music ) : ?>
										<?php foreach( $music as $val ) : ?>
												<option value="<?php echo $val; ?>" <?php
								if( $val == $row->music )
										echo 'selected="selected"';
												?> ><?php echo str_replace( '.ogg', '', str_replace( '_', ' ', $val ) ); ?></option>
														<?php endforeach ?>
												<?php endif ?>
						</select>
				</p>

            <p class="form-line">
                <label for="fonction" class="form-label"><?php echo Kohana::lang( 'region.function' ); ?> : </label>
                <textarea name="fonction" id="fonction" class="inputbox input-textarea" style="height:200px;"><?php echo $row->fonction; ?></textarea>
            </p>
		</div>
</article>
<script>
		var name_required = "<?php echo Kohana::lang( 'form.name_required' ); ?>",
		name_minlength = "<?php echo Kohana::lang( 'form.name_minlength' ); ?>",
		name_maxlength = "<?php echo Kohana::lang( 'form.name_maxlength' ); ?>",
		comment_required = "<?php echo Kohana::lang( 'form.comment_required' ); ?>",
		comment_minlength = "<?php echo Kohana::lang( 'form.comment_minlength' ); ?>",
		comment_maxlength = "<?php echo Kohana::lang( 'form.comment_maxlength' ); ?>",
		x_required = "<?php echo Kohana::lang( 'form.x_required' ); ?>",
		x_numeric = "<?php echo Kohana::lang( 'form.x_numeric' ); ?>",
		x_min = "<?php echo Kohana::lang( 'form.x_min' ); ?>",
		x_max = "<?php echo Kohana::lang( 'form.x_max' ); ?>";
</script> 
