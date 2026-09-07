jQuery.noConflict();	

function handleRibbonClick(e) {
	if (jQuery(this).hasClass('fn')) {
		return true; // allow clicking of links like logout.
	} else {
		jQuery(".ribbon li").hide();
		if (jQuery(this).parent().parent().hasClass('open'))
			jQuery(this).parent().parent().removeClass('open');
		else {
			jQuery(".ribbon ul").removeClass('open');
			jQuery(this).parent().parent().addClass('open');
		}
		jQuery(this).parent().siblings().each(function() {
			jQuery(this).removeClass('active');
		});
		jQuery(this).parent().attr('class', 'active'); 
		jQuery('.ribbon li.active').show();
		jQuery('.ribbon ul.open li').show();
		
		if (jQuery(this).hasClass('currency')) {

			var currencyClass= jQuery(this).attr('class');
			currencyClass = currencyClass.replace('currency ', '').toUpperCase();
			if (window.currentCurrency != currencyClass) {
				var prevCurrency = window.currentCurrency;
				window.currentCurrency = currencyClass;				
			
				var	currency_symbol = get_currency_symbol(window.currentCurrency);

				convert_currency(prevCurrency, window.currentCurrency, currency_symbol);
			}
		}	

		if (window.currentLanguage) {
			jQuery('.ribbon li.icl-' + window.currentLanguage).show();
		}
		
		return false;
	}
}

jQuery( window ).load(function() {
  // Run code
});

