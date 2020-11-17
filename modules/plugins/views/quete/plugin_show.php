<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' ); ?>

<h1><?php echo $data->title; ?></h1>
<?php if( $data->article ) : ?>
				<?php echo $data->article; ?>
<?php endif ?>
		
<div class="formButton">
		<input type="hidden" id="id_quete" value="<?php echo $data->id_quete; ?>"/>
		<?php if( $data->valid == 0 ) : ?>
				<input type="button" id="accepter" class="button vert" value="<?php echo Kohana::lang( 'quete.button_accept' ); ?>"/>
		<?php endif ?>
</div>

<?php if( $data->audio ) : ?>
<script>
    app.sound.effect('<?php echo $data->audio; ?>', 1);
</script>
<?php endif ?>