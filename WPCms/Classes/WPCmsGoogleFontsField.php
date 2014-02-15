<?php

Class WPCmsGoogleFontsField Extends WPCmsField {

  function __construct ($config) {
    $this->id = WPCmsStatus::getStatus()->getData('pre') . $this->normalize($config['id']);
    $this->name = isset($config['name']) ? $config['name'] : '';
    $this->description = isset($config['description']) ? $config['description'] : '';
    $this->default = isset($config['default']) ? $config['default'] : '';
    $this->fontSize = isset($config['font_size']) ? $config['font_size'] : 16;

    return $this;
  }

  static function printGoogleFontsStyles ($fontsSelectors)
  {
    $elements = array();
    $families = array();

    foreach ($fontsSelectors as $selector => $font) {
      if (in_array($font, $elements)) continue;

      $elements[] = $font;
      $f = array_shift(explode(':', $font));

      if (isset($families[$f])) $families[$f] .= ',' . array_pop(explode(':', $font));
      else $families[$f] = $font;
    }


    echo "<link href='http://fonts.googleapis.com/css?family=" . str_replace(" ", "+", implode('|', $families)) . "' rel='stylesheet' type='text/css'>" . PHP_EOL .
      "<style type=\"text/css\">" . PHP_EOL;


    foreach ($fontsSelectors as $selector => $font) {

      echo $selector . "{ font-family: '" . array_shift(explode(':', $font)) . "'; font-weight:" .
        preg_replace(array("/^(regular|italic)$/", "/^(\d*)(italic)$/"), array("400", "$1"), array_pop(explode(':', $font))) .
        "; font-style:" .
        (preg_replace(array("/^(\d*)(.*)/", "/regular/"), array("$2", "normal"), array_pop(explode(':', $font))) ?
        preg_replace(array("/^(\d*)(.*)/", "/regular/"), array("$2", "normal"), array_pop(explode(':', $font))) : 'normal') .
        "; }" . PHP_EOL;
    }

    echo "</style>";
  }

  public function addActionAdminEnqueueScripts ($hook)
  {
    wp_enqueue_script('wpcms-googlefonts-lib', '//ajax.googleapis.com/ajax/libs/webfont/1/webfont.js');
    wp_enqueue_script('wpcms-googlefonts', WPCMS_STYLESHEET_URI . '/WPCms/assets/google.fonts.js', array('jquery'));
  }

  public function renderInnerInput ($post, $data = array()) {

    // List from: https://developers.google.com/apis-explorer/#p/webfonts/v1/webfonts.webfonts.list?sort=trending&_h=1&
    // $fonts = json_decode(file_get_contents(..google api response..), true);
    // foreach ($fonts['items'] as $key => $value) { foreach ($value['variants'] as $variant) { echo $value['family'] . ':' . $variant . PHP_EOL; }}

    echo '<div class="field-wrapper">';
    echo '<select type="text" name="', $data['name'], '" id="', $data['id'], '">';

    if ($data['value'] == '' && !isset($this->options[$this->default]))
      echo '<option value="">', __('Select', WPCmsStatus::getStatus()->getData('textdomain')),'...</option>';

    $fonts = file_get_contents(WPCMS_STYLESHEET_DIR . '/WPCms/assets/google.fonts.list.20140215');
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
      echo '<option ', $selected,' value="', esc_attr($font), '" data-font="', urlencode($families[$f]), '">', $font, '</option>';
    }

    echo '</select>';

    echo '<p style="display:inline;margin:0px 10px;" class="demo" data-fontsize="', $this->fontSize, '">', ($data['value'] != '' ? $data['value'] : 'Font: ' . __('Default', WPCmsStatus::getStatus()->getData('textdomain'))), '</p>';
    echo '</div>';
  }
}