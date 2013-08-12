<?php

Class WPCmsRelationField Extends WPCmsField {

  function __construct ($config)
  {
    $this->id = WPCmsStatus::getStatus()->getData('pre') . $this->normalize($config['id']);
    $this->name = isset($config['name']) ? $config['name'] : '';
    $this->description = isset($config['description']) ? $config['description'] : '';
    $this->default = isset($config['default']) ? $config['default'] : '';
    $this->postTypeOfRelated = isset($config['related']) ? $config['related'] : '';

    return $this;
  }

  public function addActionAdminEnqueueScripts ($hook)
  {
    wp_enqueue_script('wpcms-multiselect', WPCMS_STYLESHEET_URI . '/WPCms/assets/multi.select.js', array('jquery'));
    wp_enqueue_style('wpcms-multiselect', WPCMS_STYLESHEET_URI . '/WPCms/assets/multi.select.css');
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
      echo '<a href="', $p->ID, '">', $p->post_title, ' <span>', $p->post_date, '<br />', $p->post_status, '</span></a>';
    }

    echo '</div>';
    echo '<hr />';
    echo '<label>', __('And Drag Items to Change Order', WPCmsStatus::getStatus()->getData('textdomain')), ':</label>';
    echo '<div class="options-list-sortable" style="width:100%;min-height:50px;max-height:200px;">';
    echo '</div>';
    echo '<input type="hidden" value="', esc_attr($data['value']), '" class="input" id="', $data['id'], '" name="', $data['name'], '" />';

    echo '</div>';

  }
}