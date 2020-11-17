<?php defined( 'SYSPATH' ) or die( 'No direct access allowed.' ); ?>
<!doctype html>
<html lang="en">
		<head>
				<meta charset="utf-8"/>
				<title>Dashboard I Admin Panel</title>
				<?php
				echo isset( $script ) ? $script : FALSE;
				echo isset( $css ) ? $css : FALSE;
				?>
		</head>
		<body>
				<aside id="sidebar" class="column">
						<?php echo isset( $menu ) ? $menu : FALSE; ?>	
				</aside>
				<section id="main" class="column">
						<?php if( $msg ) : ?>
								<h4 class="alert_info" id="msg"><?php echo $msg; ?></h4>
						<?php endif ?>
						<?php echo isset( $contenu ) ? $contenu : FALSE; ?>
						<div class="clear"></div>
						<?php if( isset( $button ) && $button ) : ?>
								<div class="button_valid_bottom">
										<div class="button_valid_content"><?php echo $button; ?></div>
								</div>
						<?php endif ?>
				</section>
		</body>
</html>
