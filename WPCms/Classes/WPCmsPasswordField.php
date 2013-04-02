<?php

Class WPCmsPasswordField Extends WPCmsField {

  public function renderInnerInput ($post, $data = array()) {
    echo '<input type="password" name="', $data['name'], '" id="', $data['id'], '" value="', esc_attr($data['value']), '" />';
  }

}