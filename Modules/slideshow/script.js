function module_slideshow ($) {

  $('.module_slideshow.module_slideshow_fade').each(function (k, gallery) {
    var currentPhoto = 0;
    var totalPhoto = $(gallery).find('.module_slideshow_standard_img').length;
    var timerPhoto = false;

    function rotatePhoto (newPhoto) {

      clearTimeout(timerPhoto);
      if (currentPhoto !== newPhoto) {
        $($(gallery).find('.module_slideshow_standard_img')[currentPhoto]).animate({opacity:0},600);
        $($(gallery).find('.module_slideshow_standard_img')[newPhoto]).animate({opacity:1},600);
        currentPhoto = newPhoto;
      }

      timerPhoto = setTimeout(function(){
        var n = (currentPhoto + 1)%totalPhoto;
        rotatePhoto(n);
      },4000);
    }

    $(gallery).find('.gallery_previmg').click(function(){

      var n = (totalPhoto + currentPhoto - 1)%totalPhoto;
      rotatePhoto(n);

    });

    $(gallery).find('.gallery_nextimg').click(function(){

      var n = (currentPhoto + 1)%totalPhoto;
      rotatePhoto(n);

    });

    if (totalPhoto > 1) rotatePhoto(0);

    $(gallery).find('.module_slideshow_standard_img').css({opacity: function (k) { if (k) return 0; }});

  });

  $('.module_slideshow.module_slideshow_slide').each(function (k, gallery) {
    var currentPhoto = 0;
    var totalPhoto = $(gallery).find('.module_slideshow_standard_img').length;
    var timerPhoto = false;

    function rotatePhoto (newPhoto) {

      clearTimeout(timerPhoto);
      if (currentPhoto !== newPhoto) {
        $($(gallery).find('.module_slideshow_standard_img')[currentPhoto]).stop(true,true).animate({left:'-100%'},500,"easeInOutExpo");
        $($(gallery).find('.module_slideshow_standard_img')[newPhoto]).css({left:'100%'}).stop(true,true).animate({left:0},500,"easeInOutExpo");
        currentPhoto = newPhoto;
      }

      timerPhoto = setTimeout(function(){
        var n = (currentPhoto + 1)%totalPhoto;
        rotatePhoto(n);
      },5000);
    }

    $(gallery).find('.gallery_previmg').click(function(){

      var n = (totalPhoto + currentPhoto - 1)%totalPhoto;
      rotatePhoto(n);

    });

    $(gallery).find('.gallery_nextimg').click(function(){

      var n = (currentPhoto + 1)%totalPhoto;
      rotatePhoto(n);

    });

    if (totalPhoto > 1) rotatePhoto(0);

    $(gallery).find('.module_slideshow_standard_img:not(:first)').css({left:'100%'});

  });


}
