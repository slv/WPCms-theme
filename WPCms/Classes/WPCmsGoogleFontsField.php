<?php

Class WPCmsGoogleFontsField Extends WPCmsField {

  function __construct ($id, $name = '', $description = '', $default = '') {
    $this->id = WPCmsStatus::getStatus()->getData('pre') . $this->normalize($id);
    $this->name = $name;
    $this->description = $description;
    $this->default = $default;

    return $this;
  }

  public function addActionAdminEnqueueScripts ($hook)
  {
    wp_enqueue_script('wpcms-googlefonts', get_template_directory_uri() . '/WPCms/assets/google-fonts.js', array('jquery'));
  }

  public function renderInnerInput ($post, $data = array()) {

    // List from: https://developers.google.com/apis-explorer/#p/webfonts/v1/webfonts.webfonts.list?sort=trending&_h=1&

    echo '<div class="field-wrapper">';
    echo '<p class="demo">', ($data['value'] != '' ? $data['value'] : 'Font: ' . __('Default')), '</p>';

    echo '<select type="text" name="', $data['name'], '" id="', $data['id'], '">';

    if ($data['value'] == '' && !isset($this->options[$this->default]))
      echo '<option value="">', __('Select'),'...</option>';

    $fonts = file_get_contents(__DIR__ . '/../assets/google.fonts.list');
    $fonts = explode(PHP_EOL, $fonts);

    foreach ($fonts as $font) {

      $selected = ($font == $data['value'] ? ' selected="selected"' : '');
      echo '<option ', $selected,' value="', $font, '">', $font, '</option>';
    }

    echo '</select>';
    echo '</div>';
  }
}