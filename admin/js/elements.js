$(function() {
	
		$('.vign_mod').live('click', function() {
				$('#imageModule').attr('src', dir_script+'../images/modules/'+this.id);
				$('#image').val(this.id);
		});
	
		$('#list_vignette, #imageModule').click(function() {
				$.facebox({
						ajax: url_script+'elements/vignette/'+$('#image').val()
				});
		});

});