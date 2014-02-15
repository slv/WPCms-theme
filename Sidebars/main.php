<?php

register_sidebar(
  array(
    'id' => 'sidebar',
    'name' => __('SIDEBAR', WPCmsStatus::getStatus()->getData('textdomain')),
    'description' => __('homepage Sidebar', WPCmsStatus::getStatus()->getData('textdomain')),
    'before_widget' => '<div id="%1$s" class="widget %2$s"><div>',
    'after_widget' => '</div></div>'
  )
);
