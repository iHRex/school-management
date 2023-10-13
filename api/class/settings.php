<?php 
// This is Setting page of school management plugin
require_once SMS_PLUGIN_DIR. '/includes/class-attendence-manage.php';
require_once SMS_PLUGIN_DIR. '/smgt-function.php';
//require_once SMS_PLUGIN_DIR. '/fronted_function.php';
require_once SMS_PLUGIN_DIR. '/includes/class-marks-manage.php';
require_once SMS_PLUGIN_DIR. '/school-management-class.php';
require_once SMS_PLUGIN_DIR. '/includes/class-routine.php';
require_once SMS_PLUGIN_DIR. '/includes/class-payment.php';
require_once SMS_PLUGIN_DIR. '/includes/class-fees.php';
require_once SMS_PLUGIN_DIR. '/includes/class-feespayment.php';
require_once SMS_PLUGIN_DIR. '/lib/paypal/paypal_class.php';
require_once SMS_PLUGIN_DIR. '/includes/class-library.php';
require_once SMS_PLUGIN_DIR. '/includes/class-teacher.php';
function smgt_role_exists( $role ) {

	if( ! empty( $role ) ) {
		return $GLOBALS['wp_roles']->is_role( $role );
	}

	return false;
}
function smgt_add_role_caps() {
	// gets the author role
	if( smgt_role_exists( 'teacher' ) ) {
		// The 'editor' role exists!
		$role = get_role( 'teacher' );
		$role->add_cap('read');
		$role->add_cap('level_0');
	}
	if( smgt_role_exists( 'student' ) ) {
		// The 'editor' role exists!
		$role = get_role( 'student' );
		$role->add_cap('read');
		$role->add_cap('level_0');
	}
	if( smgt_role_exists( 'parent' ) ) {
		// The 'editor' role exists!
		$role = get_role( 'parent' );
		$role->add_cap('read');
		$role->add_cap('level_0');
	}
	if( !smgt_role_exists( 'supportstaff' ) ) {
		// The 'editor' role exists!
		add_role('supportstaff', __( 'Support Staff' ,'school-mgt'),array( 'read' => true, 'level_0' => true ));
	}
	
}
add_action( 'admin_init', 'smgt_add_role_caps');

add_action( 'admin_bar_menu', 'smgt_school_dashboard_link', 999 );

function smgt_school_dashboard_link( $wp_admin_bar ) {
	$args = array(
			'id'    => 'school-dashboard',
			'title' => __('School Dashboard','school-mgt'),
			'href'  => home_url().'?dashboard=user',
			'meta'  => array( 'class' => 'smgt-school-dashboard' )
	);
	$wp_admin_bar->add_node( $args );
}

add_action( 'admin_head', 'smgt_admin_css' );

