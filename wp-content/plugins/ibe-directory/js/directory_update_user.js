jQuery(function(){
	
	jQuery('form.directory.updateuser').submit(function(e){
		e.preventDefault();
		console.log('updating user');
		submitForm(jQuery(this));
	});

	jQuery('form.directory.updateuser input, form.directory.updateuser textarea, form.directory.updateuser select').change(function(){
		var form = jQuery(this).closest('form');
		if(form.attr('autosave') == 'true'){
			submitForm(form);
		}
	});	
	
		
	function submitForm(form){
		
		//tinyMCE.triggerSave();
		var data = form.serialize();
		console.log(data);
		
		jQuery.ajax({
			type: 'POST',
			url:  directory_update.ajaxurl,
			data: data,
			dataType: 'json',
					
			success: function(result){
				if(autosave){
					jQuery.each(result, function(k,v){
						jQuery('.preview').find('span#'+k).html(v);				
					});
				}
				if(result.redirect){
					window.document.location(result.redirect);
				}
				if(result.message){
					form.find('.message').html(result.message);
				}
			}
		});
	}


});