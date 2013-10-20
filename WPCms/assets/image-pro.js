if (typeof _WPCmsGlobalInit == "undefined") _WPCmsGlobalInit = {};

_WPCmsGlobalInit.ImageProField = function ($) {

    $('.wpcms-image-pro-field').each(function (k, gall) {

        if ($(this).data('init')) return;
        $(this).data('init', true);

        var field = $(this).find('.image-pro-input').first();
        var imagePro = $(this).find('.image-pro-wrapper').first();
        var imageProDelete = $(this).find('.image-pro-delete').first();

        $(this).find('* .image-pro-button').click(function(e) {
            e.preventDefault();
            if (mojo_media_frame) {
                mojo_media_frame.open();
                return;
            }
            var mojo_media_frame = wp.media.frames.mojo_media_frame = wp.media({
                className: 'media-frame mojo-media-frame',
                frame: 'select',
                multiple:   false,
                library: {
                    type: 'image'
                }
            });
            mojo_media_frame.on('select', function () {
                var selection = mojo_media_frame.state().get('selection');
                var val = '';
                imagePro.html('');
                selection.map(function(attachment) {
                    if (!attachment.id) return;
                    var thumbnail = attachment.attributes.sizes.full;
                    if (typeof attachment.attributes.sizes.thumbnail !== "undefined") thumbnail = attachment.attributes.sizes.thumbnail;
                    if (val != '') val += ',';
                    val += attachment.id;
                    $('<div class="image-pro-sort-item" id="image-pro-sort-'+attachment.id+'"><img src="' + thumbnail.url + '" /></div>').appendTo(imagePro);
                });
                field.val(val);
                imageProDelete.show();
            });
            mojo_media_frame.on('open', function () {
                var selection = mojo_media_frame.state().get('selection');
                var ids = field.val().split(',');
                $.each(ids, function (k, id) {
                    var attachment = wp.media.attachment(id);
                    attachment.fetch();
                    if (attachment) selection.add([attachment]);
                });
            });

            mojo_media_frame.open();
        });

        $(gall).find('* .image-pro-delete').live('click', function() {
            $(this).hide();
            field.val('');
            imagePro.html('');
            return false;
        });
    });
};

jQuery(document).ready(_WPCmsGlobalInit.ImageProField);



