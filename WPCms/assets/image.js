jQuery(document).ready(function($) {


    $('.wpcms-image-field').each(function (k, imageField) {

        var field = null, deleteField = null, imgCont = null;

        $(imageField).find('.upload-image-button').live('click', function() {
            $('html').addClass('Image');
            field = $(this).siblings('.upload-image-input').first();
            deleteField = $(this).siblings('.upload-image-delete').first();
            imgCont = $(this).siblings('.image-wrapper').first();
            tb_show('', 'media-upload.php?type=image&TB_iframe=true');
            window.send_to_editor = function (html) {

                field.val($('img', html).attr('src'));
                deleteField.show();
                imgCont.html('').append($('img', html));
                tb_remove();
                $('html').removeClass('Image');
                field = imgCont = deleteField = null;
                window.send_to_editor = window.original_send_to_editor;

            };
            return false;
        });

        $(imageField).find('.upload-image-delete').live('click', function() {
            $(this).hide();
            $(this).siblings('.upload-image-input').first().val('');
            $(this).siblings('.image-wrapper').first().html('');
            return false;
        });


    });

    window.original_send_to_editor = window.send_to_editor;

});
