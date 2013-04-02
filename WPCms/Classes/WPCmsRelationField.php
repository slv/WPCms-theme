<?php

Class WPCmsRelationField Extends WPCmsField {

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
    wp_enqueue_script('wpcms-multiselect', get_template_directory_uri() . '/WPCms/assets/multi.select.js', array('jquery'));
    wp_enqueue_style('wpcms-multiselect', get_template_directory_uri() . '/WPCms/assets/multi.select.css');
  }

  public function renderInnerInput ($post, $data = array())
  {
    if ($data['value'] == '') $data['value'] = $this->default;
    $values = explode(',', (string)$data['value']);

    if ($this->postTypeOfRelated == 'page') {
      $posts = get_pages(array(
        'sort_column' => 'post_date',
        'sort_order' => 'DESC'));
    }
    else {
      $posts = get_posts(array(
        'numberposts' => -1,
        'orderby' => 'post_date',
        'order' => 'DESC',
        'post_status' => 'any',
        'post_type' => $this->postTypeOfRelated != '' ? $this->postTypeOfRelated : $post->post_type));
    }

    echo '<div class="multi-select-field">';

    echo '<label>', __('Type to Filter', WPCmsStatus::getStatus()->getData('textdomain')), ':</label>',
      '<input class="multi-select-filter" size="20" />',
      '<a class="button button-small select-all">', __('Select All', WPCmsStatus::getStatus()->getData('textdomain')), '</a>',
      '<a class="button button-small select-none">', __('Deselect All', WPCmsStatus::getStatus()->getData('textdomain')), '</a>';

    echo '<div class="options-list" id="', $data['id'], '_wrapper" style="width:100%;height:150px;">';

    foreach ($posts as $p) {
      echo '<a href="', $p->ID, '"', (in_array($p->ID, $values) ? ' class="selected"' : ''), '>', $p->post_title, ' <span>', $p->post_date, '<br />', $p->post_status, '</span></a>';
    }

    echo '</div>';
    echo '<input type="hidden" value="', esc_attr($data['value']), '" class="input" id="', $data['id'], '" name="', $data['name'], '" />';

    echo '</div>';

  }
}