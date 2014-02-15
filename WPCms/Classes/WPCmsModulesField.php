<?php

Class WPCmsModulesField Extends WPCmsField {

  function __construct ($config)
  {
    $this->id = WPCmsStatus::getStatus()->getData('pre') . $this->normalize($config['id']);
    $this->name = isset($config['name']) ? $config['name'] : '';
    $this->description = isset($config['description']) ? $config['description'] : '';
    $this->default = isset($config['default']) ? $config['default'] : '';
    $this->modules = isset($config['modules']) ? $config['modules'] : array();

    if (is_array($this->modules)) foreach ($this->modules as $module) {
      $module['fields'] = require get_template_directory() . "/Modules/" . $module['type'] . "/admin.php";

      if (is_array($module['fields'])) foreach ($module['fields'] as $field) {
        $field->id = preg_replace("/^" . WPCmsStatus::getStatus()->getData('pre') . "/", "", $field->id);
      }
    }

    return $this;
  }

  public function addActionAdminEnqueueScripts ($hook)
  {
    wp_enqueue_script('wpcms-modules', WPCMS_STYLESHEET_URI . '/WPCms/assets/modules.field.js', array('jquery', 'jquery-ui-core', 'jquery-ui-droppable'));
    wp_enqueue_style('wpcms-modules', WPCMS_STYLESHEET_URI . '/WPCms/assets/modules.field.css');

    foreach ($this->modules as $module) {
      $fields = require get_template_directory() . "/Modules/" . $module['type'] . "/admin.php";
      foreach ($fields as $field) {
        $field->addActionAdminEnqueueScripts($hook);
      }
    }

  }

  public function renderLabel ($post) {
  }

  public function renderInput ($post, $data = array()) {
    echo '<td style="width:100%">';

    $data = array(
      'id' => isset($data['id']) ? $data['id'] : $this->id,
      'name' => isset($data['name']) ? $data['name'] : $this->id,
      'value' => isset($data['value']) ? $data['value'] : $this->value($post->ID)
    );
    $this->renderInnerInput($post, $data);

    echo '</td>';
  }

  public function renderInnerInput ($post, $data = array())
  {
    $modules_cache = array();
    foreach ($this->modules as $module) {
      $modules_cache[$module['type']] = $module;
    }

    echo '<div class="modules-field" id="', $data['id'], '">';

    echo '<div class="modules-list-droppable" id="', $data['id'], '_droppable">';

    if (is_array($data['value'])) {
      foreach ($data['value'] as $order => $module_data) {
        if (!isset($modules_cache[$module_data['widget_type']])) continue;

        $module = $modules_cache[$module_data['widget_type']];

        echo '<div class="module"><a>', $module['name'], '</a><div class="module-inside"><h3>Inside of ', $module['name'], '</h3><div class="module-remove">remove</div><div class="form">
          <input type="hidden" id="', $data['id'], '____[widget_type]" value="', $module['type'], '" />';

        $module['fields'] = require get_template_directory() . "/Modules/" . $module['type'] . "/admin.php";
        foreach ($module['fields'] as $field) {
          $field_data = array(
            'id' => isset($field->id) ? $data['id'] . '____[' . $field->id . ']' : '',
            'name' => isset($field->id) ? $field->id : '',
            'value' => isset($module_data[$field->id]) ? $module_data[$field->id] : ''
          );

          $field->willRender($post);

          $field->renderLabel($post);
          $field->renderInput($post, $field_data);

          $field->didRender($post);

        }

        echo '</div></div></div>';

      }
    }

    echo '</div>';
    echo '<hr />';
    echo '<div class="modules-list" id="', $data['id'], '_wrapper">';

    foreach ($this->modules as $module) {
      echo '<div class="module"><a>', $module['name'], '</a><div class="module-inside"><h3>Inside of ', $module['name'], '</h3><div class="module-remove">remove</div><div class="form">
        <input type="hidden" id="', $data['id'], '____[widget_type]" value="', $module['type'], '" />';

        $module['fields'] = require get_template_directory() . "/Modules/" . $module['type'] . "/admin.php";
        foreach ($module['fields'] as $field) {
          $field_data = array(
            'id' => isset($field->id) ? $data['id'] . '____[' . $field->id . ']' : '',
            'name' => '',
            'value' => isset($field->default) ? $field->default : ''
          );

          $field->willRender($post);

          $field->renderLabel($post);
          $field->renderInput($post, $field_data);

          $field->didRender($post);

        }

      echo '</div></div></div>';
    }

    echo '</div>';
    echo '</div>';

  }
}