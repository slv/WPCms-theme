<?php

Class WPCmsImageField Extends WPCmsField {

  public function addActionAdminEnqueueScripts ($hook)
  {
    if (function_exists('wp_enqueue_media')) { wp_enqueue_media(); }
    wp_enqueue_script('wpcms-image', WPCMS_STYLESHEET_URI . '/WPCms/assets/image.js', array('jquery', 'media-upload', 'thickbox'));
  }

  public function renderInnerInput ($post, $data = array())
  { ?>

    <div class="image-wrapper"><?php if ($data['value'] != ''): ?><?php echo wp_get_attachment_image($data['value'], $size = 'thumbnail'); ?><?php endif; ?></div>
    <input id="<?php echo $data['id']; ?>" class="upload-image-input" type="hidden" name="<?php echo $data['name']; ?>" value="<?php echo esc_attr($data['value']); ?>" />
    <input type="button" value="<?php _e('Insert Image', WPCmsStatus::getStatus()->getData('textdomain')); ?>" class="button button-primary upload-image-button" />
    <input type="button" value="<?php _e('Delete Image', WPCmsStatus::getStatus()->getData('textdomain')); ?>" class="button button-secondary upload-image-delete"<?php if ($data['value'] == '') echo ' style="display:none;"'; ?> />

<?php
  }
}


