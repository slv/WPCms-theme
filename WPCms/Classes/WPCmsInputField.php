<?php

Class WPCmsInputField Extends WPCmsField {

  var $height = 30;

  public function renderInnerInput ($post, $data = array()) {
    echo '<input type="text" name="', $data['name'], '" id="', $data['id'], '" value="', htmlentities($data['value']), '" size="30" style="width:100%; margin-right: 20px; float:left;" />';
  }

}