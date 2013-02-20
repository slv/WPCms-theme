<?php

Class WPCmsRadioField Extends WPCmsField {

  function __construct ($id, $name = '', $description = '', $options = array(), $default = '') {
    $this->id = WPCmsStatus::getStatus()->getData('pre') . $this->normalize($id);
    $this->name = $name;
    $this->description = $description;
    $this->options = $options;
    $this->default = $default;

    return $this;
  }

  public function renderInnerInput ($post, $data = array()) {

    echo '<fieldset id="', $data['id'], '">';

    foreach ($this->options as $value => $label) {
      $selected = ($value == $data['value'] ? ' checked="checked"' : '');
      echo '<p><label><input ', $selected, 'type="radio" name="', $data['name'],'" value="', htmlentities($value), '" /> ', htmlentities($label),'</label></p>';
    }

    echo '</fieldset>';
  }
}