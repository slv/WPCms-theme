<?php the_post(); ?>


<h1>Progetto: <?php the_title(); ?></h1>

<div>
  <h2><?php the_title(); ?></h2>
  <div class="content"><?php the_content(); ?></div>
</div>


<div>
  <a href="<?php echo get_post_type_archive_link('progetti'); ?>">Progetti</a>
</div>