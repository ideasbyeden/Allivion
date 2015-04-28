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
				
				if(result.posts.length == 0){
					jQuery('#'+target).append('<tr class="rowitem"><td colspan=99><h3>No results were found</h3><p>Please broaden your search and try again</p></td></tr>');
					return false;
				}

				jQuery.each(result.posts, function(index,postdata){

					if(prototype.length > 0){
						var row = prototype.clone();
						row.addClass('rowitem clickable');
						row.removeClass('prototype');
						row.attr('data-href', clickableurl+'?i='+postdata['ID']);
						jQuery.each(returndata, function(k,v){
							
/*
							var question = return jQuery.ajax({
							    	type: 'POST',
							    	url:  url,
							    	data: data,
							    	dataType: 'json'
							});
							
							
							
							
							
							jQuery.ajax({
				    	type: 'POST',
				    	url:  '<?php echo admin_url('admin-ajax.php'); ?>',
				    	data: 'action=jsapi&type=job&method=getquestion&name='+k,
				    	dataType: 'json',
								
						success: function(question){
							console.log(question.label);
							if(typeof question.value != 'undefined'){
								jQuery.each(question.value, function(qk,qv) {
									if(qv == v) searchval = qk;
								});
							} else {
								searchval = v;
							}
							jQuery('#job_bullets table').append('<tr><td>'+question.label+'</td><td><strong>'+searchval+'</strong></td></tr>').hide().fadeIn(100);
						}
					});
							
*/
							
							
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