<?php

/*************************** LOAD THE BASE CLASS *******************************
 *******************************************************************************
 * The WP_List_Table class isn't automatically available to plugins, so we need
 * to check if it's available and load it if necessary.
 */
if(!class_exists('WP_List_Table')){
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

add_action('admin_menu' , 'accommodation_vacancy_admin_page');

function accommodation_vacancy_admin_page() {
	$hook = add_submenu_page('edit.php?post_type=accommodation', 'BYT Accommodation vacancy management', 'Vacancies', 'edit_posts', basename(__FILE__), 'accommodation_vacancies_admin_display');
	add_action( "load-$hook", 'accommodation_vacancies_add_screen_options');
}

function accommodation_vacancies_set_screen_options($status, $option, $value) {
	if ( 'accommodation_vacancies_per_page' == $option ) 
		return $value;
}
add_filter('set-screen-option', 'accommodation_vacancies_set_screen_options', 10, 3);

function accommodation_vacancies_admin_head() {
	$page = ( isset($_GET['page'] ) ) ? esc_attr( $_GET['page'] ) : false;
	if( 'theme_accommodation_vacancy_admin.php' != $page )
		return;

	accommodation_vacancies_admin_styles();
}
add_action( 'admin_head', 'accommodation_vacancies_admin_head' );		

add_action( 'wp_ajax_is_self_catered_ajax_request', 'is_self_catered_ajax_request' );
function is_self_catered_ajax_request() {
	if ( isset($_REQUEST) ) {
		$nonce = wp_kses($_REQUEST['nonce'], '');
		$accommodationId = wp_kses($_REQUEST['accommodationId'], '');
		if (wp_verify_nonce( $nonce, 'accommodation_vacancy_entry_form' )) {
			$is_self_catered = get_post_meta( $accommodationId, 'accommodation_is_self_catered', true );
			echo $is_self_catered ? '1' : '0';
		} else {
			echo 'bye';
		}
	} else {
		echo 'boo';
	}
	
	// Always die in functions echoing ajax content
	die();
}

function accommodation_vacancies_admin_styles() {

	if (isset($_POST['from'])) 
		$date_from =  wp_kses($_POST['from'], '');
	if (isset($_POST['to'])) 
		$date_to =  wp_kses($_POST['to'], '');

	echo '<style type="text/css">';
	echo '	.wp-list-table .column-Id { width: 100px; }';
	echo '	.wp-list-table .column-AccommodationName { width: 250px; }';
	echo '	.wp-list-table .column-RoomType { width: 150px; }';
	echo '	.wp-list-table .column-VacancyDay { width: 150px; }';
	echo '	.wp-list-table .column-Rooms { width: 150px; }';
	echo '  table.calendar { width:60%; }
			table.calendar th { text-align:center; }
			table.calendar td { border:none;text-align:center;height:30px;line-height:30px;vertical-align:middle; }
			table.calendar td.sel a { color:#fff;padding:10px;background:#b1b1b1; }
			table.calendar td.cur a { color:#fff;padding:10px;background:#ededed; }';
	echo "</style>";
	echo '<script>';
	echo '	window.adminAjaxUrl = "' . home_url() . '/wp-admin/admin-ajax.php";
		jQuery.noConflict();
		jQuery(document).ready(function () {
			jQuery("#from").datepicker({
				dateFormat: \'yy-mm-dd\',
				minDate: 0,';
	if (!empty($date_to))
		echo '  maxDate: "' . $date_to .'",';
	echo '		onClose: function (selectedDate) {
					var d = new Date(selectedDate);
					d = new Date(d.getFullYear(), d.getMonth(), d.getDate()+1);
					jQuery("#to").datepicker("option", "minDate", d);
				}			
			});
			jQuery("#to").datepicker({
				dateFormat: \'yy-mm-dd\',';
	if (!empty($date_from))
		echo '  minDate: "' . $date_from .'",';
	echo '		onClose: function (selectedDate) {
					var d = new Date(selectedDate);
					d = new Date(d.getFullYear(), d.getMonth(), d.getDate()-1);
					jQuery("#from").datepicker("option", "maxDate", d);
				}
			});
		});
	';
	echo '</script>';	
}

function accommodation_vacancies_add_screen_options() {
	global $wp_accommodation_vacancy_table;
	$option = 'per_page';
	$args = array('label' => 'Vacancies','default' => 50,'option' => 'accommodation_vacancies_per_page');
	add_screen_option( $option, $args );
 	$wp_accommodation_vacancy_table = new accommodation_vacancy_admin_list_table();
}

function accommodation_vacancies_admin_display() {
	echo '<div class="wrap"><h2>BYT Accommodation vacancies</h2><p>Accommodation vacancy management filter</p>'; 
	global $wp_accommodation_vacancy_table;
	$wp_accommodation_vacancy_table->handle_form_submit();
	
	if (isset($_GET['action']) && $_GET['action'] == 'delete_all_vacancies') {

		delete_all_accommodation_vacancies();
		
		echo '<div class="error" id="message" onclick="this.parentNode.removeChild(this)">';
		echo '<p>' . __('Successfully deleted all accommodation vacancies.', 'bookyourtravel') . '</p>';
		echo '</div>';
		
	} else if (isset($_GET['sub']) && $_GET['sub'] == 'manage') {
		$wp_accommodation_vacancy_table->render_entry_form(); 
	} else {
		$year = isset($_GET['year']) ? intval($_GET['year']) : intval(date("Y"));
		$month = isset($_GET['month']) ? intval($_GET['month']) : intval(date("m"));
		$current_day = ($year == intval(date("Y")) && $month  == intval(date("m"))) ? intval(date("j")) : 0;
		$accommodation_id = isset($_GET['accommodation_id']) ? intval($_GET['accommodation_id']) : 0;
		$is_self_catered = get_post_meta( $accommodationId, 'accommodation_is_self_catered', true );
		$room_type_id = isset($_GET['room_type_id']) ? intval($_GET['room_type_id']) : 0;
	
		$accommodations_filter = '<select id="accommodations_filter" name="accommodations_filter" onchange="accommodationFilterRedirect(this.value, ' . $room_type_id . ', ' . $year . ', ' . $month . ')">';
		$accommodations_filter .= '<option value="">' . __('Filter by accommodation', 'bookyourtravel') . '</option>';
		$accommodations_query = list_accommodations_all();
		if ($accommodations_query->have_posts()) {
			while ($accommodations_query->have_posts()) {
				$accommodations_query->the_post();
				global $post;				
				$accommodations_filter .= '<option value="' . $post->ID . '" ' . ($post->ID == $accommodation_id ? 'selected' : '') . '>' . $post->post_title . '</option>';
			}
		}
		$accommodations_filter .= '</select>';
		wp_reset_postdata();
		
		$room_type_filter = '<select id="room_type_filter" name="room_type_filter" onchange="accommodationFilterRedirect(' . $accommodation_id . ', this.value, ' . $year . ', ' . $month . ')">';
		$room_type_filter .= '<option value="">' . __('Filter by room type', 'bookyourtravel') . '</option>';
		$room_type_query = list_room_types_all();
		if ($room_type_query->have_posts()) {
			while ($room_type_query->have_posts()) {
				$room_type_query->the_post();
				global $post;				
				$room_type_filter .= '<option value="' . $post->ID . '" ' . ($post->ID == $room_type_id ? 'selected' : '') . '>' . $post->post_title . '</option>';
			}
		}
		$room_type_filter .= '</select>';
		wp_reset_postdata();
	
		echo '<p>' . __('Filter by date: ', 'bookyourtravel') . '</p>';
		$wp_accommodation_vacancy_table->render_admin_calendar($current_day, $month, $year, $accommodation_id); 
	
		echo '<p>' . __('Filter by accommodation: ', 'bookyourtravel') . $accommodations_filter . '</p>';
		
		if (!$accommodation_id || !$is_self_catered)
			echo '<p>' . __('Filter by room type: ', 'bookyourtravel') . $room_type_filter . '</p>';
		
		$wp_accommodation_vacancy_table->prepare_items(); 
		$wp_accommodation_vacancy_table->display();		

?>
    <div class="tablenav bottom">	
        <div class="alignleft actions">
            <a href="edit.php?post_type=accommodation&page=theme_accommodation_vacancy_admin.php&sub=manage" class="button-secondary action" ><?php _e('Add vacancies', 'bookyourtravel') ?></a>
        </div>
    </div>
	<?php
	} 
}

/************************** CREATE A PACKAGE CLASS *****************************
 *******************************************************************************
 * Create a new list table package that extends the core WP_List_Table class.
 * WP_List_Table contains most of the framework for generating the table, but we
 * need to define and override some methods so that our data can be displayed
 * exactly the way we need it to be.
 * 
 * To display this on a page, you will first need to instantiate the class,
 * then call $yourInstance->prepare_items() to handle any data manipulation, then
 * finally call $yourInstance->display() to render the table to the page.
 */
class accommodation_vacancy_admin_list_table extends WP_List_Table {

	private $options;
	private $lastInsertedID;
	
	/**
	* Constructor, we override the parent to pass our own arguments.
	* We use the parent reference to set some default configs.
	*/
	function __construct() {
		global $status, $page;	
	
		 parent::__construct( array(
			'singular'=> 'vacancy', // Singular label
			'plural' => 'vacancies', // plural label, also this well be one of the table css class
			'ajax'	=> false // We won't support Ajax for this table
		) );
		
	}	

	function column_default( $item, $column_name ) {
		return $item->$column_name;
	}	
	
	function extra_tablenav( $which ) {
		if ( $which == "top" ){	
			//The code that goes before the table is here
			$year = isset($_GET['year']) ? intval($_GET['year']) : 0;
			$month = isset($_GET['month']) ? intval($_GET['month']) : 0;
			$day = isset($_GET['day']) ? intval($_GET['day']) : 1;
			$accommodation_id = isset($_GET['accommodation_id']) ? intval($_GET['accommodation_id']) : 0;
			
			$accommodation_title = '';
			if ($accommodation_id > 0)
				$accommodation_title = get_the_title($accommodation_id);
			
			echo "<div class='alignleft'>";
			if ($year > 0 && $month > 0)
			{			
				echo '<p>' . __('Showing vacancies for ', 'bookyourtravel') . date('F Y', mktime(0,0,0, $month, $day, $year));
			} else {
				echo '<p>' . __('Showing all vacancies ', 'bookyourtravel');
			}
			
			if ($accommodation_id && !empty($accommodation_title)) {
				echo __(sprintf(' for accommodation "<strong>%s</strong>"', $accommodation_title), 'bookyourtravel');
			}
			echo '</p>';
			echo '<p class="alignleft actions">';
			echo " <a class='button-secondary action alignleft' href='edit.php?post_type=accommodation&page=theme_accommodation_vacancy_admin.php'>Show all vacancies for all accommodations</a>";
			if ($accommodation_id && !empty($accommodation_title)) {
				echo " <a class='button-secondary action alignleft' href='edit.php?post_type=accommodation&page=theme_accommodation_vacancy_admin.php&accommodation_id=$accommodation_id'>Show all vacancies for <strong>\"$accommodation_title\"</strong></a>";
			}
			echo " <a class='button-primary action alignright' onclick='return confirm_delete(\"#delete_all_vacancies\", \"" . __('Are you sure?', 'bookyourtravel') . "\");' href='edit.php?post_type=accommodation&page=theme_accommodation_vacancy_admin.php&action=delete_all_vacancies'>Delete all accommodation vacancies</a>";
			echo '</p>';
			echo '</div>';
		}
		if ( $which == "bottom" ){
			//The code that goes after the table is there
		}
	}		
	
	function column_AccommodationName($item) {
		return $item->accommodation_name;	
	}
	
	function column_RoomType($item) {
		if ($item->room_type)
			return $item->room_type;	
		else
			return __('N/A', 'bookyourtrave');
	}
	
	function column_RoomCount($item) {
		if ($item->room_count)
			return $item->room_count;	
		else
			return __('N/A', 'bookyourtrave');
	}
	
	function column_Price($item) {
		return $item->price;	
	}
	
	function column_VacancyDay($item) {
		return date("d.m.Y", strtotime($item->vacancy_day));	
	}
	
	function column_Action($item) {
		if (!$item->has_bookings) {
		
			return "<form method='post' name='delete_vacancy_" . $item->Id . "' id='delete_vacancy_" . $item->Id . "' style='display:inline;'>
						<input type='hidden' name='delete_vacancy' id='delete_vacancy' value='" . $item->Id . "' />
						<a href='javascript: void(0);' onclick='confirm_delete(\"#delete_vacancy_" . $item->Id . "\", \"" . __('Are you sure?', 'bookyourtravel') . "\");'>" . __('Delete', 'bookyourtravel') . "</a>
					</form>";
		}
		return "";
	}	
	
	/**
	 * Define the columns that are going to be used in the table
	 * @return array $columns, the array of columns to use with the table
	 */
	function get_columns() {
		return $columns= array(
			'Id'=>__('Id'),
			'VacancyDay'=>__('Vacancy Day'),
			'AccommodationName'=>__('Accommodation Name'),
			'RoomType'=>__('Room Type'),
			'RoomCount'=>__('Rooms'),
			'Price'=>__('Price'),
			'Action'=>__('Action'),				
		);
	}	
		
	/**
	 * Decide which columns to activate the sorting functionality on
	 * @return array $sortable, the array of columns that can be sorted by the user
	 */
	public function get_sortable_columns() {
		$sortable_columns = array(
			'Id'=> array( 'Id', true ),
			'RoomType'=> array( 'room_types.post_title', true ),
			'AccommodationName'=> array( 'accommodations.post_title', true ),
			'VacancyDay'=> array( 'vacancy_day', true ),
			'RoomCount'=> array( 'room_count', true ),
			'Price'=> array( 'price', true ),
		);
		return $sortable_columns;
	}	
	
	/**
	 * Prepare the table with different parameters, pagination, columns and table elements
	 */
	function prepare_items() {
	
		global $wpdb, $_wp_column_headers;
		
		$year = isset($_GET['year']) ? intval($_GET['year']) : 0;
		$month = isset($_GET['month']) ? intval($_GET['month']) : 0;
		$day = isset($_GET['day']) ? intval($_GET['day']) : 0;
		$accommodation_id = isset($_GET['accommodation_id']) ? intval($_GET['accommodation_id']) : 0;
		$room_type_id = isset($_GET['room_type_id']) ? intval($_GET['room_type_id']) : 0;
		
		$screen = get_current_screen();
		$user = get_current_user_id();
		$option = $screen->get_option('per_page', 'option');
		$per_page = get_user_meta($user, $option, true);
		if ( empty ( $per_page) || $per_page < 1 ) {
			$per_page = $screen->get_option( 'per_page', 'default' );
		}	

		$search_term = '';
		if (!empty($_REQUEST['s'])) {
			$search_term = mysql_real_escape_string(strtolower($_REQUEST['s']));
		}

		$columns = $this->get_columns(); 
		$hidden = array();
		$sortable = $this->get_sortable_columns();
		$this->_column_headers = array($columns, $hidden, $sortable);		
		
		/* -- Ordering parameters -- */
		//Parameters that are going to be used to order the result
		$orderby = !empty($_GET["orderby"]) ? mysql_real_escape_string($_GET["orderby"]) : 'Id';
		$order = !empty($_GET["order"]) ? mysql_real_escape_string($_GET["order"]) : 'ASC';

		/* -- Pagination parameters -- */
		//Number of elements in your table?
		$totalitems = list_accommodation_vacancies_total_items($day, $month, $year, $accommodation_id, $room_type_id); //return the total number of affected rows
		//How many to display per page?
		//Which page is this?
		$paged = !empty($_GET["paged"]) ? mysql_real_escape_string($_GET["paged"]) : '';
		//Page Number
		if(empty($paged) || !is_numeric($paged) || $paged<=0 ){ $paged=1; }
		//How many pages do we have in total?
		$totalpages = ceil($totalitems/$per_page);

		/* -- Register the pagination -- */
		$this->set_pagination_args( array(
			"total_items" => $totalitems,
			"total_pages" => $totalpages,
			"per_page" => $per_page,
		) );
		//The pagination links are automatically built according to those parameters

		/* -- Register the Columns -- */
		$columns = $this->get_columns();
		$_wp_column_headers[$screen->id]=$columns;

		/* -- Fetch the items -- */
		$this->items = list_paged_accommodation_vacancies($day, $month, $year, $accommodation_id, $room_type_id, $search_term, $orderby, $order, $paged, $per_page );
	}
	
	function handle_form_submit() {
		
		global $wpdb;
		
		if (isset($_POST['insert']) && check_admin_referer('accommodation_vacancy_entry_form')) {
			
			$accommodation_id = wp_kses($_POST['accommodations_select'], '');
			$room_type_id = wp_kses($_POST['room_types_select'], '');
			$date_from =  wp_kses($_POST['from'], '');
			$date_to =  wp_kses($_POST['to'], '');
			$room_count = intval(wp_kses($_POST['room_count'], '0'));
			$price = floatval(wp_kses($_POST['price'], '0'));
			
			$error = '';
			
			$is_self_catered = 0;
			if (!empty($accommodation_id)) {
				$is_self_catered = get_post_meta( $accommodation_id, 'accommodation_is_self_catered', true );
			}
			
			if(empty($accommodation_id)) {
				$error = __('You must select an accommodation', 'bookyourtravel');
			} else if(!$is_self_catered && empty($room_type_id)) {
				$error = __('You must select a room type', 'bookyourtravel');
			} else if (!$is_self_catered && (empty($room_count) || $room_count === 0)) {
				$error = __('You must provide a valid room count', 'bookyourtravel');
			} else if(empty($date_from)) {
				$error = __('You must select a from date', 'bookyourtravel');
			} else if(empty($date_to)) {
				$error = __('You must select a to date', 'bookyourtravel');
			} else if(empty($price) || $price === 0) {
				$error = __('You must provide a valid price', 'bookyourtravel');
			}
			
			if (!empty($error)) {
				  echo '<div class="error" id="message" onclick="this.parentNode.removeChild(this)">';
				  echo '<p>' . $error . '</p>';
				  echo '</div>';
			} else {
				
				$from_date = date('Y-m-d', strtotime($date_from));
				// we are actually (in terms of db data) looking for date 1 day before the to date
				// e.g. when you look to book a room from 19.12. to 20.12 you will be staying 1 night, not 2
				$date_to = date('Y-m-d', strtotime($date_to.' -1 day'));
				
				$dates = get_dates_from_range($from_date, $date_to);

				foreach ($dates as $date) {
					$sql = "INSERT INTO " . BYT_VACANCIES_TABLE . "
							(vacancy_day, post_id, room_type_id, room_count, price)
							VALUES
							(%s, %d, %d, %d, %d);";
					
					$wpdb->query($wpdb->prepare($sql, $date, $accommodation_id, $room_type_id, $room_count, $price));				
				}
				
				echo '<div class="updated" id="message" onclick="this.parentNode.removeChild(this)">';
				echo '<p>' . __('Successfully inserted new vacancies!', 'bookyourtravel') . '</p>';
				echo '</div>';

			}
		} else if (isset($_POST['delete_vacancy'])) {
			$vacancy_id = absint($_POST['delete_vacancy']);
			
			$sql = "DELETE FROM " . BYT_VACANCIES_TABLE . "
					WHERE Id = %d";
			
			$wpdb->query($wpdb->prepare($sql, $vacancy_id));	
			
			echo '<div class="updated" id="message" onclick="this.parentNode.removeChild(this)">';
			echo '<p>' . __('Successfully deleted vacancy!', 'bookyourtravel') . '</p>';
			echo '</div>';
		}
		
	}
	
	function render_entry_form() {

		$accommodation_id = 0;
		$is_self_catered = 0;
		if (isset($_POST['accommodations_select'])) {
			$accommodation_id = wp_kses($_POST['accommodations_select'], '');
			if (!empty($accommodation_id)) {
				$is_self_catered = get_post_meta( $accommodation_id, 'accommodation_is_self_catered', true );
			}	
		}
		$room_type_id = 0;
		if (isset($_POST['room_types_select']))
			$room_type_id = wp_kses($_POST['room_types_select'], '');
		
		$accommodations_select = '<select id="accommodations_select" name="accommodations_select">';
		$accommodations_select .= '<option value="">' . __('Select accommodation', 'bookyourtravel') . '</option>';
		$accommodations_query = list_accommodations_all();
		if ($accommodations_query->have_posts()) {
			while ($accommodations_query->have_posts()) {
				$accommodations_query->the_post();
				global $post;				
				$accommodations_select .= '<option value="' . $post->ID . '" ' . ($post->ID == $accommodation_id ? 'selected' : '') . '>' . $post->post_title . '</option>';
			}
		}
		$accommodations_select .= '</select>';
		
		wp_reset_postdata();
		
		$room_types_select = '<select class="normal" id="room_types_select" name="room_types_select">';
		$room_types_select .= '<option value="">' . __('Select room type', 'bookyourtravel') . '</option>';
		$room_types_query = list_room_types_all();
		if ($room_types_query->have_posts()) {
			while ($room_types_query->have_posts()) {
				$room_types_query->the_post();
				global $post;				
				$room_types_select .= '<option value="' . $post->ID . '" ' . ($post->ID == $room_type_id ? 'selected' : '') . '>' . $post->post_title . '</option>';
			}
		}
		$room_types_select .= '</select>';
		
		wp_reset_postdata();
		
		$date_from = null;
		if (isset($_POST['from']))
			$date_from =  wp_kses($_POST['from'], '');
		$date_to = null;
		if (isset($_POST['to']))
			$date_to =  wp_kses($_POST['to'], '');
		$room_count = 0;
		if (isset($_POST['room_count']))
			$room_count = intval(wp_kses($_POST['room_count'], '0'));
		$price = 0;
		if (isset($_POST['price']))
			$price = floatval(wp_kses($_POST['price'], '0'));

		echo '<h3>' . __('Add Vacancies', 'bookyourtravel') . '</h3>';
		echo '<form id="accommodation_vacancy_entry_form" method="post" action="' . esc_url($_SERVER['REQUEST_URI']) . '" style="clear: both;">';
		echo wp_nonce_field('accommodation_vacancy_entry_form');	
		echo '<table cellpadding="3" class="form-table"><tbody>';
		echo '<tr>';
		echo '	<th scope="row" valign="top">' . __('Select accommodation', 'bookyourtravel') . '</th>';
		echo '	<td>' . $accommodations_select . '</td>';
		echo '</tr>';
		
		$room_types_style = "";
		if ($is_self_catered)
			$room_types_style = " style='display:none'";
		echo '<tr id="room_types_row"' . $room_types_style . '>';
		echo '	<th scope="row" valign="top">' . __('Select room type', 'bookyourtravel') . '</th>';
		echo '	<td>' . $room_types_select . '</td>';
		echo '</tr>';
		
		$room_count_style = "";
		if ($is_self_catered)
			$room_count_style = " style='display:none'";
		echo '<tr id="room_count_row"' . $room_count_style . '>';
		echo '	<th scope="row" valign="top">' . __('Number of rooms', 'bookyourtravel') . '</th>';
		echo '	<td><input type="text" name="room_count" id="room_count" value="' . $room_count . '" /></td>';
		echo '</tr>';
		
		echo '<tr>';
		echo '	<th scope="row" valign="top">' . __('Date from', 'bookyourtravel') . '</th>';
		echo '	<td><input class="datepicker" type="text" name="from" id="from" value="' . $date_from . '" /></td>';
		echo '</tr>';
		echo '<tr>';
		echo '	<th scope="row" valign="top">' . __('Date to', 'bookyourtravel') . '</th>';
		echo '	<td><input class="datepicker" type="text" name="to" id="to" value="' . $date_to . '" /></td>';
		echo '</tr>';
		
		$per_room_style = "";
		if ($is_self_catered)
			$per_room_style = " style='display:none'";
		echo '<tr>';
		echo '	<th scope="row" valign="top">' . __('Price ', 'bookyourtravel') . '<span id="per_room"' . $per_room_style . '>' . __('(per room per day)', 'bookyourtravel') . '</span></th>';
		echo '	<td><input type="text" name="price" id="price" value="' . $price . '" /></td>';
		echo '</tr>';
		echo '</table>';
		echo '<p>';
		echo '<a href="edit.php?post_type=accommodation&page=theme_accommodation_vacancy_admin.php" class="button-secondary">' . __('Cancel', 'bookyourtravel') . '</a>&nbsp;';
		echo '<input class="button-primary" type="submit" name="insert" value="' . __('Add Vacancies', 'bookyourtravel') . '"/>';
		echo '</p>';
		echo '</form>';
	}

	function render_admin_calendar($current_day, $month, $year, $accommodation_id=0){

		/* draw table */
		$calendar = '<table cellpadding="0" cellspacing="0" class="wp-list-table widefat fixed calendar">';

		/* table headings */
		$headings = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
		$calendar.= '<thead>';
		$effectiveDate = date('Y-m-d', mktime(0,0,0, $month, 1, $year));
		$nextDate = date('Y-m-d', strtotime("+1 months", strtotime($effectiveDate)));
		$prevDate = date('Y-m-d', strtotime("-1 months", strtotime($effectiveDate)));
		$current_date_text = date('F Y', mktime(0, 0, 0, $month, 1, $year));
		$next_link = "edit.php?post_type=accommodation&page=theme_accommodation_vacancy_admin.php&year=" . date('Y', strtotime($nextDate)) . "&month=" . date('m', strtotime($nextDate));
		$prev_link = "edit.php?post_type=accommodation&page=theme_accommodation_vacancy_admin.php&year=" . date('Y', strtotime($prevDate)) . "&month=" . date('m', strtotime($prevDate));
		
		if ($accommodation_id > 0) {
			$next_link .= "&accommodation_id=" . $accommodation_id;
			$prev_link .= "&accommodation_id=" . $accommodation_id;
		}		
		
		$calendar.= '<tr><th><a class="alignleft" href="' . $prev_link . '">&laquo;</a></th><th class="aligncenter" colspan="5">' . $current_date_text . '</th><th><a class="alignright" href="' . $next_link . '">&raquo;</a></th></tr>';
		$calendar.= '<tr><th>'.implode('</th><th>',$headings).'</th></tr></thead>';

		/* days and weeks vars now ... */
		$running_day = date('w',mktime(0,0,0,$month,1,$year));
		$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
		$days_in_this_week = 1;
		$day_counter = 0;
		$dates_array = array();

		/* row for week one */
		$calendar.= '<tbody><tr>';

		/* print "blank" days until the first of the current week */
		for($x = 0; $x < $running_day; $x++):
			$calendar.= '<td class="calendar-day-np"> </td>';
			$days_in_this_week++;
		endfor;

		$request_day = isset($_GET['day']) ? intval($_GET['day']) : 0;
		
		/* keep going with days.... */
		for($list_day = 1; $list_day <= $days_in_month; $list_day++):
			
			$td_class = '';
			if ($list_day == $request_day) 
				$td_class = 'sel';
			if ($list_day == $current_day) 
				$td_class = ' cur';
			$calendar.= '<td class="calendar-day ' . $td_class . '">';
				/* add in the day number */
				$calendar.= '<div class="day-number">';
				$calendar.= "<a href='edit.php?post_type=accommodation&page=theme_accommodation_vacancy_admin.php&year=$year&month=$month&day=$list_day";
				
				if ($accommodation_id > 0) 
					$calendar .= '&accommodation_id=' . $accommodation_id;
				$calendar .= "'>";				
				
				if ($list_day == $request_day || $list_day == $current_day ) 
					$calendar .= "<strong>";
				$calendar.= $list_day;
				if ($list_day == $request_day || $list_day == $current_day) 
					$calendar .= "</strong>";
				$calendar.= "</a>";
				$calendar.= '</div>';

				/** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/
				$calendar.= str_repeat('<p> </p>',2);
				
			$calendar.= '</td>';
			if($running_day == 6):
				$calendar.= '</tr>';
				if(($day_counter+1) != $days_in_month):
					$calendar.= '<tr>';
				endif;
				$running_day = -1;
				$days_in_this_week = 0;
			endif;
			$days_in_this_week++; $running_day++; $day_counter++;
		endfor;

		/* finish the rest of the days in the week */
		if($days_in_this_week > 1 && $days_in_this_week < 8):
			for($x = 1; $x <= (8 - $days_in_this_week); $x++):
				$calendar.= '<td class="calendar-day-np"> </td>';
			endfor;
		endif;

		/* final row */
		$calendar.= '</tr>';

		/* end the table */
		$calendar.= '</tbody></table>';
		
		/* all done, return result */
		echo $calendar;
	}
	
	
}
?>
