$(function() {
	
		$('.panel-bloc-menu').click(function(){
				redirect( $('a',this).attr('href') );
		});
	
});