<?php defined( 'SYSPATH' ) or die( 'Access non autoris&eacute;.' ); ?>
<link rel="stylesheet" type="text/css" href="<?php echo url::base( TRUE ).'css_'.base64_encode( 'zoombox--ftpFichiers' ).'.css'; ?>" />
<script type="text/javascript" src="<?php echo url::base(); ?>js/lib/jquery.js"></script>
<script type="text/javascript" src="<?php echo url::base(); ?>js/zoombox.js"></script>
<script>
	function updateDir( futur_dir )
	{
		var allPaths = parent.document.getElementById('list_dossier').options;
	
		for(i=0; i<allPaths.length; i++) 
		{
			allPaths.item(i).selected = false;
		
			if( (allPaths.item(i).value) == futur_dir)
				allPaths.item(i).selected = true;
		}
	}
	function dirup()
	{
		var urlquery=frames['imgManager'].location.search.substring(1);
		var listdir= urlquery.substring(urlquery.indexOf('listdir=')+4);
		frames['imgManager'].location.href='<?php echo url::base( TRUE ); ?>/ftp/detail?dir=' + listdir;
	}
</script>
<?php if( $folders ) : ?>
	 <?php foreach( $folders as $val ) : ?>
		 <div style="float:left; padding: 5px">
		 	<div class="imgTotal" >
		 		<div align="center" class="imgBorder"> <a href="<?php echo url::base( TRUE ); ?>/ftp/detail?dir=<?php echo $dossier ? $dossier.'/'.$val : $val; ?>" target="imgManager" onclick="javascript:updateDir('<?php echo $dossier ? $dossier.'/'.$val : $val; ?>');"> <img src="<?php echo url::base(); ?>/images/ftp/folder.gif" width="80" height="80" border="0" /></a> </div>
		 	</div>
		 	<div class="imginfoBorder"> <small><?php echo $val; ?></small><br /><a href="<?php echo url::base( TRUE ); ?>/ftp/delete/folder?dir=<?php echo $dossier ? $dossier.'/'.$val : $val; ?>" target="_top"><?php echo Kohana::lang( 'ftp.delete' ); ?></a></div>
		 </div>
	 <?php endforeach ?>
	 <div style="clear:both"></div>
 <?php endif ?>
<?php if( $docs ) : ?>
	 <?php foreach( $docs as $val ) : ?>
		 <?php $titre = explode( '/', $val['file'] ); ?>
		 <div style="float:left; padding: 5px">
		 	<div class="imgTotal">
		 		<div align="center" class="imgBorder"> <a href="#" onclick="parent.document.getElementById('imagecode').value = '<?php echo $val['file']; ?>'; window.location.href='<?php echo $val['file']; ?>';" style="display: block; width: 100%; height: 100%">
		 			<div class="image"> <img src="<?php echo url::base(); ?>/images/ftp/home_article.png" height="70" border="0" /> </div>
		 			</a> </div>
		 	</div>
		 	<div class="imginfoBorder"> <small><strong><?php echo end( $titre ); ?></strong></small><br /><a href="<?php echo url::base( TRUE ); ?>/ftp/delete/file?dir=<?php echo $dossier.'/'.end( $titre ); ?>" target="_top"><?php echo Kohana::lang( 'ftp.delete' ); ?></a></div>
		 </div>
	 <?php endforeach ?>
	 <div style="clear:both"></div>
 <?php endif ?>
<?php if( $images ) : ?>
	 <?php foreach( $images as $val ) : ?>
		 <?php $titre = explode( '/', $val['file'] ); ?>
		 <div style="float:left; padding: 5px">
		 	<div class="imgTotal">
		 		<div align="center" class="imgBorder"> <a href="<?php echo $val['file']; ?>" onclick="parent.document.getElementById('imagecode').value = '<?php echo $val['file']; ?>';" style="display: block; width: 100%; height: 100%" rel="zoombox">
		 			<div class="image"> <img src="<?php echo $val['file']; ?>?t=<?php echo time(); ?>" border="0" /> </div>
		 			</a> </div>
		 	</div>
		 	<div class="imginfoBorder"> <small><strong><?php echo end( $titre ); ?></strong><br /> <?php echo $val['img_info'][0]; ?> X <?php echo $val['img_info'][1]; ?></small><br /><a href="<?php echo url::base( TRUE ); ?>/ftp/delete/file?dir=<?php echo $dossier.'/'.end( $titre ); ?>" target="_top"><?php echo Kohana::lang( 'ftp.delete' ); ?></a></div>
		 </div>
	 <?php endforeach ?>
	 <div style="clear:both"></div>
	 <div align="center"><?php echo $pagination->render(); ?></div>
	 <?php
 
 endif ?>
