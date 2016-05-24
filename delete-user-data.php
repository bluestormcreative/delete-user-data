<?php
/*
Plugin Name: Delete User Data
Description: Allows KIR to delete all teacher data in one click.
Author: Blue Storm Creative / Keller Digital
Version: 0.2
*/


define("DUD_PATH", plugin_dir_path(__FILE__) . '/');
define("DUD_SLUG", "delete-user-data");

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}


add_action('admin_menu', 'dud_setup_pages');

function dud_setup_pages(){

        add_submenu_page(NULL, 'Delete Data for User:', 'Delete Single User', 'editor', 'delete-user-data/delete-single', 'dud_single_init');
}


function dud_add_query_vars_filter( $vars ){
  $vars[] = "ID";
  return $vars;
}
add_filter( 'query_vars', 'dud_add_query_vars_filter' );

function dud_single_init() {

		$user_id = $_GET["ID"];
		$user_info = get_userdata($user_id);

		$school = get_user_meta($user_id, 'school_name', true);
		$district = get_user_meta($user_id, 'district', true);

		$room_number = get_user_meta($user_id, 'room_number', true);
		$phone_number = get_user_meta($user_id, 'phone_number', true);
		$free_period = get_user_meta($user_id, 'free_period', true);

		$not_7th = get_user_meta($user_id, 'not_7th', true);
		$not_8th = get_user_meta($user_id, 'not_8th', true);

		$spring_students_7 = get_user_meta($user_id, 'spring_students_7', true);
		$spring_students_8 = get_user_meta($user_id, 'spring_students_8', true);

		$periods_taught_7 = get_user_meta($user_id, 'periods_taught_7', true);
		$periods_taught_8 = get_user_meta($user_id, 'periods_taught_8', true);
		$startdate_kir_7 = get_user_meta($user_id, 'startdate_kir_7', true);
		$startdate_kir_8 = get_user_meta($user_id, 'startdate_kir_8', true);
		$semester_kir_7 = get_user_meta($user_id, 'semester_kir_7', true);
		$semester_kir_8 = get_user_meta($user_id, 'semester_kir_8', true);
		$number_of_students_7 = get_user_meta($user_id, 'number_of_students_7', true);
		$number_of_students_8 = get_user_meta($user_id, 'number_of_students_8', true);

		$observation_lesson_number_7 = get_user_meta($user_id, 'observation_lesson_number_7', true);
		$observation_lesson_number_8 = get_user_meta($user_id, 'observation_lesson_number_8', true);
        $request_reschedule = get_user_meta($user_id, 'request_reschedule', true);

		$output = '<div class="wrap">';
		$output .='<a href="users.php?page=delete-user-data" class="button"> << Back to List</a>';
		$output .='<h2>Delete Data for: '.$user_info->display_name.'</h2>';
		$output .='<h4>User Name: <em>'.$user_info->user_login.'</em></h4>';
		$output .= '<h4>School: '. $school .'</h4>';
    	$output .= '<h4>District: '. $district .'</h4><br><br>';

		$output .= '<h3 style="margin-bottom:0;">Data to be deleted:</h3><br>
		<em>Fields will only show up here if they contain data. Empty fields will be ignored.<br>
		Un-check any fields you would like to keep.</em><br><br>';

		$output .= '<p id="submit-message"></p>';

		//begin form output
		$output .= '<form id="dud_delete_user_meta_form" method="post" action="">';

        $output .= '<input id="selectall" type="checkbox" name="select_all" value="select_all" checked> Select All / Un-Select All<br><br>';

		if (!empty($room_number)) {
		  $output .= '<input type="checkbox" class="meta_entry" name="room_number" value="'.$room_number.'" checked> Room #: ' .$room_number.'<br>';
		}

		if (!empty($phone_number)) {
		  $output .=  '<input type="checkbox" class="meta_entry" name="phone_number" value="'.$phone_number.'" checked> Phone Number: ' .$phone_number.'<br>';
		}

		if ($free_period !== '') {
		    $output .=  '<input type="checkbox" class="meta_entry" name="free_period" value="'.$free_period.'" checked> Free Period: ' .$free_period.'<br>';
		  }

        if (!empty($not_7th)) {
            $output .= '<input type="checkbox" class="meta_entry" name="not_7th" value="'.$not_7th.'" checked> Teaching 7th this year: Yes<br>';
          }

        if (!empty($spring_students_7)) {
            $output .= '<input type="checkbox" class="meta_entry" name="spring_students_7" value="'.$spring_students_7.'" checked> Different Spring Students (7th): Yes<br>';
          }

        if (!empty($periods_taught_7)) {
            $output .= '<input type="checkbox" class="meta_entry" name="periods_taught_7" value="'.$periods_taught_7.'" checked> Periods Taught (7th): '.$periods_taught_7.'<br>';
          }

        if (!empty($startdate_kir_7 )) {
            $output .= '<input type="checkbox" class="meta_entry" name="startdate_kir_7" value="'.$startdate_kir_7 .'" checked> Projected IYG Start Date (7th): '.$startdate_kir_7 .'<br>';
          }

        if (!empty($semester_kir_7 )) {
            $output .= '<input type="checkbox" class="meta_entry" name="semester_kir_7" value="'.$semester_kir_7 .'" checked> Semester of IYG Implementation (7th): '.$semester_kir_7 .'<br>';
          }

        if (!empty($number_of_students_7 )) {
            $output .= '<input type="checkbox" class="meta_entry" name="number_of_students_7" value="'.$number_of_students_7 .'" checked> Number of 7th Grade Students: '.$number_of_students_7.'<br>';
          }

        if (!empty($not_8th)) {
            $output .= '<input type="checkbox" class="meta_entry" name="not_8th" value="'.$not_8th.'" checked> Teaching 8th this year: Yes<br>';
          }

        if (!empty($spring_students_8)) {
            $output .= '<input type="checkbox" class="meta_entry" name="spring_students_8" value="'.$spring_students_8.'" checked> Different Spring Students (8th): Yes<br>';
          }

        if (!empty($periods_taught_8)) {
            $output .= '<input type="checkbox" class="meta_entry" name="periods_taught_8" value="'.$periods_taught_8.'" checked> Periods Taught (8th): '.$periods_taught_8.'<br>';
          }

        if (!empty($startdate_kir_8 )) {
            $output .= '<input type="checkbox" class="meta_entry" name="startdate_kir_8" value="'.$startdate_kir_8 .'" checked> Projected IYG Start Date (8th): '.$startdate_kir_8 .'<br>';
          }

        if (!empty($semester_kir_8 )) {
            $output .= '<input type="checkbox" class="meta_entry" name="semester_kir_8" value="'.$semester_kir_8 .'" checked> Semester of IYG Implementation (8th): '.$semester_kir_8 .'<br>';
          }

        if (!empty($number_of_students_8 )) {
            $output .= '<input type="checkbox" class="meta_entry" name="number_of_students_8" value="'.$number_of_students_8 .'" checked> Number of 8th Grade Students: '.$number_of_students_8.'<br>';
          }

        if (!empty($observation_lesson_number_7 )) {
            $output .= '<input type="checkbox" class="meta_entry" name="observation_lesson_number_7" value="'.$observation_lesson_number_7 .'" checked> IYG Observation Lesson Number (7th):  '.$observation_lesson_number_7.'<br>';
          }

        if (!empty($observation_lesson_number_8 )) {
            $output .= '<input type="checkbox" class="meta_entry" name="observation_lesson_number_8" value="'.$observation_lesson_number_8.'" checked> IYG Observation Lesson Number (8th):  '.$observation_lesson_number_8.'<br>';
          }

        if (!empty($request_reschedule )) {
            $output .= '<input type="checkbox" class="meta_entry" name="request_reschedule" value="'.$request_reschedule.'" checked> Missed Observation Lesson:  '.$request_reschedule.'<br>';
          }

		$output .= '<input type="hidden" name="user_id" value="'.$user_id.'">';
		$output .= '<br><br><input class="button-primary" type="submit" id="dud_delete_user_meta_submit" name="dud_delete_user_meta_submit" value="Delete Now"><span class="spinner" style="float:left;"></span><br>';
		$output .= '</form>';


		print $output;

}

