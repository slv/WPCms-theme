<?php
/*
Template name: Module Building
*/

wp_enqueue_script('theme-script', get_template_directory_uri() . '/js/ck/init-ck.js', array('jquery', 'jquery-easing'));
wp_enqueue_style('theme-style', get_template_directory_uri() . '/css/style.css');



get_header(); ?>

<?php the_post(); ?>

<?php the_content(); ?>

<div class="center_content">
  <?php _module('modules_test'); ?>
</div>


<?php get_footer(); ?>