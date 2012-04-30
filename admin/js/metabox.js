jQuery(document).ready(function($){
	$('#csb-existing').bind('click', function(e){
		e.preventDefault();

		$('#custom_sidebar .wp-tab-active').removeClass('wp-tab-active');
		$(this).parent('li').addClass('wp-tab-active');

		$('#custom_sidebar .tabs-panel').hide();
		$('#csb-existing-panel').show();
	});
	$('#csb-create').bind('click', function(e){
		e.preventDefault();

		$('#custom_sidebar .wp-tab-active').removeClass('wp-tab-active');
		$(this).parent('li').addClass('wp-tab-active');

		$('#custom_sidebar .tabs-panel').hide();
		$('#csb-create-panel').show();
	});
	$('#csb-create-panel button').bind('click', function(){
		if($('#csb-create-panel :text').val() == '') return false;
		var data = {
			action: 'csb_create',
			sidebar_name: $('#csb-create-panel :text').val()
		}
		jQuery.post(ajaxurl,data, function(response){
			$('#csb-create-panel :text').val('');
			$('#csb-create-panel').prepend('<p">' + response + '</p>');
		});
	});
});