function smgt_admin_css(){ $background = "dedede";?>
     <style>
      a.toplevel_page_smgt_school:hover,  a.toplevel_page_smgt_school:focus,.toplevel_page_smgt_school.opensub a.wp-has-submenu{
  background: url("<?php echo SMS_PLUGIN_URL;?>/assets/images/school-management-system-2.png") no-repeat scroll 8px 9px rgba(0, 0, 0, 0) !important;
  
}
.toplevel_page_smgt_school:hover .wp-menu-image.dashicons-before img {
  display: none;
}

.toplevel_page_smgt_school:hover .wp-menu-image.dashicons-before {
  min-width: 23px !important;
}
    
     </style>
<?php
}
if ( is_admin() ){
	require_once SMS_PLUGIN_DIR. '/admin/admin.php';
	function school_install()
	{

			//add_role('admin', __( 'Admin','school-mgt' ));
			add_role('teacher', __( 'Teacher' ,'school-mgt'),array( 'read' => true, 'level_0' => true ));
			add_role('student', __( 'Student' ,'school-mgt'),array( 'read' => true, 'level_0' => true ));
			add_role('parent', __( 'Parent' ,'school-mgt'),array( 'read' => true, 'level_0' => true ));
			add_role('supportstaff', __( 'Support Staff' ,'school-mgt'),array( 'read' => true, 'level_0' => true ));
			
			install_tables();
			smgt_register_post();
			
	}
	register_activation_hook(SMS_PLUGIN_BASENAME, 'school_install' );
	function smgt_option(){
		$options=array("smgt_school_name"=> __( 'School Title Here' ,'school-mgt'),
					"smgt_staring_year"=>"",
					"smgt_school_address"=>"",
					"smgt_contact_number"=>"",
					"smgt_contry"=>"United States",
					"smgt_email"=>"",
					"smgt_datepicker_format"=>'yy/mm/dd',
					"smgt_school_logo"=>plugins_url( 'school-management/assets/images/finel-logo6.png' ),
					"smgt_school_background_image"=>plugins_url('school-management/assets/images/school_life.jpg' ),
					"smgt_student_thumb"=>plugins_url( 'school-management/assets/images/finel-logo6.png' ),
					"smgt_parent_thumb"=>plugins_url( 'school-management/assets/images/finel-logo6.png' ),
					"smgt_teacher_thumb"=>plugins_url( 'school-management/assets/images/finel-logo6.png' ),
					"smgt_supportstaff_thumb"=>plugins_url( 'school-management/assets/images/finel-logo6.png' ),
					"smgt_driver_thumb"=>plugins_url( 'school-management/assets/images/finel-logo6.png' ),
					"smgt_sms_service"=>"",
					"smgt_sms_service_enable"=> 0,
					"smgt_sms_template"=>"Hello [SMS_USER_NAME] ",
					"smgt_clickatell_sms_service"=>array(),
					"smgt_twillo_sms_service"=>array(),
					"parent_send_message"=>1,
					"smgt_enable_total_student"=>1,
					"smgt_enable_total_teacher"=>1,
					"smgt_enable_total_parent"=>1,
					"smgt_enable_total_attendance"=>1,
					"smgt_enable_sandbox"=>'yes',
					"smgt_paypal_email"=>'',
					"smgt_currency_code"=>'USD',
					"smgt_teacher_manage_allsubjects_marks"=>'yes',
					"registration_title"=>'Student Registration',
					"student_activation_title"=>'Student Approved',
					"fee_payment_title"=>'Fees Alert',
					"smgt_subject_access"=>"all",
					"smgt_students_access"=>"all",
					"smgt_attendance_access"=>"all",
					"registration_mailtemplate"=>"Hello {{student_name}} ,

Your registration has been successful with {{school_name}}. You Will be able to access your account after school admin approves it. 

User Name : {{user_name}} , 
Class Name : {{class_name}}, 
Email : {{email}}


Thank you
{{school_name}}.",
					"student_activation_mailcontent"=>"Hello {{student_name}},
                 Your account with {{school_name}} is approved. You can access student account using your login details. Your other details are given bellow.

class name: {{class_name}}
Roll Number:   {{roll_number}}
 Fee Amount: {{fee_amount}} 

Thanks ,
   {{school_name}}",
   
				"fee_payment_mailcontent"=>"Hello {{parent_name}} ,

Your child fees is due.

Student Name :{{student_name}}, 
Roll Number : {{roll_number}}, 
Class Name : {{class_name}}, 
Fee Type: {{fee_type}},
Fee Amount: {{fee_amount}},
Year: {{start_year}}-{{end_year}}



Thank you
{{school_name}}"
					
		);
		return $options;
	}
	add_action('admin_init','smgt_general_setting');
	function smgt_general_setting()
	{
		$options=smgt_option();
		foreach($options as $key=>$val)
		{
			add_option($key,$val); 
			
		}
	}
	function smgt_call_script_page()
	{
		$page_array = array('smgt_school','smgt_student','smgt_teacher','smgt_parent','smgt_Subject','smgt_class','smgt_route','smgt_attendence','smgt_exam',
				'smgt_grade','smgt_result','smgt_transport','smgt_notice','smgt_message','smgt_hall','smgt_fees','smgt_fees_payment','smgt_payment','smgt_holiday','smgt_report',
				'smgt_Migration','smgt_sms-setting','smgt_gnrl_settings','smgt_supportstaff','smgt_library','smgt_access_right','smgt_view-attendance','smgt_email_template','smgt_show_infographic');
		return  $page_array;
	}
function smgt_change_adminbar_css() {
	if(isset($_REQUEST['page']) && $_REQUEST['page'] == 'school')
	{
	if((isset($_REQUEST['page']) && $_REQUEST['page'] == 'route'))	
	{
		wp_enqueue_style( 'accordian-jquery-ui-css', plugins_url( '/assets/accordian/jquery-ui.css', __FILE__) );
		//wp_enqueue_script('smgt-defaultscript', plugins_url( '/assets/js/jquery-1.11.1.min.js', __FILE__ ), array( 'jquery' ), '4.1.1', true );
		//wp_enqueue_script('accordian-jquery-1.10.2', plugins_url( '/assets/accordian/jquery-1.10.2.js',__FILE__ ));
		wp_enqueue_script('accordian-jquery-ui', plugins_url( '/assets/accordian/jquery-ui.js',__FILE__ ));
	}
	
	
	
	//wp_enqueue_style( 'smgt-botstrape-css', 'http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css' );
		
	wp_enqueue_style( 'smgt-calender-css', plugins_url( '/assets/css/fullcalendar.css', __FILE__) );
	wp_enqueue_style( 'smgt-datatable-css', plugins_url( '/assets/css/dataTables.css', __FILE__) );
	wp_enqueue_style( 'smgt-admin-style-css', plugins_url( '/admin/css/admin-style.css', __FILE__) );
	wp_enqueue_style( 'smgt-style-css', plugins_url( '/assets/css/style.css', __FILE__) );
	wp_enqueue_style( 'smgt-deshboard-css', plugins_url( '/assets/css/dashboard.css', __FILE__) );
	wp_enqueue_style( 'smgt-popup-css', plugins_url( '/assets/css/popup.css', __FILE__) );
	wp_enqueue_style( 'smgt-datable-responsive-css', plugins_url( '/assets/css/dataTables.responsive.css', __FILE__) );
	wp_enqueue_style( 'smgt-multiselect-css', plugins_url( '/assets/css/bootstrap-multiselect.css', __FILE__) );
	
	
	
	
	wp_enqueue_script('smgt-defaultscript_ui', plugins_url( '/assets/js/jquery-ui.js', __FILE__ ), array( 'jquery' ), '4.1.1', true );
	wp_enqueue_script('smgt-timeago-js', plugins_url('/assets/js/jquery.timeago.js', __FILE__ ) );
	
	wp_enqueue_script('smgt-calender_moment', plugins_url( '/assets/js/moment.min.js', __FILE__ ), array( 'jquery' ), '4.1.1', true );
	wp_enqueue_script('smgt-calender', plugins_url( '/assets/js/fullcalendar.min.js', __FILE__ ), array( 'jquery' ), '4.1.1', true );
	
	/*--------Full calendar multilanguage---------*/
	$lancode=get_locale();
	$code=substr($lancode,0,2);
	wp_enqueue_script('smgt-calender-es', plugins_url( '/assets/js/calendar-lang/'.$code.'.js', __FILE__ ), array( 'jquery' ), '4.1.1', true );
	
	wp_enqueue_script('smgt-datatable', plugins_url( '/assets/js/jquery.dataTables.min.js',__FILE__ ), array( 'jquery' ), '4.1.1', true);
	wp_enqueue_script('smgt-datatable-tools', plugins_url( '/assets/js/dataTables.tableTools.min.js',__FILE__ ), array( 'jquery' ), '4.1.1', true);
	wp_enqueue_script('smgt-datatable-editor', plugins_url( '/assets/js/dataTables.editor.min.js',__FILE__ ), array( 'jquery' ), '4.1.1', true);
	wp_enqueue_script('smgt-datatable-responsive-js', plugins_url( '/assets/js/dataTables.responsive.js',__FILE__ ), array( 'jquery' ), '4.1.1', true);
	wp_enqueue_script('smgt-customjs', plugins_url( '/assets/js/smgt_custom.js', __FILE__ ), array( 'jquery' ), '4.1.1', true );
	wp_enqueue_script('smgt-multiselect', plugins_url( '/assets/js/bootstrap-multiselect.js', __FILE__ ), array( 'jquery' ), '4.1.1', true );
	
	
	
	wp_enqueue_script('smgt-popup', plugins_url( '/assets/js/popup.js', __FILE__ ));
	wp_localize_script( 'smgt-popup', 'smgt', array( 'ajax' => admin_url( 'admin-ajax.php' ) ) );
	 wp_enqueue_script('jquery');
	 wp_enqueue_media();
       wp_enqueue_script('thickbox');
       wp_enqueue_style('thickbox');
 
      
	 wp_enqueue_script('smgt-image-upload', plugins_url( '/assets/js/image-upload.js', __FILE__ ), array( 'jquery' ), '4.1.1', true );
	 
	
		 wp_enqueue_style( 'smgt-bootstrap-css', plugins_url( '/assets/css/bootstrap.min.css', __FILE__) );
	 	wp_enqueue_style( 'smgt-font-awesome-css', plugins_url( '/assets/css/font-awesome.min.css', __FILE__) );
	 	wp_enqueue_style( 'smgt-white-css', plugins_url( '/assets/css/white.css', __FILE__) );
	 	wp_enqueue_style( 'smgt-schoolmgt-min-css', plugins_url( '/assets/css/schoolmgt.min.css', __FILE__) );
		 if (is_rtl())
		 {
			wp_enqueue_style( 'smgt-bootstrap-rtl-css', plugins_url( '/assets/css/bootstrap-rtl.min.css', __FILE__) );
			
		 }
		 
		 wp_enqueue_style( 'smgt-responsive-css', plugins_url( '/assets/css/school-responsive.css', __FILE__) );
	 	wp_enqueue_script('smgt-bootstrap-js', plugins_url( '/assets/js/bootstrap.min.js', __FILE__ ) );
	 	wp_enqueue_script('smgt-school-js', plugins_url( '/assets/js/schooljs.js', __FILE__ ) );
	 	wp_enqueue_script('smgt-waypoints-js', plugins_url( '/assets/js/jquery.waypoints.min.js', __FILE__ ) );
	 	wp_enqueue_script('smgt-counterup-js', plugins_url( '/assets/js/jquery.counterup.min.js', __FILE__ ) );
	 	
		
		
	 	//Vlidation style And Script
	 	
	 	//validation lib
		
	 	wp_enqueue_style( 'wcwm-validate-css', plugins_url( '/lib/validationEngine/css/validationEngine.jquery.css', __FILE__) );
	 	//wp_register_script( 'jquery-1.8.2', plugins_url( '/lib/validationEngine/js/jquery-1.8.2.min.js', __FILE__), array( 'jquery' ) );
	 	//wp_enqueue_script( 'jquery-1.8.2' );
	 	wp_register_script( 'jquery-validationEngine-en', plugins_url( '/lib/validationEngine/js/languages/jquery.validationEngine-en.js', __FILE__), array( 'jquery' ) );
	 	wp_enqueue_script( 'jquery-validationEngine-en' );
	 	wp_register_script( 'jquery-validationEngine', plugins_url( '/lib/validationEngine/js/jquery.validationEngine.js', __FILE__), array( 'jquery' ) );
	 	wp_enqueue_script( 'jquery-validationEngine' );
		
	
		//------MULTIPLE SELECT ITEM JS -------------
		wp_enqueue_style( 'smgt-select2-css', plugins_url( '/lib/select2-3.5.3/select2.css', __FILE__) );
					
		wp_enqueue_script('smgt-select2', plugins_url( '/lib/select2-3.5.3/select2.min.js', __FILE__ ), array( 'jquery' ), '4.1.1', true );
		//------END MULTIPLE SELECT ITEM JS------
		
		
	 	if(isset($_REQUEST['page']) && ($_REQUEST['page'] == 'report' || $_REQUEST['page'] == 'school'))
	 	{
	 		wp_enqueue_script('smgt-customjs', plugins_url( '/assets/js/Chart.min.js', __FILE__ ), array( 'jquery' ), '4.1.1', true );
	 	}
	 	wp_enqueue_script('smgt-custom_jobj', plugins_url( '/assets/js/smgt_custom_confilict_obj.js', __FILE__ ), array( 'jquery' ), '4.1.1', false );
	 }
	
	}
	
if(isset($_REQUEST['page']))
	{
	$current_page = $_REQUEST['page'];
	$page_array = smgt_call_script_page();	
		if(in_array($current_page,$page_array))
		{
			add_action( 'admin_enqueue_scripts', 'smgt_change_adminbar_css' ); 
		}
	}
}

