<?php

/*************************** LOAD THE BASE CLASS *******************************
 *******************************************************************************
 * The WP_List_Table class isn't automatically available to plugins, so we need
 * to check if it's available and load it if necessary.
 */
if(!class_exists('WP_List_Table')){
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

add_action('admin_menu' , 'tour_schedule_admin_page');

function tour_schedule_admin_page() {
	$hook = add_submenu_page('edit.php?post_type=tour', 'Schedule management', 'Schedule', 'edit_posts', basename(__FILE__), 'tour_schedule_admin_display');
	add_action( "load-$hook", 'tour_schedule_add_screen_options');
}

function tour_schedule_set_screen_options($status, $option, $value) {
	if ( 'tour_schedule_per_page' == $option ) 
		return $value;
}
add_filter('set-screen-option', 'tour_schedule_set_screen_options', 10, 3);

function tour_schedule_admin_head() {
	$page = ( isset($_GET['page'] ) ) ? esc_attr( $_GET['page'] ) : false;
	if( 'theme_tour_schedule_admin.php' != $page )
		return;

	tour_schedule_admin_styles();
}
add_action( 'admin_head', 'tour_schedule_admin_head' );		

function tour_schedule_admin_styles() {

	if (isset($_POST['start_date'])) 
		$start_date =  wp_kses($_POST['start_date'], '');

	echo '<style type="text/css">';
	echo '	.wp-list-table .column-Id { width: 100px; }';
	echo '	.wp-list-table .column-TourName { width: 350px; }';
	echo '	.wp-list-table .column-StartDate { width: 150px; }';
	echo '	.wp-list-table .column-MaxPeople { width: 100px; }';
	echo '	.wp-list-table .column-DurationDays { width: 100px; }';
	echo '	.wp-list-table .column-Action { width: 150px; }';
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
			jQuery("#start_date").datepicker({
				dateFormat: \'yy-mm-dd\',
				minDate: 0
			});
		});
	';
	echo '</script>';	
}

function tour_schedule_add_screen_options() {
	global $wp_tour_schedule_table;
	$option = 'per_page';
	$args = array('label' => 'Schedule','default' => 50,'option' => 'tour_schedule_per_page');
	add_screen_option( $option, $args );
 	$wp_tour_schedule_table = new tour_schedule_admin_list_table();
}

