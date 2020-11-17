$(function() {
		if( $('#form').length)
		{	
				$('#form').validate({
						rules: {
								name: {
										required: true,
										minlength: 2,
										maxlength: 50
								},
								comment: {
										required: true,
										minlength: 10,
										maxlength: 200
								},
								bot_hp_min: {
										required: true,
										number: true,
										min: 0,
										max: 999999999
								},
								bot_hp_max: {
										required: true,
										number: true,
										min: 0,
										max: 999999999
								},
								bot_mp_min: {
										required: true,
										number: true,
										min: 0,
										max: 999999999
								},
								bot_mp_max: {
										required: true,
										number: true,
										min: 0,
										max: 999999999
								},
								bot_argent_min: {
										required: true,
										number: true,
										min: 100,
										max: 999999999
								},
								bot_argent_max: {
										required: true,
										number: true,
										min: 100,
										max: 999999999
								},
								bot_attaque_min: {
										required: true,
										number: true,
										min: 0,
										max: 1000
								},
								bot_attaque_max: {
										required: true,
										number: true,
										min: 0,
										max: 1000
								},
								bot_defense_min: {
										required: true,
										number: true,
										min: 0,
										max: 1000
								},
								bot_defense_max: {
										required: true,
										number: true,
										min: 0,
										max: 1000
								}
						},
						messages: {
								name: {
										required: name_required,
										minlength: name_minlength,
										maxlength: name_maxlength
								},
								comment: {
										required: comment_required,
										minlength: comment_minlength,
										maxlength: comment_maxlength
								},
								bot_hp_min: {
										required: x_required,
										number: x_numeric,
										min: x_min+0,
										max: x_max+999999999
								},
								bot_hp_max: {
										required: x_required,
										number: x_numeric,
										min: x_min+0,
										max: x_max+999999999
								},
								bot_mp_min: {
										required: x_required,
										number: x_numeric,
										min: x_min+0,
										max: x_max+999999999
								},
								bot_mp_max: {
										required: x_required,
										number: x_numeric,
										min: x_min+0,
										max: x_max+999999999
								},
								bot_argent_min: {
										required: x_required,
										number: x_numeric,
										min: x_min+100,
										max: x_max+999999999
								},
								bot_argent_max: {
										required: x_required,
										number: x_numeric,
										min: x_min+100,
										max: x_max+999999999
								},
								bot_attaque_min: {
										required: x_required,
										number: x_numeric,
										min: x_min+0,
										max: x_max+1000
								},
								bot_attaque_max: {
										required: x_required,
										number: x_numeric,
										min: x_min+0,
										max: x_max+1000
								},
								bot_defense_min: {
										required: x_required,
										number: x_numeric,
										min: x_min+0,
										max: x_max+1000
								},
								bot_defense_max: {
										required: x_required,
										number: x_numeric,
										min: x_min+0,
										max: x_max+1000
								}
						}
				});
		}
	
		if( $('#changeMap').length)
		{	
				$('#changeMap').change(function() {
						var value = $(this).val();
			
						if(value > 0)
								redirect( url_script+'regions/child/'+value );
						else
								redirect( url_script+'regions' );
				});
		}
		
		$('.background').live('click', function() {
				$('#imageBg').attr('src', dir_script+'../images/background/'+this.id);
				$('#background').val('images/background/'+this.id);
		});
	
		$('.terrain').live('click', function() {
				$('#imageFight').attr('src', dir_script+'../images/terrain/'+this.id);
				$('#fight_terrain').val(this.id);
		});
	
		$('#imageBg, #list_vignette_background').click(function() {
				$.facebox({
						ajax: url_script+'regions/vignette_bg/'+$('#imageBg').val()
				});
		});

		$('#imageFight, #list_vignette_fight').click(function() {
				$.facebox({
						ajax: url_script+'regions/vignette_fight/'+$('#imageFight').val()
				});
		});
		
		if($('#show_plan').length)
		{
				$('#show_plan').facebox({
						closeImage   : 'images/fancybox/fancy_closebox.png'
				});
		}
	
});
