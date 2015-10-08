jQuery(function(){
	
	var autosave;
	
	jQuery('form.directory.update').submit(function(e){
		e.preventDefault();
		submitForm(jQuery(this));
	});

	jQuery('form.directory.update input, form.directory.update textarea, form.directory.update select').change(function(){
		var form = jQuery(this).closest('form');
		autosave = form.attr('autosave');
		if (typeof autosave !== 'undefined' && autosave == 'true') {
			autosave = true;
			submitForm(form,autosave);
		}
	});	
	
		
	function submitForm(form,autosave = false){
		
		var data = form.serialize();
		//console.log(data);
		
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