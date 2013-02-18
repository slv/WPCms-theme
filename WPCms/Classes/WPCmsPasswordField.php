<?php

Class WPCmsPasswordField Extends WPCmsField {

  var $height = 30;

  public function renderInnerInput ($post, $data = array()) {
    echo '<input type="password" name="', $data['name'], '" id="', $data['id'], '" value="', htmlentities($data['value']), '" size="30" style="width:100%; margin-right: 20px; float:left;" />';
  }

}