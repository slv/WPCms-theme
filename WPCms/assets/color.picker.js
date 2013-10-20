if (typeof _WPCmsGlobalInit == "undefined") _WPCmsGlobalInit = {};

_WPCmsGlobalInit.ColorPicker = function($) {

    $('.wpcms-colorpicker').each(function (k, field) {

        if ($(this).data('init')) return;
        $(this).data('init', true);

        var input = $(field).children().first();
        $(input).wpColorPicker();
    });

}

jQuery(document).ready(_WPCmsGlobalInit.ColorPicker);