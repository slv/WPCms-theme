<?php

Abstract Class WPCmsField {

  abstract protected function renderInnerInput ($post, $data = array());

  function __construct ($id, $name = '', $description = '', $default = '') {
    $this->id = WPCmsStatus::getStatus()->getData('pre') . $this->normalize($id);
    $this->name = $name;
    $this->description = $description;
    $this->default = $default;

    return $this;
  }

  public function normalize ($str) {
    return preg_replace(array("/(\s+)/", "/([^a-zA-Z0-9_]*)/", "/(_+)/"), array("_", "", "_"), $str);
  }

  public function hyphenizeFromCamelCase ($str) {
    $str = strtolower(preg_replace("/([A-Z]+)/", "-$1", $str));
    return preg_replace("/([^A-Za-z-]+)/", "", trim($str, "-"));
  }

  public function addActionAdminEnqueueScripts ($hook) {}

  /*
    Render Field in Backend
  */

  public function willRender ($post) {
    echo '<table class="form-table wpcms-field ', $this->hyphenizeFromCamelCase(get_class($this)), '">',
      '<tr style="border-top:1px solid #eeeeee;">';
  }

  public function renderLabel ($post) {
    echo '<th style="width:25%">',
      '<label for="', $this->id, '">',
        '<strong>', $this->name, '</strong>',
        '<span style=" display:block; color:#999; margin:5px 0 0 0; line-height: 18px;">', $this->description, '</span>',
      '</label>',
      '</th>';
  }

  public function renderInput ($post, $data = array()) {
    echo '<td style="width:75%">';

    $data = array(
      'id' => isset($data['id']) ? $data['id'] : $this->id,
      'name' => isset($data['name']) ? $data['name'] : $this->id,
      'value' => isset($data['value']) ? $data['value'] : $this->value($post->ID)
    );
    $this->renderInnerInput($post, $data);

    echo '</td>';
  }

  public function didRender ($post) {
    echo '</tr>',
      '</table>';
  }

  public function render ($post) {

    $this->willRender($post);

    $this->renderLabel($post);
    $this->renderInput($post);

    $this->didRender($post);
  }

  /*
    Get The Value
  */

  public function value ($postID, $suffix = '') {

    $field_name = $this->id . $suffix;

    $meta = get_post_meta($postID, $field_name, true);

    if ($meta)
      return $meta;

    if (is_array($this->default))
    {
      if (isset($this->default[trim($suffix, "_")]))
        $meta = $this->default[trim($suffix, "_")];
      else
        $meta = '';
    }
    elseif (isset($this->default))
    {
      $meta = $this->default;
    }
    else
    {

      $meta = '';
    }

    return htmlspecialchars($meta, ENT_QUOTES);
  }

  public function save ($postID, $suffix = '') {

    if (defined('LOG_ALL')) file_put_contents(get_template_directory() . '/../../uploads/log.txt', $this->id . ' / ' . print_r($_POST, true), FILE_APPEND);

    $field_name = $this->id . $suffix;

    $old = get_post_meta($postID, $field_name, true);
    $new = $_POST[$field_name];

    if ($new && $new != $old) {

      update_post_meta($postID, $field_name, htmlspecialchars($new));
    }
    elseif ('' == $new && $old) {

      delete_post_meta($postID, $field_name, $old);
    }
  }

/*
  Revisions
*/


  public function handleRevision ($postID, $suffix = '') {

    $field_name = $this->id . $suffix;

    if ($idParent = wp_is_post_revision($postID)) {
      $parent  = get_post($idParent);
      $oldValue = get_post_meta($parent->ID, $field_name, true);

      if ($oldValue) {
        add_metadata('post', $postID, $field_name, $oldValue);
      }
    }
  }
  public function handleRestoreRevision ($postID, $revisionID, $suffix = '') {

    $field_name = $this->id . $suffix;

    $meta = get_metadata('post', $revisionID, $field_name, true);
    if ($meta)
      update_post_meta($postID, $field_name, $meta);
    else
      delete_post_meta($postID, $field_name);
  }

  public function revisionFields ($fields, $suffix = '') {

    $field_name = $this->id . $suffix;

    $fields[$field_name] = $this->name;
    return $fields;
  }

  public function addRevisionFilter ($suffix = '') {

    $field_name = $this->id . $suffix;

    add_filter( '_wp_post_revision_field_' . $field_name, array($this, 'thisRevisionField'), 10, 2 );
  }

  public function thisRevisionField ($value, $field, $metadataType = 'default') {


    if (isset($_GET['revision'])) {
      return get_metadata('post', ceil($_GET['revision']), $field, true);
    }

    if (!isset($this->alreadyCheckedMeta)) $this->alreadyCheckedMeta = array();
    $leftID = ceil($_GET['left']);
    $rightID = ceil($_GET['right']);

    if (in_array($field, $this->alreadyCheckedMeta)) {
      return get_metadata('post', $rightID, $field, true );
    }
    else {
      $this->alreadyCheckedMeta[] = $field;
      return get_metadata('post', $leftID, $field, true );
    }
  }

/*
  Settings Page
*/
  public function settingValue ($suffix = '') {

    $field_name = $this->id . $suffix;

    $option = get_option($field_name, $this->default);

    return $option;
  }

  public function registerSettingInOptionsGroup ($optionsGroup, $suffix = '') {

    register_setting(
      $optionsGroup,
      $this->id . $suffix,
      array($this, 'sanitizeSetting')
    );
  }

  public function sanitizeSetting ($data) {
    return $data;
  }


  public function renderSetting () {

    $this->willRenderSetting();

    $this->renderSettingLabel();
    $this->renderSettingInput();

    $this->didRenderSetting();

  }

  public function willRenderSetting () {
    echo '<table class="form-table wpcms-field ', $this->hyphenizeFromCamelCase(get_class($this)), '">',
      '<tr valign="top">';
  }

  public function renderSettingLabel () {
    echo '<th scope="row">' . $this->name . '</th>';
  }

  public function renderSettingInput () {

    echo '<td>';
    $this->renderInnerInput(null, array(
      'id' => $this->id,
      'name' => $this->id,
      'value' => $this->settingValue()
    ));
    echo '</td>';
  }


  public function didRenderSetting () {
    echo '</tr>',
      '</table>';
  }

};