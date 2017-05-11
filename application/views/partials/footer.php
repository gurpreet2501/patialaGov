<div class="spacer-100"></div>
<div class="row">
	<div class="col-xs-12">
		<div class="col-xs-2"><a href="#"><img src="<?=base_url()?>/images/cashless.jpg" class="zoom-in" /></div></a>
		<div class="col-xs-2"><a href="#"><img src="<?=base_url()?>/images/ceo.jpg" class="zoom-in" /></div></a>
		<div class="col-xs-2"><a href="#"><img src="<?=base_url()?>/images/sideabar-ad.jpg" class="zoom-in" /></div></a>
		<div class="col-xs-2"><a href="#"><img src="<?=base_url()?>/images/di.jpg" class="zoom-in" /></div></a>
		<div class="col-xs-2"><a href="#"><img src="<?=base_url()?>/images/fardimage.jpg" class="zoom-in" /></div></a>
		<div class="col-xs-2"><a href="#"><img src="<?=base_url()?>/images/download.jpg" class="zoom-in" /></div></a>
	</div>
</div>	
<div class="row">
	<div class="col-xs-12">
		<div class="footer">
			Copyright &copy; 2017
		</div>
	</div>
</div>
</div> <!-- container ends -->
	<script type="text/javascript" src="<?=base_url()?>/js/jquery.js"></script>
	<script type="text/javascript" src="<?=base_url()?>/js/slider.js"></script>
	<script type="text/javascript" src="<?=base_url()?>/js/locales.js"></script>
	<script type="text/javascript" src="<?=base_url()?>/js/jquery-ui.js"></script>
	<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> -->
	<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.min.js"></script>
<script type="text/javascript">
$('.carousel').carousel({
  interval: 2000
	});
  $(function () {
	    $('#datetimepicker1').datepicker();
	});
	$("#booking_form").validate({
  rules: {
    // simple rule, converted to {required:true}
    name: "required",
    // compound rule
    email: {
      required: true,
      email: true
    }
  }
});
 jQuery('#booking_form').validate();
 if(!jQuery('table').hasClass('table-bordered'))
 		jQuery('table').addClass('table table-bordered')


</script>

<script type="text/javascript">
						function googleTranslateElementInit() {
						  new google.translate.TranslateElement({pageLanguage: 'en', includedLanguages: 'hi,pa,en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE, autoDisplay: false}, 'google_translate_element');
						}
				</script>
				<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>