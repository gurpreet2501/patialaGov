jQuery(function(){
	$('iframe').hide();
	$('#missing-item').on('click', function(){
       $('.mis_items').show();
	});
  $('.damaged_items').on('click', function(){
     var id = $(this).attr('id'); 
     $('#missing-item-form-'+id).show();

  });
  $('.receiving_complete').on('click', function(){
     var id = $(this).attr('data-attr'); 
     $('#missing-item-form-'+id).hide();

  }); 
  $('.return_items').on('click', function(){
      $('.return_items_form').show();
  }); 

});