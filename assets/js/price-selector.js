$(function(){
  $('.price-selector').change(function(){
    $option = $(this).find('option').filter(':selected');
    $('.price-display').text($option.attr('data-price'));
  });
  $('.price-selector').trigger('change');
});