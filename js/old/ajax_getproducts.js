jQuery(function($){
	 host=window.location.origin;
      $.ajax({
							url: host+"/index.php/request_cat_products/",
							type: "GET",
							 data: { id: data1.category, page_no: data1.page, language: data1.lang}
					 }).done(function(data) {
		   		     $("#products").html(data);
					}).fail(function() {
		         alert('Unable to load Products for this category');  
		         $("#products").html('');
		      }); 
});

