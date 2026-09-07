<?php
/**
 * The sidebar containing the left widget area.
 *
 * If no active widgets in sidebar, let's hide it completely.
 *
 * @package WordPress
 * @subpackage BookYourTravel
 * @since Book Your Travel 1.0
 */
?>
<?php if ( is_active_sidebar( 'left' ) ) : ?>
	<aside id="secondary" class="left-sidebar widget-area" role="complementary">
		<ul>
		<?php dynamic_sidebar( 'left' ); ?>
		</ul>
	</aside><!-- #secondary -->
<?php endif; ?>