function dud_ajax_enqueue_scripts() {

    wp_enqueue_script( 'dud-select', plugin_dir_url( __FILE__ ) . '/js/dud-select.js', array('jquery'), true);

	wp_enqueue_script( 'dud-ajax', plugin_dir_url( __FILE__ ) . '/js/dud-ajax.js', array('jquery'), true);
	wp_localize_script('dud-ajax', 'dud_vars', array(
		'dud_nonce' => wp_create_nonce('dud_nonce')
		)
	);
}
add_action( 'admin_enqueue_scripts', 'dud_ajax_enqueue_scripts' );


// ajaxify our form submission
add_action ('wp_ajax_dud_success', 'dud_process_ajax');
function dud_process_ajax() {

	//security check for nonce - is the request coming from a true source
	if (!isset($_POST['dud_nonce']) || !wp_verify_nonce($_POST['dud_nonce'],'dud_nonce'))
		die('Permissions check failed.');

	global $wpdb;

	$form = array();
	parse_str($_POST['entries'], $form);

	$id = $form['user_id'];

	foreach ($form as $entry => $value) {
		if ( isset($entry)){
			delete_user_meta( $id, $entry);
		}
	}

	echo 'The selected user data has been deleted.';
	die();
}

// create the admin table of teachers using WP_List_Table
class Teachers_List extends WP_List_Table {

