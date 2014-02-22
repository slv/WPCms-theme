<?php

Class WPCmsRelationField Extends WPCmsField {

  function __construct ($config)
  {
    $this->id = WPCmsStatus::getStatus()->getData('pre') . $this->normalize($config['id']);
    $this->inverse = $this->normalize($config['inverse']);
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

  public function save ($postID, $suffix = '') {

    $field_name = $this->id . $suffix;
    if ($this->inverse) $inverse = WPCmsStatus::getStatus()->getData('pre') . $this->inverse . $suffix;
    else $inverse = $field_name . '__related_as';

    $old = get_post_meta($postID, $field_name, true);
    $new = isset($_POST[$field_name]) ? $_POST[$field_name] : false;


    if ($new && $new != $old) {

      if (get_magic_quotes_gpc()) $new = stripslashes($new);

      update_post_meta($postID, $field_name, $new);

      // Related inverse
      $newValues = explode(',', (string)$new);
      $oldValues = explode(',', (string)$old);

      // Fix revisions...
      if ($post = wp_get_post_revision($postID))
        $postID = $post->post_parent;

      if (is_array($oldValues)) {
        foreach ($oldValues as $key => $relatedID) {
          $relatedOld = get_post_meta($relatedID, $inverse, true);
          $relatedOldValues = explode(',', (string)$relatedOld);

          if (in_array($postID, $relatedOldValues)) {
            foreach (array_keys($relatedOldValues, $postID) as $key) {
              unset($relatedOldValues[$key]);
            }
            update_post_meta($relatedID, $inverse, trim(implode(',', $relatedOldValues), ','));
          }
        }
      }

      if (is_array($newValues)) {
        foreach ($newValues as $key => $relatedID) {
          $relatedNew = get_post_meta($relatedID, $inverse, true);
          $relatedNewValues = explode(',', (string)$relatedNew);

          if (!in_array($postID, $relatedNewValues)) {
            $relatedNewValues[] = $postID;
            update_post_meta($relatedID, $inverse, trim(implode(',', $relatedNewValues), ','));
          }
        }
      }
    }
    elseif ('' == $new && $old) {

      delete_post_meta($postID, $field_name, $old);

      $oldValues = explode(',', (string)$old);

      // Fix revisions...
      if ($post = wp_get_post_revision($postID))
        $postID = $post->post_parent;

      if (is_array($oldValues)) {
        foreach ($oldValues as $key => $relatedID) {
          $relatedOld = get_post_meta($relatedID, $inverse, true);
          $relatedOldValues = explode(',', (string)$relatedOld);

          if (in_array($postID, $relatedOldValues)) {
            foreach (array_keys($relatedOldValues, $postID) as $key) {
              unset($relatedOldValues[$key]);
            }
            update_post_meta($relatedID, $inverse, trim(implode(',', $relatedOldValues), ','));
          }
        }
      }
    }
  }

}