 <script type="text/javascript">
	$(document).ready(function() 
	{			
		 $("body").on("click",".teacher_csv_export_alert",function()
		 {
			//var checked = $(".selected_teacher input:checked").length;
			if ($('.selected_teacher:checked').length == 0 )
			{
				alert("<?php esc_html_e('Please Select At least One Record','school-mgt');?>");
				return false;
			}		
		});  
	});
	</script>
<?php 
$teacher_obj = new Smgt_Teacher;
$role='teacher';
if(isset($_POST['save_teacher']))
{	
	$firstname=MJ_smgt_onlyLetter_specialcharacter_validation($_POST['first_name']);
	$lastname=MJ_smgt_onlyLetter_specialcharacter_validation($_POST['last_name']);
	$userdata = array(
		'user_login'=>MJ_smgt_username_validation($_POST['username']),			
		'user_nicename'=>NULL,
		'user_email'=>MJ_smgt_email_validation($_POST['email']),
		'user_url'=>NULL,
		'display_name'=>$firstname." ".$lastname,
	);
	if($_POST['password'] != "")
		$userdata['user_pass']=MJ_smgt_password_validation($_POST['password']);
	if(isset($_POST['smgt_user_avatar']) && $_POST['smgt_user_avatar'] != "")
	{
		$photo=$_POST['smgt_user_avatar'];
	}
	else
	{
		$photo="";
	}
	$attechment='';
	if(!empty($_POST['attachment']))
	{
		$attechment=implode(',',$_POST['attachment']);
	}
	$usermetadata=array(
		'middle_name'=>MJ_smgt_onlyLetter_specialcharacter_validation($_POST['middle_name']),
		'gender'=>MJ_smgt_onlyLetterSp_validation($_POST['gender']),
		'birth_date'=>$_POST['birth_date'],
		'address'=>MJ_smgt_address_description_validation($_POST['address']),
		'city'=>MJ_smgt_city_state_country_validation($_POST['city_name']),
		'state'=>MJ_smgt_city_state_country_validation($_POST['state_name']),
		'zip_code'=>MJ_smgt_onlyLetterNumber_validation($_POST['zip_code']),
		'class_name'=>$_POST['class_name'],
		'phone'=>MJ_smgt_phone_number_validation($_POST['phone']),
		'mobile_number'=>MJ_smgt_phone_number_validation($_POST['mobile_number']),
		'alternet_mobile_number'=>MJ_smgt_phone_number_validation($_POST['alternet_mobile_number']),
		'working_hour'=>MJ_smgt_onlyLetter_specialcharacter_validation($_POST['working_hour']),
		'possition'=>MJ_smgt_address_description_validation($_POST['possition']),
		'smgt_user_avatar'=>$photo,
		'attachment'=>$attechment,
		'created_by'=>get_current_user_id()
	);
	if($_REQUEST['action']=='edit')
	{
		$userdata['ID']=$_REQUEST['teacher_id'];
		$result=update_user($userdata,$usermetadata,$firstname,$lastname,$role);
		$result1 = $teacher_obj->smgt_update_multi_class($_POST['class_name'],$_REQUEST['teacher_id']);
		wp_redirect ( admin_url().'admin.php?page=smgt_teacher&tab=teacherlist&message=2'); 		
	}
	else
	{
		if( !email_exists( $_POST['email'] ) && !username_exists( smgt_strip_tags_and_stripslashes($_POST['username']))) 
		{
			$result=add_newuser($userdata,$usermetadata,$firstname,$lastname,$role);
			$result1 = $teacher_obj->smgt_add_muli_class($_POST['class_name'],smgt_strip_tags_and_stripslashes($_POST['username']));
			wp_redirect ( admin_url().'admin.php?page=smgt_teacher&tab=teacherlist&message=1'); 			
		}
		else 
		{
		?>
			<div id="message" class="updated below-h2">
				<p><?php _e('Username Or Emailid All Ready Exist.','school-mgt');?></p>
			</div>
	<?php 
		}
	}
}
if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
{				
	$result=delete_usedata($_REQUEST['teacher_id']);
	if($result)
	{
		wp_redirect ( admin_url().'admin.php?page=smgt_teacher&tab=teacherlist&message=5'); 			
	}
}
if(isset($_REQUEST['delete_selected']))
{		
	if(!empty($_REQUEST['id']))
	foreach($_REQUEST['id'] as $id)
		$result=delete_usedata($id);
	if($result)
	{ 
		wp_redirect ( admin_url().'admin.php?page=smgt_teacher&tab=teacherlist&message=5');  
	}
}
//-------------- EXPORT TEACHER DATA ---------------//
if(isset($_POST['teacher_csv_selected']))
{
	if(isset($_POST['id']))
	{	
		 foreach($_POST['id'] as $p_id)
		 {
			$teacher_list[]=get_userdata($p_id);
		 }
			if(!empty($teacher_list))
			{
				$header = array();			
				$header[] = 'Username';
				$header[] = 'Email';
				$header[] = 'First Name';
				$header[] = 'Middle Name';
				$header[] = 'Last Name';			
				$header[] = 'Gender';
				$header[] = 'Birth Date';
				$header[] = 'Address';
				$header[] = 'City Name';
				$header[] = 'State Name';
				$header[] = 'Zip Code';
				$header[] = 'Mobile Number';
				$header[] = 'Alternate Mobile Number';			
				$header[] = 'Phone Number';	
				$filename='Reports/export_teacher.csv';
				$fh = fopen(SMS_PLUGIN_DIR.'/admin/'.$filename, 'w') or die("can't open file");
				fputcsv($fh, $header);
				foreach($teacher_list as $retrive_data)
				{
					$row = array();
					$user_info = get_userdata($retrive_data->ID);
					
					$row[] =  $user_info->user_login;
					$row[] =  $user_info->user_email;
					$row[] =  get_user_meta($retrive_data->ID, 'first_name',true);
					$row[] =  get_user_meta($retrive_data->ID, 'middle_name',true);
					$row[] =  get_user_meta($retrive_data->ID, 'last_name',true);
					$row[] =  get_user_meta($retrive_data->ID, 'gender',true);
					$row[] =  get_user_meta($retrive_data->ID, 'birth_date',true);
					$row[] =  get_user_meta($retrive_data->ID, 'address',true);
					$row[] =  get_user_meta($retrive_data->ID, 'city',true);
					$row[] =  get_user_meta($retrive_data->ID, 'state',true);
					$row[] =  get_user_meta($retrive_data->ID, 'zip_code',true);
					$row[] =  get_user_meta($retrive_data->ID, 'mobile_number',true);
					$row[] =  get_user_meta($retrive_data->ID, 'alternet_mobile_number',true);
					$row[] =  get_user_meta($retrive_data->ID, 'phone',true);				
					fputcsv($fh, $row);				
				}
				
				fclose($fh);
		
			//download csv file.
			ob_clean();
			$file=SMS_PLUGIN_DIR.'/admin/Reports/export_teacher.csv';//file location
			
			$mime = 'text/plain';
			header('Content-Type:application/force-download');
			header('Pragma: public');       // required
			header('Expires: 0');           // no cache
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Last-Modified: '.gmdate ('D, d M Y H:i:s', filemtime ($file)).' GMT');
			header('Cache-Control: private',false);
			header('Content-Type: '.$mime);
			header('Content-Disposition: attachment; filename="'.basename($file).'"');
			header('Content-Transfer-Encoding: binary');
			//header('Content-Length: '.filesize($file_name));      // provide file size
			header('Connection: close');
			readfile($file);		
			exit;	
				
		}
		else
		{
			echo "<div style=' background: none repeat scroll 0 0 red;
				border: 1px solid;
				color: white;
				float: left;
				font-size: 17px;
				margin-top: 10px;
				padding: 10px;
				width: 98%;'>Records not found.</div>";
		}
		
	}
	 
}
//------------------ IMPORT TEACHER --------------------------//
if(isset($_REQUEST['upload_teacher_csv_file']))
{
	$nonce = $_POST['_wpnonce'];
	if ( wp_verify_nonce( $nonce, 'upload_csv_nonce' ) )
	{
		if(isset($_FILES['csv_file']))
		{				
			$errors= array();
			$file_name = $_FILES['csv_file']['name'];
			$file_size =$_FILES['csv_file']['size'];
			$file_tmp =$_FILES['csv_file']['tmp_name'];
			$file_type=$_FILES['csv_file']['type'];
			//$file_ext=strtolower(end(explode('.',$_FILES['csv_file']['name'])));
			$value = explode(".", $_FILES['csv_file']['name']);
			$file_ext = strtolower(array_pop($value));				
			$extensions = array("csv");
			$upload_dir = wp_upload_dir();
			if(in_array($file_ext,$extensions )=== false)
			{
				$err=__('this file not allowed, please choose a CSV file.','school-mgt');
				$errors[]=$err;
			}
			if($file_size > 2097152)
			{
				$errors[]='File size limit 2 MB';
			}
			
			if(empty($errors)==true)
			{	
				$rows = array_map('str_getcsv', file($file_tmp));
				
				$header = array_map('trim',array_map('strtolower',array_shift($rows)));
				 
				$csv = array();
				foreach ($rows as $row) 
				{
					$csv = array_combine($header, $row);
					$username = $csv['username'];
					//$username = $username_haeder;
					 
					$email = $csv['email'];
					$user_id = 0;
					if(isset($csv['password']))
					{
					  $password = $csv['password'];
					}
					else
					{
						$password = rand();
					}
					$problematic_row = false;
					if( username_exists($username) )
					{ // if user exists, we take his ID by login
						$user_object = get_user_by( "login", $username );
						$user_id = $user_object->ID;
						if( !empty($password) )
							wp_set_password( $password, $user_id );
					}
					elseif( email_exists( $email ) ){ // if the email is registered, we take the user from this
						$user_object = get_user_by( "email", $email );
						$user_id = $user_object->ID;					
						$problematic_row = true;
						if( !empty($password) )
							wp_set_password( $password, $user_id );
					}
					else
					{
						if( empty($password) ) // if user not exist and password is empty but the column is set, it will be generated
							$password = wp_generate_password();						
							$user_id = wp_create_user($username, $password, $email);
						
					}

					if( is_wp_error($user_id) )
					{ // in case the user is generating errors after this checks
						echo '<script>alert("Problems with user: ' . $username . ', we are going to skip");</script>';
						continue;
					}

					 if(!(is_multisite() && is_super_admin( $user_id ) ))
						wp_update_user(array ('ID' => $user_id, 'role' => 'teacher')) ;
						
					
						$user_id1 = wp_update_user( array( 'ID' => $user_id, 'display_name' =>$csv['first name'].' '.$csv['last name']) );
						 
						if(isset($csv['first name']))
							update_user_meta( $user_id, "first_name", $csv['first name'] );
						if(isset($csv['last name']))
							update_user_meta( $user_id, "last_name", $csv['last name'] );
						if(isset($csv['middle name']))
							update_user_meta( $user_id, "middle_name", $csv['middle name'] );
						if(isset($csv['gender']))
							update_user_meta( $user_id, "gender", $csv['gender'] );
						if(isset($csv['birth date']))
							update_user_meta( $user_id, "birth_date", $csv['birth date'] );
						if(isset($csv['address']))
							update_user_meta( $user_id, "address", $csv['address'] );
						if(isset($csv['city name']))
							update_user_meta( $user_id, "city", $csv['city name'] );
						if(isset($csv['state name']))
							update_user_meta( $user_id, "state", $csv['state name'] );						
						if(isset($csv['zip code']))
							update_user_meta( $user_id, "zip_code", $csv['zip code'] );
						if(isset($csv['mobile number']))
							update_user_meta( $user_id, "mobile_number", $csv['mobile number'] );
						if(isset($csv['alternate mobile number']))
							update_user_meta( $user_id, "alternet_mobile_number", $csv['alternate mobile number'] );						
						if(isset($csv['phone number']))
							update_user_meta( $user_id, "phone", $csv['phone number'] );					
						$success = 1;
				}
			}
			else
			{
				foreach($errors as &$error) echo $error;
			}
					
			if(isset($success))
			{				
				wp_redirect ( admin_url().'admin.php?page=smgt_teacher&tab=teacherlist&message=6');
			} 
		}
    }
}
	
