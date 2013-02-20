<?php

/* config */

$role_object = get_role('editor');
$role_object->add_cap('manage_options');

require "WPCms/main.php";

add_theme_support('post-formats', array(
  'image',
  'gallery',
  'video',
  'link',
  'quote'
));
