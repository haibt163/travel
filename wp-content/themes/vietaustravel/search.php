<?php
/**
 * The search template file.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage BookYourTravel
 * @since Book Your Travel 1.0
 */
get_header();  
byt_breadcrumbs();
get_sidebar('under-header');
?>
	<!--three-fourth content-->
		<section class="three-fourth">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>			
			<!--post-->
			<article class="static-content post">
				<header class="entry-header">
					<h1><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h1>
					<p class="entry-meta">
						<span class="date"><?php _e('Date', 'bookmytravel');?>: <?php the_time('F j, Y'); ?></span> 
						<span class="author"><?php _e('By ', 'bookmytravel'); the_author_posts_link(); ?></span> 
						<span class="categories">Categories: <?php the_category(' ') ?></span>
						<span class="comments"><a href="<?php comments_link(); ?>" rel="nofollow"><?php comments_number('No comments','1 Comment','% Comments'); ?></a></span>
					</p>
				</header>
				<div class="entry-featured">
					<?php if ( has_post_thumbnail() ) { ?> <a href="<?php the_permalink() ?>"><figure><?php the_post_thumbnail('featured', array('title' => '')); echo '</figure></a>'; } ?>
				</div>
				<div class="entry-content">
					<?php the_excerpt(); ?>
					<a href="<?php the_permalink() ?>" class="gradient-button" rel="nofollow"><?php _e('Read More...', 'bookyourtravel'); ?></a>
				</div>
			</article>
			<!--//post-->			
			<?php endwhile; else: ?>
			<article class="static-content post">
				<header class="entry-header">
					<p><strong><?php _e('There has been an error.', 'bookmytravel'); ?></strong></p>
				</header>
				<div class="entry-content">
					<p style="whitespace:nowrap"><?php _e('We apologize for any inconvenience, please hit back on your browser or if you are an admin, enter some content.', 'bookmytravel'); ?></p>
				</div>
			</article>
			<?php endif; ?>
			
			<nav class="page-navigation bottom-nav">
				<!--back up button-->
				<a href="#" class="scroll-to-top" title="Back up">Back up</a> 
				<!--//back up button-->
				<!--pager-->
				<div class="pager">
					<?php 	global $wp_query;
							byt_display_pager($wp_query->max_num_pages); ?>
				</div>
			</nav>
			<!--//bottom navigation-->
		</section>
	<!--//three-fourth content-->
	<?php get_sidebar('right'); ?>
<?php get_footer(); ?>