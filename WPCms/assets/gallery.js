if (typeof _WPCmsGlobalInit == "undefined") _WPCmsGlobalInit = {};

_WPCmsGlobalInit.Gallery = function ($) {

    $('.wpcms-gallery-field').each(function (k, gall) {

        if ($(this).data('init')) return;
        $(this).data('init', true);

        var field = $(this).find('.gallery-input').first();
        var gallery = $(this).find('.gallery-sortable').first();
        var galleryDelete = $(this).find('.gallery-delete').first();

        $(this).find('* .gallery-button').click(function(e) {
            e.preventDefault();
            if (mojo_media_frame) {
                mojo_media_frame.open();
                return;
            }
            var mojo_media_frame = wp.media.frames.mojo_media_frame = wp.media({
                className: 'media-frame mojo-media-frame',
                frame: 'select',
                multiple:   'add',
                library: {
                    type: 'image'
                }
            });
            mojo_media_frame.on('select', function () {
                var selection = mojo_media_frame.state().get('selection');
                var val = '';
                gallery.html('');
                selection.map(function(attachment) {
                    if (!attachment.id) return;
                    var thumbnail = attachment.attributes.sizes.full;
                    if (typeof attachment.attributes.sizes.thumbnail !== "undefined") thumbnail = attachment.attributes.sizes.thumbnail;
                    if (val != '') val += ',';
                    val += attachment.id;
                    $('<div class="gallery-sort-item" id="gallery-sort-'+attachment.id+'"><img src="' + thumbnail.url + '" /></div>').appendTo(gallery);
                });
                field.val(val);
                galleryDelete.show();
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

        $(gall).find('* .gallery-delete').live('click', function() {
            $(this).hide();
            field.val('');
            gallery.html('');
            return false;
        });


        $(this).find("* .gallery-sortable").sortable({
            stop: function (event, ui) {
                var ids = $(this).sortable("toArray");
                var val = ids.join(',').replace(/gallery-sort-/gi, '');
                field.val(val);
            }
        });
    });
}

jQuery(document).ready(_WPCmsGlobalInit.Gallery);


