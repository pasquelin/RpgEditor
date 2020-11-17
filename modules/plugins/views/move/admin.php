<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' ); ?>

<div class="row_form">
		<label><span class="titreSpanForm"><?php echo Kohana::lang( 'action.pos_end' ); ?> X</span>
				<input type="text" class="input-text" name="x_move" value="<?php echo isset( $data->x_move ) ? $data->x_move : false; ?>" maxlength="11" />
		</label>
		<div class="clear"></div>
</div>
<div class="row_form">
		<label><span class="titreSpanForm"><?php echo Kohana::lang( 'action.pos_end' ); ?> Y</span>
				<input type="text" class="input-text" name="y_move" value="<?php echo isset( $data->y_move ) ? $data->y_move : false; ?>" maxlength="11" />
		</label>
		<div class="clear"></div>
</div>
<div class="row_form">
		<label><span class="titreSpanForm"><?php echo Kohana::lang( 'action.pos_end' ); ?> Z</span>
				<input type="text" class="input-text" name="z_move" value="<?php echo isset( $data->z_move ) ? $data->z_move : false; ?>" maxlength="11" />
		</label>
		<div class="clear"></div>
</div>
<div class="row_form">
		<label>
				<span class="titreSpanForm"><?php echo Kohana::lang( 'action.choose_map' ); ?></span>
				<select name="id_region_move" class="input-select" >
						<?php if( $region ) : ?>
								<?php foreach( $region as $val ) : ?>
										<option value="<?php echo $val->id; ?>" <?php echo isset( $data->id_region_move ) && $val->id == $data->id_region_move ? 'selected="selected"' : ''; ?> style="padding-left:<?php echo $val->level * 12; ?>px;"><?php echo $val->name; ?></option>
								<?php endforeach ?>
						<?php endif ?>
				</select>
		</label>
		<div class="clear"></div>
</div>
<div class="row_form">
		<label>
				<span class="titreSpanForm"><?php echo Kohana::lang( 'action.music_move' ); ?></span>
				<select name="music" class="input-select" >
						<option value="" ><?php echo Kohana::lang( 'region.no_music' ); ?></option>
						<option value="porte" <?php echo isset( $data->music ) && $data->music == 'porte' ? 'selected="selected"' : ''; ?>><?php echo Kohana::lang( 'action.music_porte' ); ?></option>
						<option value="teleporte" <?php echo isset( $data->music ) && $data->music == 'teleporte' ? 'selected="selected"' : ''; ?>><?php echo Kohana::lang( 'action.music_teleporte' ); ?></option>
				</select>
		</label>
		<div class="clear"></div>
</div>
<div class="row_form">
		<label><span class="titreSpanForm"><?php echo Kohana::lang( 'action.price_move' ); ?></span>
				<input type="text" class="input-text" name="prix" value="<?php echo isset( $data->prix ) ? $data->prix : false; ?>" size="20" maxlength="11" />
		</label>
		<div class="clear"></div>
</div>