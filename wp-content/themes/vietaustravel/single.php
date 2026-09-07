<?php get_header(); 
byt_breadcrumbs();
get_sidebar('under-header');
?>
	<!--three-fourth content-->
		<section class="three-fourth bg-tours">
		<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>					
			<!--post-->
			<article class="static-content post">
				<header class="entry-header">
					<h1><?php the_title(); ?></h1>
					<p class="entry-meta">
						<span class="date"><?php _e('Date', 'bookmytravel');?>: <?php the_time('F j, Y'); ?></span> 
						<span class="author"><?php _e('By ', 'bookmytravel'); the_author_posts_link(); ?></span> 
						<span class="categories"><?php _e('Categories', 'bookmytravel');?>: <?php the_category(' ') ?></span>
						<span class="comments"><a href="<?php comments_link(); ?>" rel="nofollow"><?php comments_number('No comments','1 Comment','% Comments'); ?></a></span>
					</p>
				</header>
				<div class="entry-featured">
					<?php if ( has_post_thumbnail() ) { ?> <a href="<?php the_permalink() ?>"><figure><?php the_post_thumbnail('featured', array('title' => '')); echo '</figure></a>'; } ?>
				</div>
				<div class="entry-content">
					<?php the_content(); ?>
					<?php wp_link_pages('before=<div class="pagination">&after=</div>'); ?>
				</div>
			</article>
			<!--//post-->	
            <div class="list-tours">
				<?php comments_template( '', true ); ?>			
            </div>
			<?php endwhile; ?>
		</section>
	<!--//three-fourth content-->
	<?php get_sidebar('right'); ?>
<?php get_footer(); ?>