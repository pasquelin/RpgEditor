<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' ); ?>
<article class="module width_full relative">
		<header>
				<h3 class="tabs_involved"><?php echo Kohana::lang( 'menu.users' ); ?></h3>
		</header>
		<table id="json_users" class="datatable" cellspacing="0" >
				<thead>
						<tr>
								<th width="50"><?php echo Kohana::lang( 'form.id' ); ?></th>
								<th><?php echo Kohana::lang( 'user.pseudo' ); ?></th>
								<th width="150"><?php echo Kohana::lang( 'user.last_login' ); ?></th>
								<th width="150"><?php echo Kohana::lang( 'user.mail' ); ?></th>
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