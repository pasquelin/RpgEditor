<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' ) ?>

<div class="message">
		<table width="100%" border="0" cellpadding="4" cellspacing="2" class="table-list">
				<tr class="odd">
						<td width="200"><?php echo Kohana::lang( 'statistique.nb_user' ); ?></td>
						<td><strong><?php echo number_format( $global->nb_user ); ?></strong></td>
				</tr>
				<tr class="odd">
						<td width="200"><?php echo Kohana::lang( 'statistique.nb_region' ); ?></td>
						<td><strong><?php echo number_format( $global->nb_region ); ?></strong></td>
				</tr>
				<tr class="odd">
						<td width="200"><?php echo Kohana::lang( 'statistique.nb_article' ); ?></td>
						<td><strong><?php echo number_format( $global->nb_article ); ?></strong></td>
				</tr>
				<tr class="even">
						<td width="200"><?php echo Kohana::lang( 'statistique.nb_quete' ); ?></td>
						<td><strong><?php echo number_format( $global->nb_quete ); ?></strong></td>
				</tr>
		</table>
</div>
<div style="text-align:right;"><a href="<?php echo url::base( TRUE ); ?>statistiques"><?php echo Kohana::lang( 'statistique.show' ); ?></a></div>
