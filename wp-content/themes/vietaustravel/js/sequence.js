jQuery.noConflict();
jQuery(document).ready(function(){
	var options = {
		autoPlay: true,
		autoPlayDelay: window.sliderSpeed,
		pauseOnHover: false,
		nextButton: false,
		prevButton: false,
		preloader: false,
		navigationSkipThreshold: 1000,
		fadeFrameWhenSkipped: false
	};
	var sequence = jQuery("#sequence").sequence(options).data("sequence");
});