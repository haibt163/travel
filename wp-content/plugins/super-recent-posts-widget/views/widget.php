<?php 
if ( $title ) {
    echo $before_title . $title . $after_title;
}
?>
<ul class="tour-home-natural-widget">
    <?php while ( $posts->have_posts() ) : $posts->the_post(); ?>
        <li>
            <a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail();?> 
				<h2><?php get_the_title() ? the_title() : the_ID(); ?></h2>
            </a>
        </li>
    <?php endwhile; ?>
</ul>
<?php wp_reset_postdata(); ?>