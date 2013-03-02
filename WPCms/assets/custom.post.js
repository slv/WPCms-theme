jQuery(document).ready(function ($) {

  var postFormatSelect = jQuery('#post-formats-select input').change(function (e) {

    var r = new RegExp(e.target.value + '$');
    var cr = new RegExp('^wpcms-format');

    jQuery(".postbox").each(function (key) {

      if (cr.test(jQuery(this).attr('id')))
      {
        if (r.test(jQuery(this).attr('id')))
          jQuery(this).css('display', 'block');

        else
          jQuery(this).css('display', 'none');
      }
    });

  }).each(function (key) {
    if (!jQuery(this).is(':checked'))
      jQuery("#wpcms-format-" + jQuery(this).val()).css('display', 'none');
    else
      jQuery("#wpcms-format-" + jQuery(this).val()).css('display', 'block');
  });
});

