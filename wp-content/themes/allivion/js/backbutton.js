jQuery(function(){
	jQuery('a.back').click(function(){
		parent.history.back();
		return false;
	});
});