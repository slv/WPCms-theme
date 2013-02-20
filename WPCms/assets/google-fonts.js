function WPCmsRenderFonts (k, field)
{
    var select = jQuery(field).find('select');

    if (select.val().length > 3) {

        if (WebFontConfig.google.families.indexOf(select.val().replace(/\s/g, '+')) < 0)
            WebFontConfig.google.families.push(select.val().replace(/\s/g, '+'));

        jQuery(field).find('.demo').css({
            fontSize: 16,
            lineHeight: '20px',
            fontFamily: function () { return select.val().split(':').shift(); },
            fontWeight: function () { return WPCmsFontStyles[select.val().split(':').pop()][0]; },
            fontStyle: function () { return WPCmsFontStyles[select.val().split(':').pop()][1]; }
        }).html(select.val());
    }
}

var WPCmsFontStyles = {
    '100': [100, 'normal'],
    '100italic': [100, 'italic'],
    '200': [200, 'normal'],
    '200italic': [200, 'italic'],
    '300': [300, 'normal'],
    '300italic': [300, 'italic'],
    '400': [400, 'normal'],
    '400italic': [400, 'italic'],
    'regular': [400, 'normal'],
    'italic': [400, 'italic'],
    '500': [500, 'normal'],
    '500italic': [500, 'italic'],
    '600': [600, 'normal'],
    '600italic': [600, 'italic'],
    '700': [700, 'normal'],
    '700italic': [700, 'italic'],
    '800': [800, 'normal'],
    '800italic': [800, 'italic'],
    '900': [900, 'normal'],
    '900italic': [900, 'italic']
};

jQuery(document).ready(function($) {

    function loadGoogleFontsScript ()
    {
        WebFontConfig.google.families.sort();

        var wf = document.createElement('script');
        wf.src = ('https:' == document.location.protocol ? 'https' : 'http') + '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
        wf.type = 'text/javascript';
        wf.async = 'true';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(wf, s);
    }

    if (typeof WebFontConfig == "undefined") WebFontConfig = {google: {families: []}};
    if (typeof WebFontConfig.google == "undefined") WebFontConfig.google = {families: []};
    if (typeof WebFontConfig.google.families == "undefined") WebFontConfig.google.families = [];

    WebFontConfig.active = function () {
        $('.wpcms-google-fonts-field .field-wrapper').each(WPCmsRenderFonts);
    };


    $('.wpcms-google-fonts-field .field-wrapper').each(WPCmsRenderFonts).each(function (k, field) {

        $(field).find('select').change(function () {

            if (WebFontConfig.google.families.indexOf($(this).val().replace(/\s/g, '+')) < 0) {
                WebFontConfig.google.families.push($(this).val().replace(/\s/g, '+'));
                loadGoogleFontsScript();
            }
            else {
                WPCmsRenderFonts(null, field);
            }
        });
    });

    loadGoogleFontsScript();
});