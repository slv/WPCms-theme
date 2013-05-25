<?php the_post(); ?>


<h1>Progetto: <?php the_title(); ?></h1>

<div>
  <h2><?php the_title(); ?></h2>
  <div class="content"><?php the_content(); ?></div>


<?php $postIds = explode(',', _m('relation2'));
foreach ($postIds as $postId) { $tmpPost = get_post($postId);

  echo $tmpPost->post_title;

} ?>


</div>


<div>
  <a href="<?php echo get_post_type_archive_link('progetti'); ?>">Progetti</a>
</div>