jQuery(function(){
	
	var autosave;

	jQuery('form.directory.create').submit(function(e){
		e.preventDefault();
		submitForm(jQuery(this));
	});
	
	function submitForm(form){
		
		var data = form.serialize();
		
		jQuery.ajax({
			type: 'POST',
			url:  directory_create.ajaxurl,
			data: data,
			dataType: 'json',
					
			success: function(result){
				if(result.redirect){
					window.document.location(result.redirect);
				}
				if(result.message){
					form.find('.message').html(result.message);
				}
				form.trigger("reset");
			}
		});
	}


});