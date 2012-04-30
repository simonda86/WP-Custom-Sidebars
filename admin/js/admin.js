jQuery(document).ready(function($){
	
	$('.csb_delete').live('click', function(){
		$(this).parents('tr').remove();
		
		// If no items add the no items label
		if($('#the-list tr').size() == 0)
		{
			$('#the-list').append('<tr class="no-items"><td class="colspanchange" colspan="2">No items found.</td></tr>');
		}
	});
	
	$('#csb_create_btn').bind('click', function(){
		var name = $('#csb_create_sidebar').val();
		$('#the-list').append('<tr><td class="csb_name">' + name + '</td><td><a href="#" class="csb_delete">Delete</a><input type="hidden" name="csb_sidebars[]" value="' + name + '" /></td></tr>');
		
		// Clear text box
		$('#csb_create_sidebar').val('');
		
		// Remove no items label
		$('tr.no-items').remove();
	});
	
});