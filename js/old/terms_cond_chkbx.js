jQuery(function($){
	function on_checked(){
    
		if( $(".conditions-accept:checked").length == 1 ) {
       $('.register-btn').removeClass('disabled');
    } else {
			 $('.register-btn').addClass('disabled');
		}
	}	
  $(".conditions-accept").change(on_checked);

});