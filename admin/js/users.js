$(function(){
	
		$('#form').validate({
				rules: {
						username: {
								required: true,
								minlength: 2,
								maxlength: 50
						},
						password: {
								minlength: 2,
								maxlength: 50
						},
						email: {
								required: true,
								email: true
						},
						argent: {
								required: true,
								number: true,
								max: 999999999
						},
						xp: {
								required: true,
								number: true,
								max: 999999999
						},
						hp: {
								required: true,
								number: true,
								max: 999999999
						},
						hp_max: {
								required: true,
								number: true,
								max: 999999999
						},
						mp: {
								required: true,
								number: true,
								max: 999999999
						},
						mp_max: {
								required: true,
								number: true,
								max: 999999999
						}
				},
				messages: {
						username: {
								required: username_required,
								minlength: username_minlength,
								maxlength: username_maxlength
						},
						password: {
								minlength: password_minlength,
								maxlength: password_maxlength
						},
						email: {
								required: email_required,
								email: email_format
						},
						argent: {
								required: argent_required,
								max: argent_max,
								number: argent_number
						},
						xp: {
								required: xp_required,
								max: xp_max,
								number: xp_number
						},
						hp: {
								required: hp_required,
								max: hp_max,
								number: hp_number
						},
						hp_max: {
								required: hp_required,
								max: hp_max,
								number: hp_number
						},
						mp: {
								required: mp_required,
								max: mp_max,
								number: mp_number
						},
						mp_max: {
								required: mp_required,
								max: mp_max,
								number: mp_number
						}
				}
		});
	

		$('#user_list_items').click(function() {
				$.facebox({
						ajax: url_script+'users/show_items/'+$('#idUser').html()
				});
		});

		$('#user_list_sorts').click(function() {
				$.facebox({
						ajax: url_script+'users/show_sorts/'+$('#idUser').html()
				});
		});

		$('#user_list_quetes').click(function() {
				$.facebox({
						ajax: url_script+'users/show_quetes/'+$('#idUser').html()
				});
		});
	
		$('#enregistrer_item').live('click', function() {
				$.post(url_script+'users/save_items/'+$('#idUser').html(), $('form').serialize());
		});
	
		$('#enregistrer_sort').live('click', function() {
				$.post(url_script+'users/save_sorts/'+$('#idUser').html(), $('form').serialize());
		});
	
		$('#list_vignette_avatar').click(function() {
				$.facebox({
						ajax: url_script+'users/listing_avatar'
				});
		});
	
		$('.avatar_modif').live('click', function() {
				$('#avatar').val(this.id);
				$('#vignetteAvatar').css({
						'background-image' : 'url("'+dir_script+'../images/character/'+this.id+'")'
				});
		});
	
});
