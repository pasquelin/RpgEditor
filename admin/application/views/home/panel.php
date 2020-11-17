<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' ) ?>
<?php if( $version ) : ?>
		<h4 class="alert_warning"><?php echo Kohana::lang( 'menu.version_game', $version, Kohana::config( 'game.version' ) ); ?></h4>
<?php endif ?>
<article class="module width_3_quarter">
		<header><h3 class="tabs_involved"><?php echo Kohana::lang( 'menu.menu_quick' ); ?></h3>
		</header>
		<?php if( $menu ) : ?>
				<?php foreach( $menu as $row ) : ?>
						<div class="panel-bloc-menu">
								<div><img src="<?php echo url::base(); ?>images/menu/<?php echo $row['img']; ?>" width="48" height="48" alt="<?php echo $row['title']; ?>" /></div>
								<div><a href="<?php echo $row['href']; ?>"><?php echo $row['title']; ?></a></div>
						</div>
				<?php endforeach ?>
		<?php endif ?>
		<div class="spacer"></div>
</article>
<article class="module width_quarter">
		<header><h3><?php echo Kohana::lang( 'statistique.stat_light' ); ?></h3></header>
		<div class="module_content">
				<?php echo $stats; ?>
		</div>
		<div class="spacer"></div>
</article>
<div class="clear"></div>
<article class="module width_full">
		<form method="post" action="<?php echo url::base( TRUE ); ?>mailing/envoyer" >
				<header><h3><?php echo Kohana::lang( 'mailing.send_title' ); ?></h3></header>
				<div class="module_content">
						<fieldset>
								<label><?php echo Kohana::lang( 'mailing.sujet' ); ?></label>
								<input name="sujet" type="text">
						</fieldset>
						<fieldset>
								<label><?php echo Kohana::lang( 'mailing.msg' ); ?></label>
								<textarea name="texte" rows="12"></textarea>
						</fieldset>
						<div class="clear"></div>
				</div>
				<footer>
						<div class="submit_link">
								<input type="reset" value="<?php echo Kohana::lang( 'form.reset' ); ?>">
								<input type="submit" value="<?php echo Kohana::lang( 'mailing.label_button' ); ?>" class="alt_btn">
						</div>
				</footer>
		</form>
</article>