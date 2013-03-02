<?php

Class WPCmsRadioField Extends WPCmsField {

  function __construct ($id, $name = '', $description = '', $options = array(), $default = '', $fieldsRelation = array()) {
    $this->id = WPCmsStatus::getStatus()->getData('pre') . $this->normalize($id);
    $this->name = $name;
    $this->description = $description;
    $this->options = $options;
    $this->default = $default;
    $this->fieldsRelation = $fieldsRelation;

    return $this;
  }

  public function addActionAdminEnqueueScripts ($hook)
  {
    wp_enqueue_script('wpcms-radio', get_template_directory_uri() . '/WPCms/assets/radio.js', array('jquery'));
  }

  public function renderInnerInput ($post, $data = array()) {

    $relations = count($this->fieldsRelation) ? ' class="wpcms-radio-relation" data-related="' . implode(',', $this->fieldsRelation) . '"' : '';

    echo '<fieldset id="', $data['id'], '"', $relations, '>';

    foreach ($this->options as $value => $label) {
      $selected = ($value == $data['value'] ? ' checked="checked"' : '');
      $dataRelated = (isset($this->fieldsRelation[$value]) ? ' data-related="' . $this->fieldsRelation[$value] . '"' : '');
      echo '<p><label><input', $selected, $dataRelated, ' type="radio" name="', $data['name'],'" value="', htmlentities($value), '" /> ', htmlentities($label),'</label></p>';
    }

    echo '</fieldset>';
  }
}