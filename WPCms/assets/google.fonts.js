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

var WPCmsFontFamilies = {};

function WPCmsLoadGoogleFontsScript ()
{
    WebFont.load({
        google: {
            families: WebFontConfig.google.families
        }
    });
}

function WPCmsRenderFonts (k, field)
{
    var select = jQuery(field).find('select');

    if (select.val().length > 3) {

        jQuery(field).find('.demo').css({
            fontSize: function () { var s = parseInt(jQuery(this).attr('data-fontsize')) || 16; return s; },
            lineHeight: '20px',
            fontFamily: select.val().split(':').shift(),
            fontWeight: WPCmsFontStyles[select.val().split(':').pop()][0],
            fontStyle: WPCmsFontStyles[select.val().split(':').pop()][1]
        }).html(select.val());

        if (WebFontConfig.google.families.indexOf(WPCmsFontFamilies[select.val()]) < 0) {
            WebFontConfig.google.families.push(WPCmsFontFamilies[select.val()]);
            WPCmsLoadGoogleFontsScript();
        }
    }
}

if (typeof _WPCmsGlobalInit === "undefined") _WPCmsGlobalInit = {};

_WPCmsGlobalInit.GoogleFonts = function ($) {

    if (typeof WebFontConfig === "undefined") WebFontConfig = {google: {families: []}};
    if (typeof WebFontConfig.google === "undefined") WebFontConfig.google = {families: []};
    if (typeof WebFontConfig.google.families === "undefined") WebFontConfig.google.families = [];

    if ($('.wpcms-google-fonts-field .field-wrapper').length && !$('.wpcms-google-fonts-field .field-wrapper').first().data('init-families')) {
        $('.wpcms-google-fonts-field .field-wrapper').first().data('init-families', true);
        $('.wpcms-google-fonts-field .field-wrapper').first().find('select > option').each(function (k, option) {
            WPCmsFontFamilies[$(option).val()] = $(option).attr('data-font');
        });
    }

    $('.wpcms-google-fonts-field .field-wrapper').each(WPCmsRenderFonts).each(function (k, field) {

        if ($(this).data('init')) return;
        $(this).data('init', true);

        $(field).find('select').change(function () {
            WPCmsRenderFonts(null, field);
        });
    });

};

jQuery(document).ready(function($) {

    _WPCmsGlobalInit.GoogleFonts($);
    WPCmsLoadGoogleFontsScript();
});