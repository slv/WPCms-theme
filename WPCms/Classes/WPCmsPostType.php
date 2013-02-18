<?php

Class WPCmsPostType {

  function __construct ($post_type, $args, $custom_fields = array(), $adminBarParent = false) {

    $this->post_type = $post_type;

    $this->theme_hash = defined('THEME_HASH') ? THEME_HASH : '';
    $this->custom_fields = $custom_fields;
    $labels = $args['labels'];

    if (is_array($labels)) {

      $labels = array(
        'name' => __(isset($labels['name']) ? $labels['name'] : 'Custom Items', $this->theme_hash),
        'singular_name' => __(isset($labels['singular_name']) ? $labels['singular_name'] : 'Custom Item', $this->theme_hash),
        'add_new' => __(isset($labels['add_new']) ? $labels['add_new'] : 'Add New', $this->theme_hash),
        'add_new_item' => __(isset($labels['add_new_item']) ? $labels['add_new_item'] : 'Add New Item', $this->theme_hash),
        'edit_item' => __(isset($labels['edit_item']) ? $labels['edit_item'] : 'Edit Item', $this->theme_hash),
        'new_item' => __(isset($labels['new_item']) ? $labels['new_item'] : 'New Item', $this->theme_hash),
        'view_item' => __(isset($labels['view_item']) ? $labels['view_item'] : 'View Item', $this->theme_hash),
        'search_items' => __(isset($labels['search_items']) ? $labels['search_items'] : 'Search Item', $this->theme_hash),
        'not_found' =>  __(isset($labels['not_found']) ? $labels['not_found'] : 'No item found', $this->theme_hash),
        'not_found_in_trash' => __(isset($labels['not_found_in_trash']) ? $labels['not_found_in_trash'] : 'No items found in Trash', $this->theme_hash),
        'parent_item_colon' => isset($labels['menu_name']) ? $labels['menu_name'] : '',
        'menu_name' => __(isset($labels['menu_name']) ? $labels['menu_name'] : 'Custom Items', $this->theme_hash)
      );
    }
    else {
      return false;
    }

    if (is_array($args)) {

      $args['labels'] = $labels;
      $this->args = $args;
    }
    else {
      return false;
    }

    add_action('after_setup_theme', array($this, 'after_setup_theme'));

    add_action('init', array($this, 'add_posttype'));

    return $this;
  }


  function after_setup_theme () {
    if (in_array('thumbnail', $this->args['supports'])) {

      $thumbnails_support = get_theme_support('post-thumbnails');

      if (is_array($thumbnails_support)) {
        $thumbnails_support = array_shift($thumbnails_support);
      }

      if ($thumbnails_support) {
        if (is_array($thumbnails_support)) {
          $thumbnails_support[] = $this->post_type;
        }
        else {
          $thumbnails_support = array($thumbnails_support, $this->post_type);
        }
      }
      else {
        $thumbnails_support = array($this->post_type);
      }

      add_theme_support('post-thumbnails', $thumbnails_support);
    }
  }

  function admin_enqueue_scripts ($hook) {

    global $post_type;
    if ($post_type != $this->post_type) return;

    $this->admin_post_page_js($hook);

    foreach ($this->custom_fields as $custom_field) {

      foreach ($custom_field['fields'] as $field) {

        $field->addActionAdminEnqueueScripts($hook);
      }
    }
  }

  function add_posttype () {

    if (!in_array($this->post_type, array('post', 'page', 'attachment', 'revision', 'nav_menu_item'))) {

      register_post_type($this->post_type, $this->args);
    }

    add_action('save_post', array($this, 'custom_fields_save'));

    add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
    add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'), 10, 1);

    add_action('wp_restore_post_revision', array($this, 'handle_restore_revision'), 10, 2 );
    add_filter('_wp_post_revision_fields', array($this, 'post_revision_fields'), 10, 1);

    $this->add_filter_for_revisions();
  }

  function custom_fields_save ($idPost) {

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
      return $idPost;
    }

    if (!current_user_can('edit_post', $idPost)) {
      return $idPost;
    }
    elseif (!isset($_POST['post_type']) || $_POST['post_type'] != $this->post_type) {
      return $idPost;
    }
    elseif ($_POST['action'] == 'inline-save') {
      return $idPost;
    }

    foreach ($this->custom_fields as $custom_field) {

      foreach ($custom_field['fields'] as $field) {

        $field->handleRevision($idPost);
        $field->save($idPost);
      }
    }
  }

  function add_meta_boxes () {

    if (in_array('postId', $this->args['supports'])) {
      add_meta_box(
        'custom-render-post-id',
        'Post ID',
        array($this, 'render_post_ID'),
        $this->post_type,
        'normal',
        'high'
      );
    }
    if (in_array('media', $this->args['supports'])) {
      add_meta_box(
        'custom-media-upload',
        'Media Upload',
        array($this, 'render_media_upload'),
        $this->post_type,
        'normal',
        'high'
      );
      wp_enqueue_script('media-upload');
      wp_enqueue_script('thickbox');
      wp_enqueue_style('thickbox');
    }
    foreach ($this->custom_fields as $id => $field) {
      add_meta_box(
        $id,
        $field['title'],
        array($this, 'render_meta_box'),
        $this->post_type,
        $field['context'],
        $field['priority'],
        array('id' => $id)
      );
    }
  }

  function render_post_ID ($post) {
    echo '<table class="form-table">',
        '<tr style="border-top:1px solid #eeeeee;">',
          '<th style="width:25%">',
          '<label>',
            '<strong>Post ID & URL</strong>',
            '<span style=" display:block; color:#999; margin:5px 0 0 0; line-height: 18px;"></span>',
          '</label>',
          '</th>',
          '<td style="width:10%">',
            '<input type="text" size="5" value="', $post->ID, '" />',
          '</td>',
          '<td style="width:65%">',
            the_permalink($post->ID),
          '</td>',
        '</tr>',
      '</table>';
  }

  function render_meta_box ($post, $args)
  {
    foreach ($this->custom_fields[$args['id']]['fields'] as $field) {

      $field->render($post);
    }
  }

  function render_media_upload ($post) {
    echo '<table class="form-table">',
        '<tr style="border-top:1px solid #eeeeee;">',
          '<th style="width:25%">',
          '<label>',
            '<strong>Media Upload</strong>',
            '<span style=" display:block; color:#999; margin:5px 0 0 0; line-height: 18px;"></span>',
          '</label>',
          '</th>',
          '<td style="width:75%">',
            '<a href="' . admin_url() . 'media-upload.php?post_id=' . $post->ID . '&tab=gallery&TB_iframe=1&width=640&height=919" class="thickbox add_media" id="content-add_media" title="Add Media" onclick="set_send(\'#media-gallery-cont' . $post->ID . '\'); return false;">Upload/Insert <img src="' . admin_url() . 'images/media-button.png" width="15" height="15"></a>',
          '</td>',
        '</tr>',
        '<tr>',
          '<td colspan="2" id="media-gallery-cont' . $post->ID . '" style="background:#888;">';

    $attachments = get_posts(array('post_type' => 'attachment', 'orderby' => 'menu_order', 'order' => 'ASC', 'posts_per_page' => -1, 'post_parent' => $post->ID, 'exclude' => get_post_thumbnail_id()));
    if (count($attachments)) foreach ($attachments as $att) {
      if (wp_attachment_is_image($att->ID)) echo wp_get_attachment_image($att->ID, array(100, 100), true, array('style' => 'margin:5px;'));
    }

    echo '</td>',
        '</tr>',
      '</table>';
  }

  function admin_post_page_js ($hook) {

    if ($hook == 'post.php' || $hook == 'post-new.php') {
      wp_register_script('custom-post-admin-javascript', get_template_directory_uri() . '/WPCms/assets/custom.post.js', 'jquery');
      wp_enqueue_script('custom-post-admin-javascript');
      wp_dequeue_script('autosave');
    }
  }

  function post_revision_fields ($fields) {

    if (!$this->is_revision_of_same_type()) return $fields;

    foreach ($this->custom_fields as $custom_field) {

      foreach ($custom_field['fields'] as $field) {

        $fields = $field->revisionFields($fields);
      }
    }
    return $fields;
  }

  function add_filter_for_revisions () {

    if (!$this->is_revision_of_same_type()) return true;

    foreach ($this->custom_fields as $custom_field) {

      foreach ($custom_field['fields'] as $field) {

        $field->addRevisionFilter();
      }
    }
    return true;
  }

  function is_revision_of_same_type () {
    $postType = '';

    if (isset($_GET['revision'])) {
      if ($postID = wp_is_post_revision(ceil($_GET['revision']))) {
        $post = get_post($postID);
        $postType = $post->post_type;
      }
    } elseif (isset($_GET['post_type'])) {
      $postType = $_GET['post_type'];
    }

    return ($postType == $this->post_type);
  }

  function handle_restore_revision ($idPost, $revision_id) {

    $post = get_post($idPost);
    $revision = get_post($revision_id);

    if (!current_user_can('edit_post', $idPost)) {
      return $idPost;
    }
    elseif ($post->post_type != $this->post_type) {
      return $idPost;
    }

    foreach ($this->custom_fields as $custom_field) {

      foreach ($custom_field['fields'] as $field) {

        $field->handleRestoreRevision($idPost, $revision_id);
      }
    }

  }

};