function smgt_upload_image() {
    global $pagenow;
	
 
    if ( isset($_REQUEST['page']) && ($_REQUEST['page'] = 'teacher' || 'teacher' == $pagenow || 'async-upload.php' == $pagenow )) {
        // Now we'll replace the 'Insert into Post Button' inside Thickbox
        add_filter( 'gettext', 'replace_thickbox_text'  , 1, 3 );
    }
}
add_action( 'admin_init', 'smgt_upload_image' );
 
function replace_thickbox_text($translated_text, $text, $domain) {
    if ('Insert into Post' == $text) {
        $referer = strpos( wp_get_referer(), 'wptuts-settings' );
        if ( $referer != '' ) {
            return __('Upload Image','school-mgt');
        }
    }
    return $translated_text;
}
function smgt_domain_load(){
	load_plugin_textdomain( 'school-mgt', false, dirname( plugin_basename( __FILE__ ) ). '/languages/' );
}
add_action( 'plugins_loaded', 'smgt_domain_load' );
function smgt_install_login_page() {

	if ( !get_option('smgt_login_page') ) {
		

		$curr_page = array(
				'post_title' => __('School Management Login Page', 'school-mgt'),
				'post_content' => '[smgt_login]',
				'post_status' => 'publish',
				'post_type' => 'page',
				'comment_status' => 'closed',
				'ping_status' => 'closed',
				'post_category' => array(1),
				'post_parent' => 0 );
		

		$curr_created = wp_insert_post( $curr_page );

		update_option( 'smgt_login_page', $curr_created );

	}
}
function smgt_install_student_registration_page() {
	

	if ( !get_option('smgt_student_registration_page') ) {
		

		$curr_page = array(
				'post_title' => __('Student Registration', 'school-mgt'),
				'post_content' => '[smgt_student_registration]',
				'post_status' => 'publish',
				'post_type' => 'page',
				'comment_status' => 'closed',
				'ping_status' => 'closed',
				'post_category' => array(1),
				'post_parent' => 0 );
		

		$curr_created = wp_insert_post( $curr_page );

		update_option( 'smgt_student_registration_page', $curr_created );
		
		
	}
}
function user_dashboard()
{
	
	if(isset($_REQUEST['dashboard']))
	{
		
		require_once SMS_PLUGIN_DIR. '/fronted_template.php';
		exit;
	}
	if(isset($_REQUEST['smgt_login']))
	{
		add_action( 'authenticate', 'pu_blank_login');
	}
}

