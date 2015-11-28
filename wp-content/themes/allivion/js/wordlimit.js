jQuery(function() {
    jQuery('textarea').on('keyup', function() {
	    var limit = jQuery(this).attr('limit');
	    if(limit.length > 0){ // see if limit field is set
		    limit = parseInt(limit);
	        var words = this.value.match(/\S+/g).length;
	        if (words > limit) {
	            // Split the string on first [limit] words and rejoin on spaces
	            var trimmed = jQuery(this).val().split(/\s+/, limit).join(" ");
	            // Add a space at the end to keep new typing making new words
	            jQuery(this).val(trimmed + " ");
	        }
	        else {
	            jQuery(this).siblings('.wordlimit' ).find('.wordcount').html(words);
	        }
        }
    });
 }); 