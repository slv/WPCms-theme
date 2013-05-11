<?php

// Config

define ('IS_CHILD_THEME', false);
define ('WPCMS_STYLESHEET_DIR', (IS_CHILD_THEME ? get_stylesheet_directory_uri() : get_template_directory_uri()));

//
// Requires
//

require_once "WPCms/Singleton/WPCmsStatus.php";

require_once "WPCms/Classes/WPCmsField.php";
require_once "WPCms/Classes/WPCmsMultilanguageField.php";

require_once "WPCms/Classes/WPCmsInputField.php";
require_once "WPCms/Classes/WPCmsTextField.php";
require_once "WPCms/Classes/WPCmsTextareaField.php";
require_once "WPCms/Classes/WPCmsTinyMCEField.php";
require_once "WPCms/Classes/WPCmsPasswordField.php";
require_once "WPCms/Classes/WPCmsCheckboxField.php";
require_once "WPCms/Classes/WPCmsSelectField.php";
require_once "WPCms/Classes/WPCmsRadioField.php";

require_once "WPCms/Classes/WPCmsGoogleFontsField.php";
require_once "WPCms/Classes/WPCmsRelationField.php";
require_once "WPCms/Classes/WPCmsColorPicker.php";
require_once "WPCms/Classes/WPCmsUploadField.php";
require_once "WPCms/Classes/WPCmsImageField.php";
require_once "WPCms/Classes/WPCmsGoogleMapField.php";

require_once "WPCms/Classes/WPCmsSeparatorField.php";

require_once "WPCms/Classes/WPCmsPostType.php";
require_once "WPCms/Classes/WPCmsSettingsPage.php";

require_once "WPCms/actions-filters.php";

//
// Global Config saved in WPCmsStatus Singleton
//

// array of languages used by WPCmsMultilanguageField
WPCmsStatus::getStatus()->setData('languages', array('en', 'us', 'it'));

// prefix to all postmeta and options, (not required)
WPCmsStatus::getStatus()->setData('pre', 'wpcms_');




//
// Settings Page
//

