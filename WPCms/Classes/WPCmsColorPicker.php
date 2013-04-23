<?php

Class WPCmsColorPicker Extends WPCmsField {

  public function addActionAdminEnqueueScripts ($hook)
  {
    wp_enqueue_style('farbtastic');
    wp_enqueue_script('farbtastic');
    wp_enqueue_script('wpcms-colorpicker', WPCMS_STYLESHEET_DIR . '/WPCms/assets/color.picker.js', array('farbtastic', 'jquery'));
    wp_enqueue_style('wpcms-colorpicker', WPCMS_STYLESHEET_DIR . '/WPCms/assets/color.picker.css', array('farbtastic'));
  }

  public function renderInnerInput ($post, $data = array())
  {
    echo '<div class="farbtastic-colorpicker">';
    echo '<input type="text" name="', $data['name'], '" id="', $data['id'], '" value="', esc_attr($data['value']), '" size="30" />';
    echo '<div></div>';
    echo '</div>';
  }

}
