<?php
/*	Template Name: Byt Home page
 * The Front Page template file.
 *
 * This is the template of the page that can be selected to be shown as the front page.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage BookYourTravel
 * @since Book Your Travel 1.0
 */
	global $currency_symbol;
	
	get_header();  
	$frontpage_show_slider = of_get_option('frontpage_show_slider', '1');
	if (!$frontpage_show_slider)
		$body_class = 'noslider';
		
?>
<section class="three-fourth">
<section id="byt_sequence_slider_homepage_wrapper" class="slider clearfix">
    <div id="sequence">
        <?php if (function_exists('nivoslider4wp_show')) { nivoslider4wp_show(); } ?>
    </div>
</section>



<?php 

 get_sidebar('under-header');
 get_sidebar('home-above-slider');
 ?>
	<!--full-width content-->
        <div class="offers clearfix full-home-tour">
            <article class="one-fourth">
				<?php dynamic_sidebar('tour-home-natural'); ?>
            </article>
            <article class="one-fourth no-bg">
            	<div class="widget-box-content title-beach-block">
     				<a href="#"><img src="wp-content/uploads/2014/05/bg-beach.png"/></a>
                </div>
                <div class="widget-box-content title-beach-block" style="height:845px;">
                	<?php dynamic_sidebar('home-tour-beach'); ?>
                </div>
                <div class="widget-box-content title-beach-block">
                	<a href="#"><img src="wp-content/uploads/2014/05/thailan.png" /></a>
                </div>                 
            </article>                        
            <article class="one-fourth no-bg last">
            	<div class="widget-box-content title-beach-block">
     				<a href="#"><img src="wp-content/uploads/2014/05/logo1.png"/></a>
                </div>
                <div class="widget-box-content title-beach-block" style="height:845px;">
                	<?php dynamic_sidebar('home-tour-unesco'); ?>
                </div>
                <div class="widget-box-content title-beach-block">
                	<a href="#"><img src="wp-content/uploads/2014/05/cambodia.png" /></a>
                </div>                 
            </article>
        </div>
	</section>
	<!--//full-width content-->
	<?php get_sidebar('left'); ?>
    
	<?php
	get_sidebar('home-footer');
	get_footer(); 	
	?>