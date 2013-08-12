<?php

Class WPCmsMultilanguageField {

  function __construct ($field, $languages = null) {
    $this->field = $field;

    if (is_null($languages))
      $languages = WPCmsStatus::getStatus()->getData('languages');
    if (is_null($languages) || !is_array($languages))
      die('Cannot Instantiate ' . __CLASS__ . ' without setting languages in constructor or in WPCmsStatus...');

    $languages = array_map(array($this, "normalize"), $languages);

    $this->languages = $languages;

    $this->id = $this->field->id;
    $this->name = $this->field->name;
    $this->description = $this->field->description;

    return $this;
  }

  public function normalize ($str) {
    return preg_replace(array("/(\s+)/", "/([^a-zA-Z0-9_]*)/", "/(_+)/"), array("_", "", "_"), $str);
  }

  public function addActionAdminEnqueueScripts ($hook) {
    wp_enqueue_script('wpcms-multilanguage', WPCMS_STYLESHEET_URI . '/WPCms/assets/multilanguage.js', array('jquery'));
    $this->field->addActionAdminEnqueueScripts($hook);
  }

  public function render ($post) {

    $meta = $this->value($post->ID);

    $this->field->willRender($post);
    $this->field->renderLabel($post);

    echo '<td style="width:75%">',
      '<div class="wpcms-multilingual-field"><div>',
        '<div style="text-align:right;padding:3px;">';

    foreach ($this->languages as $k => $lang) {
      echo '<a class="multilingual-switcher ord-', $k, ' lang-', $lang, ' button-secondary" style="margin-right:5px;">', $lang, '</a>';
    }

    echo '</div>';


    foreach ($this->languages as $k => $lang) {

      $data = array(
        'id' => $this->field->id . '__' . $lang,
        'name' => $this->field->id . '__' . $lang,
        'value' => $meta[$lang]
      );

      echo '<div class="multilingual-wrapper ord-', $k, ' lang-', $lang, '">';

      $this->field->renderInnerInput($post, $data);

      echo '</div>';
    }

    echo '</td>';

    $this->field->didRender($post);
  }

  public function value ($postID) {

    $out = array();
    foreach ($this->languages as $lang) {

      $out[$lang] = $this->field->value($postID, '__' . $lang);
    }
    return $out;
  }

  public function save ($postID) {

    foreach ($this->languages as $lang) {

      $this->field->save($postID, '__' . $lang);
    }
  }

  public function handleRevision ($postID) {

    foreach ($this->languages as $lang) {

      $this->field->handleRevision($postID, '__' . $lang);
    }
  }

  public function handleRestoreRevision ($postID, $revisionID, $suffix = '') {

    foreach ($this->languages as $lang) {

      $this->field->handleRestoreRevision($postID, $revisionID, '__' . $lang);
    }
  }

  public function revisionFields ($fields) {

    foreach ($this->languages as $lang) {

      $fields[$this->id . '__' . $lang] = $this->name . " [$lang]";
    }
    return $fields;
  }

  public function addRevisionFilter ($suffix = '') {

    foreach ($this->languages as $lang) {

      $this->field->addRevisionFilter('__' . $lang);
    }
  }

//
// Settings Page
//

  public function settingValue ($suffix = '') {

    $out = array();
    foreach ($this->languages as $lang) {

      $out[$lang] = $this->field->settingValue('__' . $lang);
    }
    return $out;
  }

  public function registerSettingInOptionsGroup ($optionsGroup) {

    foreach ($this->languages as $lang) {

      $this->field->registerSettingInOptionsGroup ($optionsGroup, '__' . $lang);
    }
  }

  public function renderSetting () {

    $option = $this->settingValue();

    $this->field->willRenderSetting();
    $this->field->renderSettingLabel();

    echo '<td style="width:75%">',
      '<div class="wpcms-multilingual-field"><div>',
        '<div style="text-align:right;padding:3px;">';

    foreach ($this->languages as $k => $lang) {
      echo '<a class="multilingual-switcher ord-', $k, ' lang-', $lang, ' button-secondary" style="margin-right:5px;">', $lang, '</a>';
    }

    echo '</div>';


    foreach ($this->languages as $k => $lang) {

      $data = array(
        'id' => $this->field->id . '__' . $lang,
        'name' => $this->field->id . '__' . $lang,
        'value' => $option[$lang]
      );

      echo '<div class="multilingual-wrapper ord-', $k, ' lang-', $lang, '" style="background:#ffffff;">';

      $this->field->renderInnerInput(null, $data);

      echo '</div>';
    }

    echo '</td>';

    $this->field->didRenderSetting();
  }
}