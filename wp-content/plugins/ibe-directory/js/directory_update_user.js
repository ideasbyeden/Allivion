jQuery(function(){
	
	jQuery('form.directory.updateuser').submit(function(e){
		tinyMCE.triggerSave();
		e.preventDefault();
		console.log('updating user');
		submitForm(jQuery(this));
	});

	jQuery('form.directory.updateuser input, form.directory.updateuser textarea, form.directory.updateuser select').change(function(){
		tinyMCE.triggerSave();
		var form = jQuery(this).closest('form');
		if(form.attr('autosave') == 'true'){
			submitForm(form);
		}
	});	
	
		
	function submitForm(form){
		
		//tinyMCE.triggerSave();
		//var data = form.serialize();
		
		var data = new FormData(form[0]);

		
		jQuery.ajax({
			type: 'POST',
			url:  directory_update_user.ajaxurl,
			data: data,
			cache: false,
			contentType: false,
			processData: false,
					
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