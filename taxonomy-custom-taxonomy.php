<h1>Progetti:</h1>

<?php

while (have_posts()) { the_post();
?>


<div class="type-<?php echo $post->post_type; ?>">

  <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
  <div class="content"><?php the_content(); ?></div>
</div>


<?php } ?>


<div>
  <a href="<?php echo get_post_type_archive_link('progetti'); ?>">Progetti</a>
</div>




<br />
<br />





<h3>Categorie:</h3>
<?php

$terms = get_terms('categorie-progetti');
echo '<ul>';
foreach ($terms as $term) {
    echo '<li><a href="'.get_term_link($term->slug, 'categorie-progetti').'">'.$term->name.'</a></li>';
}
echo '</ul>';
?>


<h3>Custom Taxonomy:</h3>
<?php

$terms = get_terms('custom-taxonomy');
echo '<ul>';
foreach ($terms as $term) {
    echo '<li><a href="'.get_term_link($term->slug, 'custom-taxonomy').'">'.$term->name.'</a></li>';
}
echo '</ul>';
?>