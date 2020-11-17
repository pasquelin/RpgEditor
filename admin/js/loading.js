var is_visible = false,
sizeMain = false,
load_submit = false;
		
$(function() {
			
		$('.btn_validation').click( function() {
				envois_form('valid');
		});
	
		$('.btn_sauvegarde').click( function() {
				envois_form('sauve');
		});
	
		$('.btn_annuler').click( function() {
				envois_form('annul');
		});
	
		$('.btn_trash').click( function() {
				if( confirm(confirm_delete) ) envois_form('trash');
		});
 
		$('.p-lower').click(function(){
				minuscule ( this )
		});
	
		$('#logo').click( function() {
				redirect( url_script )
		});

		if($('#msg').length) {
				$('#msg').delay(3000).fadeOut(2000);
		}
		
		$('#hideShowMenu').click(function() {
				
				if( $('#sidebar').is(':visible') ) {
						$('#sidebar').hide();
				}
				else {
						$('#sidebar').show();
				}
				
				if($('#td_map').length)
						$('.map').width(500).width($('#td_map').width());
		});
});

function envois_form( type )
{
		if(load_submit)
				return;
		
		var url_Action = $('#main form').attr('action'); 
		var id = $('#id').val(); 
		
		if( url_Action.length )
		{
				if( type != 'annul' )
				{
						if( !$('#form').valid() )
								return;
		
						load_submit = true;

						$('#main form').attr({
								'action' : url_script+url_Action+'/'+type+'/'+id, 
								'onsubmit' : ''
						}).submit(); 
				}
				else window.location.replace(url_script+url_Action+'/annul');		
		}
		else
				alert(error_controler+' $action');
}

function redirect( url )
{
		$(location).attr('href',url);
}

function minuscule ( obj ) 
{
		var m_zone = $(obj).parents('p:first');
		var m_input = $(':input',m_zone);
		var m_val = m_input.val();
		m_input.val(m_val.toLowerCase());
}
		
function definitPosition ( name, menuYloc, height )
{
		var my_body = $(document).scrollTop(),
		nameContener = '#colRight',
		bottomContener = parseInt($(nameContener).height()) + parseInt($(nameContener).position().top);
					
		if( menuYloc < my_body )
		{
				if( ( my_body + height ) < bottomContener)
						$(name).css('top',(my_body - menuYloc)+'px');
				else
						$(name).css('top',(parseInt($(nameContener).height()) - height)+'px');
		}
		else
				$(name).css('top',0);
}

function position ( obj, position )
{
		return parseInt($(obj).css(position).replace('px',''));
}

function start_loading()
{
		$('body').prepend('<div id="laoding_page"></div>');
}

function stop_loading()
{
		$('#laoding_page').remove();
}

function encode( data )
{
		return encodeURIComponent(data);
}