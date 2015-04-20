jQuery(function(){
	
	
	var target;
	var clickableurl;
	var returndata;

	jQuery('form.directory.search').submit(function(e){
		e.preventDefault();

		target = jQuery(this).attr('targetid');
		clickableurl = jQuery(this).attr('clickableurl');
		returndata = jQuery(this).attr('return');
		returndata = returndata.split(',');
		console.log(returndata);

		itemsearch(jQuery(this));

	});
	
	function itemsearch(form){
		
		var data = form.serialize();
		
		jQuery.ajax({
			type: 'POST',
			url:  directory_search.ajaxurl,
			data: data,
			dataType: 'json',
			async: true,
					
			success: function(result){
				var prototype = jQuery('#'+target+' .prototype');
				jQuery('#'+target+' .rowitem').remove();
				jQuery.each(result.posts, function(index,postdata){


					if(prototype.length > 0){
						var row = prototype.clone();
						row.addClass('rowitem clickable');
						row.removeClass('prototype');
						row.attr('data-href', clickableurl+'?i='+postdata['ID']);
						jQuery.each(returndata, function(k,v){
							if(typeof postdata.meta[v] != 'undefined'){
								if(jQuery.isArray(postdata.meta[v])){
									row.html(row.html().replace('['+v+']',postdata.meta[v][0]));
								} else {
									row.html(row.html().replace('['+v+']',postdata.meta[v]));
								}
							}
							
							if(typeof postdata.groupmeta[v] != 'undefined'){
								if(jQuery.isArray(postdata.groupmeta[v])){
									row.html(row.html().replace('['+v+']',postdata.groupmeta[v][0]));
								} else {
									row.html(row.html().replace('['+v+']',postdata.groupmeta[v]));
								}
							}

							if(typeof postdata.authormeta[v] != 'undefined'){
								if(jQuery.isArray(postdata.authormeta[v])){
									row.html(row.html().replace('['+v+']',postdata.authormeta[v][0]));
								} else {
									row.html(row.html().replace('['+v+']',postdata.authormeta[v]));
								}
							}
							
							
						});
						row.html(row.html().replace(/\[.*?\]/g,''));
					} else {					
						var row = '<tr class="clickable rowitem" data-href="'+clickableurl+'?i='+postdata['ID']+'">';
							jQuery.each(returndata, function(k,v){
								if(typeof postdata.meta[v] == 'undefined') postdata.meta[v] = '';
								row += '<td>'+postdata.meta[v]+'</td>';
							});
						row += '</tr>';
					}
					jQuery('#'+target).append(row);				
				});
			}
		});
	}


});