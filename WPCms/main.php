<?php

//
// Requires
//

require_once "Singleton/WPCmsStatus.php";

require_once "Classes/WPCmsField.php";
require_once "Classes/WPCmsMultilanguageField.php";

require_once "Classes/WPCmsInputField.php";
require_once "Classes/WPCmsTextField.php";
require_once "Classes/WPCmsTextareaField.php";
require_once "Classes/WPCmsPasswordField.php";
require_once "Classes/WPCmsCheckboxField.php";
require_once "Classes/WPCmsRelationField.php";

require_once "Classes/WPCmsSeparatorField.php";
require_once "Classes/WPCmsColorPicker.php";
require_once "Classes/WPCmsImageField.php";

require_once "Classes/WPCmsPostType.php";
require_once "Classes/WPCmsSettingsPage.php";

require_once "actions-filters.php";

//
// Global Config saved in WPCmsStatus Singleton
//

WPCmsStatus::getStatus()->setData('languages', array('en', 'de', 'it'));
WPCmsStatus::getStatus()->setData('pre', PRE);




//
// Settings Page
//

$txtComuni = new WPCmsSettingsPage(
  'Testi Comuni',
  array(
    new WPCmsSeparatorField ('sep1', 'Separatore Campi'),
    new WPCmsInputField ('input1', 'Input Numero 1'),
    new WPCmsTextField ('txt1', 'Testo Numero 1'),
    new WPCmsSeparatorField ('sep2', 'Separatore Campi'),
    new WPCmsTextField ('txt2', 'Testo Numero 2'),
    new WPCmsColorPicker ('color1', 'Colore Titolo Home'),
    new WPCmsColorPicker ('color2', 'Colore Titolo Home 2'),
    new WPCmsColorPicker ('color3', 'Colore Titolo Home 3'),
    new WPCmsColorPicker ('color4', 'Colore Titolo Home 4'),
    new WPCmsRelationField('custom_post_related', 'Related Custom Posts', 'custom post correlati', '', 'custom-post-type')
  )
);

$txtComuni->capabilityType = 'edit_themes';





//
// Custom Taxonomies
//

register_taxonomy(
  'custom-taxonomy',
  null,
  array(
    'hierarchical' => true,
    'labels' => array(
      'name' => 'Custom Taxonomy'
    ),
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'custom-taxonomy' ),
  )
);





//
// Custom Post Types
//

$customPostType = new WPCmsPostType(
  'custom-post-type',
  array(
    'labels' => array(
      'name' => 'Custom Post',
      'singular_name' => 'Custom Post',
      'edit_item' => 'Edit Custom Post',
      'add_new' => 'Add New',
      'add_new_item' => 'Add New Custom Post',
      'parent_item_colon' => '',
      'menu_name' => 'Custom Post'
    ),
    'public' => true,
    'exclude_from_search' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'query_var' => true,
    'has_archive' => true,
    'show_in_menu' => true,
    'capability_type' => 'post',
    'map_meta_cap' => true,
    'hierarchical' => false,
    'menu_position' => null,
    'taxonomies' => array('custom-taxonomy'),
    'supports' => array(
      'title',
      'editor',
      'thumbnail',
      'revisions'
    )
  ),
  array(
    'shared' => array(
      'title' => 'Dati Aggiuntivi',
      'post_type' => 'post',
      'context' => 'normal',
      'priority' => 'high',
      'fields' => array(
        new WPCmsCheckboxField('check', 'Attivo questa opzione?'),
        new WPCmsColorPicker ('color1', 'Colore Titolo Home'),
        new WPCmsColorPicker ('color2', 'Colore Titolo Home 2'),
        new WPCmsColorPicker ('color3', 'Colore Titolo Home 3'),
        new WPCmsRelationField('custom_post_related', 'Related Custom Posts', 'Articoli correlati', '', 'custom-post-type'),
        new WPCmsImageField('custom_post_type_image', 'Custom Post Image')
      )
    )
  )
);

WPCmsStatus::getStatus()->addToArray('postTypeInstances', $customPostType);



$customPostType2 = new WPCmsPostType(
  'custom-post-type2',
  array(
    'labels' => array(
      'name' => 'Custom Post2',
      'singular_name' => 'Custom Post2',
      'edit_item' => 'Edit Custom Post2',
      'add_new' => 'Add New',
      'add_new_item' => 'Add New Custom Post2',
      'parent_item_colon' => '',
      'menu_name' => 'Custom Post2'
    ),
    'public' => true,
    'exclude_from_search' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'query_var' => true,
    'has_archive' => true,
    'show_in_menu' => true,
    'capability_type' => 'post',
    'map_meta_cap' => true,
    'hierarchical' => false,
    'menu_position' => null,
    'taxonomies' => array('custom-taxonomy'),
    'supports' => array(
      'title',
      'editor',
      'thumbnail'
    )
  ),
  array(
    'shared' => array(
      'title' => 'Dati Aggiuntivi',
      'post_type' => 'post',
      'context' => 'normal',
      'priority' => 'high',
      'fields' => array(
        new WPCmsRelationField('custom_post_related', 'Related Custom Posts', 'custom post correlati', array(), 'custom-post-type'),
        new WPCmsImageField('custom_post_type_image', 'Custom Post Image'),
        new WPCmsImageField('custom_post_type_image1', 'Custom Post Image'),
        new WPCmsImageField('custom_post_type_image2', 'Custom Post Image'),
        new WPCmsImageField('custom_post_type_image3', 'Custom Post Image')
      )
    )
  )
);

WPCmsStatus::getStatus()->addToArray('postTypeInstances', $customPostType2);
