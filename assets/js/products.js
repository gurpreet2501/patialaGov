jQuery(function($){
  function calculator(ele){
    this.$ele   = $(ele);
    this.$qty   = this.$ele.find('.quantity');
    this.product_id = this.$ele.find('.product_id').val();
    this.stock  = parseInt(this.$ele.find('.stock').val());
    this.$calc  = this.$ele.find('.calculations');
    this.$btn_plus  = this.$ele.find('.btn-plus');
    this.$btn_minus = this.$ele.find('.btn-minus');
    this.xhr        = null;
    
    var self = this;
    this.init = function(){
      self.$qty.unbind('keyup');
      self.$qty.keyup(self.qty_changed);
      self.bind_qty_btns();
    }
    
    this.bind_qty_btns = function(){
      self.$btn_plus.click(function(){
        self.set_qty(parseInt(self.$qty.val())+1);
      });
      self.$btn_minus.click(function(){
        self.set_qty(parseInt(self.$qty.val())-1);
      });
    };
    
    this.set_qty = function(val){
      if((val <= 0))
        val = 0;
      if(isNaN(val))
        val = 1;
      self.$qty.val(val);
      self.qty_changed();
    };
    
    
    this.qty_changed = function(){
     
    	var qty = self.$qty.val();
      if(self.xhr)
        self.xhr.abort();
      // var flag = validator.isInt(self.$qty.val(), 
      //                           { min: 0, 
      //                             max: window.vals.force_stock?
      //                                   self.stock :
      //                                   99999999999999 }) ;
      // if(flag == false){
      // 	self.$qty.val('');
      // 	$('.error_id-'+self.product_id).show();
      //   return;
      // }
      
      self.$calc.html('<p>&nbsp;</p><img src='+ base_url('/images/processing.gif') +' />');
      $('.error_id-'+self.product_id).hide();
        self.xhr = $.ajax({
          url   : window.vals.subtotal_jax_url,
          data  : { qty         : qty , 
                    product_id  : self.product_id ,
                    booking_id  : window.vals.booking_id  },
                  
          success: function(data) {

            data = JSON.parse(data);
            self.$calc.html(data.item_discounts); // Appending Discounts
            self.$calc.append(data.item_tax);     // Appending tax
            self.$calc.append(data.final_total);  // Appending Subtotal
           
            $('.order_total').html('0.00');           //Calculating total from all the subtotales
            total = 0;
            $.each( $('.sb_tot'), function( key, value ) {
              total = total +	parseFloat($(value).val()); 
              
              $('.order_total').html(
                accounting.formatNumber(total, {  //Using accounting library to format total in correct form
                  precision : 2,
                  thousand : ","
                }));
            });  

          }
        });
    };
    
    this.init();
  }
  
  $('.products-table tr').each(function(){
     new calculator(this); 
  })
  

 
});