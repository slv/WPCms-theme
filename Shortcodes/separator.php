<?php

function wpcms_shortcode_separator () {
  return '<div class="shrt-separator"></div>';
}

add_shortcode ('separator', 'wpcms_shortcode_separator');