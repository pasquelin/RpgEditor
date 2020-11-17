<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' ); ?>
<article class="module width_full relative">
		<header>
				<h3 class="tabs_involved"><?php echo Kohana::lang( 'menu.article' ); ?></h3>
		</header>
		<table id="json_articles" class="datatable" cellspacing="0">
				<thead>
						<tr>
								<th width="50"><?php echo Kohana::lang( 'form.id' ); ?></th>
								<th><?php echo Kohana::lang( 'article.desc' ); ?></th>
								<th width="250"><?php echo Kohana::lang( 'article.category' ); ?></th>
								<th width="60"><?php echo Kohana::lang( 'article.status' ); ?></th>
								<th width="50"></th>
						</tr>
				</thead>
				<tbody>
						<tr>
								<td colspan="4" class="dataTables_empty"><?php echo Kohana::lang( 'form.loading' ); ?></td>
						</tr>
				</tbody>
		</table>
		<div class="clear"></div>
</article>