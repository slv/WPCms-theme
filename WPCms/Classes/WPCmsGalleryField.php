<?php

Class WPCmsGalleryField Extends WPCmsField {

  public function addActionAdminEnqueueScripts ($hook)
  {
    if (function_exists('wp_enqueue_media')) { wp_enqueue_media(); }
    wp_enqueue_script('wpcms-gallery', WPCMS_STYLESHEET_URI . '/WPCms/assets/gallery.js', array('jquery-ui-core'));
    wp_enqueue_style('wpcms-gallery', WPCMS_STYLESHEET_URI . '/WPCms/assets/gallery.css');
  }

  public function renderInnerInput ($post, $data = array())
  {
    ?>

    <div class="gallery-sortable">
      <?php if ($data['value'] != ''): $images = explode(',', $data['value']); foreach ($images as $image): ?>
      <div class="gallery-sort-item" id="gallery-sort-<?php echo $image; ?>">
        <?php echo wp_get_attachment_image($image, $size = 'thumbnail'); ?>
      </div>
      <?php endforeach; endif; ?>
    </div>
    <input id="<?php echo $data['id']; ?>" class="gallery-input" type="hidden" name="<?php echo $data['name']; ?>" value="<?php echo esc_attr($data['value']); ?>" />
    <input type="button" value="<?php _e('Edit Gallery', WPCmsStatus::getStatus()->getData('textdomain')); ?>" class="button button-primary gallery-button" />
    <input type="button" value="<?php _e('Delete Gallery', WPCmsStatus::getStatus()->getData('textdomain')); ?>" class="button button-secondary gallery-delete"<?php if ($data['value'] == '') echo ' style="display:none;"'; ?> />

    <?php
  }
}


