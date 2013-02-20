function slvToggleFields (field, fields) {

  jQuery.each(fields, function (k, id) {
    if (jQuery(field).is(':checked'))
      jQuery("#" + id).parentsUntil(".postbox", ".form-table").css('display', 'block');

    else
      jQuery("#" + id).parentsUntil(".postbox", ".form-table").css('display', 'none');
  });

}

function slvRemoveImage (image) {
  image.parentNode.parentNode.innerHTML = '';
  return false;
}

jQuery(document).ready(function ($) {

  var postFormatSelect = jQuery('#post-formats-select input').change(function (e) {

    var r = new RegExp(e.target.value + '$');
    var cr = new RegExp('^wpcms');

    jQuery(".postbox").each(function (key) {

      if (cr.test(jQuery(this).attr('id')))
      {
        if (r.test(jQuery(this).attr('id')) || /shared$/.test(jQuery(this).attr('id')))
          jQuery(this).css('display', 'block');

        else
          jQuery(this).css('display', 'none');
      }
    });

  }).each(function (key) {
    if (!jQuery(this).is(':checked'))
      jQuery("#wpcms-" + jQuery(this).val()).css('display', 'none');
    else
      jQuery("#wpcms-" + jQuery(this).val()).css('display', 'block');
  });

  jQuery(".to-trigger-click").click().click();

  jQuery('textarea.ckeditor').each(function(index) {
    var objectName = jQuery(this).attr('name');

    var configurationData = {
        startupOutlineBlocks : true,
        uiColor : '#f3f3f3',
        resize_enabled: false,
        height: 240,
        toolbar :
            [
                ['Format'],
                ['Bold', 'Italic', 'Underline','-', 'Subscript', 'Superscript'],
                ['HorizontalRule'],
                ['BulletedList'],
                ['Link', 'Unlink'],
                ['Source'],
                ['PasteText','PasteFromWord','SelectAll', 'RemoveFormat'],['-','Undo', 'Redo']
            ],
        format_tags: 'p;h1;h2'
    };

    if (jQuery(this).hasClass('multilingual')) configurationData.language = objectName.toString().substr(-2);

    CKEDITOR.replaceByClassEnabled = false;
    CKEDITOR.replace(objectName, configurationData);

  });

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

function set_send(field) {
  window.original_send_to_editor = window.send_to_editor;

  window.send_to_editor = function(html) {
    img = jQuery('img',html).css({'max-width': 100, 'max-height': 100, 'margin': 5});
    jQuery(field).prepend(img);
    tb_remove();
    window.send_to_editor = window.original_send_to_editor;
  };
}