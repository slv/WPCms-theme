<?php

/* Options Retriever */
function _o($label, $default = '') {
  if (!defined('PRE'))
    return 'constant PRE not defined';

  return get_option(PRE . $label, $default);
}

function _m($postID, $label) {
  if (!defined('PRE'))
    return 'constant PRE not defined';

  return get_post_meta($postID, PRE . $label, true);
}

/* To enable $_FILES variable */
function update_edit_form () { echo ' enctype="multipart/form-data"'; }
add_action('post_edit_form_tag', 'update_edit_form');