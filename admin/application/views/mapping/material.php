<?php defined( 'SYSPATH' ) or die( 'No direct access allowed.' ); ?>

<div class="titreForm">
		<div style="float:right; margin-top:3px;"><a href="<?php echo url::base( TRUE ); ?>ftp?dir=/images/background"><?php echo html::image('images/template/icn_folder.png'); ?></a></div>
		<div class="titreCentent"><?php echo Kohana::lang( 'user.modif_avatar' ); ?></div>
</div>
<form id="formInscript" method="post" action="admin/mapping/background" >
		<div class="contentForm">
				<?php foreach( $material as $row ) : ?>
						<div class="material close" id="<?php echo $row; ?>" style="background-image:url('<?php echo url::base(); ?>../images/background/<?php echo $row; ?>');"></div>
				<?php endforeach ?>
				<div class="spacer"></div>
		</div>
		<div class="footerForm" id="footerForm">
				<input type="button" class="button close" value="<?php echo Kohana::lang( 'form.close' ); ?>"/>
		</div>
</form>