    function __construct(){
        global $status, $page;

        //Set parent defaults
        parent::__construct( array(
            'singular'  => 'teacher',     //singular name of the listed records
            'plural'    => 'teachers',    //plural name of the listed records
            'ajax'      => false        //does this table support ajax?
        ) );

    }


    /** ************************************************************************
     * This method is called when the parent class can't find a method
     * specifically build for a given column.
     **************************************************************************/
    function column_default($item, $column_name){
        switch($column_name){
        	case 'user_login':
            case 'display_name':
            case 'meta_value':
                return $item[$column_name];
            default:
                return print_r($item,true); //Show the whole array for troubleshooting purposes
        }
    }


    /** ************************************************************************
     * This is a custom column method and is responsible for what
     * is rendered in any column with a name/slug of 'title'.
     *
     * @see WP_List_Table::::single_row_columns()
     * @param array $item A singular item (one full row's worth of data)
     * @return string Text to be placed inside the column <td> (movie title only)
     **************************************************************************/
    function column_user_login($item){

        //Build row actions
        $actions = array(
            'delete'      => sprintf('<a href="users.php?page=delete-user-data/delete-single&ID='.$item["ID"].'">Delete User Data</a>',$_REQUEST['page'],'delete',$item['ID'])
        );


        //Return the title contents
        return sprintf('%1$s <span style="color:silver">(id:%2$s)</span>%3$s',
            /*$1%s*/ $item['user_login'],
            /*$2%s*/ $item['ID'],
            /*$3%s*/ $this->row_actions($actions)
        );
    }


    /** ************************************************************************
     * Define method for checkbox column
     *
     * @see WP_List_Table::::single_row_columns()
     * @param array $item A singular item (one full row's worth of data)
     * @return string Text to be placed inside the column <td> (movie title only)
     **************************************************************************/
    function column_cb($item){
        return sprintf(
            '<input type="checkbox" name="%1$s[]" value="%2$s" />',
            /*$1%s*/ $this->_args['singular'],  //Let's simply repurpose the table's singular label ("movie")
            /*$2%s*/ $item['ID']                //The value of the checkbox should be the record's id
        );
    }


    /** ************************************************************************
     * Set table columns and titles.
     *
     * @see WP_List_Table::::single_row_columns()
     * @return array An associative array containing column information: 'slugs'=>'Visible Titles'
     **************************************************************************/
    function get_columns(){
        $columns = array(
            'cb'        => '<input type="checkbox" />', //Render a checkbox instead of text
            'user_login'     => 'Username',
            'display_name'    => 'Display Name',
            'meta_value'  => 'School'
        );
        return $columns;
    }


    /** ************************************************************************
     * Define sortable columns and make clickable.
     *
     * @return array An associative array containing all the columns that should be sortable: 'slugs'=>array('data_values',bool)
     **************************************************************************/
    function get_sortable_columns() {
        $sortable_columns = array(
            'user_login'     => array('user_login',false),     //true means it's already sorted
            'display_name'    => array('display_name',false),
            'meta_value'  => array('meta_value',false)
        );
        return $sortable_columns;
    }


    /** ************************************************************************
     * Define bulk actions.
     *
     * @return array An associative array containing all the bulk actions: 'slugs'=>'Visible Titles'
     **************************************************************************/
    function get_bulk_actions() {
        $actions = array(
            'delete'    => 'Delete'
        );
        return $actions;
    }


    /** ************************************************************************
     * Handler for bulk actions.
     *
     * @see $this->prepare_items()
     **************************************************************************/
    function process_bulk_action() {

        //Detect when a bulk action is being triggered...
        if( 'delete'===$this->current_action() ) {
            wp_die('User deleted (or they would be if we had a user to delete)!');
        }

    }


