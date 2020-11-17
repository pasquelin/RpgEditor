<?php defined( 'SYSPATH' ) or die( 'Access non autoris&eacute;.' ); ?>
<?php if( isset( $no_html ) ): ?>
		<script type="text/javascript" src="<?php echo url::base(); ?>/js/lib/jquery.js"></script>
		<style type="text/css">
				<!--
				body, html {
						background-color:#FFF;
						font-family:Arial, Helvetica, sans-serif;
				}
				-->
		</style>
<?php endif ?>
<script  type="text/javascript">
		function dirup()
		{
				var urlquery=frames['imgManager'].location.search.substring(1),
				curdir= urlquery.substring(urlquery.indexOf('dir=')+4),
				listdir=curdir.substring(0,curdir.lastIndexOf('/')),
				allPaths = window.document.getElementById('list_dossier').options;
	
				for(i=0; i<allPaths.length; i++) 
				{
						allPaths.item(i).selected = false;
		
						if( (allPaths.item(i).value) == listdir)
								allPaths.item(i).selected = true;
				}
	
				frames['imgManager'].location.href='<?php echo url::base( TRUE ); ?>/ftp/detail?dir=' + listdir;
		}

		function goUpDir() 
		{
				frames['imgManager'].location.href='<?php echo url::base( TRUE ); ?>/ftp/detail?dir=' + $('#list_dossier').val();
		}
</script>

<article class="module width_full relative">
		<header>
				<h3 class="tabs_involved"><?php echo Kohana::lang( 'menu.ftp' ); ?></h3>
		</header>
		<form action="<?php echo url::base( TRUE ); ?>ftp/envois" name="adminForm" method="post" enctype="multipart/form-data"  class="form">
				<table border="0" align="right" cellpadding="0" cellspacing="4">
						<tr>
								<td><a href="javascript:dirup()"> <img src="<?php echo url::base(); ?>/images/ftp/btnFolderUp.gif" width="15" height="15" border="0" alt="<?php echo Kohana::lang( 'ftp.parent_dir' ); ?>" /> </a> <?php echo Kohana::lang( 'ftp.dir' ); ?></td>
								<td><select onchange="goUpDir()" id="list_dossier" name="list_dossier" class="inputbox" style="width:100%" >
												<option value="/">/</option>
												<?php
												if( $folders )
												{
														foreach( $folders as $file )
														{
																$file = str_replace( DOCROOT.'../', '', $file );
																$select = $listdir == $file ? 'selected="selected"' : '';
																echo '<option value="'.$file.'" '.$select.'>/'.$file.'</option>';
														}
												}
												?>
										</select></td>
						</tr>
						<tr>
								<td><?php echo Kohana::lang( 'ftp.file_upload' ); ?> <small><?php echo Kohana::lang( 'ftp.max_upload', ini_get( 'post_max_size' ) ); ?></small></td>
								<td align="right"><input class="inputbox" type="file" name="upload" id="upload" size="30" />
										<input type="submit" class="button button-normal" value="<?php echo Kohana::lang( 'ftp.upload' ); ?>" /></td>
						</tr>
				</table>
		</form>
		<iframe height="450" src="<?php echo url::base( TRUE ); ?>/ftp/detail?dir=<?php echo $listdir ?>" name="imgManager" id="imgManager" class="imgManager" marginwidth="0" marginheight="0" scrolling="auto" frameborder="0" ></iframe>
		<form action="/ftp/envois" name="adminForm" method="post" enctype="multipart/form-data" >
				<table border="0" align="right" cellpadding="0" cellspacing="4" class="form">
						<tr>
								<td align="right" style="padding-right:10px;white-space:nowrap"><?php echo Kohana::lang( 'ftp.crea_dir' ); ?></td>
								<td align="right"><input class="inputbox" type="text" name="foldername" style="width:334px" />
										<input type="submit" class="button button-normal" value="<?php echo Kohana::lang( 'form.crea' ); ?>" /></td>
						</tr>
						<tr>
								<td align="right" style="padding-right:10px;;white-space:nowrap"><?php echo Kohana::lang( 'ftp.url_img' ); ?></td>
								<td align="right"><input class="inputbox" type="text" name="imagecode" id="imagecode" style="width:400px" /></td>
						</tr>
				</table>
		</form>
		<div class="clear"></div>
</article>