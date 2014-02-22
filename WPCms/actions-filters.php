<?php

// Options Retriever

function _o($label, $default = '') {

  return get_option(WPCmsStatus::getStatus()->getData('pre') . $label, $default);
}

function _m($label, $postID = false) {
  if (!$postID) $postID = get_the_ID();

  return get_post_meta($postID, WPCmsStatus::getStatus()->getData('pre') . $label, true);
}

function _is_related_to($label, $postID = false) {
  if (!$postID) $postID = get_the_ID();

  return get_post_meta($postID, WPCmsStatus::getStatus()->getData('pre') . $label . '__related_as', true);
}

function _module($id, $postID = false) {
  if (_m($id, $postID)) {
    foreach(_m($id, $postID) as $key => $m) {
      global $module;

      $module = array();
      foreach ($m as $k => $v) {
        $module[preg_replace("/^" . WPCmsStatus::getStatus()->getData('pre') . "/", "", $k)] = $v;
      }

      get_template_part('Modules/' . $module['widget_type'] . '/view');
    }
  }
}


// To enable $_FILES variable

function update_edit_form () {
  echo ' enctype="multipart/form-data"';
}

add_action('post_edit_form_tag', 'update_edit_form');
