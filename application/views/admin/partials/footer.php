     
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
 

    <!-- Morris Charts JavaScript -->
 <script src="<?=base_url('assets/js/form-validator.js')?>"></script>
 <script type="text/javascript" src="<?=base_url('assets/js/chosen.jquery.js')?>"></script>
 <script type="text/javascript">
  jQuery(function($){
      $('.chosen-select').chosen();
  });

</script>
<script>
  $.validate({
    lang: 'en'
  });
</script>

<!-- Hiding the domestic usertype column when export customer is added  -->
<script>
jQuery(function(){
    $("#field-customer_type" ).change(function() {
       var text = $('#field_customer_type_chzn a span').text();
       if(text == 'Export')
            $('#domestic_user_type_field_box').hide();
        else
            $('#domestic_user_type_field_box').show();
    });

});
</script>
<script type="text/javascript">
  jQuery(function($){
    // $('.order-cancellation-form').hide();
    $( ".show-order-cancel-form" ).click(function() {
      $('.show-order-cancel-form').hide();
      $( ".order-cancellation-form" ).slideDown( "slow", function() {

      });
    });
  })
</script>
    <div style='height:20px;'></div>  
</body>
</html>
<script>
function goBack() {
    window.history.back();
}
</script>
