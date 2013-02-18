jQuery(document).ready(function($) {

    $('.farbtastic-colorpicker').each(function (k, colorpicker) {
        var input = $(colorpicker).children().first();
        var picker = $(colorpicker).children().last();
        var isActive = false;

        if (!$(input).val().match(/^#/)) {
            $(input).val('#');
        }

        $(picker).hide();
        $(picker).farbtastic(input);

        $(input).bind({
            blur: function() {
                isActive = false;
                $(picker).css({height: 0}).hide();
            },
            focus: function() {
                isActive = true;
                $(picker).css({height: 195}).show();
            }
        });
    });
});