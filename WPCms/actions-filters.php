<?php

// Options Retriever

function _o($label, $default = '') {

  return get_option(WPCmsStatus::getStatus()->getData('pre') . $label, $default);
}

function _m($label, $postID = false) {
  if (!$postID) $postID = get_the_ID();

  return get_post_meta($postID, WPCmsStatus::getStatus()->getData('pre') . $label, true);
}


// To enable $_FILES variable

function update_edit_form () {
  echo ' enctype="multipart/form-data"';
}

add_action('post_edit_form_tag', 'update_edit_form');
