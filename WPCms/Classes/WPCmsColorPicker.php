<?php

Class WPCmsColorPicker Extends WPCmsField {

  public function addActionAdminEnqueueScripts ($hook)
  {
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('wpcms-colorpicker', WPCMS_STYLESHEET_URI . '/WPCms/assets/color.picker.js', array('wp-color-picker'));
  }

  public function renderInnerInput ($post, $data = array())
  {
    echo '<div class="wpcms-colorpicker">';
    echo '<input type="text" name="', $data['name'], '" id="', $data['id'], '" value="', esc_attr($data['value']), '" size="30" />';
    echo '<div></div>';
    echo '</div>';
  }

}
