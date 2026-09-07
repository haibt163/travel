function confirm_delete(form_id, message) {
	var answer = confirm(message);
	if (answer){
		jQuery(form_id).submit();
		return true;
	}
	return false;  
}

jQuery.noConflict();

function showHideRoomTypes(checked) {
	if (checked)
		jQuery('#accommodation_is_self_catered').closest('tr').next().hide();
	else
		jQuery('#accommodation_is_self_catered').closest('tr').next().show();
}

function accommodationFilterRedirect(accommodationId, roomTypeId, year, month) {
    document.location = 'edit.php?post_type=accommodation&page=theme_accommodation_vacancy_admin.php&accommodation_id=' + accommodationId + '&room_type_id=' + roomTypeId + '&year=' + year + '&month=' + month;
};

function tourFilterRedirect(id, year, month) {
    document.location = 'edit.php?post_type=tour&page=theme_tour_schedule_admin.php&tour_id=' + id + '&year=' + year + '&month=' + month;
};

jQuery(document).ready(function() {
	
	showHideRoomTypes(jQuery('#accommodation_is_self_catered').is(':checked'));
	jQuery("#accommodation_is_self_catered").change(function() {
		showHideRoomTypes(jQuery(this).is(':checked'));
	});
	
	jQuery('#accommodations_select').on('change', function() {
		var accommodationId = jQuery(this).val()
		var _wpnonce = jQuery('#_wpnonce').val();
		
		var dataObj = {
				'action':'is_self_catered_ajax_request',
				'accommodationId' : accommodationId,
				'nonce' : _wpnonce
			}				  
	
		jQuery.ajax({
			url: window.adminAjaxUrl,
			data: dataObj,
			success:function(data) {
				// This outputs the result of the ajax request
				console.log(data);
				if (data == '1') {
					jQuery('#room_types_row').hide();
					jQuery('#room_count_row').hide();
					jQuery('#per_room').hide();
				} else {
					jQuery('#room_types_row').show();
					jQuery('#room_count_row').show();
					jQuery('#per_room').show();
				}
			},
			error: function(errorThrown){
				console.log(errorThrown);
			}
		}); 
	});
});
