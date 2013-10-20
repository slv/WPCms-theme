if (typeof _WPCmsGlobalInit == "undefined") _WPCmsGlobalInit = {};

jQuery(document).ready(function ($) {

  $('.wpcms-modules-field').each(function (k, field) {

    if ($(this).data('init')) return;
    $(this).data('init', true);

    function setFields (sortable) {
      sortable.find('.module').each(function (k) {
        var module = $(this),
            order = k+1;
        module.find('input').each(function (k) {
          if ($(this).attr('id') && ~$(this).attr('id').indexOf('____')) {
            var name = $(this).attr('id').replace('____', '[' + order + ']');
            $(this).attr('name', name);
          }
        });
      });

      $.each(_WPCmsGlobalInit, function (Field, Init) {
        Init($);
      });
    };

    $(field).find('.modules-list-droppable').sortable({
      start: function (event, ui) {
        $(ui.item).children('.module-inside').hide();
      },
      stop: function (event, ui) {
        $(ui.item).children('.module-inside').show();
      },
      update: function (event, ui) {
        setFields($(this));
      }
    });

    setFields($(field).find('.modules-list-droppable'));

    var id = 0;

    $(field).find('.modules-list > .module').draggable({
      containment: $(field),
      connectToSortable: $(field).find('.modules-list-droppable'),
      // appendTo: $(field).find('.modules-list-droppable'),
      helper: "clone"
    });

    $(field).find('.modules-list-droppable').droppable({
      accept: ".module",
      hoverClass: "drop-hover"
    });

  });
});

