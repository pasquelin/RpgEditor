<?php
defined( 'SYSPATH' ) OR die( 'No direct access allowed.' );
?>

<form id="myFormOption" onsubmit="return false;">
		<div class="titreForm">
				<div class="titreCentent"><?php echo Kohana::lang( 'editeur.form_title' ); ?></div>
				<div class="spacer"></div>
		</div>
		<div class="contentForm">
				<div class="row_form">
						<label><span class="titreSpanForm"><?php echo Kohana::lang( 'editeur.form_name' ); ?></span>
								<input type="text" class="input-text" id="title" name="title" value="<?php echo isset( $row->title ) ? $row->title : false; ?>" size="40" maxlength="100" />
						</label>
						<div class="spacer"></div>
				</div>
				<div class="row_form">
						<label><span class="titreSpanForm"><?php echo Kohana::lang( 'editeur.form_label_bot' ); ?></span>
								<select class="input-select" id="bot" name="bot">
									<option value="0"><?php echo Kohana::lang( 'editeur.form_no_bot' ); ?></option>
                                    <option <?php if( isset( $row->bot ) && $row->bot == 1 ) echo 'selected="selected"'; ?> value="1"><?php echo Kohana::lang( 'editeur.form_yes_bot' ); ?></option>
                                    <option <?php if( isset( $row->bot ) && $row->bot == 2 ) echo 'selected="selected"'; ?> value="2"><?php echo Kohana::lang( 'editeur.form_yes_bears' ); ?></option>
                                    <option <?php if( isset( $row->bot ) && $row->bot == 3 ) echo 'selected="selected"'; ?> value="3"><?php echo Kohana::lang( 'editeur.form_yes_dog' ); ?></option>
								</select>
						</label>
						<div class="spacer"></div>
				</div>
				<div class="row_form">
						<label><span class="titreSpanForm"><?php echo Kohana::lang( 'editeur.form_label_action' ); ?></span>
								<select class="input-select" id="module" name="module">
										<option value=""><?php echo Kohana::lang( 'editeur.form_no_action' ); ?></option>
										<?php if( $actions ) : ?>
												<?php foreach( $actions as $val ) : ?>
														<?php $val = str_replace( '.php', '', $val ); ?>
														<option value="<?php echo $val; ?>" <?php echo ( isset( $row->module ) && $val == $row->module ) ? 'selected="selected"' : ''; ?>><?php echo Kohana::lang( 'plg_'.$val.'.title' ); ?></option>
												<?php endforeach ?>
										<?php endif ?>
								</select>
						</label>
						<div class="spacer"></div>
				</div>
				<div id="formAction"></div>
		</div>
		<div class="footerForm">
				<input type="button" id="enregistrer" class="button button_vert close" value="<?php echo!$row ? Kohana::lang( 'form.crea' ) : Kohana::lang( 'form.modif' ); ?>"/>
				<input type="button" class="button close" value="<?php echo Kohana::lang( 'form.annul' ); ?>"/>
		</div>
		<input type="hidden" id="x" name="x" value="<?php echo $x; ?>"/>
		<input type="hidden" id="y" name="y" value="<?php echo $y; ?>"/>
		<input type="hidden" id="z" name="z" value="<?php echo $z; ?>"/>
		<input type="hidden" id="region_id" name="region_id" value="<?php echo $region_id; ?>"/>

		<?php if( isset( $id ) && $id ) : ?>
				<input type="hidden" id="id" name="id" value="<?php echo $id; ?>"/>
		<?php endif ?>
</form>
<script>
		$('#module').one('change', function() {
				action_form();
		});
		
		$('#enregistrer').one('click', function() {
				if(typeof(editor)!='undefined' && $('#fonction').length )	
						$('#fonction').val(editor.getCode());	
				else if(typeof(editor)!='undefined' && $('#html').length )	
						$('#html').val(editor.getCode());	

				$.post(url_script+'mapping/<?php echo $type; ?>_module', $('#myFormOption').serialize() );
		});
	
		$('#supprimer').one('click', function() {
				$.post(url_script+'mapping/remove_module', $('#myFormOption').serialize() );
		});
		

		function action_form ()
		{
				var form = $('#module').val();
	
				if(form)
						$('#formAction').load(url_script+'actions/form/'+form+'/'+$('#region_id').val()+'/'+$('#x').val()+'/'+$('#y').val()+'/'+$('#z').val());
				else
						$('#formAction').html('');
		}
		
		action_form();
</script>