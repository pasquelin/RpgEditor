<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' ) ?>

<article class="module width_full relative">
		<form method="post" action="<?php echo url::base( TRUE ); ?>mailing/envoyer" name="form" id="form" class="form-css">
				<header>
						<h3 class="tabs_involved"><?php echo Kohana::lang( 'mailing.send_mailing' ); ?></h3>
				</header>
				<div class="module_content">
						<fieldset>
								<label for="sujet" class="form-label"><?php echo Kohana::lang( 'mailing.sujet' ); ?></label>
								<input name="sujet" type="text" id="sujet" value="<?php echo isset( $sujet ) ? $sujet : ''; ?>" maxlength="50" />
						</fieldset>
						<fieldset>
								<label for="texte" class="form-label"><?php echo Kohana::lang( 'mailing.msg' ); ?></label>
								<textarea name="texte" id="texte" rows="12"><?php echo isset( $texte ) ? $texte : ''; ?></textarea>
						</fieldset>
						<div class="clear"></div>
				</div>
				<footer>
						<div class="submit_link">
								<input type="reset" value="Reset">
								<input type="submit" value="<?php echo Kohana::lang( 'mailing.label_button' ); ?>" id="buttonSubmitEmailing" class="alt_btn">
						</div>
				</footer>
				<div class="clear"></div>
		</form>
</article>