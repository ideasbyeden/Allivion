jQuery(function(){
	
	
	var target;
	var returndata;

	jQuery('form.directory.search').submit(function(e){
		e.preventDefault();

		console.log('searching');

		target = jQuery(this).attr('targetid');
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
				jQuery('#'+target).append('<thead><tr><td>Job title</td><td>Reference</td></tr></thead>');
				jQuery.each(result.posts, function(index,postdata){
					console.log(postdata);
					var row = '<tr class="clickable" data-href="/job-details-form?i='+postdata['ID']+'">';
						jQuery.each(returndata, function(k,v){
							row += '<td>'+postdata.meta[v]+'</td>';
						});
					row += '</tr>';
					jQuery('#'+target).append(row);				
				});
			}
		});
	}


});