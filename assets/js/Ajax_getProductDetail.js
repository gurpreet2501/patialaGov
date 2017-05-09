jQuery(function($){
	     $.ajax({
							url: host+"/index.php/product_detail/",
							type: "GET",
							 data: { prod: data.prod ,  language: data.lang}
					 }).done(function(data) {
		   		     $("#products").html(data);
					}).fail(function() {
		         alert('Unable to load Products for this category');  
		         $("#products").html('');
		      }); 
   });