jQuery(document).ready(function($) {


  $('.multi-select-field').each(function (k, field) {

    function getValues ()
    {
      var values = [];
      $(field).find('.options-list > a').each(function (k, option) {
        if ($(option).hasClass('selected')) values.push($(option).attr('href'));
      });
      return values;
    }

    $(field).find('.multi-select-filter').on("keyup", function (e) {
      var input = $(this);
      $(field).find('.options-list > a').css({
        display: function () { return $(this).text().replace(/\([^\(\)]*\)$/, '').match(new RegExp(input.val(), 'gi')) ? 'block' : 'none'; }
      });
    });

    $(field).find('.options-list > a').each(function (k, option) {
      $(option).bind({
        click: function (e) {
          e.preventDefault();
          $(option).toggleClass('selected');
          $(field).find('.input').val(getValues().join(','));
        }
      });
    });

    $(field).find('.select-all').bind({
      click: function (e) {
        e.preventDefault();
        $(field).find('.options-list > a').addClass('selected');
        $(field).find('.input').val(getValues().join(','));
      }
    });

    $(field).find('.select-none').bind({
      click: function (e) {
        e.preventDefault();
        $(field).find('.options-list > a').removeClass('selected');
        $(field).find('.input').val(getValues().join(','));
      }
    });

  });


});