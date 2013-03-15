<?php

Class WPCmsTextField Extends WPCmsField {

  public function renderInnerInput ($post, $data = array()) {
    echo '<textarea name="', $data['name'], '" id="', $data['id'], '" rows="8" cols="5" style="width:100%; resize:none; height:60px;">', esc_textarea($data['value']), '</textarea>';
  }

}