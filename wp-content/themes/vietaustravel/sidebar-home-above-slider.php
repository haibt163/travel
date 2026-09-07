<?php
/**
 * The sidebar containing the above slider home widget area.
 *
 * If no active widgets in sidebar, let's hide it completely.
 *
 * @package WordPress
 * @subpackage BookYourTravel
 * @since Book Your Travel 1.0
 */
?>
<?php if ( is_active_sidebar( 'home-above-slider' ) ) : ?>
	<aside id="secondary" class="home-above-slider widget-area" role="complementary">
		<ul>
		<?php dynamic_sidebar( 'home-above-slider' ); ?>
		</ul>
	</aside><!-- #secondary -->
<?php endif; ?>