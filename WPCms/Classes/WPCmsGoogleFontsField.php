<?php

Class WPCmsGoogleFontsField Extends WPCmsField {

  function __construct ($id, $name = '', $description = '', $default = '') {
    $this->id = WPCmsStatus::getStatus()->getData('pre') . $this->normalize($id);
    $this->name = $name;
    $this->description = $description;
    $this->default = $default;

    return $this;
  }

  static function printGoogleFontsLink ($font, $cssSelector = 'body')
  {
    echo "<link href='http://fonts.googleapis.com/css?family=" . $font . "' rel='stylesheet' type='text/css'>" . PHP_EOL .
    "<style type=\"text/css\">" . $cssSelector . "{ font-family: '" .
    array_shift(explode(':', _o('main_font'))) .
    "'; font-weight:" .
    preg_replace(array("/^(regular|italic)$/", "/^(\d*)(italic)$/"), array("400", "$1"), array_pop(explode(':', _o('main_font')))) .
    "; font-style:" .
    preg_replace(array("/^(\d*)(.*)/", "/regular/"), array("$2", "normal"), array_pop(explode(':', _o('main_font')))) .
    "; }</style>" . PHP_EOL;
  }

  public function addActionAdminEnqueueScripts ($hook)
  {
    wp_enqueue_script('wpcms-googlefonts', get_template_directory_uri() . '/WPCms/assets/google.fonts.js', array('jquery'));
  }

  public function renderInnerInput ($post, $data = array()) {

    // List from: https://developers.google.com/apis-explorer/#p/webfonts/v1/webfonts.webfonts.list?sort=trending&_h=1&
    // $fonts = json_decode(file_get_contents(..google api response..), true);
    // foreach ($fonts['items'] as $key => $value) { foreach ($value['variants'] as $variant) { echo $value['family'] . ':' . $variant . PHP_EOL; }}

    echo '<div class="field-wrapper">';
    echo '<p class="demo">', ($data['value'] != '' ? $data['value'] : 'Font: ' . __('Default')), '</p>';

    echo '<select type="text" name="', $data['name'], '" id="', $data['id'], '">';

    if ($data['value'] == '' && !isset($this->options[$this->default]))
      echo '<option value="">', __('Select'),'...</option>';

    $fonts = file_get_contents(__DIR__ . '/../assets/google.fonts.list');
    $fonts = explode(PHP_EOL, $fonts);
    $families = array();

    foreach ($fonts as $font) {

      $f = array_shift(explode(':', $font));

      if (isset($families[$f])) $families[$f] .= ',' . array_pop(explode(':', $font));
      else $families[$f] = $font;
    }

    foreach ($fonts as $font) {

      $f = array_shift(explode(':', $font));

      $selected = ($font == $data['value'] ? ' selected="selected"' : '');
      echo '<option ', $selected,' value="', $font, '" data-font="', urlencode($families[$f]), '">', $font, '</option>';
    }

    echo '</select>';
    echo '</div>';
  }
}