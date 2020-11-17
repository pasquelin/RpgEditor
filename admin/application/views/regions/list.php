<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' ); ?>
<article class="module width_full relative">
		<header>
				<h3 class="tabs_involved"><?php echo Kohana::lang( 'menu.map' ); ?></h3>
		</header>
		<table id="json_regions" class="datatable" cellspacing="0">
				<thead>
						<tr>
								<th width="50"><?php echo Kohana::lang( 'form.id' ); ?></th>
								<th><?php echo Kohana::lang( 'region.name' ); ?></th>
								<th width="50">X</th>
								<th width="50">Y</th>
								<th width="50">Z</th>
								<th width="150"></th>
						</tr>
				</thead>
				<tbody>
						<tr>
								<td colspan="7" class="dataTables_empty"><?php echo Kohana::lang( 'form.loading' ); ?></td>
						</tr>
				</tbody>
		</table>
		<div class="other_filter">
				<select name="changeMap" id="changeMap" class="input-select" >
						<option value="" ><?php echo Kohana::lang( 'region.prim_map' ); ?></option>
						<?php if( $listing ) : ?>
								<?php foreach( $listing as $val ) : ?>
										<option value="<?php echo $val->id; ?>" <?php echo ( $val->id == $idRegion ) ? 'selected="selected"' : ''; ?> style="padding-left:<?php echo $val->level * 12; ?>px;"><?php echo $val->name; ?></option>
								<?php endforeach ?>
						<?php endif ?>
				</select>
		</div>
		<div class="clear"></div>
</article>