$txtComuni = new WPCmsSettingsPage('Testi Comuni', 'testi_comuni',
  array(
    new WPCmsSeparatorField ('separator1', 'WPCmsSeparatorField 1', 'Example of WPCmsSeparatorField'),
    new WPCmsInputField ('input1', 'WPCmsInputField 1', 'Example of WPCmsInputField'),
    new WPCmsTextField ('text1', 'WPCmsTextField 1', 'Example of WPCmsTextField'),
    new WPCmsTextareaField ('textarea1', 'WPCmsTextareaField 1', 'Example of WPCmsTextareaField'),
    new WPCmsTinyMCEField ('tinymce1', 'WPCmsTinyMCEField 1', 'Example of WPCmsTinyMCEField'),
    new WPCmsPasswordField ('password1', 'WPCmsPasswordField 1', 'Example of WPCmsPasswordField', 'password'),
    new WPCmsCheckboxField ('checkbox1', 'WPCmsCheckboxField 1', 'Example of WPCmsCheckboxField'),
    new WPCmsColorPicker ('colorpicker1', 'WPCmsColorPicker 1', 'Example of WPCmsColorPicker'),
    new WPCmsColorPicker ('colorpicker2', 'WPCmsColorPicker 2', 'Example of WPCmsColorPicker with default value', '#ff6700'),
    new WPCmsSelectField ('select1', 'WPCmsSelectField 1', 'WPCmsSelectField', array('first' => 'First Option', 'second' => 'Second Option', 'third' => 'Third Option')),
    new WPCmsSelectField ('select2', 'WPCmsSelectField 2', 'WPCmsSelectField with default value', array('first' => 'First Option', 'second' => 'Second Option', 'third' => 'Third Option'), 'second'),
    new WPCmsRelationField ('relation1', 'WPCmsRelationField 1', 'Example of WPCmsRelationField related to Posts', '', 'post'),
    new WPCmsRelationField ('relation2', 'WPCmsRelationField 2', 'Example of WPCmsRelationField related to Page', '', 'page'),
    new WPCmsRadioField ('radio1', 'WPCmsRadioField 1', 'Example of WPCmsRadioField', array('first' => 'First Option', 'second' => 'Second Option', 'third' => 'Third Option'), 'first', array('first' => 'related111', 'second' => 'related112,related113')),
    new WPCmsRadioField ('radio2', 'WPCmsRadioField 2', 'Example of WPCmsRadioField with default value', array('first' => 'First Option', 'second' => 'Second Option', 'third' => 'Third Option'), 'second'),
    new WPCmsInputField ('related111', 'WPCmsInputField related to WPCmsRadioField 1', 'active with value = First Option'),
    new WPCmsInputField ('related112', 'WPCmsInputField related to WPCmsRadioField 1', 'active with value = Second Option'),
    new WPCmsInputField ('related113', 'WPCmsInputField related to WPCmsRadioField 1', 'active with value = Second Option'),
    new WPCmsGoogleFontsField ('googlefonts1', 'WPCmsGoogleFontsField 1', 'Example of WPCmsGoogleFontsField'),
    new WPCmsGoogleFontsField ('googlefonts2', 'WPCmsGoogleFontsField 2', 'Example of WPCmsGoogleFontsField with default value', 'Roboto:300'),
    new WPCmsImageField ('image1', 'WPCmsImageField 1', 'Example of WPCmsImageField'),
    new WPCmsGoogleMapField ('gmap1', 'WPCmsGoogleMapField 1', 'Example of WPCmsGoogleMapField'),
    new WPCmsSeparatorField ('separator2', 'WPCmsMultilanguageField Fields:', 'Every fields can be added as "multillanguage" simply passing it as unique parameter of WPCmsMultilanguageField constructor<br />
      for example the first of following fields is:<br />
      new WPCmsMultilanguageField(new WPCmsInputField (\'input2\', \'WPCmsInputField 2\', \'Example of WPCmsInputField in a multilanguage context\'));'),
      new WPCmsMultilanguageField (
    new WPCmsInputField ('input2', 'WPCmsInputField 2', 'Example of WPCmsInputField in a multilanguage context')),
      new WPCmsMultilanguageField (
    new WPCmsTextField ('text2', 'WPCmsTextField 2', 'If you pass an array as \'default\' parameter<br />array(\'{$lang}\' => \'{$value}\', ...)<br />you can define different default values for every langauge', array('en' => 'default value EN', 'it' => 'default value IT'))),
      new WPCmsMultilanguageField (
    new WPCmsTextareaField ('textarea2', 'WPCmsTextareaField 2', 'Example of WPCmsTextareaField in a multilanguage context'))
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
    'shared' => array(
      'title' => 'Dati Aggiuntivi',
      'fields' => array(
        new WPCmsSeparatorField ('separator1', 'WPCmsSeparatorField 1', 'Example of WPCmsSeparatorField'),
        new WPCmsInputField ('input1', 'WPCmsInputField 1', 'Example of WPCmsInputField'),
        new WPCmsTextField ('text1', 'WPCmsTextField 1', 'Example of WPCmsTextField'),
        new WPCmsTextareaField ('textarea1', 'WPCmsTextareaField 1', 'Example of WPCmsTextareaField'),
        new WPCmsTinyMCEField ('tinymce1', 'WPCmsTinyMCEField 1', 'Example of WPCmsTinyMCEField'),
        new WPCmsPasswordField ('password1', 'WPCmsPasswordField 1', 'Example of WPCmsPasswordField', 'password'),
        new WPCmsCheckboxField('checkbox1', 'WPCmsCheckboxField 1', 'Example of WPCmsCheckboxField'),
        new WPCmsColorPicker ('colorpicker1', 'WPCmsColorPicker 1', 'Example of WPCmsColorPicker'),
        new WPCmsColorPicker ('colorpicker2', 'WPCmsColorPicker 2', 'Example of WPCmsColorPicker with default value', '#ff6700'),
        new WPCmsSelectField ('select1', 'WPCmsSelectField 1', 'WPCmsSelectField', array('first' => 'First Option', 'second' => 'Second Option', 'third' => 'Third Option')),
        new WPCmsSelectField ('select2', 'WPCmsSelectField 2', 'WPCmsSelectField with default value', array('first' => 'First Option', 'second' => 'Second Option', 'third' => 'Third Option'), 'second'),
        new WPCmsRelationField ('relation1', 'WPCmsRelationField 1', 'Example of WPCmsRelationField related to same posttype Posts', '', 'custom-post-type'),
        new WPCmsRelationField ('relation2', 'WPCmsRelationField 2', 'Example of WPCmsRelationField related to media', '', 'attachment'),
        new WPCmsRadioField ('radio1', 'WPCmsRadioField 1', 'Example of WPCmsRadioField', array('first' => 'First Option', 'second' => 'Second Option', 'third' => 'Third Option')),
        new WPCmsRadioField ('radio2', 'WPCmsRadioField 2', 'Example of WPCmsRadioField with default value', array('first' => 'First Option', 'second' => 'Second Option', 'third' => 'Third Option'), 'second'),
        new WPCmsGoogleFontsField ('googlefonts1', 'WPCmsGoogleFontsField 1', 'Example of WPCmsGoogleFontsField'),
        new WPCmsGoogleFontsField ('googlefonts2', 'WPCmsGoogleFontsField 2', 'Example of WPCmsGoogleFontsField with default value', 'Roboto:300'),
        new WPCmsImageField ('image1', 'WPCmsImageField 1', 'Example of WPCmsImageField'),
        new WPCmsSeparatorField ('separator2', 'WPCmsMultilanguageField Fields:', 'Every fields can be added as "multillanguage" simply passing it as unique parameter of WPCmsMultilanguageField constructor<br />
          for example the first of following fields is:<br />
          new WPCmsMultilanguageField(new WPCmsInputField (\'input2\', \'WPCmsInputField 2\', \'Example of WPCmsInputField in a multilanguage context\'));'),
          new WPCmsMultilanguageField (
        new WPCmsInputField ('input2', 'WPCmsInputField 2', 'Example of WPCmsInputField in a multilanguage context')),
          new WPCmsMultilanguageField (
        new WPCmsTextField ('text2', 'WPCmsTextField 2', 'If you pass an array as \'default\' parameter<br />array(\'{$lang}\' => \'{$value}\', ...)<br />you can define different default values for every langauge', array('en' => 'default value EN', 'it' => 'default value IT'))),
          new WPCmsMultilanguageField (
        new WPCmsTextareaField ('textarea2', 'WPCmsTextareaField 2', 'Example of WPCmsTextareaField in a multilanguage context')),
          new WPCmsMultilanguageField (
        new WPCmsTinyMCEField ('tinymce2', 'WPCmsTinyMCEField 2', 'Example of WPCmsTinyMCEField'))
      )
    )
  )
);

$customPostType->setArgs(array(
    'taxonomies' => array('custom-taxonomy'),
    'supports' => array(
      'title',
      'revisions'
    )
));

$customPostType->setLabels(array(
    'name' => 'Custom Posts',
    'singular_name' => 'Custom Post',
    'edit_item' => 'Edit Custom Post',
    'add_new' => 'Add New',
    'add_new_item' => 'Add New Custom Post',
    'menu_name' => 'Custom Post'
));

$customPostType->register();

WPCmsStatus::getStatus()->addToArray('postTypeInstances', $customPostType);



$customPostType2 = new WPCmsPostType(
  'custom-post-type2',
  array(
    'shared' => array(
      'title' => 'Dati Aggiuntivi',
      'fields' => array(
        new WPCmsRelationField('custom_post_related', 'Related Custom Posts', 'related...', '', 'post'),
        new WPCmsImageField('custom_post_type_image', 'Custom Post Image'),
        new WPCmsImageField('custom_post_type_image1', 'Custom Post Image'),
        new WPCmsImageField('custom_post_type_image2', 'Custom Post Image'),
        new WPCmsImageField('custom_post_type_image3', 'Custom Post Image')
      )
    ),
    'wpcms-format-image' => array(
      'title' => 'Custom Fields for Post Format image',
      'fields' => array(
        new WPCmsInputField ('test112', 'Input available only for post format Image')
      )
    )
  )
);

$customPostType2->setArgs(array(
    'taxonomies' => array('custom-taxonomy'),
    'supports' => array(
      'title',
      'editor',
      'thumbnail',
      'post-formats'
    )
));

$customPostType2->setLabels(array(
    'name' => 'Custom Post2',
    'singular_name' => 'Custom Post2',
    'edit_item' => 'Edit Custom Post2',
    'add_new_item' => 'Add New Custom Post2',
    'menu_name' => 'Custom Post2'
));

$customPostType2->register();

WPCmsStatus::getStatus()->addToArray('postTypeInstances', $customPostType2);


$postType = new WPCmsPostType(
  'post',
  array(
    'wpcms-format-image' => array(
      'title' => 'Custom Fields for Post Format image',
      'fields' => array(
        new WPCmsInputField ('test111', 'Input available only for post format Image')
      )
    )
  )
);

$postType->register();



// Exclude pages from search

function filterPostTypeInstances ($postType)
{
  return (!$postType->args['exclude_from_search'] && 1);
}

function mapPostTypeInstances ($postType)
{
  return $postType->post_type;
}


function postTypeSearchFilter ($query) {
  if ($query->is_search && $query->get('post_type') == '') {
    $searchPostTypes = array_map('mapPostTypeInstances', array_filter(WPCmsStatus::getStatus()->getArray('postTypeInstances'), 'filterPostTypeInstances'));
    $searchPostTypes[] = 'post';

    $query->set('post_type', $searchPostTypes);
  }
  return $query;
}
add_filter('pre_get_posts', 'postTypeSearchFilter');


