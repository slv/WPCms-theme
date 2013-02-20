<?php

Class WPCmsTinyMCEField Extends WPCmsField {

  public function renderInnerInput ($post, $data = array()) {
    wp_editor(
      $data['value'],
      $data['id'],
      array(
        'wpautop' => true,
        'media_buttons' => true,
        'textarea_name' => $data['name'],
        'textarea_rows' => get_option('default_post_edit_rows', 10),
        'tabindex' => '',
        'editor_css' => '',
        'editor_class' => '',
        'teeny' => false,
        'dfw' => false,
        'tinymce' => true,
        'quicktags' => true
      )
    );
  }
}


