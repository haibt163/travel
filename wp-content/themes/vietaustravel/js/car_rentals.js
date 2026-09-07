jQuery.noConflict();
jQuery(document).ready(function() {

	jQuery('.book_car_rental_image').on('click', function(event) {
		var buttonId = jQuery(this).attr('id');
		var carRentalId = buttonId.replace('book_car_rental_image', '');
		jQuery('#car_booking_form_car_type_name').html(jQuery('#car_rental_' + carRentalId + '_car_type_name').val());
		jQuery('#car_booking_form_car_price').html(jQuery('#car_rental_' + carRentalId + '_car_price').val());
		jQuery('#car_booking_form_term_from').html(jQuery('#car_rental_' + carRentalId + '_term_from').val());
		jQuery('#car_booking_form_term_to').html(jQuery('#car_rental_' + carRentalId + '_term_to').val());
		jQuery('#car_booking_form_car_rental_name').html(jQuery('#car_rental_' + carRentalId + '_car_rental_name').val());
		window.carRentalId = carRentalId;
		jQuery('#car_booking_form_car_rental_id').val(window.carRentalId);
		showCarRentalForm();
	});


	jQuery('.book_car_rental').on('click', function(event) {
		var buttonId = jQuery(this).attr('id');
		var carRentalId = buttonId.replace('book_car_rental', '');
		jQuery('#car_booking_form_car_type_name').html(jQuery('#car_rental_' + carRentalId + '_car_type_name').val());
		jQuery('#car_booking_form_car_price').html(jQuery('#car_rental_' + carRentalId + '_car_price').val());
		jQuery('#car_booking_form_term_from').html(jQuery('#car_rental_' + carRentalId + '_term_from').val());
		jQuery('#car_booking_form_term_to').html(jQuery('#car_rental_' + carRentalId + '_term_to').val());
		jQuery('#car_booking_form_car_rental_name').html(jQuery('#car_rental_' + carRentalId + '_car_rental_name').val());
		window.carRentalId = carRentalId;
		jQuery('#car_booking_form_car_rental_id').val(window.carRentalId);
		showCarRentalForm();
	});
	
	jQuery('#cancel-car_rental-booking').on('click', function(event) {
		hideCarRentalBookingForm();
		jQuery('.sort-by').show();
		jQuery('.deals').show();
		jQuery('.offers').show();
		jQuery('.destinations').show();
		jQuery('.full').show();
	});	
	

	jQuery('#car_rental-booking-form').validate({
		onkeyup: false,
		ignore: [],
		errorPlacement: function(error, element) {
			if (element.attr('type') == 'hidden' && (element.attr('id') == 'car_booking_form_date_from' || element.attr('id') == 'car_booking_form_date_to'))
				error.appendTo( jQuery('#car_booking_form_datepicker') );
			else
				error.insertAfter(element);
		},
		rules: {
			car_booking_form_first_name: {
				required: true
			},
			car_booking_form_last_name: "required",
			car_booking_form_email: {
				required: true,
				email: true
			},
			car_booking_form_confirm_email: {
				required: true,
				equalTo: "#car_booking_form_email"
			},
			car_booking_form_phone: "required",
			car_booking_form_address: "required",
			car_booking_form_town: "required",
			car_booking_form_zip: "required",
			car_booking_form_country: "required",
			car_booking_form_date_from: "required",
			car_booking_form_date_to: "required"
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
			car_booking_form_first_name: window.bookingFormFirstNameError,
			car_booking_form_last_name: window.bookingFormLastNameError,
			car_booking_form_email: window.bookingFormEmailError,
			car_booking_form_confirm_email: {
				required: window.bookingFormConfirmEmailError1,
				equalTo: window.bookingFormConfirmEmailError2
			},
			car_booking_form_phone: window.bookingFormPhoneError,
			car_booking_form_address: window.bookingFormAddressError,
			car_booking_form_town: window.bookingFormCityError,
			car_booking_form_zip: window.bookingFormZipError,
			car_booking_form_country: window.bookingFormCountryError,
			car_booking_form_date_from: window.bookingFormDateFromError,
			car_booking_form_date_to: window.bookingFormDateToError
		},
		submitHandler: function() { 
			processCarRentalBooking(); }
		,
		debug:true
	});

});

