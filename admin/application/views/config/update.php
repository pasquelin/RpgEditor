<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' ) ?>

<article class="module width_full relative">
		<form method="post" action="<?php echo url::base( TRUE ); ?>config/save/<?php echo $file_name; ?>" >
				<header>
						<h3 class="tabs_involved"><?php echo Kohana::lang( 'config.update' ); ?></h3>
				</header>
				<div class="module_content">
						<?php echo Code_Core::editeur( 'fichier', $file, 600 ); ?>
				</div>
				<footer>
						<div class="submit_link">
								<input type="submit" value="<?php echo Kohana::lang( 'form.modif' ); ?>" class="alt_btn">
						</div>
				</footer>
				<div class="clear"></div>
		</form>
</article>