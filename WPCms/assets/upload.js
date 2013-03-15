jQuery(document).ready(function($) {

    var field = null, deleteField = null, imgCont = null;

    $('.upload-file-button').live('click', function() {
        $('html').addClass('Image');
        field = $(this).siblings('.upload-file-input').first();
        deleteField = $(this).siblings('.upload-file-delete').first();
        linkCont = $(this).siblings('.file-wrapper').first();
        tb_show('', 'media-upload.php?type=image&TB_iframe=true');
        return false;
    });

    $('.upload-file-delete').live('click', function() {
        $(this).hide();
        $(this).siblings('.upload-file-input').first().val('');
        $(this).siblings('.file-wrapper').first().html('');
        return false;
    });


    window.original_send_to_editor = window.send_to_editor;
    window.send_to_editor = function (html) {

        if (field != null) {

            var lnk = $(html);
            field.val($(lnk).attr('href'));
            deleteField.show();
            linkCont.html('').append(html);
            tb_remove();
            $('html').removeClass('Image');
            field = imgCont = deleteField = null;

        } else {
            window.original_send_to_editor(html);
        }
    };

});