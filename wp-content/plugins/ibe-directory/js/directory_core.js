jQuery(function(){
	
	jQuery('body').on('click', '.clickable', function () {  
		window.document.location = jQuery(this).data('href');
		//alert($(this).attr('datahref'));
		//alert(jQuery(this).attr('class'));
	});
	
});