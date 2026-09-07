<?php
/**
 * The sidebar containing the below slider home widget area.
 *
 * If no active widgets in sidebar, let's hide it completely.
 *
 * @package WordPress
 * @subpackage BookYourTravel
 * @since Book Your Travel 1.0
 */
?>
<?php if ( is_active_sidebar( 'home-below-slider' ) ) : ?>
	<aside id="secondary" class="home-below-slider widget-area" role="complementary">
		<ul>
		<?php dynamic_sidebar( 'home-below-slider' ); ?>
		</ul>
	</aside><!-- #secondary -->
<?php endif; ?>