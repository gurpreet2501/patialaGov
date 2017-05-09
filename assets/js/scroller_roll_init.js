$(function(){
  $(".scroller_roll").each(function(){
    $(this).scroller_roll({
                  title_show: 'enable',//enable  disable
                  time_interval: 15,
                  window_background_color: "none",
                  window_padding: 1,
                  border_size: 1,
                  border_color: 'none',
                  images_width: 140,
                  images_height: 200,
                  images_margin: 5,
                  title_size: 12,
                  title_color: 'black',
                  show_count: 8
                });
  });
  
  
});