jQuery(function(){
	
	var autosave = 'false';
	
	jQuery('form.directory.update').submit(function(e){
		e.preventDefault();
		submitForm(jQuery(this),autosave);
	});

	jQuery('form.directory.update input, form.directory.update textarea, form.directory.update select').change(function(){
		console.log('changes made');
		var form = jQuery(this).closest('form');
		autosave = form.attr('autosave');
		if (typeof autosave !== 'undefined' && autosave == 'true') {
			console.log('autosaving');
			submitForm(form,autosave);
		}
	});	
		

	function submitForm(form,autosave){
				
		var data = new FormData(form[0]);

		
		// Is this required? Seems to work without...

		/*
		jQuery.each(jQuery('input[type="file"]')[0].files, function(i,file){
			data.append(jQuery(this).attr('name'),file);
		});
		*/

				
		jQuery.ajax({
			type: 'POST',
			url:  directory_update.ajaxurl,
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			dataType: 'json',
					
			success: function(result){
				if(autosave == 'true'){
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