<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' ); ?>
<?php $article = explode( '<hr id="system-readmore" />', $article ); ?>
<h1><?php echo $titre; ?></h1>
<?php if( $article && count( $article ) > 1 ) : ?>
		<div class="coda-slider-wrapper">
				<div class="coda-slider preload" id="coda-slider-1">
						<?php foreach( $article as $key => $row ) : ?>
								<div class="panel">
										<div class="panel-wrapper">
												<div class="titleCoda"><?php echo Kohana::lang( 'article.page', (1 + $key ) ); ?></div>
												<div><?php echo article::edit_user( $row, $username ); ?></div>
										</div>
								</div>
						<?php endforeach ?>
				</div>
		</div>
<?php else : ?>
		<?php echo article::edit_user( $article[0], $username ); ?>
<?php endif ?>
<hr/>
<?php if( isset( $referer ) && $referer ) : ?>
		<div class="right"><?php echo html::anchor( $referer, Kohana::lang( 'article.close' ), array( 'class' => 'button' ) ); ?></div>
<?php else : ?>
		<div class="right"><?php echo html::anchor( NULL, Kohana::lang( 'form.return_map' ), array( 'class' => 'button' ) ); ?></div>
<?php endif ?>

<script>
		$(function(){
	
				var sliderwidth = $("#coda-slider-1").width();
		
				$("#coda-slider-1 .panel").width(sliderwidth);

				$('#coda-slider-1').codaSlider({
						dynamicTabsPosition : 'bottom', 
						dynamicArrows : false, 
						panelTitleSelector : '.titleCoda',
						autoHeightEaseFunction: "easeInOutElastic",
						slideEaseFunction : 'easeInOutBack'
				});
		});
</script>
