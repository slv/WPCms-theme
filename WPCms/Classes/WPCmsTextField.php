<?php

Class WPCmsTextField Extends WPCmsField {

  var $height = 60;

  public function renderInnerInput ($post, $data = array()) {
    echo '<textarea name="', $data['name'], '" id="', $data['id'], '" rows="8" cols="5" style="width:100%; resize:none; height:', $this->height, 'px;margin-right: 20px; float:left;">', htmlentities($data['value']), '</textarea>';
  }

}