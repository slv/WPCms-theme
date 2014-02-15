<?php /* SLIDESHOW FADE */ global $module; ?>
<div class="module_slideshow module_slideshow_<?php echo $module['transition_type']; ?>">
  <div class="relative_placeholder"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/placeholder-2-1.jpg"></div>
  <?php $imageIds = explode(',', $module['images']); foreach ($imageIds as $imageId): ?>
    <div class="module_slideshow_standard_img">
      <img src="<?php $img = wp_get_attachment_image_src( $imageId, 'full' ); echo $img[0];  ?>">
      <div>
        <h1><?php $metadata = get_post($imageId); echo $metadata->post_title; ?></h1>
        <h2><?php $metadata = get_post($imageId); echo $metadata->post_content; ?></h2>
      </div>
    </div>
  <?php endforeach; ?>
</div>
