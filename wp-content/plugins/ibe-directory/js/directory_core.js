jQuery(function(){
	
	// clickable rows
	jQuery('body').on('click', '.clickable', function () {  
		window.document.location = jQuery(this).attr('data-href');
	});
	
	jQuery('.datepicker').datepicker({ dateFormat : 'd M yy' });
	
});


// Show / hide questions based on dependency

jQuery(function(){
	
	showHide();
	jQuery('input, select, textarea').change(function(){
		showHide();
	});
	
	function showHide(){
		jQuery('input, select, textarea').each(function(){


			if(typeof jQuery(this).attr('dependency') != 'undefined'){

				var deps = jQuery(this).attr('dependency').split(',');
				var show = false;
				
				jQuery.each(deps, function(index, dep){

					dep = dep.split(':');
					console.log(dep);
	
					var depQ = jQuery('[name="'+dep[0]+'"]');
					if(depQ.val() == dep[1] || jQuery(':checkbox[name="'+dep[0]+'[]"][value="'+dep[1]+'"]').is(':checked')){
						show = true;
						console.log('yeah show this question');					
					}
					
				});
				
				if(show){
					jQuery(this).closest('.question').show();					
				} else {
					jQuery(this).closest('.question').hide();					
				}

			}


		});
	}
});



/*
	
foreach field
 if has a dependency, check that dependency is met then validate
	
*/

function dirvalidates(form){
	var result = 'true';
	form.find('input, textarea, select, radio, file').each(function(){
		if(typeof jQuery(this).attr('req') != 'undefined'){
			if(jQuery(this).attr('req') != ''){




				

				if(typeof jQuery(this).attr('reqdep') != 'undefined'){
					var reqdep = jQuery(this).attr('reqdep');
			
					if(form.find('*[name="'+reqdep+'"]').val() == jQuery(this).attr('req')){
						
						

						
						if(jQuery(this).is(':checkbox')){
							var name = jQuery(this).attr('name');
							if(jQuery('input[name="'+name+'"]:checked').length > 0){
								jQuery(this).closest('fieldset').removeClass('invalid');					
							} else {
								console.log(name+' is empty');
								jQuery(this).closest('fieldset').addClass('invalid');	
								result = 'false';
							}
						} else if(jQuery(this).val() == ''){
							jQuery(this).addClass('invalid');
							result = 'false';
						} else {
							jQuery(this).removeClass('invalid');			
						}
						

					}
				}
/*
				else {
					
					if(jQuery(this).is(':checkbox')){
						var name = jQuery(this).attr('name');
						if(jQuery('input[name="'+name+'"]:checked').length > 0){
							jQuery(this).closest('fieldset').removeClass('invalid');					
						} else {
							console.log(name+' is empty');
							jQuery(this).closest('fieldset').addClass('invalid');	
							result = 'false';
						}
					} else if(jQuery(this).val() == ''){
						jQuery(this).addClass('invalid');
						result = 'false';
					} else {
						jQuery(this).removeClass('invalid');			
					}
					
					
					
				}
*/
				
				
			}
		}
	});
	return result;
}