<?php
/**
/* Template Name: Blog index page
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
$page = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args = array(
	'paged'			   => $page,
	'offset'           => 0,
	'category'         => '',
	'orderby'          => 'post_date',
	'order'            => 'DESC',
	'post_type'        => 'post',
	'post_status'      => 'publish'); 

$query = new WP_Query($args); 

?>

	<!--three-fourth content-->
		<section class="three-fourth">
			<?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>			
			<!--post-->
            
			<article class="static-content post clearfix">
				<header class="entry-header">
					<h1><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h1>
					<p class="entry-meta">
						<span class="date"><?php _e('Date', 'bookmytravel');?>: <?php the_time('F j, Y'); ?></span> 
						<span class="author"><?php _e('By ', 'bookmytravel'); the_author_posts_link(); ?></span> 
						<span class="categories"><?php _e('Categories', 'bookyourtravel'); ?>: <?php the_category(' ') ?></span>
						<span class="comments"><a href="<?php comments_link(); ?>" rel="nofollow"><?php comments_number('No comments','1 Comment','% Comments'); ?></a></span>
					</p>
				</header>
                <?php if ( has_post_thumbnail() ) { ?>
				<div class="entry-featured">
					 <a href="<?php the_permalink() ?>"><figure>
					 	<?php the_post_thumbnail('featured', array('title' => ''));?>
                        </figure>
                     </a>
				</div>
                <?php 
				 }
				?>
				<div class="entry-content">
					<?php the_excerpt(); ?>
					<a href="<?php the_permalink() ?>" class="gradient-button" rel="nofollow"><?php _e('Read More', 'bookyourtravel'); ?></a>
				</div>
			</article>
			<!--//post-->			
			<?php endwhile; else: ?>
				<article class="static-content post clearfix">
					<header class="entry-header">
						<p><strong><?php _e('There has been an error.', 'bookmytravel'); ?></strong></p>
					</header>
					<div class="entry-content">
						<p><?php _e('We apologize for any inconvenience, please hit back on your browser or if you are an admin, enter some content.', 'bookmytravel'); ?></p>
					</div>
				</article>
			<?php endif; ?>
			
				<nav class="page-navigation bottom-nav">
					<!--pager-->
					<div class="pager">
						<?php byt_display_pager($query->max_num_pages); ?>
					</div>
				</nav>
			<!--//bottom navigation-->
		</section>
	<!--//three-fourth content-->
	<?php get_sidebar('right'); ?>
<?php get_footer(); ?>