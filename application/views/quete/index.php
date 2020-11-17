<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' ); ?>

<h2><?php echo html::image( 'images/template/lock_add.png', array( 'align' => 'top' ) ).' '.Kohana::lang( 'quete.recap_start' ); ?></h2>
<?php if( $start ) : ?>
		<table class="recap_quete">
				<?php foreach( $start as $row ) : ?>
						<tr>
								<td class="title"><strong class="vert"><?php echo $row->title; ?></strong></td>
								<td class="level orange"><?php echo Kohana::lang( 'user.level' ); ?> <?php echo $row->niveau; ?></td>
								<td class="link"><?php echo html::anchor( 'article/'.base64_encode( $row->article_id_help ).'?referer=quete', Kohana::lang( 'quete.article_recap' ) ); ?></td>
						</tr>
				<?php endforeach ?>
		</table>
<?php else : ?>
		<div class="rouge"><?php echo Kohana::lang( 'quete.no_start' ); ?></div>
<?php endif ?>
<hr/>
<h2><?php echo html::image( 'images/template/lock_go.png', array( 'align' => 'top' ) ).' '.Kohana::lang( 'quete.recap_stop' ); ?></h2>
<?php if( $stop ) : ?>
		<table class="recap_quete">
				<?php foreach( $stop as $row ) : ?>
						<tr>
								<td class="title"><strong class="vert"><?php echo $row->title; ?></strong></td>
								<td class="level orange"><?php echo Kohana::lang( 'user.level' ); ?> <?php echo $row->niveau; ?></td>
								<td class="link"><?php echo html::anchor( 'article/'.base64_encode( $row->article_id_stop ).'?referer=user/show', Kohana::lang( 'quete.article_recap' ) ); ?></td>
						</tr>
				<?php endforeach ?>
		</table>
<?php else : ?>
		<div><?php echo Kohana::lang( 'quete.no_stop' ); ?></div>
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