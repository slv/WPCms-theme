<?php

Class WPCmsDatePicker Extends WPCmsField {

  public function addActionAdminEnqueueScripts ($hook)
  {
    wp_enqueue_style('jquery.ui.theme', get_template_directory_uri() . '/WPCms/assets/jquery-ui-datepicker/css/jquery-ui-1.10.2.custom.min.css');
    wp_enqueue_script('jquery.ui.datepicker', get_template_directory_uri() . '/WPCms/assets/jquery-ui-datepicker/js/jquery-ui-1.10.2.custom.min.js', array('jquery', 'jquery-ui-core'));
  }

  public function renderInnerInput ($post, $data = array())
  {
    echo '<div class="jquery-ui-datepicker">';
    echo '<input type="text" name="', $data['name'], '" id="', $data['id'], '" value="', $data['value'], '" size="30" />';
    echo '<div></div>';
    echo '<script>jQuery(document).ready(function ($) { $("#', $data['id'], '").datepicker({numberOfMonths: 3, showWeek: 0, autoSize: 0}); });</script>';
    echo '</div>';
  }

}