function tour_schedule_admin_display() {
	echo '<div class="wrap"><h2>Schedule</h2><p>Tour schedule management filter</p>'; 
	global $wp_tour_schedule_table;
	$wp_tour_schedule_table->handle_form_submit();
	
	if (isset($_GET['action']) && $_GET['action'] == 'delete_all_scheduled_entries') {
	
		delete_all_tour_scheduled_entries();
		
		echo '<div class="error" id="message" onclick="this.parentNode.removeChild(this)">';
		echo '<p>' . __('Successfully deleted all tour scheduled entries.', 'bookyourtravel') . '</p>';
		echo '</div>';
	
	} else if (isset($_GET['sub']) && $_GET['sub'] == 'manage') {
		$wp_tour_schedule_table->render_entry_form(); 
	} else {
		$year = isset($_GET['year']) ? intval($_GET['year']) : intval(date("Y"));
		$month = isset($_GET['month']) ? intval($_GET['month']) : intval(date("m"));
		$current_day = ($year == intval(date("Y")) && $month  == intval(date("m"))) ? intval(date("j")) : 0;
		$tour_id = isset($_GET['tour_id']) ? intval($_GET['tour_id']) : 0;
	
		$tours_filter = '<select id="tours_filter" name="tours_filter" onchange="tourFilterRedirect(this.value, ' . $year . ', ' . $month . ')">';
		$tours_filter .= '<option value="">' . __('Filter by tour', 'bookyourtravel') . '</option>';
		$tours_query = list_tours_all();
		if ($tours_query->have_posts()) {
			while ($tours_query->have_posts()) {
				$tours_query->the_post();
				global $post;				
				$tours_filter .= '<option value="' . $post->ID . '" ' . ($post->ID == $tour_id ? 'selected' : '') . '>' . $post->post_title . '</option>';
			}
		}
		$tours_filter .= '</select>';
		wp_reset_postdata();
	
		echo '<p>' . __('Filter by date: ', 'bookyourtravel') . '</p>';
		$wp_tour_schedule_table->render_admin_calendar($current_day, $month, $year, $tour_id); 
	
		echo '<p>' . __('Filter by tour: ', 'bookyourtravel') . $tours_filter . '</p>';
		$wp_tour_schedule_table->prepare_items(); 
		$wp_tour_schedule_table->display();

?>
    <div class="tablenav bottom">	
        <div class="alignleft actions">
            <a href="edit.php?post_type=tour&page=theme_tour_schedule_admin.php&sub=manage" class="button-secondary action" ><?php _e('Add schedule', 'bookyourtravel') ?></a>
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
class tour_schedule_admin_list_table extends WP_List_Table {

	private $options;
	private $lastInsertedID;
	
	/**
	* Constructor, we override the parent to pass our own arguments.
	* We use the parent reference to set some default configs.
	*/
	function __construct() {
		global $status, $page;	
	
		 parent::__construct( array(
			'singular'=> 'schedule', // Singular label
			'plural' => 'schedule', // plural label, also this well be one of the table css class
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
			$tour_id = isset($_GET['tour_id']) ? intval($_GET['tour_id']) : 0;
			
			$tour_title = '';
			if ($tour_id > 0)
				$tour_title = get_the_title($tour_id);
			
			echo "<div class='alignleft'>";
			if ($year > 0 && $month > 0)
			{			
				echo '<p>' . __('Showing scheduled entries for ', 'bookyourtravel') . date('F Y', mktime(0,0,0, $month, $day, $year));
			} else {
				echo '<p>' . __('Showing all scheduled entries ', 'bookyourtravel');
			}
			
			if ($tour_id && !empty($tour_title)) {
				echo __(sprintf(' for tour "<strong>%s</strong>"', $tour_title), 'bookyourtravel');
			}
			echo '</p>';
			echo '<p class="actions">';
			echo " <a class='button-secondary action alignleft' href='edit.php?post_type=tour&page=theme_tour_schedule_admin.php'>Show all scheduled entries for all tours</a>";
			if ($tour_id && !empty($tour_title)) {
				echo " <a class='button-secondary action alignleft' href='edit.php?post_type=tour&page=theme_tour_schedule_admin.php&tour_id=$tour_id'>Show all scheduled entries for <strong>\"$tour_title\"</strong></a>";
			}
			echo " <a class='button-primary action alignright' onclick='return confirm_delete(\"#delete_all_scheduled_entries\", \"" . __('Are you sure?', 'bookyourtravel') . "\");' href='edit.php?post_type=tour&page=theme_tour_schedule_admin.php&action=delete_all_scheduled_entries'>Delete all scheduled entries</a>";
			echo '</p>';
			echo '</div>';
		}
		if ( $which == "bottom" ){
			//The code that goes after the table is there
		}
	}		
	
	function column_TourName($item) {
		return $item->tour_name;	
	}
	
	function column_MaxPeople($item) {
		return $item->max_people;	
	}
	
	function column_DurationDays($item) {
		return $item->duration_days;	
	}
	
	function column_Price($item) {
		return $item->price;	
	}
	
	function column_StartDate($item) {
		return date("d.m.Y", strtotime($item->start_date));	
	}
	
	function column_Action($item) {
		if (!$item->has_bookings) {
		
			return "<form method='post' name='delete_schedule_" . $item->Id . "' id='delete_schedule_" . $item->Id . "' style='display:inline;'>
						<input type='hidden' name='delete_schedule' id='delete_schedule' value='" . $item->Id . "' />
						<a href='javascript: void(0);' onclick='confirm_delete(\"#delete_schedule_" . $item->Id . "\", \"" . __('Are you sure?', 'bookyourtravel') . "\");'>" . __('Delete', 'bookyourtravel') . "</a>
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
			'StartDate'=>__('Start Date'),
			'TourName'=>__('Tour Name'),
			'DurationDays'=>__('Duration Days'),
			'MaxPeople'=>__('Max People'),
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
			'TourName'=> array( 'tours.post_title', true ),
			'StartDate'=> array( 'start_date', true ),
			'DurationDays'=> array( 'duration_days', true ),
			'MaxPeople'=> array( 'max_people', true ),
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
		$tour_id = isset($_GET['tour_id']) ? intval($_GET['tour_id']) : 0;
		
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
		$totalitems = list_tour_schedule_total_items($day, $month, $year, $tour_id); //return the total number of affected rows
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
		$this->items = list_paged_tour_schedule($day, $month, $year, $tour_id, $search_term, $orderby, $order, $paged, $per_page );
	}
	
	function handle_form_submit() {
		
		global $wpdb;
		
		if (isset($_POST['insert']) && check_admin_referer('tour_schedule_entry_form')) {
			
			$tour_id = wp_kses($_POST['tours_select'], '');
			$start_date =  wp_kses($_POST['start_date'], '');
			$max_people = intval(wp_kses($_POST['max_people'], '0'));
			$duration_days = intval(wp_kses($_POST['duration_days'], '0'));
			$price = floatval(wp_kses($_POST['price'], '0'));
			
			$error = '';
			
			if(empty($tour_id)) {
				$error = __('You must select an tour', 'bookyourtravel');
			} else if(empty($start_date)) {
				$error = __('You must select a schedule date', 'bookyourtravel');
			} else if(empty($max_people) || $max_people === 0) {
				$error = __('You must provide a max people count', 'bookyourtravel');
			} else if(empty($duration_days) || $duration_days === 0) {
				$error = __('You must provide a duration in days', 'bookyourtravel');
			} else if(empty($price) || $price === 0) {
				$error = __('You must provide a valid price', 'bookyourtravel');
			}
			
			if (!empty($error)) {
				  echo '<div class="error" id="message" onclick="this.parentNode.removeChild(this)">';
				  echo '<p>' . $error . '</p>';
				  echo '</div>';
			} else {
				
				$start_date = date('Y-m-d', strtotime($start_date));
				$sql = "INSERT INTO " . BYT_TOUR_SCHEDULE_TABLE . "
						(tour_id, duration_days, max_people, start_date, price)
						VALUES
						(%d, %d, %d, %s, %d);";
				
				$wpdb->query($wpdb->prepare($sql, $tour_id, $duration_days, $max_people, $start_date, $price));				
				
				echo '<div class="updated" id="message" onclick="this.parentNode.removeChild(this)">';
				echo '<p>' . __('Successfully inserted new tour schedule entry!', 'bookyourtravel') . '</p>';
				echo '</div>';

			}
		} else if (isset($_POST['delete_schedule'])) {
			$schedule_id = absint($_POST['delete_schedule']);
			
			$sql = "DELETE FROM " . BYT_TOUR_SCHEDULE_TABLE . "
					WHERE Id = %d";
			
			$wpdb->query($wpdb->prepare($sql, $schedule_id));	
			
			echo '<div class="updated" id="message" onclick="this.parentNode.removeChild(this)">';
			echo '<p>' . __('Successfully deleted tour schedule entry!', 'bookyourtravel') . '</p>';
			echo '</div>';
		}
		
	}
	
	function render_entry_form() {

		$tour_id = 0;
		$is_self_catered = 0;
		if (isset($_POST['tours_select'])) {
			$tour_id = wp_kses($_POST['tours_select'], '');
		}
		
		$tours_select = '<select id="tours_select" name="tours_select">';
		$tours_select .= '<option value="">' . __('Select tour', 'bookyourtravel') . '</option>';
		$tours_query = list_tours_all();
		if ($tours_query->have_posts()) {
			while ($tours_query->have_posts()) {
				$tours_query->the_post();
				global $post;				
				$tours_select .= '<option value="' . $post->ID . '" ' . ($post->ID == $tour_id ? 'selected' : '') . '>' . $post->post_title . '</option>';
			}
		}
		$tours_select .= '</select>';
		
		wp_reset_postdata();
		
		$start_date = null;
		if (isset($_POST['start_date']))
			$start_date =  wp_kses($_POST['start_date'], '');
		$max_people = 0;
		if (isset($_POST['max_people']))
			$max_people = intval(wp_kses($_POST['max_people'], '0'));
		$duration_days = 0;
		if (isset($_POST['duration_days']))
			$duration_days = intval(wp_kses($_POST['duration_days'], '0'));
		$price = 0;
		if (isset($_POST['price']))
			$price = floatval(wp_kses($_POST['price'], '0'));

		echo '<h3>' . __('Add Tour Schedule Entry', 'bookyourtravel') . '</h3>';
		echo '<form id="tour_schedule_entry_form" method="post" action="' . esc_url($_SERVER['REQUEST_URI']) . '" style="clear: both;">';
		echo wp_nonce_field('tour_schedule_entry_form');	
		echo '<table cellpadding="3" class="form-table"><tbody>';
		echo '<tr>';
		echo '	<th scope="row" valign="top">' . __('Select tour', 'bookyourtravel') . '</th>';
		echo '	<td>' . $tours_select . '</td>';
		echo '</tr>';
		
		echo '<tr>';
		echo '	<th scope="row" valign="top">' . __('Max number of people', 'bookyourtravel') . '</th>';
		echo '	<td><input type="text" name="max_people" id="max_people" value="' . $max_people . '" /></td>';
		echo '</tr>';
		
		echo '<tr>';
		echo '	<th scope="row" valign="top">' . __('Duration (days)', 'bookyourtravel') . '</th>';
		echo '	<td><input type="text" name="duration_days" id="duration_days" value="' . $duration_days . '" /></td>';
		echo '</tr>';
		
		echo '<tr>';
		echo '	<th scope="row" valign="top">' . __('Start date', 'bookyourtravel') . '</th>';
		echo '	<td><input class="datepicker" type="text" name="start_date" id="start_date" value="' . $start_date . '" /></td>';
		echo '</tr>';
		
		echo '<tr>';
		echo '	<th scope="row" valign="top">' . __('Price ', 'bookyourtravel') . '<span id="per_person">' . __('(per person)', 'bookyourtravel') . '</span></th>';
		echo '	<td><input type="text" name="price" id="price" value="' . $price . '" /></td>';
		echo '</tr>';
		
		echo '</table>';
		echo '<p>';
		echo '<a href="edit.php?post_type=tour&page=theme_tour_schedule_admin.php" class="button-secondary">' . __('Cancel', 'bookyourtravel') . '</a>&nbsp;';
		echo '<input class="button-primary" type="submit" name="insert" value="' . __('Add Tour Schedule Entry', 'bookyourtravel') . '"/>';
		echo '</p>';
		echo '</form>';
	}

	function render_admin_calendar($current_day, $month, $year, $tour_id=0){

		/* draw table */
		$calendar = '<table cellpadding="0" cellspacing="0" class="wp-list-table widefat fixed calendar">';

		/* table headings */
		$headings = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
		$calendar.= '<thead>';
		$effectiveDate = date('Y-m-d', mktime(0,0,0, $month, 1, $year));
		$nextDate = date('Y-m-d', strtotime("+1 months", strtotime($effectiveDate)));
		$prevDate = date('Y-m-d', strtotime("-1 months", strtotime($effectiveDate)));
		$current_date_text = date('F Y', mktime(0, 0, 0, $month, 1, $year));
		$next_link = "edit.php?post_type=tour&page=theme_tour_schedule_admin.php&year=" . date('Y', strtotime($nextDate)) . "&month=" . date('m', strtotime($nextDate));
		$prev_link = "edit.php?post_type=tour&page=theme_tour_schedule_admin.php&year=" . date('Y', strtotime($prevDate)) . "&month=" . date('m', strtotime($prevDate));
		
		if ($tour_id > 0) {
			$next_link .= "&tour_id=" . $tour_id;
			$prev_link .= "&tour_id=" . $tour_id;
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
				$calendar.= "<a href='edit.php?post_type=tour&page=theme_tour_schedule_admin.php&year=$year&month=$month&day=$list_day";
				
				if ($tour_id > 0) 
					$calendar .= '&tour_id=' . $tour_id;
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
