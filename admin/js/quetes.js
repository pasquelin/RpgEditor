$(function() {
		$('#edit_article_help').click(function() {
				redirect( url_script+'articles/show/'+$('#article_id_help').val() )
		});

		$('#edit_article_start').click(function() {
				redirect( url_script+'articles/show/'+$('#article_id_start').val() )
		});

		$('#edit_article_stop').click(function() {
				redirect( url_script+'articles/show/'+$('#article_id_stop').val() )
		});
			
		$('#supprimer').live('click', function() {
				deleteCase();
		});
	
		$('#enregistrer').live('click', function() {
				enregistrerCase();
		});
	
		$('#type').change(function() {
				affiche_option_objet( this )
		});
	
});

function action_form ()
{
		var form = $('#module').val();
	
		if(form)
				$('#formAction').load(url_script+'actions/form/'+form+'/'+$('#coordonne').val());
		else
				$('#formAction').html('');
}

function affiche_option_objet( obj )
{
		$('#option_objet, #option_bot').hide();
		
		if( $(obj).val() == 0 )
				$('#option_objet').show();
		else if( $(obj).val() == 2 )
				$('#option_bot').show();
				
}