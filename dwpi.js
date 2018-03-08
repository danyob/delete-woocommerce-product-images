jQuery(document).ready(function() {
	jQuery('.deleteAll').click(function(e) {
		//e.preventDefault();
		var c = confirm("Are you sure you want to delete all images? This cannot be reverted!");
		if(c == true){
			jQuery('#deleteallimages').submit();	
		}
	});
});