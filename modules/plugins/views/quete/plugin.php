<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' );  ?>
<div class="contenerActionStat">
		<h1><?php echo $list_quete->title; ?></h1>
</div>
<div class="center">
		<?php
		$url = 'actions/quete/show/'.$list_quete->id_quete;

		switch( $list_quete->valid )
		{
				case 0 :
						$value = Kohana::lang( 'quete.look_show' );
						break;
				case 1 :
						$value = Kohana::lang( 'quete.actif_quete' );
						break;
				case 2 :
						$url = 'actions/quete/valid/'.$list_quete->id_quete;
						$value = Kohana::lang( 'quete.valide_quete' );
						break;
				case 3 :
						$value = Kohana::lang( 'quete.stop_quete' );
						break;
		}
		?>
		<input type="button" class="button orange" data-url="<?php echo $url; ?>" value="<?php echo $value; ?>"/>
</div>
<div class="spacer"></div>