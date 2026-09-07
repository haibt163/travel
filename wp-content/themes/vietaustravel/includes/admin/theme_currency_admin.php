<?php

/*************************** LOAD THE BASE CLASS *******************************
 *******************************************************************************
 * The WP_List_Table class isn't automatically available to plugins, so we need
 * to check if it's available and load it if necessary.
 */
 
if(!class_exists('WP_List_Table')){
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

add_action('admin_menu' , 'currency_admin_page');
function currency_admin_page() {
	$hook = add_menu_page(__('BYT Currency management', 'bookyourtravel'), __('Currencies', 'bookyourtravel'), 'edit_posts', 'byt_currencies_admin', 'currencies_admin_display');

	add_action( "load-$hook", 'currencies_add_screen_options');
}

function currencies_set_screen_options($status, $option, $value) {
	if ( 'currencies_per_page' == $option ) 
		return $value;
}
add_filter('set-screen-option', 'currencies_set_screen_options', 10, 3);

function currencies_admin_head() {
	$page = ( isset($_GET['page'] ) ) ? esc_attr( $_GET['page'] ) : false;
	if( 'byt_currencies_admin' != $page )
		return;
	currencies_admin_styles();
}
add_action( 'admin_head', 'currencies_admin_head' );		

function currencies_admin_styles() {
	echo '<style type="text/css">';
	echo '.wp-list-table .column-Id { width: 100px; }';
	echo '.wp-list-table .column-CurrencyCode { width: 80px; }';
	echo '.wp-list-table .column-CurrencyLabel { width: 250px; }';
	echo '.wp-list-table .column-CurrencySymbol { width: 80px; }';
	echo '.wp-list-table .column-Action { width: 100px; }';
	echo '</style>';
}

function currencies_add_screen_options() {
	global $wp_currency_table;
	$option = 'per_page';
	$args = array('label' => 'Currencies','default' => 50,'option' => 'currencies_per_page');
	add_screen_option( $option, $args );
 	$wp_currency_table = new currency_admin_list_table();
}

function currencies_admin_display() {
	echo '</pre><div class="wrap"><h2>BYT Currencies</h2> Currency management screen'; 
	global $wp_currency_table;
	$wp_currency_table->handle_form_submit();
	
	if (isset($_GET['sub']) && $_GET['sub'] == 'manage') {
		$wp_currency_table->render_entry_form(); 
	} else {
		$wp_currency_table->prepare_items(); 
		$wp_currency_table->display();
		
		echo '<div class="tablenav bottom">';
		echo '    <div class="alignleft actions">';
		echo '        <a href="admin.php?page=byt_currencies_admin&sub=manage" class="button-secondary action" >' . __('Add Currency', 'bookyourtravel') . '</a>';
		echo '    </div>';
		echo '</div>';
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
class currency_admin_list_table extends WP_List_Table {

	/**
	* Constructor, we override the parent to pass our own arguments.
	* We use the parent reference to set some default configs.
	*/
	function __construct() {
		global $status, $page;	
	
		 parent::__construct( array(
			'singular'=> 'currency', // Singular label
			'plural' => 'currencys', // plural label, also this well be one of the table css class
			'ajax'	=> false // We won't support Ajax for this table
		) );
		
	}	

	function column_default( $item, $column_name ) {
		return $item->$column_name;
	}	
	
	function extra_tablenav( $which ) {
		if ( $which == "top" ){	
			//The code that goes before the table is here
		}
		if ( $which == "bottom" ){
			//The code that goes after the table is there
		}
	}		
	
	function column_CurrencyCode($item) {
		return $item->currency_code;
	}

	function column_CurrencyLabel($item) {
		return $item->currency_label;
	}
	
	function column_CurrencySymbol($item) {
		return $item->currency_symbol;
	}

	function column_Action($item) {
		return "<a href='admin.php?page=byt_currencies_admin&sub=manage&edit=" . $item->Id . "'>" . __('Edit', 'bookyourtravel') . "</a> | 
				<form method='post' name='delete_currency_" . $item->Id . "' id='delete_currency_" . $item->Id . "' style='display:inline;'>
					<input type='hidden' name='delete_currency' id='delete_currency' value='" . $item->Id . "' />
					<a href='javascript: void(0);' onclick='confirm_delete(\"#delete_currency_" . $item->Id . "\", \"" . __('Are you sure?', 'bookyourtravel') . "\");'>" . __('Delete', 'bookyourtravel') . "</a>
				</form>";
	}	
	
	/**
	 * Define the columns that are going to be used in the table
	 * @return array $columns, the array of columns to use with the table
	 */
	function get_columns() {
		return $columns= array(
			'Id'=>__('Id'),
			'CurrencyCode'=>__('Currency Code', 'bookyourtravel'),
			'CurrencyLabel'=>__('Currency Label', 'bookyourtravel'),
			'CurrencySymbol'=>__('Currency Symbol', 'bookyourtravel'),
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
			'CurrencyCode'=> array( 'currency_code', true ),
			'CurrencyLabel'=> array( 'currency_label', true ),
			'CurrencySymbol'=> array( 'currency_symbol', true ),
		);
		return $sortable_columns;
	}	
	
	/**
	 * Prepare the table with different parameters, pagination, columns and table elements
	 */
	function prepare_items() {
		global $wpdb, $_wp_column_headers;
		
		$screen = get_current_screen();
		$user = get_current_user_id();
		$option = $screen->get_option('per_page', 'option');
		$per_page = get_user_meta($user, $option, true);
		if ( empty ( $per_page) || $per_page < 1 ) {
			$per_page = $screen->get_option( 'per_page', 'default' );
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
		$totalitems = list_currencies_total_items(); //return the total number of affected rows
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
		$this->items = list_paged_currencies($orderby, $order, $paged, $per_page );
	}
	
	function handle_form_submit() {
		
		global $wpdb;
		$table_name = BYT_CURRENCIES_TABLE;
		
		if (isset($_POST['delete_currency'])) {
			$currency_id = absint($_POST['delete_currency']);
			
			$sql = "DELETE FROM $table_name
					WHERE Id = %d";
			
			$wpdb->query($wpdb->prepare($sql, $currency_id));	
			
			echo '<div class="updated" id="message" onclick="this.parentNode.removeChild(this)">';
			echo '<p>' . __('Successfully deleted currency!', 'bookyourtravel') . '</p>';
			echo '</div>';
		} else {
			$edit = isset($_GET['edit']) ? absint($_GET['edit']) : 0;
			
			if ($edit==0) {
				$existing_object = null;
			} else {
				$existing_object = get_currency($edit);
			}
			
			if (isset($_POST['currency_label']))
				$currencyLabel = stripslashes( $_POST['currency_label'] );
			if (isset($_POST['currency_code']))
				$currencyCode = stripslashes( $_POST['currency_code'] );
			if (isset($_POST['currency_symbol']))
				$currencySymbol = stripslashes( $_POST['currency_symbol'] );
			
			if ((isset($_POST['insert']) || isset($_POST['update'])) && (empty($currencyLabel) || empty($currencyCode))) {
				echo '<div class="error" id="message" onclick="this.parentNode.removeChild(this)">';
				echo '<p>' . __('Error: Please complete all fields!', 'bookyourtravel') . '</p>';
				echo '</div>';
			} else {
				if (isset($_POST['insert']) && check_admin_referer('byt_enter_currency_nonce')) {

					$result = $wpdb->query($wpdb->prepare("INSERT INTO $table_name (currency_code, currency_label, currency_symbol)
								  VALUES (%s, %s, %s);", $currencyCode, $currencyLabel, $currencySymbol));
					
					if ($result)
						$insert_id = $wpdb->insert_id;
					if ($result == 0) {	
						echo '<div class="error" id="message" onclick="this.parentNode.removeChild(this)">';
						echo '<p>' . __('Error: Problem processing insert.', 'bookyourtravel') . '</p>';
						echo '</div>';
					} else {
						echo '<div class="updated" id="message" onclick="this.parentNode.removeChild(this)">';
						echo '<p>' . __('Success: Insert successfully processed!', 'bookyourtravel') . '</p>';
						echo '</div>';
					} 
				} elseif (isset($_POST['update']) && check_admin_referer('byt_enter_currency_nonce')) {
					$update_id = $edit;
					
					$wpdb->show_errors();
					$result = $wpdb->query($wpdb->prepare(
						"UPDATE $table_name
						SET currency_code=%s,
							currency_label=%s,
							currency_symbol=%s
						WHERE Id = %d ", $currencyCode, $currencyLabel, $currencySymbol, $update_id));
					$wpdb->hide_errors();	
					if ($result == 0) {	
						echo '<div class="error" id="message" onclick="this.parentNode.removeChild(this)">';
						echo '<p>' . __('Error: Problem processing update.', 'bookyourtravel') . '</p>';
						echo '</div>';
					} else {
						echo '<div class="updated" id="message" onclick="this.parentNode.removeChild(this)">';
						echo '<p>' . __('Success: Update successfully processed!', 'bookyourtravel') . '</p>';
						echo '</div>';
					} 
				}
			}
			
		}
		
	}
	
	function render_entry_form() {
		global $wpdb;
		$edit = isset($_GET['edit']) ? absint($_GET['edit']) : "";
		$form_uri = esc_url($_SERVER['REQUEST_URI']);
		
		if ($edit > 0) {
			$existing_object = get_currency($edit);
		} else {
			$existing_object = null;
		}
		
		echo '<h3>' . (empty($edit) ? __('Add Currency', 'bookyourtravel') : __('Edit Currency', 'bookyourtravel')) . '</h3>';
		echo '<form id="byt_enter_currency_form" method="post" action="' . $form_uri . '" style="clear: both;">' . wp_nonce_field('byt_enter_currency_nonce');	

		echo '<table cellpadding="3" class="form-table"><tbody>';
		
		$currency_code = '';
		if (isset($_POST['currency_code']))
			$currency_code = $_POST['currency_code'];
		elseif ($existing_object != null)
			$currency_code = $existing_object['currency_code'];

		$currency_label = '';
		if (isset($_POST['currency_label']))
			$currency_label = $_POST['currency_label'];
		elseif ($existing_object != null)
			$currency_label = $existing_object['currency_label'];
			
		$currency_symbol = '';
		if (isset($_POST['currency_symbol']))
			$currency_symbol = $_POST['currency_symbol'];
		else if ($existing_object != null)
			$currency_symbol = $existing_object['currency_symbol'];
			
		$html = '<tr>';
		$html .= '<th scope="row" valign="top">' . __('Currency Code', 'bookyourtravel') . '</th>';
		$html .= "<td><input type='text' id='currency_code' name='currency_code' value='" . esc_attr($currency_code) . "' size='50' /></td>";
		$html .= "</tr>";
		$html .= '<tr>';
		$html .= '<th scope="row" valign="top">' . __('Currency Label', 'bookyourtravel') . '</th>';
		$html .= "<td><input type='text' id='currency_label' name='currency_label' value='" . esc_attr($currency_label) . "' size='100' /></td>";
		$html .= "</tr>";	
		$html .= '<tr>';
		$html .= '<th scope="row" valign="top">' . __('Currency Symbol', 'bookyourtravel') . '</th>';
		$html .= "<td><input type='text' id='currency_symbol' name='currency_symbol' value='" . esc_attr($currency_symbol) . "' size='100' /></td>";
		$html .= "</tr>";	
		
		echo $html;		
		
		echo '</table>';		
        echo '<p>';
		
		if (empty($edit)) {		
			echo '<input class="button-primary" type="submit" name="insert" value="' . __( 'Add Currency', 'bookyourtravel' ) . '"/>';
			echo '&nbsp;';
			echo '<a href="admin.php?page=byt_currencies_admin" class="button-secondary">' . __( 'Cancel', 'bookyourtravel' ) . '</a>';
		} else {
			echo '<input class="button-primary" type="submit" name="update" value="' . __( 'Update Currency', 'bookyourtravel' ) . '"/>';
			echo '&nbsp;';
			echo '<a href="admin.php?page=byt_currencies_admin" class="button-secondary">' . __( 'Cancel', 'bookyourtravel' ) . '</a>';		
		}
        echo '</p>';
		echo '</form>';
	}
	
}
?>
