<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' ) ?>

<article class="module width_full relative">
		<header>
				<h3 class="tabs_involved"><?php echo Kohana::lang( 'menu.config' ); ?></h3>
		</header>
		<div>
				<table id="json_items" class="datatable" cellspacing="0">
						<tbody>
								<tr class="odd">
										<td width="200"><strong><?php echo Kohana::lang( 'config.version' ); ?></strong></td>
										<td><?php echo version_compare( PHP_VERSION, '5.2', '<' ) ? '<b class="rouge">'.$versionPHP.' < 5.2</b>' : '<b class="vert">'.$versionPHP.' > 5.2</b>'; ?></td>
								</tr>
								<tr class="even">
										<td width="200"><strong><strong><?php echo Kohana::lang( 'config.interface' ); ?></strong></td>
										<td><?php echo php_sapi_name(); ?></td>
								</tr>
								<tr class="odd">
										<td width="200"><strong><strong><?php echo Kohana::lang( 'config.heber' ); ?></strong></td>
										<td><?php echo php_uname(); ?></td>
								</tr>
								<tr class="even">
										<td width="200"><strong><?php echo Kohana::lang( 'config.browser' ); ?></strong></td>
										<td><?php echo $versionPHP <= '4.2.1' ? getenv( 'HTTP_USER_AGENT' ) : $_SERVER['HTTP_USER_AGENT']; ?></td>
								</tr>
								<tr class="odd">
										<td width="200"><strong>register_globals</strong></td>
										<td><?php echo ini_get( 'register_globals' ) ? '<b class="rouge">'.Kohana::lang( 'form.actif' ).'</b>' : '<b class="vert">'.Kohana::lang( 'form.no_actif' ).'</b>'; ?></td>
								</tr>
								<tr class="even">
										<td width="200"><strong>magic_quotes_gpc</strong></td>
										<td><?php echo ini_get( 'magic_quotes_gpc' ) ? '<b class="rouge">'.Kohana::lang( 'form.actif' ).'</b>' : '<b class="vert">'.Kohana::lang( 'form.no_actif' ).'</b>'; ?></td>
								</tr>
								<tr class="odd">
										<td width="200"><strong>safe_mode</strong></td>
										<td><?php echo ini_get( 'safe_mode' ) ? '<b class="rouge">'.Kohana::lang( 'form.actif' ).'</b>' : '<b class="vert">'.Kohana::lang( 'form.no_actif' ).'</b>'; ?></td>
								</tr>
								<tr class="even">
										<td width="200"><strong>file_uploads</strong></td>
										<td><?php echo ini_get( 'file_uploads' ) ? '<b class="vert">'.Kohana::lang( 'form.actif' ).'</b>' : '<b class="rouge">'.Kohana::lang( 'form.no_actif' ).'</b>'; ?></td>
								</tr>
								<tr class="odd">
										<td width="200"><strong>session.auto_start</strong></td>
										<td><?php echo ini_get( 'session.auto_start' ) ? '<b class="rouge">'.Kohana::lang( 'form.actif' ).'</b>' : '<b class="vert">'.Kohana::lang( 'form.no_actif' ).'</b>'; ?></td>
								</tr>
						</tbody>
				</table>
		</div>
		<div class="clear"></div>
</article>
<article class="module width_full relative">
		<header>
				<h3 class="tabs_involved"><?php echo Kohana::lang( 'config.list_config' ); ?></h3>
		</header>
				<table id="json_items" class="datatable" cellspacing="0">
						<tbody>
								<?php
								$n = 0;
								foreach( $config as $key => $row ):
										$class = $n % 2 == 0 ? 'odd' : 'even';
										?>
										<tr class="<?php echo $class; ?>">
												<td width="100"><strong><?php echo str_replace( '.php', '', $row ); ?></strong></td>
												<td><?php echo str_replace( 'admin/../', '', SYSPATH.'config/'.$row ); ?></td>
												<td><?php echo is_writable( SYSPATH.'config/'.$row ) ? html::anchor( 'config/update/'.str_replace( '.php', '', $row ), html::image( 'images/template/drawings.png', array( 'title' => Kohana::lang( 'form.edit' ), 'class' => 'icon_list' ) ) ) : FALSE; ?></td>
										</tr>
										<?php
										$n++;
								endforeach
								?>
						</tbody>
				</table>
		<div class="clear"></div>
</article>
<article class="module width_full relative">
		<header>
				<h3 class="tabs_involved"><?php echo Kohana::lang( 'config.chmod_dir' ); ?></h3>
		</header>
				<table id="json_items" class="datatable" cellspacing="0">
						<tbody>
								<?php
								$n = 0;
								foreach( $list as $key => $row ):
										$class = $n % 2 == 0 ? 'odd' : 'even';
										?>
										<tr class="<?php echo $class; ?>">
												<td width="200"><strong><?php echo Kohana::lang( 'config.'.$key ); ?></strong></td>
												<td><?php echo file::chmod( $row ); ?></td>
												<td>chmod 777 <?php echo str_replace( 'admin/../', '', $row ); ?></td>
										</tr>
										<?php
										$n++;
								endforeach
								?>
						</tbody>
				</table>
		<div class="clear"></div>
</article>