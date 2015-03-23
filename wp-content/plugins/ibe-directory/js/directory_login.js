jQuery(function(){
	
	// show popup login form
	jQuery('a#show_login').on('click', function(e){
        jQuery('body').prepend('<div class="login_overlay"></div>');
        jQuery('form#login').fadeIn(500);
        jQuery('div.login_overlay, form#login a.close').on('click', function(){
            jQuery('div.login_overlay').fadeOut();
            jQuery('form#login').hide();
        });
        e.preventDefault();
    });
    
    jQuery('form#login').submit(function(e){
	    e.preventDefault();
	    
	    var data = jQuery(this).serialize();
	    
	    jQuery.ajax({
			type: 'POST',
			url:  directory_login.ajaxurl,
			data: data,
			dataType: 'json',
			async: true,
					
			success: function(result){

				if(result.roles[0] == 'recruiter' || result.roles[0] == 'recruiter_admin') { window.document.location = '/recruiter-dashboard'; }
				else if(result.roles[0] == 'advertiser' ) { window.document.location = '/advertiser-dashboard'; }
				else if(result.roles[0] == 'candidate' ) { window.document.location = '/candidate-dashboard'; }
				else { window.document.location = '/wp-admin'; }

			}
		});
    });

});