<?php

Class WPCmsRelationField Extends WPCmsField {

  var $height = 100;

  function __construct ($id, $name = '', $description = '', $default = '', $postTypeOfRelated = '')
  {
    $this->id = WPCmsStatus::getStatus()->getData('pre') . $this->normalize($id);
    $this->name = $name;
    $this->description = $description;
    $this->default = $default;
    $this->postTypeOfRelated = $postTypeOfRelated;

    return $this;
  }

  public function addActionAdminEnqueueScripts ($hook)
  {
    wp_enqueue_script('wpcms-multi-select', get_template_directory_uri() . '/WPCms/assets/multi-select.js', array('jquery'));
    wp_enqueue_style('wpcms-multi-select', get_template_directory_uri() . '/WPCms/assets/multi-select.css');
  }

  public function renderInnerInput ($post, $data = array())
  {
    if ($data['value'] == '') $data['value'] = $this->default;
    $values = explode(',', (string)$data['value']);

    $posts = get_posts(array(
      'numberposts' => -1,
      'orderby' => 'post_date',
      'order' => 'DESC',
      'post_type' => $this->postTypeOfRelated != '' ? $this->postTypeOfRelated : $post->post_type));

    echo '<div class="multi-select-field">';

    echo '<label>', __('type to filter'), ':</label>',
      '<input class="multi-select-filter" size="40" />',
      '<a class="button button-small select-all">Select All</a>',
      '<a class="button button-small select-none">Select None</a>';

    echo '<div class="options-list" id="', $data['id'], '_wrapper" style="width:100%;height:150px;">';

    foreach ($posts as $p) {
      echo '<a href="', $p->ID, '"', (in_array($p->ID, $values) ? ' class="selected"' : ''), '>', $p->post_title, ' (', $p->post_status, ', ', $p->post_date, ')</a>';
    }

    echo '</div>';
    echo '<input type="hidden" value="', $data['value'], '" class="input" id="', $data['id'], '" name="', $data['name'], '" />';

    echo '</div>';

  }
}