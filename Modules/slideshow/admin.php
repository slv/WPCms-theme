<?php

return array(
  new WPCmsSelectField (array(
    'id' => 'transition_type',
    'name' => 'Transition Type',
    'default' => 'slide',
    'options' => array('slide' => 'Slide', 'fade' => 'Fade'))),
  new WPCmsGalleryField (array(
    'id' => 'images',
    'name' => 'Images'))
);