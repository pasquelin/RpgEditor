<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' ); ?>

<article class="module width_full relative">
		<header>
				<h3 class="tabs_involved"><?php echo $row->title; ?></h3>
		</header>
		<div class="module_content">
				<p class="form-line">
						<label for="title" class="form-label"><?php echo Kohana::lang( 'quete.title' ); ?> :</label>
						<input name="title" id="title" value="<?php echo $row->title; ?>" class="inputbox input-text" type="text" maxlength="50" />
				</p>
				<p class="form-line">
						<label for="status" class="form-label"><?php echo Kohana::lang( 'quete.status' ); ?> :</label>
						<select class="inputbox" name="status" id="status">
								<option value="1" class="vert"><?php echo Kohana::lang( 'form.yes' ); ?></option>
								<option value="0" class="rouge" <?php
if( !$row->status )
		echo 'selected="selected"';
?>><?php echo Kohana::lang( 'form.no' ); ?></option>
						</select>
				</p>
				<p class="form-line">
						<label for="element_detail_id_start" class="form-label"><?php echo Kohana::lang( 'quete.element_start' ); ?> :</label>
						<select name="element_detail_id_start" id="element_detail_id_start" class="inputbox" style="width:320px;">
								<?php if( $module ) : ?>
										<?php foreach( $module as $val ) : ?>
												<option value="<?php echo $val->id; ?>" <?php echo ( $val->id == $row->element_detail_id_start ) ? 'selected="selected"' : ''; ?>><?php echo $val->title; ?></option>
										<?php endforeach ?>
								<?php endif ?>
						</select>
				</p>
				<p class="form-line">
						<label for="element_detail_id_stop" class="form-label"><?php echo Kohana::lang( 'quete.element_stop' ); ?> :</label>
						<select name="element_detail_id_stop" id="element_detail_id_stop" class="inputbox" style="width:320px;">
								<?php if( $module ) : ?>
										<?php foreach( $module as $val ) : ?>
												<option value="<?php echo $val->id; ?>" <?php echo ( $val->id == $row->element_detail_id_stop ) ? 'selected="selected"' : ''; ?>><?php echo $val->title; ?></option>
										<?php endforeach ?>
								<?php endif ?>
						</select>
				</p>
				
				<p>
						<strong><?php echo Kohana::lang( 'quete.article_start' ); ?> : </strong>
						<?php Fck_Core::editeur( 'article_start', isset( $row->article_start ) ? $row->article_start : ''  ); ?>
				</p>
				
				<p>
						<strong><?php echo Kohana::lang( 'quete.article_stop' ); ?> : </strong>
						<?php Fck_Core::editeur( 'article_stop', isset( $row->article_stop ) ? $row->article_stop : ''  ); ?>
				</p>
				
				<p>
						<strong><?php echo Kohana::lang( 'quete.article_help' ); ?> : </strong>
						<?php Fck_Core::editeur( 'article_help', isset( $row->article_help ) ? $row->article_help : ''  ); ?>
				</p>
				<p class="form-line">
						<label for="niveau" class="form-label"><?php echo Kohana::lang( 'quete.level' ); ?> :</label>
						<select name="niveau" id="niveau" class="inputbox" >
								<?php for( $n = 0; $n <= 100; $n++ ) : ?>
										<option value="<?php echo $n; ?>" <?php echo ( $n == $row->niveau ) ? 'selected="selected"' : ''; ?>><?php echo sprintf( '%02d', $n ); ?></option>
								<?php endfor ?>
						</select>
				</p>
				<p class="form-line">
						<label for="xp" class="form-label"><?php echo Kohana::lang( 'quete.xp', Kohana::lang( 'user.xp' ) ); ?> :</label>
						<input name="xp" id="xp" value="<?php echo $row->xp; ?>" class="inputbox input-text" type="text" maxlength="11" />
				</p>
				<p class="form-line">
						<label for="argent" class="form-label"><?php echo Kohana::lang( 'quete.money', Kohana::lang( 'user.money' ) ); ?> :</label>
						<input name="argent" id="argent" value="<?php echo $row->argent; ?>" class="inputbox input-text" type="text" maxlength="11" />
				</p>
				<p class="form-line">
						<label for="quete_id_parent" class="form-label"><?php echo Kohana::lang( 'quete.quete_obligatoire' ); ?> :</label>
						<select name="quete_id_parent" id="quete_id_parent" class="inputbox" >
								<option value=""><?php echo Kohana::lang( 'quete.no_quete' ); ?> </option>
								<?php if( $quete ) : ?>
										<?php foreach( $quete as $val ) : ?>
												<option value="<?php echo $val->id_quete; ?>" <?php echo ( $val->id_quete == $row->quete_id_parent ) ? 'selected="selected"' : ''; ?>><?php echo $val->title; ?></option>
										<?php endforeach ?>
								<?php endif ?>
						</select>
				</p>
				<p><strong><?php echo Kohana::lang( 'form.add_function' ); ?></strong></p>
				<p><?php echo Kohana::lang( 'quete.info_fonction' ); ?></p>
				<pre>$txt = 'Votre quête est terminée';
$maj['xp'] = $quete-&gt;xp + $this-&gt;user-&gt;xp;<br />$maj['argent'] = $quete-&gt;argent + $this-&gt;user-&gt;argent;
<strong class="rouge">&lt;-- <?php echo Kohana::lang( 'form.your_code' ); ?> --&gt;</strong><br />$this-&gt;user-&gt;update( $maj, $this-&gt;user-&gt;id );</pre>
				<?php echo Code_Core::editeur( 'fonction', $row->fonction ? $row->fonction : '<?php ?>', 200 ); ?>
				<strong class="rouge"><?php echo Kohana::lang( 'form.warning_function' ); ?></strong>

		</div>
		<div class="clear"></div>
</article>