if(isset($_REQUEST['attendance']) && $_REQUEST['attendance'] == 1)
{
?>
<script type="text/javascript">
$(document).ready(function() {	
	$('.sdate').datepicker({
		dateFormat: "yy-mm-dd",
		maxDate:0,
		beforeShow: function (textbox, instance) 
			{
				instance.dpDiv.css({
					marginTop: (-textbox.offsetHeight) + 'px'                   
				});
			}
		}); 
	$('.edate').datepicker({
		dateFormat: "yy-mm-dd",
		maxDate:0,
		beforeShow: function (textbox, instance) 
			{
				instance.dpDiv.css({
					marginTop: (-textbox.offsetHeight) + 'px'                   
				});
			}
		});  
} );
</script>

<div class="page-inner">
	<div class="page-title"> 
		<h3><img src="<?php echo get_option( 'smgt_school_logo' ) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo get_option( 'smgt_school_name' );?></h3>
	</div>
	<div id="main-wrapper">	
		<div class="row">
			<div class="panel panel-white">
				<div class="panel-body">
				<h2 class="nav-tab-wrapper">
			    	<a href="?page=smgt_teacher&teacher_id=<?php echo $_REQUEST['teacher_id'];?>&attendance=1" class="nav-tab nav-tab-active">
					<?php echo '<span class="dashicons dashicons-menu"></span>'.__('View Attendance', 'school-mgt'); ?></a>
				</h2>
				<form name="wcwm_report" action="" method="post">
					<input type="hidden" name="attendance" value=1> 
					<input type="hidden" name="user_id" value=<?php echo $_REQUEST['teacher_id'];?>>       
					<div class="form-group col-md-3">
						<label for="exam_id"><?php _e('Start Date','school-mgt');?></label>					
						<input type="text"  class="form-control sdate" name="sdate" value="<?php if(isset($_REQUEST['sdate'])) echo $_REQUEST['sdate'];else echo date('Y-m-d');?>" readonly>            	
					</div>
					<div class="form-group col-md-3">
						<label for="exam_id"><?php _e('End Date','school-mgt');?></label>
						<input type="text"  class="form-control edate" name="edate" value="<?php if(isset($_REQUEST['edate'])) echo $_REQUEST['edate'];else echo date('Y-m-d');?>" readonly>							
					</div>
					<div class="form-group col-md-3 button-possition">
						<label for="subject_id">&nbsp;</label>
						<input type="submit" name="view_attendance" Value="<?php _e('Go','school-mgt');?>"  class="btn btn-info"/>
					</div>	
				</form>
	<div class="clearfix"></div>
	<?php if(isset($_REQUEST['view_attendance']))
	{
		$start_date = $_REQUEST['sdate'];
		$end_date = $_REQUEST['edate'];
		$user_id = $_REQUEST['user_id'];
		$attendance = smgt_view_student_attendance($start_date,$end_date,$user_id);	
		$curremt_date =$start_date;
	?>
	
	<script>
	
jQuery(document).ready(function() {
	
	var table =  jQuery('#attendance_teacher_list').DataTable({
			responsive: true,
			 dom: 'Bfrtip',
				buttons: [
				{
            extend: 'print',
			title: 'View Attendance',

				}
			
				],
		
			"order": [[ 0, "asc" ]],
			"aoColumns":[	                  
			{"bSortable": true},
			{"bSortable": true},
			{"bSortable": true},
			{"bSortable": true},					           
			{"bSortable": false}],	
			language:<?php echo smgt_datatable_multi_language();?>	
		});
	});
	</script>
	<div class="panel-body">
	<table id="attendance_teacher_list" class="display" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th><?php _e('Teacher Name','school-mgt');?></th>
				<th><?php _e('Class Name','school-mgt');?></th>
				<th><?php _e('Date','school-mgt');?></th>
				<th><?php _e('Day','school-mgt');?></th>
				<th><?php _e('Attendance','school-mgt');?></th>				
			</tr>
		</thead>
 
        <tfoot>
            <tr>
				<th><?php _e('Teacher Name','school-mgt');?></th>
				<th><?php _e('Class Name','school-mgt');?></th>
				<th><?php _e('Date','school-mgt');?></th>
				<th><?php _e('Day','school-mgt');?></th>
				<th><?php _e('Attendance','school-mgt');?></th>				
			</tr>
        </tfoot> 
        <tbody>
			<?php 
			while ($end_date >= $curremt_date)
			{
				echo '<tr>';
				echo '<td>';
				echo get_display_name($user_id);
				echo '</td>';
				
				echo '<td>';
					$class='';
					$get_users = get_user_meta($user_id, 'class_name',true);
					if(!empty($get_users))
					{
						foreach($get_users as $class_id)
						{
							$class .= get_class_name_by_id($class_id).", ";
						}
					}
                    $space_trim = rtrim($class, ' '); 					
                    $class_name = rtrim($space_trim, ','); 					
					echo $class_name;
				echo '</td>';
				
				echo '<td>';
				echo $curremt_date;
				echo '</td>';
				
				$attendance_status = smgt_get_attendence($user_id,$curremt_date);
				echo '<td>';
				$day=date("D", strtotime($curremt_date));
				//echo date("D", strtotime($curremt_date));
			    echo __("$day","school-mgt"); 
				echo '</td>';
				
				if(!empty($attendance_status))
				{
					echo '<td>';
					$attendence_status=smgt_get_attendence($user_id,$curremt_date);
					echo __("$attendence_status","school-mgt"); 
					echo '</td>';
				}
				else 
				{
					echo '<td>';
					echo __('Absent','school-mgt');
					echo '</td>';
				}
				
				echo '</tr>';
				$curremt_date = strtotime("+1 day", strtotime($curremt_date));
				$curremt_date = date("Y-m-d", $curremt_date);
			}
		?>
        </tbody>        
    </table>
	</div>
	
	<!--<table class="table col-md-12">
	<tr>
	<th width="200px"><?php _e('Date','school-mgt');?></th>
	<th><?php _e('Day','school-mgt');?></th>
	<th><?php _e('Attendance','school-mgt');?></th>
	</tr>
	<?php 
	/* while ($end_date >= $curremt_date)
	{
		echo '<tr>';
		echo '<td>';
		echo $curremt_date;
		echo '</td>';
		
		$attendance_status = smgt_get_attendence($user_id,$curremt_date);
		echo '<td>';
		echo date("D", strtotime($curremt_date));
		echo '</td>';
		
		if(!empty($attendance_status))
		{
			echo '<td>';
			echo smgt_get_attendence($user_id,$curremt_date);
			echo '</td>';
		}
		else 
		{
			echo '<td>';
			echo __('Absent','school-mgt');
			echo '</td>';
		}
		
		echo '</tr>';
		$curremt_date = strtotime("+1 day", strtotime($curremt_date));
		$curremt_date = date("Y-m-d", $curremt_date);
	} */
?>
</table>-->

<?php }?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php 

}
else 
{
?>
	<?php
$active_tab = isset($_GET['tab'])?$_GET['tab']:'teacherlist';
	
	?>


<div class="page-inner">
<div class="page-title">
		<h3><img src="<?php echo get_option( 'smgt_school_logo' ) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo get_option( 'smgt_school_name' );?></h3>
	</div>
	<div id="main-wrapper">
	<?php
	$message = isset($_REQUEST['message'])?$_REQUEST['message']:'0';
	
	switch($message)
	{
		case '1':
			$message_string = __('Teacher Added Successfully.','school-mgt');
			break;
		case '2':
			$message_string = __('Teacher Updated Successfully.','school-mgt');
			break;
		case '3':
			$message_string = __('Roll No Already Exist.','school-mgt');
			break;
		case '4':
			$message_string = __('Teacher Username Or Emailid Already Exist.','school-mgt');
			break;
		case '5':
			$message_string = __('Teacher Deleted Successfully.','school-mgt');
			break;
		case '6':
			$message_string = __('Teacher CSV Successfully Uploaded.','school-mgt');
			break;
		case '7':
			$message_string = __('Student Activated Auccessfully.','school-mgt');
			break;
		
		
	}
	if($message)
	{
		?>
		<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible">
			<p><?php echo $message_string;?></p>
			<button type="button" class="notice-dismiss" data-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>
		</div>
		<?php
	}
?>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-white">
					<div class="panel-body">
	<h2 class="nav-tab-wrapper">
    	<a href="?page=smgt_teacher&tab=teacherlist" class="nav-tab <?php echo $active_tab == 'teacherlist' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-menu"></span>'.__('Teacher List', 'school-mgt'); ?></a>
    	
        <?php if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
		{?>
        <a href="?page=smgt_teacher&tab=addteacher&&action=edit&teacher_id=<?php echo $_REQUEST['teacher_id'];?>" class="nav-tab <?php echo $active_tab == 'addteacher' ? 'nav-tab-active' : ''; ?>">
		<?php _e('Edit Teacher', 'school-mgt'); ?></a>  
		<?php 
		}
		else
		{?>
			<a href="?page=smgt_teacher&tab=addteacher" class="nav-tab <?php echo $active_tab == 'addteacher' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-plus-alt"></span>'.__('Add New Teacher', 'school-mgt'); ?></a>  
		<?php }?>
		<?php if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'view_teacher')
		{ ?>
		<a href="?page=smgt_teacher&tab=view_teacher&action=view_teacher&teacher_id=<?php echo $_REQUEST['teacher_id'];?>" class="nav-tab <?php echo $active_tab == 'view_teacher' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="fa fa-eye"></span> '.__('View Teacher', 'school-mgt'); ?></a>
		<?php
		}
		?>
		<a href="?page=smgt_teacher&tab=uploadteacher" class="nav-tab <?php echo $active_tab == 'uploadteacher' ? 'nav-tab-active' : ''; ?>"><?php echo '<span class="dashicons dashicons-menu"></span> '.__('Upload Teacher CSV', 'school-mgt'); ?>
		</a>
			   
    </h2>
     <?php 
	//Report 1 
	if($active_tab == 'teacherlist')
	{ 
	
	?>	
 <div class="panel-body">
<script>
jQuery(document).ready(function() {
	var table =  jQuery('#teacher_list').DataTable({
        responsive: true,
		"order": [[ 2, "asc" ]],
		"aoColumns":[
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": true},
            {"bSortable": true},	                
            {"bSortable": true},
            {"bSortable": true},	                  
            {"bSortable": false}],
		language:<?php echo smgt_datatable_multi_language();?>
    });
	 jQuery('#checkbox-select-all').on('click', function(){
    var rows = table.rows({ 'search': 'applied' }).nodes();
      jQuery('input[type="checkbox"]', rows).prop('checked', this.checked);
	}); 
   
	 $("#delete_selected").on('click', function()
		{	
			if ($('.select-checkbox:checked').length == 0 )
			{
				alert("<?php esc_html_e('Please select atleast one record','school-mgt');?>");
				return false;
			}
		else{
				var alert_msg=confirm("<?php esc_html_e('Are you sure you want to delete this record?','school-mgt');?>");
				if(alert_msg == false)
				{
					return false;
				}
				else
				{
					return true;
				}
			}
	});
});
</script>
<div class="table-responsive">
	<form name="frm-example" action="" method="post">
        <table id="teacher_list" class="display admin_taecher_datatable" cellspacing="0" width="100%">
		<thead>
           <tr>
				<th style="width: 20px;"><input name="select_all" value="all" id="checkbox-select-all" 
					type="checkbox" /></th> 
				<th><?php  _e( 'Photo', 'school-mgt' ) ;?></th>
				<th><?php _e( 'Teacher Name', 'school-mgt' ) ;?></th>
				<th> <?php _e( 'Class', 'school-mgt' ) ;?></th>
				<th> <?php _e( 'Subject', 'school-mgt' ) ;?></th>
				<th> <?php _e( 'Teacher Email', 'school-mgt' ) ;?></th>
				<th><?php  _e( 'Action', 'school-mgt' ) ;?></th>
           </tr>
        </thead>
 
        <tfoot>
            <tr>
				<th></th>
				<th><?php  _e( 'Photo', 'school-mgt' ) ;?></th>
				<th><?php _e( 'Teacher Name', 'school-mgt' ) ;?></th>
				<th> <?php _e( 'Class', 'school-mgt' ) ;?></th>
				<th> <?php _e( 'Subject', 'school-mgt' ) ;?></th>
                <th> <?php _e( 'Teacher Email', 'school-mgt' ) ;?></th>
                <th><?php  _e( 'Action', 'school-mgt' ) ;?></th>                
            </tr>
        </tfoot>
 
        <tbody>
         <?php 
		$teacherdata=get_usersdata('teacher');
		if(!empty($teacherdata))
		{
		 	foreach (get_usersdata('teacher') as $retrieved_data)
            {   	
				
                $teacher_group = array();
                $teacher_ids = smgt_teacher_by_subject($retrieved_data);                             
                foreach($teacher_ids as $teacher_id)
                {
                    $teacher_group[] = get_teacher($teacher_id);
                }
                $teachers = implode(',',$teacher_group);
				
		 ?>
            <tr>
			<td><input type="checkbox" class="select-checkbox selected_teacher" name="id[]" 
				value="<?php echo $retrieved_data->ID;?>"></td>
				<td class="user_image"><?php $uid=$retrieved_data->ID;
							$umetadata=get_user_image($uid);
		 	if(empty($umetadata))
									{
										echo '<img src='.get_option( 'smgt_teacher_thumb' ).' height="50px" width="50px" class="img-circle" />';
									}
							else
							echo '<img src='.$umetadata.' height="50px" width="50px" class="img-circle"/>';
				?></td>
                <td class="name"><a href="?page=smgt_teacher&tab=addteacher&action=edit&teacher_id=<?php echo $retrieved_data->ID;?>"><?php echo $retrieved_data->display_name;?></a></td>
                 <td class="class_name">
				<?php 
						$classes="";
						$classes = $teacher_obj->smgt_get_class_by_teacher($retrieved_data->ID);
						$classname = "";
						foreach($classes as $class)
						{
							$classname .= get_class_name($class['class_id']).",";
						}
						$classname_rtrim=rtrim($classname,", ");
						$classname_ltrim=ltrim($classname_rtrim,", ");
						echo $classname_ltrim;
				?></td>
				<td class="subject_name"><?php $subjectname=get_subject_name_by_teacher($uid); 
				echo rtrim($subjectname,", ");?></td>
                <td class="email"><?php echo $retrieved_data->user_email;?></td>
               	<td class="action"> 
				<a href="?page=smgt_teacher&tab=view_teacher&action=view_teacher&teacher_id=<?php echo $retrieved_data->ID;?>" class="btn btn-success"><?php _e('View','school-mgt');?></a>  
				<a href="?page=smgt_teacher&tab=addteacher&action=edit&teacher_id=<?php echo $retrieved_data->ID;?>" class="btn btn-info"> <?php _e('Edit', 'school-mgt' ) ;?></a>
                <a href="?page=smgt_teacher&tab=teacherlist&action=delete&teacher_id=<?php echo $retrieved_data->ID;?>" class="btn btn-danger" 
                onclick="return confirm('<?php _e('Are you sure you want to delete this record?','school-mgt');?>');">
                <?php _e( 'Delete', 'school-mgt' ) ;?> </a>
                <a href="?page=smgt_teacher&teacher_id=<?php echo $retrieved_data->ID;?>&attendance=1" class="btn btn-default">
               <i class="fa fa-eye"></i> <?php _e('View Attendance','school-mgt');?></a>
                </td>
               
            </tr>
            <?php } 
			
		}?>
     
        </tbody>
        
        </table>
		<div class="print-button pull-left">
			<input id="delete_selected" type="submit" value="<?php _e('Delete Selected','school-mgt');?>" name="delete_selected" class="btn btn-danger delete_selected margin_top_10_res"/>
			<input type="submit" class="btn delete_margin_bottom btn-primary margin_top_10_res teacher_csv_export_alert" name="teacher_csv_selected" value="<?php esc_attr_e('Export Selected', 'school-mgt' ) ;?> " />
		</div>
		</form>
        </div>
        </div>
       

     <?php 
	 }
	
	if($active_tab == 'addteacher')
	{
		require_once SMS_PLUGIN_DIR. '/admin/includes/teacher/add-newteacher.php';
	}
	if($active_tab == 'view_teacher')
	{
		require_once SMS_PLUGIN_DIR. '/admin/includes/teacher/view_teacher.php';
	}
	if($active_tab == 'uploadteacher')
	{
		require_once SMS_PLUGIN_DIR. '/admin/includes/teacher/upload_teacher.php';
	}
	?>
</div>
			
		</div>
	</div>
</div>
<?php } ?>