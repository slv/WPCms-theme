<?php

Class WPCmsInputField Extends WPCmsField {

  public function renderInnerInput ($post, $data = array()) {
    echo '<input type="text" name="', $data['name'], '" id="', $data['id'], '" value="', htmlentities($data['value']), '" size="30" />';
  }

}