jQuery(document).ready(function () {
	//UI FORM ELEMENTS
	var spinner = jQuery('.spinner input').spinner({ min: 0 });
	
	jQuery('#from').datepicker({
		showOn: 'button',
		buttonImage: window.themePath + '/images/ico/calendar.png',
		buttonImageOnly: true,
		minDate: 0,
		onClose: function (selectedDate) {
			var d = new Date(selectedDate);
			d = new Date(d.getFullYear(), d.getMonth(), d.getDate()+1);
			jQuery("#to").datepicker("option", "minDate", d);
        }
	});
	
	jQuery('#from2').datepicker({
		showOn: 'button',
		buttonImage: window.themePath + '/images/ico/calendar.png',
		buttonImageOnly: true,
		minDate: 0,
		onClose: function (selectedDate) {
			var d = new Date(selectedDate);
			d = new Date(d.getFullYear(), d.getMonth(), d.getDate()+1);
			jQuery("#to2").datepicker("option", "minDate", d);
        }
	});
	
	jQuery('#from3').datepicker({
		showOn: 'button',
		buttonImage: window.themePath + '/images/ico/calendar.png',
		buttonImageOnly: true,
		minDate: 0,
		onClose: function (selectedDate) {
			var d = new Date(selectedDate);
			d = new Date(d.getFullYear(), d.getMonth(), d.getDate()+1);
			jQuery("#to3").datepicker("option", "minDate", d);
        }
	});
	
	jQuery('#from4').datepicker({
		showOn: 'button',
		buttonImage: window.themePath + '/images/ico/calendar.png',
		buttonImageOnly: true,
		minDate: 0
	});

	jQuery('#to').datepicker({
		showOn: 'button',
		buttonImage: window.themePath + '/images/ico/calendar.png',
		buttonImageOnly: true,
		onClose: function (selectedDate) {
			var d = new Date(selectedDate);
			d = new Date(d.getFullYear(), d.getMonth(), d.getDate()-1);
			jQuery("#from").datepicker("option", "maxDate", d);
        }
	});
	
	jQuery('#to2').datepicker({
		showOn: 'button',
		buttonImage: window.themePath + '/images/ico/calendar.png',
		buttonImageOnly: true,
		onClose: function (selectedDate) {
			var d = new Date(selectedDate);
			d = new Date(d.getFullYear(), d.getMonth(), d.getDate()-1);
			jQuery("#from2").datepicker("option", "maxDate", d);
        }
	});
	
	jQuery('#to3').datepicker({
		showOn: 'button',
		buttonImage: window.themePath + '/images/ico/calendar.png',
		buttonImageOnly: true,
		onClose: function (selectedDate) {
			var d = new Date(selectedDate);
			d = new Date(d.getFullYear(), d.getMonth(), d.getDate()-1);
			jQuery("#from3").datepicker("option", "maxDate", d);
        }
	});
	
	jQuery( "#slider" ).slider({
		range: "min",
		value:0,
		min: 0,
		max: 10,
		step: 1
	});
	
	//CUSTOM FORM ELEMENTS
	jQuery("input[type=radio], select, input[type=checkbox]").uniform();
		
	jQuery('.form').hide();
	jQuery('.form input').prop('disabled', true);	
	jQuery('.form select').prop('disabled', true);	
	jQuery("#form" + window.visibleSearchFormNumber).show();
	jQuery("#form" + window.visibleSearchFormNumber + " input").prop('disabled', false);
	jQuery("#form" + window.visibleSearchFormNumber + " select").prop('disabled', false);
	jQuery('.main-search input[name=what]').change(function() {
		window.visibleSearchFormNumber = jQuery(this).val();
		jQuery('.form').hide();
		jQuery('.form input').prop('disabled', true);
		jQuery('.form select').prop('disabled', true);
		jQuery("#form" + window.visibleSearchFormNumber).show();
		jQuery("#form" + window.visibleSearchFormNumber + " input").prop('disabled', false);
		jQuery("#form" + window.visibleSearchFormNumber + " select").prop('disabled', false);
		jQuery.uniform.update('select'); 
	});
	
	//SCROLL TO TOP BUTTON
	jQuery('.scroll-to-top').click(function () {
		jQuery('body,html').animate({
			scrollTop: 0
		}, 800);
		return false;
	});

	//HEADER RIBBON NAVIGATION
	jQuery('.ribbon li').hide();
	jQuery('.ribbon li.active').show();
	if (window.currentLanguage) {
		jQuery('.ribbon li.icl-' + window.currentLanguage).show();
	}
	jQuery(".ribbon li:not([class^='icl-']) a").click(handleRibbonClick);
	if (window.currentLanguage) {
		jQuery(".ribbon li.icl-" + window.currentLanguage + " a").click(handleRibbonClick);
	}
	
	//LIGHTBOX
	jQuery("a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'normal',theme:'light_square'});
	
	//TABS
	jQuery(".tab-content").hide();
	jQuery(".tab-content:first").show();
	jQuery(".inner-nav li:first").addClass("active");

	jQuery(".inner-nav a").click(function(){
		jQuery(".inner-nav li").removeClass("active");
		jQuery(this).parent().addClass("active");
		var currentTab = jQuery(this).attr("href");
		if (currentTab == "#location")
			initialize_map();
		jQuery(".tab-content").hide();
		jQuery(currentTab).show();
		return false;
	});
	
	
	//CSS
	jQuery('.top-right-nav li:last-child,.social li:last-child,.twins .f-item:last-child,.ribbon li:last-child,.room-types li:last-child,.three-col li:nth-child(3n),.reviews li:last-child,.three-fourth .deals .one-fourth:nth-child(3n),.full .one-fourth:nth-of-type(4n),.locations .one-fourth:nth-child(3n),.pager span:last-child,.get_inspired li:nth-child(5n)').addClass('last');
	jQuery('.bottom nav li:first-child,.pager span:first-child').addClass('first');
	
	//ROOM TYPES MORE BUTTON
	jQuery(".more-information").slideUp();
	jQuery(".more-info").click(function() {
		var moreinformation = jQuery(this).closest("li").find(".more-information");
		var txt = moreinformation.is(':visible') ? '+ more info' : ' - less info';
		jQuery(this).text(txt);
		moreinformation.stop(true, true).slideToggle("slow");
	});
	
	jQuery(".f-item .radio").click(function() {
		jQuery(".f-item").removeClass("active");
		jQuery(this).parent().addClass("active");
	});	
		
	jQuery('.grid-view').click(function() {
		jQuery(".three-fourth article").attr("class", "one-fourth");
		jQuery(".three-fourth article:nth-child(3n)").addClass("last");
		jQuery(".view-type li").removeClass("active");
		jQuery(this).addClass("active");
	});
	
	jQuery('.list-view').click(function() {
		jQuery(".three-fourth article").attr("class", "full-width");
		jQuery(".view-type li").removeClass("active");
		jQuery(this).addClass("active");
	});
	
	// LIST AND GRID VIEW TOGGLE
	if (window.defaultResultsView === 0)
		jQuery('.view-type li.grid-view').trigger('click');
	else
		jQuery('.view-type li.list-view').trigger('click');

	
	// ACCOMMODATION PAGE GALLERY
	jQuery('.gallery img:first-child').css('opacity',1);
	
	var i=0,p=1,q=function(){return document.querySelectorAll(".gallery>img")};

	function s(e){
	for(c=0;c<q().length;c++){q()[c].style.opacity="0";q()[e].style.opacity="1"}
	}

	setInterval(function(){
	if(p){i=(i>q().length-2)?0:i+1;s(i)}
	},5000);

});

jQuery(window).load(function() {
	if (window.currentCurrency != window.defaultCurrency) {
		var	currency_symbol = get_currency_symbol(window.currentCurrency);
		convert_currency(window.defaultCurrency, window.currentCurrency, currency_symbol);
	}
});

function get_currency_symbol(currency_code) {

	var currency_symbol = '';
	
	var dataObj = {
		'action':'currency_symbol_ajax_request',
		'currency_code' : currency_code,
		'nonce' : BYTAjax.nonce
	}		

	jQuery.ajax({
		url: BYTAjax.ajaxurl,
		data: dataObj,
		async: false,
		success:function(data) {
			// This outputs the result of the ajax request
			console.log(data);
			currency_symbol = data;
		},
		error: function(errorThrown){
			console.log(errorThrown);
		}
	});

	return currency_symbol;
}

function convert_currency(from, to, toHtml) {

	var elCount = 0;
	jQuery('.amount').each(function(j, ctrl) {	
		var amountElement = jQuery(ctrl);

		var amount = amountElement.html();		
		var dataObj = {
				'action':'currency_ajax_request',
				'from' : from,
				'to' : to,
				'amount' : amount,
				'userId' : window.currentUserId,
				'nonce' : BYTAjax.nonce
			}	

		jQuery.ajax({
			url: BYTAjax.ajaxurl,
			data: dataObj,
			success:function(data) {
				// This outputs the result of the ajax request
				console.log(data);
				if (elCount == 0) {
					jQuery('.curr').each(function(i, ctrl2) {	
						jQuery(ctrl2).html(toHtml); // child
					});					
				}
				amountElement.html(data);
				elCount += 1;
			},
			error: function(errorThrown){
				console.log(errorThrown);
			}
		}); 
	}); 
}

//first, checks if it isn't implemented yet
if (!String.prototype.format) {
  String.prototype.format = function() {
    var args = arguments;
    return this.replace(/{(\d+)}/g, function(match, number) { 
      return typeof args[number] != 'undefined'
        ? args[number]
        : match
      ;
    });
  };
}

function toggleLightbox(id) {
	if (id != 'login_lightbox' && jQuery('#login_lightbox').is(":visible"))
		jQuery('#login_lightbox').hide();
	else if (id != 'register_lightbox' && jQuery('#register_lightbox').is(":visible"))
		jQuery('#register_lightbox').hide();
	jQuery('#' + id).toggle(500);
}	

// Initiate selectnav function
selectnav();

jQuery(".menu-right-taskbar li.submenu").on('click', function(){	
	if (jQuery(".menu-right-taskbar li.submenu .submenu-taskbar").hasClass("display-submenu")) {
			jQuery(".menu-right-taskbar li.submenu .submenu-taskbar").removeClass("display-submenu");					
	}else{
		jQuery(".menu-right-taskbar li.submenu .submenu-taskbar").addClass("display-submenu");
	}

	return true;
							
});



