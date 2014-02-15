<?php

/* config */

$role_object = get_role('editor');
$role_object->add_cap('manage_options');

require "WPCms-main.php";

add_theme_support('post-formats', array(
  'image',
  'gallery',
  'video',
  'link',
  'quote'
));



// SCRIPT & STYLES

function wpcms_enqueue_script () {
  wp_register_script('jquery-easing', get_stylesheet_directory_uri() . '/js/lib/jquery.easing.js', array('jquery'));
}
add_action('wp_enqueue_scripts', 'wpcms_enqueue_script');



// SIDEBARS

function wpcms_register_sidebars()
{
  require "Sidebars/main.php";
};

add_action('widgets_init', 'wpcms_register_sidebars');




// MENUS

function wpcms_register_menus()
{
  register_nav_menu('nav-menu', __('Nav Menu', WPCmsStatus::getStatus()->getData('textdomain')));
};

add_action('widgets_init', 'wpcms_register_menus');




// SHORTCODES

require "Shortcodes/separator.php";


// WIDGETS

// require "Widgets/.php";

