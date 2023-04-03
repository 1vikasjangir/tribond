$(document).on("click",".project_box a", function(){
  let slideno = $(this).attr("data-slide")
  console.log($(".modal-dialog").find(".project_box::before").attr('style'))
  $(".modal-dialog").find(".project_box").find("img").hide()
  $(".modal-dialog").find(".project_info").hide()
  $(".modal-dialog").find(".project_box").addClass('hide_content')
  $(".modal-dialog").find(".carousel").hide()
  setTimeout(function(){
      $('.modal_slider').not('.slick-initialized').slick({
          slidesToScroll: 1,
          slidesToShow: 1,
          arrows: true,
          dots: false,
          speed: 1000,
      });
      $('.modal_slider').slick('slickGoTo', slideno, true );
      $(".modal-dialog").find(".project_box").find("img").show()
      $(".modal-dialog").find(".project_box").removeClass('hide_content')
      $(".modal-dialog").find(".project_info").show()
      $(".modal-dialog").find(".carousel").show()
  }, 700);
})