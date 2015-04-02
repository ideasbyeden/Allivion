jQuery(function(){
	
	
	var target;
	var clickableurl;
	var returndata;

	jQuery('form.directory.search').submit(function(e){
		e.preventDefault();

		console.log('searching');

		target = jQuery(this).attr('targetid');
		clickableurl = jQuery(this).attr('clickableurl');
		returndata = jQuery(this).attr('return');
		returndata = returndata.split(',');

		itemsearch(jQuery(this));

	});
	
	function itemsearch(form){
		
		var data = form.serialize();
		console.log(returndata);
		
		jQuery.ajax({
			type: 'POST',
			url:  directory_search.ajaxurl,
			data: data,
			dataType: 'json',
			async: true,
					
			success: function(result){
				jQuery('#'+target).html('');
				jQuery.each(result.posts, function(index,postdata){
					console.log(postdata);
					var row = '<tr class="clickable" data-href="'+clickableurl+'?i='+postdata['ID']+'">';
						jQuery.each(returndata, function(k,v){
							if(typeof postdata.meta[v] == 'undefined') postdata.meta[v] = '';
							row += '<td>'+postdata.meta[v]+'</td>';
						});
					row += '</tr>';
					jQuery('#'+target).append(row);				
				});
			}
		});
	}


});