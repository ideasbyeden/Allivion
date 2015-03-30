jQuery(function(){
	

	jQuery('form.directory.update').submit(function(e){
		e.preventDefault();
		submitForm(jQuery(this));
	});

	if(jQuery('form.directory.create').attr('autosave') == 'true'){
		autosave = true;
		jQuery('form.directory.create input, form.directory.create textarea, form.directory.create select').change(function(){
			var form = jQuery(this).closest('form');
			submitForm(form);
		});	
	}
		
	function submitForm(form){
		
		var data = form.serialize();
		
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