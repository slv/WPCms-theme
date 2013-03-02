<?php

Class WPCmsPostType {

  function __construct ($post_type, $custom_fields = array(), $adminBarParent = false) {

    $this->post_type = $post_type;
    $this->custom_fields = $custom_fields;

    $labels = array(
      'name' => __('Custom Items'),
      'singular_name' => __('Custom Item'),
      'add_new' => __('Add New'),
      'add_new_item' => __('Add New Item'),
      'edit_item' => __('Edit Item'),
      'new_item' => __('New Item'),
      'view_item' => __('View Item'),
      'search_items' => __('Search Items'),
      'not_found' =>  __('No items found'),
      'not_found_in_trash' => __('No items found in Trash'),
      'parent_item_colon' => '',
      'menu_name' => __('Custom Items')
    );

    $args = array(
      'public' => true,
      'exclude_from_search' => false,
      'publicly_queryable' => true,
      'show_ui' => true,
      'query_var' => true,
      'has_archive' => true,
      'show_in_menu' => true,
      'capability_type' => 'post',
      'map_meta_cap' => true,
      'hierarchical' => false,
      'menu_position' => null,
      'taxonomies' => array(),
      'supports' => array(
        'title',
        'editor',
        'thumbnail',
        'revisions'
      )
    );

    $args['labels'] = $labels;
    $this->args = $args;

    return $this;
  }

  function register () {

    add_action('after_setup_theme', array($this, 'after_setup_theme'));
    add_action('init', array($this, 'add_posttype'));

    return $this;
  }

  function setArgs ($args = array()) {

    $labels = $this->args['labels'];
    $this->args = array_merge($this->args, $args);
    $this->args['labels'] = $labels;

    return $this;
  }

  function setLabels ($labels = array()) {

    $this->args['labels'] = array_merge($this->args['labels'], $labels);

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

    foreach ($this->custom_fields as $id => $field) {
      $field = array_merge(array(
        'title' => 'Custom Fields',
        'context' => 'normal',
        'priority' => 'high'), $field);

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

  function render_meta_box ($post, $args)
  {
    foreach ($this->custom_fields[$args['id']]['fields'] as $field) {

      $field->render($post);
    }
  }

  function admin_post_page_js ($hook) {

    if ($hook == 'post.php' || $hook == 'post-new.php') {
      wp_register_script('wpcms-custompost', get_template_directory_uri() . '/WPCms/assets/custom.post.js', 'jquery');
      wp_enqueue_script('wpcms-custompost');
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