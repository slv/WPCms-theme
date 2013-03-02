jQuery(document).ready(function ($) {

  $(".wpcms-multilingual-field > div").css({
    height: function () {
      var height = 0,
          add = $(this).children().first().outerHeight();

      $(this).find('.multilingual-wrapper').each(function (k, wrap) {
        height = Math.max($(wrap).outerHeight(), height);
      });

      return (height + add);
    }
  })

  $(".multilingual-switcher.ord-0").addClass('button-primary');

  $('.multilingual-wrapper').hide();
  $('.multilingual-wrapper.ord-0').show();

  $(".multilingual-switcher").click(function (e) {
    e.preventDefault();

    $('.multilingual-wrapper').hide();
    $('.multilingual-wrapper.lang-' + $(this).text()).show();

    $('.multilingual-switcher.button-primary').removeClass('button-primary');
    $('.multilingual-switcher.lang-' + $(this).text()).addClass('button-primary');
  });
});