function remove_all_theme_styles() {
	global $wp_styles;
	$wp_styles->queue = array();
}
if(isset($_REQUEST['dashboard']) && $_REQUEST['dashboard'] == 'user')
{
add_action('wp_print_styles', 'remove_all_theme_styles', 100);
}

function smgt_load_script1()
{
	if(isset($_REQUEST['dashboard']) && $_REQUEST['dashboard'] == 'user')
	{
	
	
	wp_register_script('smgt-popup-front', plugins_url( 'assets/js/popup.js', __FILE__ ), array( 'jquery' ));
	wp_enqueue_script('smgt-popup-front');
	
	wp_localize_script( 'smgt-popup-front', 'smgt', array( 'ajax' => admin_url( 'admin-ajax.php' ) ) );
	 wp_enqueue_script('jquery');
	
	}

}
function smgt_registration_form( $class_name,$first_name,$middle_name,$last_name,$gender,$birth_date,$address,$city_name,$state_name,$zip_code,$mobile_number,$alternet_mobile_number,$phone,$email,$username,$password,$smgt_user_avatar) 
{
		
		//wp_enqueue_script('smgt-defaultscript', plugins_url( '/assets/js/jquery-1.11.1.min.js', __FILE__ ), array( 'jquery' ), '4.1.1', true );
		
	
		
	 	wp_enqueue_style( 'wcwm-validate-css', plugins_url( '/lib/validationEngine/css/validationEngine.jquery.css', __FILE__) );
	 	//wp_register_script( 'jquery-1.8.2', plugins_url( '/lib/validationEngine/js/jquery-1.8.2.min.js', __FILE__), array( 'jquery' ) );
	 	//wp_enqueue_script( 'jquery-1.8.2' );
	 	wp_register_script( 'jquery-validationEngine-en', plugins_url( '/lib/validationEngine/js/languages/jquery.validationEngine-en.js', __FILE__), array( 'jquery' ) );
	 	wp_enqueue_script( 'jquery-validationEngine-en' );
	 	wp_register_script( 'jquery-validationEngine', plugins_url( '/lib/validationEngine/js/jquery.validationEngine.js', __FILE__), array( 'jquery' ) );
	 	wp_enqueue_script( 'jquery-validationEngine' );

		wp_enqueue_script('jquery-ui-datepicker');
		wp_enqueue_style( 'accordian-jquery-ui-css', plugins_url( '/assets/accordian/jquery-ui.css', __FILE__) );
		wp_enqueue_script('smgt-custom_jobj', plugins_url( '/assets/js/smgt_custom_confilict_obj.js', __FILE__ ), array( 'jquery' ), '4.1.1', false );
	
    echo '
    <style>
	.student_registraion_form .form-group,.student_registraion_form .form-group .form-control{float:left;width:100%}
	.student_registraion_form .form-group .require-field{color:red;}
	.student_registraion_form select.form-control,.student_registraion_form input[type="file"] {
  padding: 0.5278em;
   margin-bottom: 5px;
}
.student_registraion_form  .radio-inline {
    float: left;
    margin-bottom: 10px;
    margin-top: 10px;
	 margin-right: 15px;
}
.student_registraion_form  .radio-inline .tog {
    margin-right: 5px;
}
.student_registraion_form .col-sm-2.control-label {
  line-height: 50px;
  text-align: right;
}
	.student_registraion_form .form-group .col-sm-2 {width: 32.666667%;}
	.student_registraion_form .form-group .col-sm-8 {     width: 66.66666667%;}
	.student_registraion_form .form-group .col-sm-7{  width: 53.33333333%;}
	.student_registraion_form .form-group .col-sm-1{  width: 13.33333333%;}
	.student_registraion_form .form-group .col-sm-8, .student_registraion_form .form-group .col-sm-2,.student_registraion_form .form-group .col-sm-7,.student_registraion_form .form-group .col-sm-1{      
	padding-left: 15px;
	 padding-right: 15px;
	float:left;}
	.student_registraion_form .form-group .col-sm-8, .student_registraion_form .form-group .col-sm-2,.student_registraion_form .form-group .col-sm-7{
		position: relative;
    min-height: 1px;   
	}

    div {
        margin-bottom:2px;
    }
     
    input{
        margin-bottom:4px;
    }
	.student_registraion_form .col-sm-offset-2.col-sm-8 {
  float: left;
  margin-left: 35%;
  margin-top: 15px;
}
	.student_reg_error .error{color:red;}
    </style>
    ';?>
 <script type="text/javascript">
jQuery(document).ready(function() {
	$('#registration_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
	  $('#birth_date').datepicker({
		  changeMonth: true,
	        changeYear: true,
	        yearRange:'-65:+25',
	        onChangeMonthYear: function(year, month, inst) {
	            $(this).val(month + "/" + year);
	        }
                    
        }); 
	function fileCheck(obj)
	{
            var fileExtension = ['jpeg', 'jpg', 'png', 'bmp',''];
            if ($.inArray($(obj).val().split('.').pop().toLowerCase(), fileExtension) == -1)
			{
                alert("<?php _e("Only '.jpeg','.jpg', '.png', '.bmp' formats are allowed.",'school-mgt');?>");
				$(obj).val('');
			}	
	}
} );
</script>			
 
 <?php   
 $edit = 0;
 echo '
	<div class="student_registraion_form">
    <form id="registration_form" action="' . $_SERVER['REQUEST_URI'] . '" method="post" enctype="multipart/form-data">
	<div class="form-group">
			<label class="col-sm-2 control-label" for="class_name">'. __('Class','school-mgt').'<span class="require-field">*</span></label>
			<div class="col-sm-8">
				
                        <select name="class_name" class="form-control validate[required]" id="class_name">
                        	<option value="">'.__('Select Class','school-mgt').'</option>';
								$classval = $class_name;
								foreach(get_allclass() as $classdata)
								{  
								?>
								 <option value="<?php echo $classdata['class_id'];?>" <?php selected($classval, $classdata['class_id']);  ?>><?php echo $classdata['class_name'];?></option>
							<?php }?>
                        </select>
			</div>
		
    </div>

		<div class="form-group">
			<label class="col-sm-2 control-label" for="first_name"><?php _e('First Name','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="first_name" class="form-control validate[required,custom[onlyLetterSp]] text-input" type="text" value="<?php if($edit){ echo $user_info->first_name;}elseif(isset($_POST['first_name'])) echo $_POST['first_name'];?>" name="first_name">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="middle_name"><?php _e('Middle Name','school-mgt');?></label>
			<div class="col-sm-8">
				<input id="middle_name" class="form-control " type="text"  value="<?php if($edit){ echo $user_info->middle_name;}elseif(isset($_POST['middle_name'])) echo $_POST['middle_name'];?>" name="middle_name">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="last_name"><?php _e('Last Name','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="last_name" class="form-control validate[required,custom[onlyLetterSp]] text-input" type="text"  value="<?php if($edit){ echo $user_info->last_name;}elseif(isset($_POST['last_name'])) echo $_POST['last_name'];?>" name="last_name">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="gender"><?php _e('Gender','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
			<?php $genderval = "male"; if($edit){ $genderval=$user_info->gender; }elseif(isset($_POST['gender'])) {$genderval=$_POST['gender'];}?> 
				<label class="radio-inline">
			     <input type="radio" value="male" class="tog validate[required]" name="gender"  <?php  checked( 'male', $genderval);  ?>/><?php _e('Male','school-mgt');?>
			     </label> 
			    <label class="radio-inline">
			      <input type="radio" value="female" class="tog validate[required]" name="gender"  <?php  checked( 'female', $genderval);  ?>/><?php _e('Female','school-mgt');?> 
			    </label>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="birth_date"><?php _e('Date of birth','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="birth_date" class="form-control validate[required]" type="text"  name="birth_date" 
				value="<?php if($edit){ echo $user_info->birth_date;}elseif(isset($_POST['birth_date'])) echo $_POST['birth_date'];?>" readonly>
			</div>
		</div>		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="address"><?php _e('Address','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="address" class="form-control validate[required]" type="text"  name="address" 
				value="<?php if($edit){ echo $user_info->address;}elseif(isset($_POST['address'])) echo $_POST['address'];?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="city_name"><?php _e('City','school');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="city_name" class="form-control validate[required]" type="text"  name="city_name" 
				value="<?php if($edit){ echo $user_info->city;}elseif(isset($_POST['city_name'])) echo $_POST['city_name'];?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="state_name"><?php _e('State','school-mgt');?></label>
			<div class="col-sm-8">
				<input id="state_name" class="form-control" type="text"  name="state_name" 
				value="<?php if($edit){ echo $user_info->state;}elseif(isset($_POST['state_name'])) echo $_POST['state_name'];?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="zip_code"><?php _e('Zip Code','school');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="zip_code" class="form-control  validate[required,custom[onlyLetterNumber]]" type="text"  name="zip_code" 
				value="<?php if($edit){ echo $user_info->zip_code;}elseif(isset($_POST['zip_code'])) echo $_POST['zip_code'];?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="mobile_number"><?php _e('Mobile Number','school-mgt');?></label>
			<div class="col-sm-1">
			
			<input type="text" readonly value="+<?php echo smgt_get_countery_phonecode(get_option( 'smgt_contry' ));?>"  class="form-control" name="phonecode">
			</div>
			<div class="col-sm-7">
				<input id="mobile_number" class="form-control text-input" type="text"  name="mobile_number" maxlength="10"
				value="<?php if($edit){ echo $user_info->mobile_number;}elseif(isset($_POST['mobile_number'])) echo $_POST['mobile_number'];?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="mobile_number"><?php _e('Alternate Number','school-mgt');?></label>
			<div class="col-sm-1">
			<input type="text" readonly value="+<?php echo smgt_get_countery_phonecode(get_option( 'smgt_contry' ));?>"  class="form-control" name="alter_mobile_number">
			</div>
			<div class="col-sm-7">
				<input id="alternet_mobile_number" class="form-control text-input" type="text"  name="alternet_mobile_number" maxlength="10"
				value="<?php if($edit){ echo $user_info->alternet_mobile_number;}elseif(isset($_POST['alternet_mobile_number'])) echo $_POST['alternet_mobile_number'];?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label " for="phone"><?php _e('Phone','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="phone" class="form-control validate[,custom[phone]] text-input" type="text"  name="phone" 
				value="<?php if($edit){ echo $user_info->phone;}elseif(isset($_POST['phone'])) echo $_POST['phone'];?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label " for="email"><?php _e('Email','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="email" class="form-control validate[required,custom[email]] text-input" type="text"  name="email" 
				value="<?php if($edit){ echo $user_info->user_email;}elseif(isset($_POST['email'])) echo $_POST['email'];?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="username"><?php _e('User Name','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="username" class="form-control validate[required]" type="text"  name="username" 
				value="<?php if($edit){ echo $user_info->user_login;}elseif(isset($_POST['username'])) echo $_POST['username'];?>" <?php if($edit) echo "readonly";?>>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="password"><?php _e('Password','school-mgt');?><?php if(!$edit) {?><span class="require-field">*</span><?php }?></label>
			<div class="col-sm-8">
				<input id="password" class="form-control <?php if(!$edit) echo 'validate[required]';?>" type="password"  name="password" value="">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="photo"><?php _e('Image','school-mgt');?></label>
			<div class="col-sm-8">
				
				<input type="file"  class="form-control" onchange="fileCheck(this);" name="smgt_user_avatar"  >				
			</div>	
		</div>
		<div class="col-sm-offset-2 col-sm-8">
        	
        	<input type="submit" value="<?php _e('Registration','school-mgt');?>" name="save_student_front" class="btn btn-success"/>
        </div>
    </form>
	</div>
    <?php
}
function smgt_complete_registration($class_name,$first_name,$middle_name,$last_name,$gender,$birth_date,$address,$city_name,$state_name,$zip_code,$mobile_number,$alternet_mobile_number,$phone,$email,$username,$password,$smgt_user_avatar) {
    global $reg_errors;
	 global $class_name,$first_name,$middle_name,$last_name,$gender,$birth_date,$address,$city_name,$state_name,$zip_code,$mobile_number,$alternet_mobile_number,$phone,$email,$username,$password,$smgt_user_avatar;
	 $smgt_avatar = '';	
		
    if ( 1 > count( $reg_errors->get_error_messages() ) ) {
        $userdata = array(
        'user_login'    =>   $username,
        'user_email'    =>   $email,
        'user_pass'     =>   $password,
        'user_url'      =>   NULL,
        'first_name'    =>   $first_name,
        'last_name'     =>   $last_name,
        'nickname'      =>   NULL
        
        );
        
		$user_id = wp_insert_user( $userdata );
	
 		$user = new WP_User($user_id);
	  $user->set_role('student');
	  $smgt_avatar = '';
	if($_FILES['smgt_user_avatar']['size'] > 0)
		{
		 $smgt_avatar_image = smgt_user_avatar_image_upload('smgt_user_avatar');
		 $smgt_avatar = content_url().'/uploads/school_assets/'.$smgt_avatar_image;
		}
		else {
			$smgt_avatar = '';
		}
		$usermetadata=array('roll_id' => '',						
						'middle_name'=>$middle_name,
						'gender'=>$gender,
						'birth_date'=>$birth_date,
						'address'=>$address,
						'city'=>$city_name,
						'state'=>$state_name,
						'zip_code'=>$zip_code,
						'class_name'=>$class_name,
						'phone'=>$phone,
						'mobile_number'=>$mobile_number,
						'alternet_mobile_number'=>$alternet_mobile_number,
						'smgt_user_avatar'=>$smgt_avatar);
		//var_dump($usermetadata);
		foreach($usermetadata as $key=>$val)
		{		
			$result=update_user_meta( $user_id, $key,$val );	
	
		}
		$hash = md5( rand(0,1000) );
		$result=update_user_meta( $user_id, 'hash', $hash );
		$class_name=get_user_meta($user_id,'class_name',true);
		$user_info = get_userdata($user_id);
		$to = $user_info->user_email;           
		$subject = get_option('registration_title'); 

				$search=array('{{student_name}}','{{user_name}} ','{{class_name}}','{{email}}','{{school_name}}');
				$replace = array($user_info->display_name,$user_info->user_login,$class_name,$to,get_option( 'smgt_school_name' ));
				$message = str_replace($search, $replace,get_option('registration_mailtemplate'));	
if($result)
	wp_mail($to, $subject, $message); 
        //_e('Registration complete.Your account active after admin can approve.','school-mgt');   
    }
}
function smgt_registration_validation($class_name,$first_name,$middle_name,$last_name,$gender,$birth_date,$address,$city_name,$state_name,$zip_code,$mobile_number,$alternet_mobile_number,$phone,$email,$username,$password,$smgt_user_avatar )  
{
	global $reg_errors;
	$reg_errors = new WP_Error;
	if ( empty( $class_name )  || empty( $first_name ) || empty( $last_name ) || empty( $birth_date ) || empty( $address ) || empty( $city_name ) || empty( $zip_code ) || empty( $phone ) || empty( $email ) || empty( $username ) || empty( $password ) ) 
	{
    $reg_errors->add('field', 'Required form field is missing');
	}
	if ( 4 > strlen( $username ) ) {
    $reg_errors->add( 'username_length', 'Username too short. At least 4 characters is required' );
	}
	if ( username_exists( $username ) )
		$reg_errors->add('user_name', 'Sorry, that username already exists!');
	if ( ! validate_username( $username ) ) {
    $reg_errors->add( 'username_invalid', 'Sorry, the username you entered is not valid' );
	}
	
	if ( !is_email( $email ) ) {
    $reg_errors->add( 'email_invalid', 'Email is not valid' );
	}
	if ( email_exists( $email ) ) {
    $reg_errors->add( 'email', 'Email Already in use' );
	}
	
	if ( is_wp_error( $reg_errors ) ) {
 
    foreach ( $reg_errors->get_error_messages() as $error ) {
     
        echo '<div class="student_reg_error">';
        echo '<strong>ERROR</strong> : ';
        echo '<span class="error"> '.$error . ' </span><br/>';
        echo '</div>';
         
    }
 
}	

}
function smgt_student_registration_function()
{
	//$class_name,$roll_id,$first_name,$middle_name,$last_name,$gender,$birth_date,$address,$city_name,$state_name,$zip_code,$mobile_number,$alternet_mobile_number,$phone,$email,$username,$password,$smgt_user_avatar
	   global $class_name,$first_name,$middle_name,$last_name,$gender,$birth_date,$address,$city_name,$state_name,$zip_code,$mobile_number,$alternet_mobile_number,$phone,$email,$username,$password,$smgt_user_avatar;
	    $class_name = isset($_POST['class_name'])?$_POST['class_name']:'';
	   
    if ( isset($_POST['save_student_front'] ) ) {
        smgt_registration_validation(
		$_POST['class_name'],
		
		$_POST['first_name'],
		$_POST['middle_name'],
		$_POST['last_name'],
		$_POST['gender'],
		$_POST['birth_date'],
		$_POST['address'],
		$_POST['city_name'],
		$_POST['state_name'],
		$_POST['zip_code'],
		$_POST['mobile_number'],
		$_POST['alternet_mobile_number'],
		$_POST['phone'],
		$_POST['email'],
        smgt_strip_tags_and_stripslashes($_POST['username']),
        $_POST['password'],        
        $_FILE['smgt_user_avatar']
        
        );
         
		 
        // sanitize user form input
        global $class_name,$first_name,$middle_name,$last_name,$gender,$birth_date,$address,$city_name,$state_name,$zip_code,$mobile_number,$alternet_mobile_number,$phone,$email,$username,$password,$smgt_user_avatar;
        if(isset($_POST['class_name'])){ $class_name =$_POST['class_name']; } else { echo $class_name =""; } 
		//$roll_id =   sanitize_text_field( $_POST['roll_id'] );
		$first_name =    smgt_strip_tags_and_stripslashes($_POST['first_name']);
		$middle_name =   smgt_strip_tags_and_stripslashes($_POST['middle_name']);
		$last_name =  smgt_strip_tags_and_stripslashes($_POST['last_name']);
		$gender =   $_POST['gender'];
		$birth_date =   $_POST['birth_date'];
		$address =   smgt_strip_tags_and_stripslashes($_POST['address']);
		$city_name =    smgt_strip_tags_and_stripslashes($_POST['city_name']);
		$state_name =   smgt_strip_tags_and_stripslashes($_POST['state_name']);
		$zip_code =   smgt_strip_tags_and_stripslashes($_POST['zip_code']);
		$mobile_number =   $_POST['mobile_number'];
		$alternet_mobile_number =  $_POST['alternet_mobile_number'] ;
		$phone =   $_POST['phone'];		
		$username   =    smgt_strip_tags_and_stripslashes($_POST['username']);
        $password   =    strip_tags($_POST['password']);
        $email      =    $_POST['email'];
        
 
        // call @function complete_registration to create the user
        // only when no WP_error is found
        smgt_complete_registration(
        $class_name,$first_name,$middle_name,$last_name,$gender,$birth_date,$address,$city_name,$state_name,$zip_code,$mobile_number,$alternet_mobile_number,$phone,$email,$username,$password,$smgt_user_avatar
        );
   
	 }
    smgt_registration_form(
       $class_name,$first_name,$middle_name,$last_name,$gender,$birth_date,$address,$city_name,$state_name,$zip_code,$mobile_number,$alternet_mobile_number,$phone,$email,$username,$password,$smgt_user_avatar
        );
		

}
function smgt__activat_mail_link()
{
	if(isset($_REQUEST['haskey']) && isset($_REQUEST['id']))
	{		
	
	global $wpdb;
		$table_users=$wpdb->prefix.'users';
		$user = get_userdatabylogin($_REQUEST['id']);
   $user_id =  $user->ID; // prints the id of the user
		if( get_user_meta($user_id, 'hash', true))
		{
		
			if(get_user_meta($user_id, 'hash', true) == $_REQUEST['haskey'])
			{
				delete_user_meta($user_id, 'hash');
				$curr_args = array(
			'page_id' => get_option('smgt_login_page'),
			'smgt_activate' => 1
	);
	//print_r($curr_args);
	$referrer_faild = add_query_arg( $curr_args, get_permalink( get_option('smgt_login_page') ) );
				wp_redirect($referrer_faild);
				exit;
			}
			else
			{
				$curr_args = array(
			'page_id' => get_option('smgt_login_page'),
			'smgt_activate' => 2
	);
	//print_r($curr_args);
	$referrer_faild = add_query_arg( $curr_args, get_permalink( get_option('smgt_login_page') ) );
				wp_redirect($referrer_faild);
				exit;
			}
			
			
		}
		wp_redirect(home_url('/'));
				exit;
		
			
		
	}
}
add_filter('wp_authenticate_user', 'smgt_authenticate_user', 10, 2);
function smgt_authenticate_user($user) {
    
	$havemeta = get_user_meta($user->ID, 'hash', true);
	if($havemeta)
	{
		global $reg_errors;
	$reg_errors = new WP_Error;
	return $reg_errors->add( 'not_active', 'Please active account' );
	}
	return $user;
	
}
add_action('wp_enqueue_scripts','smgt_load_script1');
//add_action('init','smgt__activat_mail_link');
add_action('init','smgt_install_login_page');
add_action('init','smgt_install_student_registration_page');
add_action('wp_head','user_dashboard');
add_shortcode( 'smgt_login','smgt_login_link' );
add_action('init','smgt_output_ob_start');
// Register a new shortcode: [cr_custom_registration]
add_shortcode( 'smgt_student_registration', 'smgt_custom_registration_shortcode' );
 
// The callback function that will replace [book]
function smgt_custom_registration_shortcode() {
    ob_start();
    smgt_student_registration_function();
    return ob_get_clean();
}
function smgt_output_ob_start()
{
	ob_start();
}

add_action('init','smgt_generate_pdf');
function smgt_generate_pdf()
{
	if(isset($_REQUEST['print']) && $_REQUEST['print'] == 'pdf' && isset($_REQUEST['student']))
			{
	ob_start();
	$obj_mark = new Marks_Manage();
	$uid = $_REQUEST['student'];
	
	$user =get_userdata( $uid );
	$user_meta =get_user_meta($uid);
	$class_id = $user_meta['class_name'][0];
	$subject = $obj_mark->student_subject($class_id);
	$total_subject=count($subject);
	$exam_id =$_REQUEST['exam_id'];
	$total = 0;
	$grade_point = 0;
	$umetadata=get_user_image($uid);
	
	?>
	<center>
	  <div style="float:left;width:100%;"> <img src="<?php echo get_option( 'smgt_school_logo' ) ?>"  style="max-height:50px;"/> <?php echo get_option( 'smgt_school_name' );?> </div>
	  <div style="width:100%;float:left;border-bottom:1px solid red;"></div>
	  <div style="width:100%;float:left;border-bottom:1px solid yellow;padding-top:5px;"></div>
	  <br>
	  <div style="float:left;width:100%;padding:10px 0;">
	    <div style="width:70%;float:left;text-align:left;">
	      <p>
		 <?php _e('Surname','school-mgt');?>
	        :
	        <?php echo get_user_meta($uid, 'last_name',true);?>
	      </p>
	      <p>
	        <?php _e('First Name','school-mgt');?>
	        : <?php echo get_user_meta($uid, 'first_name',true);?></p>
	      <p>
	        <?php _e('Class','school-mgt');?>
	        :
	        <?php $class_id=get_user_meta($uid, 'class_name',true);
												echo $classname=	get_class_name($class_id);
							?>
	      </p>
	      <p>
	        <?php _e('Exam Name','school-mgt');?>
	        :
	        <?php 
					echo get_exam_name_id($exam_id);
							?>
	      </p>
	    </div>
	    <div style="float:right;width:30%;">
		<?php 
		if(empty($umetadata['meta_value']))
									{
										echo '<img src='.get_option( 'smgt_student_thumb' ).'  width="100" />';
									}
									else
									echo '<img src='.$umetadata['meta_value'].' width="100" />';
		?>
		
		
		</div>
	  </div>
	  <br>
	  <table style="float:left;width:100%;border:1px solid #000;" cellpadding="0" cellspacing="0">
	    <thead>
	      <tr style="border-bottom: 1px solid #000;">
	        <th style="border-bottom: 1px solid #000;text-align:left;border-right: 1px solid #000;"><?php _e('S/No','school-mgt');?></th>
	        <th style="border-bottom: 1px solid #000;text-align:left;border-right: 1px solid #000;"><?php _e('Subject','school-mgt')?></th>
	        <th style="border-bottom: 1px solid #000;text-align:left;border-right: 1px solid #000;"><?php _e('Obtain Mark','school-mgt')?></th>
	        <th style="border-bottom: 1px solid #000;text-align:left;border-right: 1px solid #000;"><?php _e('Grade','school-mgt')?></th>
	      </tr>
	    </thead>
	    <tbody>
	      <?php
		        $i=1;
				foreach($subject as $sub)
				{
				?>
	      <tr style="border-bottom: 1px solid #000;">
	        <td style="border-bottom: 1px solid #000;border-right: 1px solid #000;"><?php echo $i;?></td>
	        <td style="border-bottom: 1px solid #000;border-right: 1px solid #000;"><?php echo $sub->sub_name;?></td>
	        <td style="border-bottom: 1px solid #000;border-right: 1px solid #000;"><?php echo $obj_mark->get_marks($exam_id,$class_id,$sub->subid,$uid);?> </td>
	        <td style="border-bottom: 1px solid #000;border-right: 1px solid #000;"><?php echo $obj_mark->get_grade($exam_id,$class_id,$sub->subid,$uid);?></td>
	      </tr>
	      <?php
				$i++;
				$total +=  $obj_mark->get_marks($exam_id,$class_id,$sub->subid,$uid);
				$grade_point += $obj_mark->get_grade_point($exam_id,$class_id,$sub->subid,$uid);
				}
				
				?>
	    </tbody>
	  </table>
	  <p class="result_total">
	    <?php _e("Total Marks","school-mgt");
	    echo " : ".$total;?>
	  </p>
	  <p class="result_point">
	    <?php	_e("GPA(grade point average)","school-mgt");
	    $GPA=$grade_point/$total_subject;
	    echo " : ".round($GPA, 2);	?>
	  </p>
	  <hr />
	</center>
	<?php
	$out_put = ob_get_contents();
		ob_clean();
		header('Content-type: application/pdf');
		header('Content-Disposition: inline; filename="result"');
		header('Content-Transfer-Encoding: binary');
		header('Accept-Ranges: bytes');
		require_once SMS_PLUGIN_DIR. '/lib/mpdf/mpdf.php';
		$mpdf		=	new mPDF( get_bloginfo( 'charset' ) );
		$mpdf		=	new mPDF('+aCJK');
		
		
		$mpdf->WriteHTML($out_put);
		$mpdf->Output();
			
		unset( $out_put );
		unset( $mpdf );
		exit;	
		}
		if(isset($_REQUEST['print']) && $_REQUEST['print'] == 'pdf' && isset($_REQUEST['invoice_type']))
		{
			smgt_student_invoice_pdf($_REQUEST['invoice_id']);
			$out_put = ob_get_contents();
			ob_clean();
			header('Content-type: application/pdf');
			header('Content-Disposition: inline; filename="result"');
			header('Content-Transfer-Encoding: binary');
			header('Accept-Ranges: bytes');
			require_once SMS_PLUGIN_DIR. '/lib/mpdf/mpdf.php';
			$mpdf		=	new mPDF( get_bloginfo( 'charset' ) );
			$mpdf		=	new mPDF('+aCJK');
			
			
			$mpdf->WriteHTML($out_put);
			$mpdf->Output();
				
			unset( $out_put );
			unset( $mpdf );
			exit;
		}
		if(isset($_REQUEST['print']) && $_REQUEST['print'] == 'pdf' && isset($_REQUEST['fee_paymenthistory']))
		{
			smgt_student_paymenthistory_pdf($_REQUEST['payment_id']);
			$out_put = ob_get_contents();
			ob_clean();
			header('Content-type: application/pdf');
			header('Content-Disposition: inline; filename="feepaymenthistory"');
			header('Content-Transfer-Encoding: binary');
			header('Accept-Ranges: bytes');
			require_once SMS_PLUGIN_DIR. '/lib/mpdf/mpdf.php';
			$mpdf		=	new mPDF( get_bloginfo( 'charset' ) );
			$mpdf		=	new mPDF('+aCJK');
			$mpdf->WriteHTML($out_put);
			$mpdf->Output();
			unset( $out_put );
			unset( $mpdf );
			exit;
		}
}
?>