<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' ); ?>

<article class="module width_full relative">
		<header>
				<h3 class="tabs_involved"><?php echo Kohana::lang( 'menu.element' ); ?></h3>
		</header>
		<table id="json_elements" class="datatable" cellspacing="0">
				<thead>
						<tr>
								<th width="50"><?php echo Kohana::lang( 'form.id' ); ?></th>
								<th><?php echo Kohana::lang( 'element.name' ); ?></th>
								<th width="100"><?php echo Kohana::lang( 'element.module' ); ?></th>
								<th width="150"><?php echo Kohana::lang( 'element.region' ); ?></th>
								<th width="50">X</th>
								<th width="50">Y</th>
								<th width="50">Z</th>
						</tr>
				</thead>
				<tbody>
						<tr>
								<td colspan="7" class="dataTables_empty"><?php echo Kohana::lang( 'form.loading' ); ?></td>
						</tr>
				</tbody>
		</table>
		<div class="clear"></div>
</article>