<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' ); ?>

<article class="module width_full relative">
		<header>
				<h3 class="tabs_involved"><?php echo Kohana::lang( 'menu.quete' ); ?></h3>
		</header>
		<table id="json_quetes" class="datatable" cellspacing="0">
				<thead>
						<tr>
								<th width="50"><?php echo Kohana::lang( 'form.id' ); ?></th>
								<th><?php echo Kohana::lang( 'quete.title' ); ?></th>
								<th width="150"><?php echo Kohana::lang( 'quete.element_start' ); ?></th>
								<th width="150"><?php echo Kohana::lang( 'quete.element_stop' ); ?></th>
								<th width="70"><?php echo Kohana::lang( 'quete.lvl' ); ?></th>
								<th width="120"><?php echo Kohana::lang( 'quete.argent' ); ?></th>
								<th width="60"><?php echo Kohana::lang( 'quete.status' ); ?></th>
								<th width="50"></th>
						</tr>
				</thead>
				<tbody>
						<tr>
								<td colspan="5" class="dataTables_empty"><?php echo Kohana::lang( 'form.loading' ); ?></td>
						</tr>
				</tbody>
		</table>
		<div class="clear"></div>
</article>