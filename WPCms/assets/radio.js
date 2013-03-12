jQuery(document).ready(function ($) {

  $(".wpcms-radio-relation").each(function (k, field) {

    var qs = $(field).attr('data-related'), relations = {};

    $(field).find('input').each(function (k, id) {
      relations[$(this).val()] = ('' + $(this).attr('data-related')).split(',');
    });

    if (qs) {
      var fields = qs.split(',');

      $.each(fields, function (k, id) {
        $('.wpcms_' + id + '-wrapper').hide();
      });

      if ($(field).find('input:radio:checked').length)
        $.each(relations[$(field).find('input:radio:checked').val()], function (k, id) {
          $('.wpcms_' + id + '-wrapper').show();
        });

      $(field).find('input:radio').change(function (e) {

        $.each(fields, function (k, id) {
          $('.wpcms_' + id + '-wrapper').hide();
        });

        if (typeof relations[$(this).val()] != "undefined")
          $.each(relations[$(this).val()], function (k, id) {
            $('.wpcms_' + id + '-wrapper').show();
          });
      });
    }
  });
});