<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content
 *
 * @package WordPress
 * @subpackage BookYourTravel
 * @since Book Your Travel 1.0
 */  
?>
			</div><!--//main content-->
		</div><!--//wrap-->
		<?php get_sidebar('above-footer'); ?>
	</div><!--//main-->
	<!--footer-->
	<footer>
		<?php get_sidebar('footer'); ?>
		<div class="wrap clearfix">		
			<section class="bottom">
				<p class="copy"><?php echo of_get_option('copyright_footer', 'no entry'); ?></p>				
				<!--footer navigation-->				
				<?php if ( has_nav_menu( 'footer-menu' ) ) {
					wp_nav_menu( array( 
						'theme_location' => 'footer-menu', 
						'container' => 'nav', 
					) ); 
				} else { ?>
				<nav class="menu-main-menu-container">
					<ul class="menu">
						<li class="menu-item"><a href="<?php echo home_url(); ?>"><?php _e('Home', "bookyourtravel"); ?></a></li>
						<li class="menu-item"><a href="<?php echo admin_url('nav-menus.php'); ?>"><?php _e('Configure', "bookyourtravel"); ?></a></li>
					</ul>
				</nav>
				<?php } ?>
				<!--//footer navigation-->
			</section>
		</div>
	</footer>
	<!--//footer-->
	<?php 
	get_template_part('includes/parts/login', 'lightbox');
	get_template_part('includes/parts/register', 'lightbox'); 
	?>	
<?php wp_footer(); ?>
</div>
</body>
</html>