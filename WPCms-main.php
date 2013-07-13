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

require_once "WPCms/Classes/WPCmsDatePicker.php";
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
require_once "WPCms/Classes/WPCmsImageProField.php";
require_once "WPCms/Classes/WPCmsGoogleMapField.php";
require_once "WPCms/Classes/WPCmsGalleryField.php";

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

$txtComuni = new WPCmsSettingsPage(
  array(
    'title' => 'Testi Comuni',
    'menu_slug' => 'testi_comuni',
    'fields' => array(

      new WPCmsSeparatorField (array(
        'id' => 'separator1',
        'name' => 'WPCmsSeparatorField 1',
        'description' => 'Example of WPCmsSeparatorField')),

      new WPCmsInputField (array(
        'id' => 'input1',
        'name' => 'WPCmsInputField 1',
        'description' => 'Example of WPCmsInputField')),

      new WPCmsTextField (array(
        'id' => 'text1',
        'name' => 'WPCmsTextField 1',
        'description' => 'Example of WPCmsTextField')),

      new WPCmsTextareaField (array(
        'id' => 'textarea1',
        'name' => 'WPCmsTextareaField 1',
        'description' => 'Example of WPCmsTextareaField')),

      new WPCmsTinyMCEField (array(
        'id' => 'tinymce1',
        'name' => 'WPCmsTinyMCEField 1',
        'description' => 'Example of WPCmsTinyMCEField')),

      new WPCmsPasswordField (array(
        'id' => 'password1',
        'name' => 'WPCmsPasswordField 1',
        'description' => 'Example of WPCmsPasswordField',
        'default' => 'password')),

      new WPCmsCheckboxField (array(
        'id' => 'checkbox1',
        'name' => 'WPCmsCheckboxField 1',
        'description' => 'Example of WPCmsCheckboxField')),

      new WPCmsColorPicker (array(
        'id' => 'colorpicker1',
        'name' => 'WPCmsColorPicker 1',
        'description' => 'Example of WPCmsColorPicker')),

      new WPCmsColorPicker (array(
        'id' => 'colorpicker2',
        'name' => 'WPCmsColorPicker 2',
        'description' => 'Example of WPCmsColorPicker with default value',
        'default' => '#ff6700')),

      new WPCmsSelectField (array(
        'id' => 'select1',
        'name' => 'WPCmsSelectField 1',
        'description' => 'WPCmsSelectField',
        'options' => array('first' => 'First Option', 'second' => 'Second Option', 'third' => 'Third Option'))),

      new WPCmsSelectField (array(
        'id' => 'select2',
        'name' => 'WPCmsSelectField 2',
        'description' => 'WPCmsSelectField with default value',
        'options' => array('first' => 'First Option', 'second' => 'Second Option', 'third' => 'Third Option'),
        'default' => 'second')),

      new WPCmsRelationField (array(
        'id' => 'relation1',
        'name' => 'WPCmsRelationField 1',
        'description' => 'Example of WPCmsRelationField related to Posts',
        'related' => 'post')),

      new WPCmsRelationField (array(
        'id' => 'relation2',
        'name' => 'WPCmsRelationField 2',
        'description' => 'Example of WPCmsRelationField related to Page',
        'related' => 'page')),

      new WPCmsRadioField (array(
        'id' => 'radio1',
        'name' => 'WPCmsRadioField 1',
        'description' => 'Example of WPCmsRadioField',
        'options' => array('first' => 'First Option', 'second' => 'Second Option', 'third' => 'Third Option'),
        'default' => 'first',
        'relations' => array('first' => 'related111', 'second' => 'related112,related113'))),

      new WPCmsRadioField (array(
        'id' => 'radio2',
        'name' => 'WPCmsRadioField 2',
        'description' => 'Example of WPCmsRadioField with default value',
        'options' => array('first' => 'First Option', 'second' => 'Second Option', 'third' => 'Third Option'),
        'default' => 'second')),

      new WPCmsInputField (array(
        'id' => 'related111',
        'name' => 'WPCmsInputField related to WPCmsRadioField 1',
        'description' => 'active with value = First Option')),

      new WPCmsInputField (array(
        'id' => 'related112',
        'name' => 'WPCmsInputField related to WPCmsRadioField 1',
        'description' => 'active with value = Second Option')),

      new WPCmsInputField (array(
        'id' => 'related113',
        'name' => 'WPCmsInputField related to WPCmsRadioField 1',
        'description' => 'active with value = Second Option')),

      new WPCmsGoogleFontsField (array(
        'id' => 'googlefonts1',
        'name' => 'WPCmsGoogleFontsField 1',
        'description' => 'Example of WPCmsGoogleFontsField')),

      new WPCmsGoogleFontsField (array(
        'id' => 'googlefonts2',
        'name' => 'WPCmsGoogleFontsField 2',
        'description' => 'Example of WPCmsGoogleFontsField with default value',
        'default' => 'Roboto:300')),

      new WPCmsImageField (array(
        'id' => 'image1',
        'name' => 'WPCmsImageField 1',
        'description' => 'Example of WPCmsImageField')),

      new WPCmsImageProField (array(
        'id' => 'image2',
        'name' => 'WPCmsImageProField',
        'description' => 'Example of WPCmsImageProField')),

      new WPCmsGoogleMapField (array(
        'id' => 'gmap1',
        'name' => 'WPCmsGoogleMapField 1',
        'description' => 'Example of WPCmsGoogleMapField')),

      new WPCmsGalleryField (array(
        'id' => 'gallery1',
        'name' => 'WPCmsGalleryField 1',
        'description' => 'Example of WPCmsGalleryField')),

      new WPCmsSeparatorField (array(
        'id' => 'separator2',
        'name' => 'WPCmsMultilanguageField Fields:',
        'description' => 'Every fields can be added as "multillanguage" simply passing it as unique parameter of WPCmsMultilanguageField constructor<br />
        for example the first of following fields is:<br />
        new WPCmsMultilanguageField(new WPCmsInputField (\'input2\', \'WPCmsInputField 2\', \'Example of WPCmsInputField in a multilanguage context\'));')),

        new WPCmsMultilanguageField (
      new WPCmsInputField (array(
        'id' => 'input2',
        'name' => 'WPCmsInputField 2',
        'description' => 'Example of WPCmsInputField in a multilanguage context'))),

        new WPCmsMultilanguageField (
      new WPCmsTextField (array(
        'id' => 'text2',
        'name' => 'WPCmsTextField 2',
        'description' => 'If you pass an array as \'default\' parameter<br />array(\'{$lang}\' => \'{$value}\', ...)<br />you can define different default values for every langauge',
        'default' => array('en' => 'default value EN', 'it' => 'default value IT')))),

        new WPCmsMultilanguageField (
      new WPCmsTextareaField (array(
        'id' => 'textarea2',
        'name' => 'WPCmsTextareaField 2',
        'description' => 'Example of WPCmsTextareaField in a multilanguage context')))
    )
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
  array(
    'post_type' => 'custom-post-type',
    'fields' => array(
      'shared' => array(
        'title' => 'Dati Aggiuntivi',
        'fields' => array(
          new WPCmsSeparatorField (array(
            'id' => 'separator1',
            'name' => 'WPCmsSeparatorField 1',
            'description' => 'Example of WPCmsSeparatorField')),

          new WPCmsDatePicker (array(
            'id' => 'datepicker1',
            'name' => 'Publish date',
            'description' => 'Select publish date',
            'options' => array('numberOfMonths' => 2, 'showWeek' => 0, 'autoSize' => 0))),

          new WPCmsDatePicker (array(
            'id' => 'datepicker2',
            'maxDate' => 'datepicker3',
            'name' => 'From',
            'description' => 'Select start date',
            'options' => array('numberOfMonths' => 2, 'showWeek' => 0, 'autoSize' => 0))),

          new WPCmsDatePicker (array(
            'id' => 'datepicker3',
            'minDate' => 'datepicker2',
            'name' => 'To',
            'description' => 'Select end date',
            'options' => array('numberOfMonths' => 2, 'showWeek' => 0, 'autoSize' => 0))),

          new WPCmsInputField (array(
            'id' => 'input1',
            'name' => 'WPCmsInputField 1',
            'description' => 'Example of WPCmsInputField')),

          new WPCmsTextField (array(
            'id' => 'text1',
            'name' => 'WPCmsTextField 1',
            'description' => 'Example of WPCmsTextField')),

          new WPCmsTextareaField (array(
            'id' => 'textarea1',
            'name' => 'WPCmsTextareaField 1',
            'description' => 'Example of WPCmsTextareaField')),

          new WPCmsTinyMCEField (array(
            'id' => 'tinymce1',
            'name' => 'WPCmsTinyMCEField 1',
            'description' => 'Example of WPCmsTinyMCEField')),

          new WPCmsPasswordField (array(
            'id' => 'password1',
            'name' => 'WPCmsPasswordField 1',
            'description' => 'Example of WPCmsPasswordField',
            'default' => 'password')),

          new WPCmsCheckboxField (array(
            'id' => 'checkbox1',
            'name' => 'WPCmsCheckboxField 1',
            'description' => 'Example of WPCmsCheckboxField')),

          new WPCmsColorPicker (array(
            'id' => 'colorpicker1',
            'name' => 'WPCmsColorPicker 1',
            'description' => 'Example of WPCmsColorPicker')),

          new WPCmsColorPicker (array(
            'id' => 'colorpicker2',
            'name' => 'WPCmsColorPicker 2',
            'description' => 'Example of WPCmsColorPicker with default value',
            'default' => '#ff6700')),

          new WPCmsSelectField (array(
            'id' => 'select1',
            'name' => 'WPCmsSelectField 1',
            'description' => 'WPCmsSelectField',
            'options' => array('first' => 'First Option', 'second' => 'Second Option', 'third' => 'Third Option'))),

          new WPCmsSelectField (array(
            'id' => 'select2',
            'name' => 'WPCmsSelectField 2',
            'description' => 'WPCmsSelectField with default value',
            'options' => array('first' => 'First Option', 'second' => 'Second Option', 'third' => 'Third Option'),
            'default' => 'second')),

          new WPCmsRelationField (array(
            'id' => 'relation1',
            'name' => 'WPCmsRelationField 1',
            'description' => 'Example of WPCmsRelationField related to Posts',
            'related' => 'post')),

          new WPCmsRelationField (array(
            'id' => 'relation2',
            'name' => 'WPCmsRelationField 2',
            'description' => 'Example of WPCmsRelationField related to Page',
            'related' => 'page')),

          new WPCmsRadioField (array(
            'id' => 'radio1',
            'name' => 'WPCmsRadioField 1',
            'description' => 'Example of WPCmsRadioField',
            'options' => array('first' => 'First Option', 'second' => 'Second Option', 'third' => 'Third Option'),
            'default' => 'first',
            'relations' => array('first' => 'related111', 'second' => 'related112,related113'))),

          new WPCmsRadioField (array(
            'id' => 'radio2',
            'name' => 'WPCmsRadioField 2',
            'description' => 'Example of WPCmsRadioField with default value',
            'options' => array('first' => 'First Option', 'second' => 'Second Option', 'third' => 'Third Option'),
            'default' => 'second')),

          new WPCmsInputField (array(
            'id' => 'related111',
            'name' => 'WPCmsInputField related to WPCmsRadioField 1',
            'description' => 'active with value = First Option')),

          new WPCmsInputField (array(
            'id' => 'related112',
            'name' => 'WPCmsInputField related to WPCmsRadioField 1',
            'description' => 'active with value = Second Option')),

          new WPCmsInputField (array(
            'id' => 'related113',
            'name' => 'WPCmsInputField related to WPCmsRadioField 1',
            'description' => 'active with value = Second Option')),

          new WPCmsGoogleFontsField (array(
            'id' => 'googlefonts1',
            'name' => 'WPCmsGoogleFontsField 1',
            'description' => 'Example of WPCmsGoogleFontsField')),

          new WPCmsGoogleFontsField (array(
            'id' => 'googlefonts2',
            'name' => 'WPCmsGoogleFontsField 2',
            'description' => 'Example of WPCmsGoogleFontsField with default value',
            'default' => 'Roboto:300')),

          new WPCmsImageField (array(
            'id' => 'image1',
            'name' => 'WPCmsImageField 1',
            'description' => 'Example of WPCmsImageField')),

          new WPCmsGoogleMapField (array(
            'id' => 'gmap1',
            'name' => 'WPCmsGoogleMapField 1',
            'description' => 'Example of WPCmsGoogleMapField')),

          new WPCmsGalleryField (array(
            'id' => 'gallery1',
            'name' => 'WPCmsGalleryField 1',
            'description' => 'Example of WPCmsGalleryField')),

          new WPCmsSeparatorField (array(
            'id' => 'separator2',
            'name' => 'WPCmsMultilanguageField Fields:',
            'description' => 'Every fields can be added as "multillanguage" simply passing it as unique parameter of WPCmsMultilanguageField constructor<br />
            for example the first of following fields is:<br />
            new WPCmsMultilanguageField(new WPCmsInputField (\'input2\', \'WPCmsInputField 2\', \'Example of WPCmsInputField in a multilanguage context\'));')),

            new WPCmsMultilanguageField (
          new WPCmsInputField (array(
            'id' => 'input2',
            'name' => 'WPCmsInputField 2',
            'description' => 'Example of WPCmsInputField in a multilanguage context'))),

            new WPCmsMultilanguageField (
          new WPCmsTextField (array(
            'id' => 'text2',
            'name' => 'WPCmsTextField 2',
            'description' => 'If you pass an array as \'default\' parameter<br />array(\'{$lang}\' => \'{$value}\', ...)<br />you can define different default values for every langauge',
            'default' => array('en' => 'default value EN', 'it' => 'default value IT')))),

            new WPCmsMultilanguageField (
          new WPCmsTextareaField (array(
            'id' => 'textarea2',
            'name' => 'WPCmsTextareaField 2',
            'description' => 'Example of WPCmsTextareaField in a multilanguage context')))
        )
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
  array(
    'post_type' => 'custom-post-type2',
    'fields' => array(
      'shared' => array(
        'title' => 'Dati Aggiuntivi',
        'fields' => array(

          new WPCmsRelationField(array(
            'id' => 'custom_post_related',
            'name' => 'Related Custom Posts',
            'related' => 'post')),

          new WPCmsImageField(array(
            'id' => 'custom_post_type_image',
            'name' => 'Custom Post Image')),

          new WPCmsImageField(array(
            'id' => 'custom_post_type_image1',
            'name' => 'Custom Post Image')),

          new WPCmsImageField(array(
            'id' => 'custom_post_type_image2',
            'name' => 'Custom Post Image')),

          new WPCmsImageField(array(
            'id' => 'custom_post_type_image3',
            'name' => 'Custom Post Image'))
        )
      ),
      'wpcms-format-image' => array(
        'title' => 'Custom Fields for Post Format image',
        'fields' => array(
          new WPCmsInputField (array(
            'id' => 'test112',
            'name' => 'Input available only for post format Image'))
        )
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




$pageType = new WPCmsPostType(array(
  'post_type' => 'page',
  'fields' => array(
    'common' => array(
      'title' => 'Per tutte le pagine',
      'fields' => array(
        new WPCmsInputField(array(
          'id' => 'input_test',
          'name' => 'Input Test'))
      )
    ),

    'solo-portfolio' => array(
      'title' => 'Solo per Portfolio',
      'template-file' => 'template.pagina.test.php',
      'fields' => array(
        new WPCmsGoogleMapField(array(
          'id' => 'mappa11',
          'name' => 'Projects to Include in Slideshow')),

        new WPCmsRelationField(array(
          'id' => 'progetti11',
          'name' => 'Projects to Include in Slideshow',
          'related' => 'project'))
      )
    )
  )
));

$pageType->register();





// Progetti


register_taxonomy(
  'categorie-progetti',
  null,
  array(
    'hierarchical' => true,
    'labels' => array(
      'name' => 'Categorie Progetti'
    ),
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array('slug' => 'categorie-progetti'),
  )
);



$postTypeProgetti = new WPCmsPostType(array(
  'post_type' => 'progetti',
  'fields' => array(
    'google-map-box' => array(
      'title' => 'Box per la Mappa',
      'fields' => array(
        new WPCmsGoogleMapField (array(
          'id' => 'ttgmap1',
          'name' => 'Mappa',
          'description' => 'Descrizione della mappa')),
      )
    ),
    'immagine-e-testi-box' => array(
      'title' => 'Box per immagine e i testi',
      'fields' => array(
        new WPCmsImageField (array(
          'id' => 'ttimage1',
          'name' => 'Immagine',
          'description' => 'Descrizione Immagine')),
        new WPCmsTextField (array(
          'id' => 'tttext1',
          'name' => 'Testo 1',
          'description' => 'Descrizione testo 1')),
        new WPCmsTextField (array(
          'id' => 'tttext2',
          'name' => 'Testo 2',
          'description' => 'Descrizione testo 2')),
        new WPCmsRelationField (array(
          'id' => 'relation2',
          'name' => 'WPCmsRelationField 2',
          'description' => 'Example of WPCmsRelationField related to Page',
          'related' => 'page')),
      )
    )
  )
));

$postTypeProgetti->setLabels(array(
    'name' => 'Progetti',
    'singular_name' => 'Progetto',
    'menu_name' => 'Progetti'
));


$postTypeProgetti->setArgs(array(
    'taxonomies' => array('categorie-progetti', 'custom-taxonomy')
));

$postTypeProgetti->register();







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



