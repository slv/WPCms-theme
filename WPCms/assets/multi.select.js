jQuery(document).ready(function($) {


  $('.multi-select-field').each(function (k, field) {

    var sortables = $(field).find(".options-list-sortable").first();

    function getValues ()
    {
      var values = [];
      $(field).find('.options-list-sortable > a').each(function (k, option) {
        values.push($(option).attr('href'));
      });
      return values;
    }

    function initValues () {
      $.each($(field).find('.input').val().split(','), function (k, v) {
        $(field).find('.options-list > a[href='+v+']').clone().attr({id: 'option-sort-'+v, href: '#'}).removeClass('selected').appendTo(sortables);
      });
    }

    function setSelected () {
      $(field).find('.input').val(getValues().join(','));
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
          if ($(this).hasClass('selected')) {
            $(option).clone().attr({id: 'option-sort-'+$(option).attr('href'), href: '#'}).appendTo(sortables);
          }
          else {
            $(field).find('* #option-sort-' + $(option).attr('href')).remove();
          }
          setSelected();
        }
      });
    });

    $(field).find('.select-all').bind({
      click: function (e) {
        e.preventDefault();
        sortables.html('');
        $(field).find('.options-list > a').addClass('selected').each(function (k, option) {
          $(option).clone().attr({id: 'option-sort-'+$(option).attr('href'), href: '#'}).appendTo(sortables);
        });
        setSelected();
      }
    });

    $(field).find('.select-none').bind({
      click: function (e) {
        e.preventDefault();
        $(field).find('.options-list > a').removeClass('selected');
        sortables.html('');
        setSelected();
      }
    });

    $(this).find(".options-list-sortable").sortable({
        stop: function (event, ui) {
            var ids = $(this).sortable("toArray");
            var val = ids.join(',').replace(/option-sort-/gi, '');
            $(field).find('.input').val(val);
        }
    });

    initValues();
  });
});