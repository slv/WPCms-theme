<?php

Class WPCmsSettingsPage {

  function __construct($title = 'Untitled', $fields = array(), $parentSlug = null) {

    $this->title = $title;
    $this->fields = $fields;
    $this->parentSlug = $parentSlug;
    $this->capabilityType = 'manage_options';

    $this->options_group = $this->hash($this->title);

    add_action('admin_init', array(&$this, 'on_action_admin_init'));
    add_action('admin_menu', array(&$this, 'on_action_admin_menu'));
    add_action('admin_enqueue_scripts', array(&$this, 'admin_enqueue_scripts'), 10, 1);
  }

  public function hash ($str) {
    return md5($str);
  }

  public function normalize ($str) {
    return preg_replace(array("/(\s+)/", "/([^a-zA-Z0-9_]*)/", "/(_+)/"), array("_", "", "_"), $str);
  }

  public function on_action_admin_init() {

    foreach ($this->fields as $k => $field) {

      $field->registerSettingInOptionsGroup($this->hash($this->title));
    }
  }
  function admin_enqueue_scripts ($hook) {

    if ($hook == $this->slug) {

      wp_register_script('custom-post-admin-javascript', get_template_directory_uri() . '/WPCms/assets/custom.post.js', 'jquery');
      wp_enqueue_script('custom-post-admin-javascript');

      foreach ($this->fields as $k => $field) {

        $field->addActionAdminEnqueueScripts($hook);
      }
    }
  }

  public function on_action_admin_menu () {

    if ($this->parentSlug)
    {
      $this->slug = add_submenu_page($this->parentSlug,
        $this->title, $this->title, $this->capabilityType, $this->normalize($this->title), array($this, 'settingsPage')
      );
    }
    else
    {
      $this->slug = add_menu_page(
        $this->title, $this->title, $this->capabilityType, $this->normalize($this->title), array($this, 'settingsPage')
      );
    }
  }

  public function settingsPage () {
    echo '<div class="wrap">',
      '<h2>' . $this->title . '</h2>',
      '<form method="post" action="options.php" enctype="multipart/form-data">';

      settings_fields($this->options_group);
      do_settings_fields($this->options_group, 'options-general.php');

      echo '<table class="form-table">';

      foreach ($this->fields as $k => $field) {

        $field->renderSetting();
      }

      echo '</table>',
        '<p class="submit">',
          '<input type="submit" class="button-primary" value="' . __('Save Changes') . '" />',
        '</p>',
      '</form>',
    '</div>';
  }
}