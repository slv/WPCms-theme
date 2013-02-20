<?php

Class WPCmsSeparatorField Extends WPCmsField {

  public function renderInnerInput ($post, $data = array()) {
    echo '<h2>' . $this->name . '</h2>';
    if ($this->description != '') {
      echo '<p>' . $this->description . '</d>';
    }
  }

  public function render ($post) {

    echo '<table class="form-table">',
      '<tr valign="middle">',
        '<td colspan="2" style="background:#eeeeee;border-top:1px solid #b0b0b0;">';

    $this->renderInnerInput(null);

    echo '</td>',
        '</tr>',
      '</table>';
  }

//
// Get The Value
//

  public function value ($postID, $suffix = '') {}
  public function save ($postID, $suffix = '') {}
  public function handleRevision ($postID, $suffix = '') {}
  public function handleRestoreRevision ($postID, $revisionID, $suffix = '') {}

  public function revisionFields ($fields, $suffix = '') {
    return $fields;
  }

  public function addRevisionFilter ($suffix = '') {}
  public function thisRevisionField ($value, $field, $metadataType = 'default') {}

//
// Settings Page
//

  public function settingValue ($suffix = '') {}
  public function registerSettingInOptionsGroup ($optionsGroup) {}

  public function sanitizeSetting ($data) {
    return $data;
  }

  public function renderSetting () {

    $this->willRenderSetting();
    $this->renderInnerInput(null);
    $this->didRenderSetting();
  }

  public function willRenderSetting () {
    echo '<table class="form-table wpcms-field ', $this->hyphenizeFromCamelCase(get_class($this)), '">',
      '<tr valign="middle">',
    '<td colspan="2" style="background:#eeeeee;border-top:1px solid #b0b0b0;">';
  }

  public function renderSettingLabel () {}
  public function renderSettingInput () {}

  public function didRenderSetting () {
    echo '</td>',
      '</tr>',
    '</table>';
  }

};