function showCarRentalForm() {
	jQuery('#car_rental-booking-form').show();
	jQuery('.sort-by').hide();
	jQuery('.deals').hide();
	jQuery('.offers').hide();
	jQuery('.destinations').hide();
	jQuery('.full').hide();
	
	if (typeof jQuery('#car_booking_form_datepicker') !== 'undefined') {
		var datepickerDateFormat = 'yy-mm-dd';
		jQuery('#car_booking_form_datepicker').datepicker({
			dateFormat: datepickerDateFormat,
			numberOfMonths: 1,
			minDate: 0,
			beforeShowDay: function(d) {
				var date1 = null;
				var date2 = null;
				if (jQuery("#car_booking_form_date_from").val())
					date1 = jQuery.datepicker.parseDate(datepickerDateFormat, jQuery("#car_booking_form_date_from").val());
				if (jQuery("#car_booking_form_date_to").val())
					date2 = jQuery.datepicker.parseDate(datepickerDateFormat, jQuery("#car_booking_form_date_to").val());

				if (window['sc_cr_bd' + window.carRentalId]) {
					var dateTextForCompare = d.getFullYear() + '-' + ("0" + (d.getMonth() + 1)).slice(-2) + '-' + ("0" + d.getDate()).slice(-2);
					if (jQuery.inArray(dateTextForCompare, window['sc_cr_bd' + window.carRentalId]) > -1)
						return [false, 'ui-datepicker-unselectable ui-state-disabled'];
				}
				
				return [true, date1 && ((d.getTime() == date1.getTime()) || (date2 && d >= date1 && d <= date2)) ? "dp-highlight" : ""];
			},
			onSelect: function(dateText, inst) {
				var dateTextForParse = inst.currentYear + '-' + (inst.currentMonth + 1) + '-' + ("0" + inst.currentDay).slice(-2);
				var date1 = null;
				if (jQuery("#car_booking_form_date_from").val())
					date1 = jQuery.datepicker.parseDate(datepickerDateFormat, jQuery("#car_booking_form_date_from").val());
				var date2 = null;
				if (jQuery("#car_booking_form_date_to").val())
					date2 = jQuery.datepicker.parseDate(datepickerDateFormat, jQuery("#car_booking_form_date_to").val());

				if (!date1 || date2) {
					jQuery("#car_booking_form_date_from").val(dateText);
					jQuery("#car_booking_form_date_to").val("");
				} else {
					var dateCompare = Date.parse(dateTextForParse);
					if (dateCompare < date1)
					{
						jQuery("#car_booking_form_date_from").val(dateText);
						jQuery("#car_booking_form_date_to").val("");							
					}
					else
					{
						date1 = jQuery.datepicker.parseDate(datepickerDateFormat, jQuery("#car_booking_form_date_from").val());
						date2 = jQuery.datepicker.parseDate(datepickerDateFormat, dateText);
						
						var allOk = true;
						for (var d = date1; d <= date2; d.setDate(d.getDate() + 1)) {
							var dateTextForCompare = d.getFullYear() + '-' + ("0" + (d.getMonth() + 1)).slice(-2) + '-' +  ("0" + d.getDate()).slice(-2);
							if (jQuery.inArray(dateTextForCompare, window['sc_cr_bd' + window.carRentalId]) > -1)
								allOk = false;
						}
						
						if (!allOk) {
							jQuery("#car_booking_form_date_from").val(dateText);
							jQuery("#car_booking_form_date_to").val("");									
						} else {
							jQuery("#car_booking_form_date_to").val(dateText);
							
							var d1=new Date(jQuery("#car_booking_form_date_from").val());
							var d2=new Date(jQuery("#car_booking_form_date_to").val());       
							var days = (Math.abs((d2-d1)/86400000)); //days between 2 dates
							var pricePerDay = jQuery('#car_rental_' + carRentalId + '_car_price').val();
							var totalPrice = days*pricePerDay;
							jQuery('#car_confirm_total_price').html(window.currencySymbol + totalPrice);
						}
					}
				}
			},
			onChangeMonthYear: function (year, month, inst) {

			}
		});
	}
}

function hideCarRentalBookingForm() {
	jQuery('#car_rental-booking-form').hide();
}

function processCarRentalBooking() {
	var first_name = jQuery('#car_booking_form_first_name').val();
	var last_name = jQuery('#car_booking_form_last_name').val();
	var email = jQuery('#car_booking_form_email').val();
	var phone = jQuery('#car_booking_form_phone').val();
	var address = jQuery('#car_booking_form_address').val();
	var town = jQuery('#car_booking_form_town').val();
	var zip = jQuery('#car_booking_form_zip').val();
	var country = jQuery('#car_booking_form_country').val();
	var requirements = jQuery('#car_booking_form_requirements').val();
	var car_rental_id = jQuery('#car_booking_form_car_rental_id').val();
	var date_from = jQuery('#car_booking_form_date_from').val();
	var date_to = jQuery('#car_booking_form_date_to').val();
	var pick_up = jQuery('#car_booking_form_term_from').html();
	var drop_off = jQuery('#car_booking_form_term_to').html();
	var car_rental_name = jQuery('#car_booking_form_car_rental_name').html();
	
	var d1=new Date(date_from);
	var d2=new Date(date_to);       
	var days = (Math.abs((d2-d1)/86400000)); //days between 2 dates
	
	jQuery("#car_confirm_first_name").html(first_name);
	jQuery("#car_confirm_last_name").html(last_name);
	jQuery("#car_confirm_email_address").html(email);
	jQuery("#car_confirm_phone").html(phone);
	jQuery("#car_confirm_street").html(address);
	jQuery("#car_confirm_town").html(town);
	jQuery("#car_confirm_zip").html(zip);
	jQuery("#car_confirm_country").html(country);
	jQuery("#car_confirm_requirements").html(requirements);
	jQuery("#car_confirm_date_from").html(date_from);
	jQuery("#car_confirm_date_to").html(date_to);
	jQuery("#car_confirm_pick_up").html(pick_up);
	jQuery("#car_confirm_drop_off").html(drop_off);
	jQuery('#car_confirm_car_rental_name').html(car_rental_name);
	
	jQuery.ajax({
		url: BYTAjax.ajaxurl,
		data: {
			'action':'book_car_rental_ajax_request',
			'first_name' : first_name,
			'last_name' : last_name,
			'email' : email,
			'phone' : phone,
			'address' : address,
			'town' : town,
			'zip' : zip,
			'country' : country,
			'requirements' : requirements,
			'date_to' : date_to,
			'date_from' : date_from,
			'car_rental_id' : car_rental_id,
			'nonce' : BYTAjax.nonce
		},
		success:function(data) {
			// This outputs the result of the ajax request
			console.log(data);				
			hideCarRentalBookingForm();
			showCarRentalConfirmationForm();
		},
		error: function(errorThrown){
			console.log(errorThrown);
		}
	}); 
}

function showCarRentalConfirmationForm() {
	jQuery('#car_rental-confirmation-form').show();
}

function hideCarRentalConfirmationForm() {
	jQuery('#car_rental-confirmation-form').hide();
}