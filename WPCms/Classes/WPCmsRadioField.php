<?php

Class WPCmsRadioField Extends WPCmsField {

  function __construct ($config) {
    $this->id = WPCmsStatus::getStatus()->getData('pre') . $this->normalize($config['id']);
    $this->name = isset($config['name']) ? $config['name'] : '';
    $this->description = isset($config['description']) ? $config['description'] : '';
    $this->options = isset($config['options']) ? $config['options'] : array();
    $this->default = isset($config['default']) ? $config['default'] : '';
    $this->fieldsRelation = isset($config['relations']) ? $config['relations'] : array();

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
      echo '<p><label><input', $selected, $dataRelated, ' type="radio" name="', $data['name'],'" value="', esc_attr($value), '" /> ', $label,'</label></p>';
    }

    echo '</fieldset>';
  }
}