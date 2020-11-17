<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' ) ?>

<article class="module width_full relative">
		<header>
				<h3 class="tabs_involved"><?php echo Kohana::lang( 'menu.stat' ); ?></h3>
		</header>
		<table id="json_items" class="datatable" cellspacing="0">
				<tbody>
						<?php foreach( $global as $key => $row ) : ?>
						<tr class="<?php echo $key % 2 == 0 ? 'odd' : 'even';  ?>">
								<td><?php echo Kohana::lang( 'statistique.'.$key ); ?></td>
								<td width="300"><strong><?php echo number_format( $row ); ?></strong></td>
						</tr>
						<?php endforeach ?>
				</tbody>
		</table>
		<div class="clear"></div>
</article>