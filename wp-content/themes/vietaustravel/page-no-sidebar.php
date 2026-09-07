<?php
/*	Template Name: Page Without Sidebar
 * The template for displaying a full width page without sidebar
 *
 * @package WordPress
 * @subpackage BookYourTravel
 * @since Book Your Travel 1.0
 */
 get_header(); 
 byt_breadcrumbs();
 get_sidebar('under-header');
 ?>
	<!--full-width content-->
	<section class="full-width">
		<?php  while ( have_posts() ) : the_post(); ?>
		<article class="static-content" id="page-<?php the_ID(); ?>">
			<h1><?php the_title(); ?></h1>
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'bookyourtravel' ) ); ?>
			<?php wp_link_pages('before=<div class="pagination">&after=</div>'); ?>
		</article>
		<?php endwhile; ?>
	</section>
	<!--//full-width content-->
 
 <?php get_footer(); ?>
