<?php

Class WPCmsSelectField Extends WPCmsField {

  function __construct ($id, $name = '', $description = '', $options = array(), $default = '') {
    $this->id = WPCmsStatus::getStatus()->getData('pre') . $this->normalize($id);
    $this->name = $name;
    $this->description = $description;
    $this->options = $options;
    $this->default = $default;

    return $this;
  }

  public function renderInnerInput ($post, $data = array()) {
    echo '<select type="text" name="', $data['name'], '" id="', $data['id'], '">';

    if ($data['value'] == '' && !isset($this->options[$default]))
      echo '<option value="">', __('Select', WPCmsStatus::getStatus()->getData('textdomain')),'...</option>';

    foreach ($this->options as $value => $label) {
      $selected = ($value == $data['value'] ? ' selected="selected"' : '');

      echo '<option ', $selected,' value="', esc_attr($value), '">', htmlentities($label), '</option>';
    }

    echo '</select>';
  }

}