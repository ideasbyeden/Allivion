jQuery(function(){
	var form = jQuery('form.homesearch');
	var natheight = form.height();
	jQuery('#searchform_toggle').click(function(){
		var d = 0;
		if(jQuery(this).hasClass('open')){
			jQuery(this).removeClass('open').html('Use advanced search');
			form.animate({
				height: natheight
			},500);
			jQuery(jQuery('div.selector').get().reverse()).each(function() {
			    jQuery(this).delay(d).fadeOut(400);
			    d += 100;
			});
		} else {
			jQuery(this).addClass('open').html('Use basic search');			
			jQuery('div.selector').each(function() {
			    jQuery(this).delay(d).fadeIn(400);
			    d += 100;
			});
			form.animate({
				height: '167'
			},500);		}
	})
});