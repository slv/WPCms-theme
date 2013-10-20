if (typeof _WPCmsGlobalInit == "undefined") _WPCmsGlobalInit = {};

_WPCmsGlobalInit.MultiSelectField = function ($) {

  $('.multi-select-field').each(function (k, field) {

    if ($(this).data('init')) return;
    $(this).data('init', true);

    var sortables = $(field).find(".options-list-sortable").first(),
        values = $(field).find('.input').val().length ? $(field).find('.input').val().split(',') : [];

    function initValues () {
      sortables.html('');
      $(field).find('.options-list > a').removeClass('selected');
      $.each(values, function (k, v) {
        $(field).find('.options-list > a[href='+v+']').addClass('selected')
        .clone().attr({id: 'option-sort-'+v}).removeClass('selected').click(function (e) {e.preventDefault(); })
        .appendTo(sortables);
      });
      $(field).find('.input').val(values.join(','));
    }

    function setItems (val) {
      values = val;
    }

    function addItem (itemId) {
      if (!~values.indexOf(itemId))
        values.push(itemId);
    }

    function removeItem (itemId) {
      var i = values.indexOf(itemId);
      if (~i)
        values.splice(i, 1);
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

          if ($(this).hasClass('selected'))
            addItem($(option).attr('href'));
          else
            removeItem($(option).attr('href'));

          initValues();
        }
      });
    });

    $(field).find('.select-all').bind({
      click: function (e) {
        e.preventDefault();
        setItems([]);
        $(field).find('.options-list > a').each(function (k, option) { addItem($(option).attr('href')); });
        initValues();
      }
    });

    $(field).find('.select-none').bind({
      click: function (e) {
        e.preventDefault();
        setItems([]);
        initValues();
      }
    });

    $(this).find(".options-list-sortable").sortable({
        stop: function (event, ui) {
            var ids = $(this).sortable("toArray");
            var val = ids.join(',').replace(/option-sort-/gi, '');
            setItems(val.split(','));
            initValues();
        }
    });

    initValues();
  });
};

jQuery(document).ready(_WPCmsGlobalInit.MultiSelectField);

