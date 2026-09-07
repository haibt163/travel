	jQuery.noConflict();
	jQuery(document).ready(function() {

		jQuery('.radio').bind('click.uniform',
			function (e) {
				if (jQuery(this).find("span").hasClass('checked')) 
					jQuery(this).find("input").attr('checked', true);
				else
					jQuery(this).find("input").attr('checked', false);
			}
		);
		
		jQuery('#book-tour').hide();
		jQuery('#book-tour').on('click', function(event) {
			var tourScheduleId = jQuery("input[name='schedule_radio']:checked").val();
			window.tourScheduleId = tourScheduleId;
			jQuery('#start_date').html(jQuery('#schedule_' + tourScheduleId + '_date').val());
			jQuery('#total_price').html(jQuery('#schedule_' + tourScheduleId + '_price').val());
			jQuery('#tour_name').html(window.tourTitle);
			jQuery('#tour_schedule_id').val(window.tourScheduleId);
			
			showTourBookingForm();
			return false;
		});
		
		jQuery('.review_tour').on('click', function(event) {
			showTourReviewForm();
		});	
		
		jQuery('.cancel_tour_review').on('click', function(event) {
			hideTourReviewForm();
		});	

		jQuery('input:radio[name="schedule_radio"]').change(function(){
			if (jQuery(this).is(':checked')) {
				jQuery('#book-tour').show();
			}		
		});

		jQuery('#review-tour-form').validate({
			onkeyup: false,
			rules: {
				likes: {
					required: true
				},
				dislikes: "required"
			},
			invalidHandler: function(e, validator) {
				var errors = validator.numberOfInvalids();
				if (errors) {
					var message = errors == 1
						? window.formSingleError
						: window.formMultipleError.format(errors);
					jQuery("div.error span p").html(message);
					jQuery("div.error").show();
				} else {
					jQuery("div.error").hide();
				}
			},
			messages: {
				likes: window.reviewFormLikesError,
				dislikes: window.reviewFormDislikesError
			},
			submitHandler: function() { processTourReview(); },
			debug:true
		});		

		jQuery('#tour-booking-form').validate({
			onkeyup: false,
			rules: {
				first_name: {
					required: true
				},
				last_name: "required",
				email: {
					required: true,
					email: true
				},
				confirm_email: {
					required: true,
					equalTo: "#email"
				},
				phone: "required",
				address: "required",
				town: "required",
				zip: "required",
				country: "required"
			},
			invalidHandler: function(e, validator) {
				var errors = validator.numberOfInvalids();
				if (errors) {
					var message = errors == 1
						? window.formSingleError
						: window.formMultipleError.format(errors);
					jQuery("div.error span p").html(message);
					jQuery("div.error").show();
				} else {
					jQuery("div.error").hide();
				}
			},
			messages: {
				first_name: window.bookingFormFirstNameError,
				last_name: window.bookingFormLastNameError,
				email: window.bookingFormEmailError,
				confirm_email: {
					required: window.bookingFormConfirmEmailError1,
					equalTo: window.bookingFormConfirmEmailError2
				},
				phone: window.bookingFormPhoneError,
				address: window.bookingFormAddressError,
				town: window.bookingFormCityError,
				zip: window.bookingFormZipError,
				country: window.bookingFormCountryError
			},
			submitHandler: function() { processTourBooking(); },
			debug:true
		});
		
		jQuery('#cancel-tour-booking').on('click', function(event) {
			hideTourBookingForm();
			showTourInfo();
		});	
	});
	
	function showTourInfo() {
		jQuery('.three-fourth .gallery').show();
		jQuery('.three-fourth .inner-nav').show();
		jQuery('.three-fourth .tab-content').show();
		jQuery(".tab-content").hide();
		jQuery(".tab-content:first").show();
		jQuery(".inner-nav li:first").addClass("active");
	}	

	function showTourBookingForm() {
		jQuery('#tour-booking-form').show();
		jQuery('.three-fourth .gallery').hide();
		jQuery('.three-fourth .inner-nav').hide();
		jQuery('.three-fourth .tab-content').hide();
	}
	
	function hideTourBookingForm() {
		jQuery('#tour-booking-form').hide();
	}
	
	function showTourReviewForm() {
		jQuery('.three-fourth').hide();
		jQuery('.right-sidebar').hide();
		jQuery('.full-width.review-tour-section').show();
	}
		
	function hideTourReviewForm() {
		jQuery('.three-fourth').show();
		jQuery('.right-sidebar').show();
		jQuery('.full-width.review-tour-section').hide();
	}
		
	function processTourReview() {
		var likes = jQuery('#likes').val();
		var dislikes = jQuery('#dislikes').val();

		var dataObj = {
				'action':'review_tour_ajax_request',
				'likes' : likes,
				'dislikes' : dislikes,
				'userId' : window.currentUserId,
				'postId' : window.tourId,
				'nonce' : BYTAjax.nonce
			}		
		
		for (var i = 0; i < window.reviewFields.length; i++) {
			var slug = window.reviewFields[i];
			dataObj["tourReviewField_" + slug] = jQuery("input[type='radio'][name='tourReviewField_" + slug + "']:checked").val();
		}
		
		jQuery.ajax({
			url: BYTAjax.ajaxurl,
			data: dataObj,
			success:function(data) {
				// This outputs the result of the ajax request
				console.log(data);
				jQuery('.review_tour').hide(); // hide the button
				hideTourReviewForm();
			},
			error: function(errorThrown){
				console.log(errorThrown);
			}
		}); 
	}
	
	function showTourConfirmationForm() {
		jQuery('#tour-confirmation-form').show();
	}
	
	function hideTourConfirmationForm() {
		jQuery('#tour-confirmation-form').hide();
	}	

	function processTourBooking() {
		
		var first_name = jQuery('#first_name').val();
		var last_name = jQuery('#last_name').val();
		var email = jQuery('#email').val();
		var phone = jQuery('#phone').val();
		var address = jQuery('#address').val();
		var town = jQuery('#town').val();
		var zip = jQuery('#zip').val();
		var country = jQuery('#country').val();
		var requirements = jQuery('#requirements').val();
		var tour_schedule_id = jQuery('#tour_schedule_id').val();

		jQuery("#confirm_first_name").html(first_name);
		jQuery("#confirm_last_name").html(last_name);
		jQuery("#confirm_email_address").html(email);
		jQuery("#confirm_phone").html(phone);
		jQuery("#confirm_street").html(address);
		jQuery("#confirm_town").html(town);
		jQuery("#confirm_zip").html(zip);
		jQuery("#confirm_country").html(country);
		jQuery("#confirm_requirements").html(requirements);
		
		jQuery.ajax({
			url: BYTAjax.ajaxurl,
			data: {
				'action':'book_tour_ajax_request',
				'first_name' : first_name,
				'last_name' : last_name,
				'email' : email,
				'phone' : phone,
				'address' : address,
				'town' : town,
				'zip' : zip,
				'country' : country,
				'requirements' : requirements,
				'tour_schedule_id' : tour_schedule_id,
				'nonce' : BYTAjax.nonce
			},
			success:function(data) {
				// This outputs the result of the ajax request
				console.log(data);				
				hideTourBookingForm();
				showTourConfirmationForm();
			},
			error: function(errorThrown){
				console.log(errorThrown);
			}
		}); 
	}