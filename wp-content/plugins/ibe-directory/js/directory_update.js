jQuery(function(){
	

	jQuery('form.directory.update').submit(function(e){
		e.preventDefault();
		saveForm(jQuery(this));
	});
	
	jQuery('form.directory.update input, form.directory.update textarea, form.directory.update select').change(function(){
		var form = jQuery(this).closest('form');
		saveForm(form);
	});	
	
	function saveForm(form){
		
		var data = form.serialize();
		
		jQuery.ajax({
			type: 'POST',
			url:  directory_update.ajaxurl,
			data: data,
			dataType: 'json',
					
			success: function(result){
				jQuery.each(result, function(k,v){
					jQuery('.preview').find('span#'+k).html(v);				
				});
			}
		});
	}


});