    /** ************************************************************************
     * Query db and prepare data for display
     *
     * @global WPDB $wpdb
     * @uses $this->_column_headers
     * @uses $this->items
     * @uses $this->get_columns()
     * @uses $this->get_sortable_columns()
     * @uses $this->get_pagenum()
     * @uses $this->set_pagination_args()
     **************************************************************************/
    function prepare_items() {
        global $wpdb; //This is used only if making any database queries

        /**
         * First, lets decide how many records per page to show
         */
        $per_page = 25;


        /**
         * REQUIRED. Now we need to define our column headers. This includes a complete
         * array of columns to be displayed (slugs & titles), a list of columns
         * to keep hidden, and a list of columns that are sortable. Each of these
         * can be defined in another method (as we've done here) before being
         * used to build the value for our _column_headers property.
         */
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();


        /**
         * REQUIRED. Finally, we build an array to be used by the class for column
         * headers. The $this->_column_headers property takes an array which contains
         * 3 other arrays. One for all columns, one for hidden columns, and one
         * for sortable columns.
         */
        $this->_column_headers = array($columns, $hidden, $sortable);


        /**
         * Optional. You can handle your bulk actions however you see fit. In this
         * case, we'll handle them within our package just to keep things clean.
         */
        $this->process_bulk_action();

	$search = ( isset( $_REQUEST['s'] ) ) ? $_REQUEST['s'] : false;
	$do_search = ( $search ) ? $wpdb->prepare(" AND $wpdb->users.display_name LIKE '%%%s%%'", $search) : '';
 		$sql = "SELECT * FROM $wpdb->users, $wpdb->usermeta
 				WHERE $wpdb->users.ID = $wpdb->usermeta.user_id
 				AND $wpdb->usermeta.meta_key = 'school_name'
				$do_search";

 		if ( ! empty( $_REQUEST['orderby'] ) ) {
 		  $sql .= ' ORDER BY ' . esc_sql( $_REQUEST['orderby'] );
 		  $sql .= ! empty( $_REQUEST['order'] ) ? ' ' . esc_sql( $_REQUEST['order'] ) : ' ASC';
 		}

        $data = $wpdb->get_results( $sql, 'ARRAY_A' );


        /**
         * REQUIRED for pagination. Let's figure out what page the user is currently
         * looking at. We'll need this later, so you should always include it in
         * your own package classes.
         */
        $current_page = $this->get_pagenum();

        /**
         * REQUIRED for pagination. Let's check how many items are in our data array.
         * In real-world use, this would be the total number of items in your database,
         * without filtering. We'll need this later, so you should always include it
         * in your own package classes.
         */
        $total_items = count($data);


        /**
         * The WP_List_Table class does not handle pagination for us, so we need
         * to ensure that the data is trimmed to only the current page. We can use
         * array_slice() to
         */
        $data = array_slice($data,(($current_page-1)*$per_page),$per_page);



        /**
         * REQUIRED. Now we can add our *sorted* data to the items property, where
         * it can be used by the rest of the class.
         */
        $this->items = $data;


        /**
         * REQUIRED. We also have to register our pagination options & calculations.
         */
        $this->set_pagination_args( array(
            'total_items' => $total_items,                  //WE have to calculate the total number of items
            'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
            'total_pages' => ceil($total_items/$per_page)   //WE have to calculate the total number of pages
        ) );
    }


}





/** ************************ REGISTER THE TEST PAGE ****************************
 *******************************************************************************
 */
function dud_add_menu_items(){
    add_users_page('Delete User Data', 'Delete User Data', 'editor', DUD_SLUG, 'dud_render_list_page');
} add_action('admin_menu', 'dud_add_menu_items');




/** *************************** RENDER TEST PAGE ********************************
 *******************************************************************************
 */
function dud_render_list_page(){

    //Create an instance of our package class...
    $testListTable = new Teachers_List();
    //Fetch, prepare, sort, and filter our data...
    if( isset($_POST['s']) ){
                $testListTable->prepare_items($_POST['s']);
        } else {
                $testListTable->prepare_items();
        }

    ?>
    <div class="wrap">

        <div id="icon-users" class="icon32"><br/></div>
        <h2>Delete User Data</h2>
	<a class="button" href="users.php?page=delete-user-data">List All Assigned Users</a>
	<br>
	<strong><em>Note: only users who have been assigned to schools will be listed.</em></strong>
        <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
        <form id="teacher-filter" method="post">
            <!-- For plugins, we also need to ensure that the form posts back to our current page -->
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
            <!-- Now we can render the completed list table -->
	    <?php $testListTable->search_box('Search Users by Name', 'search-teachers' ); ?>
            <?php $testListTable->display() ?>

        </form>

    </div>
    <?php
}

?>
