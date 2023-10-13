<?php 
$custom_field_obj =new Smgt_custome_field;
	$obj_mark = new Marks_Manage(); 
	$role	='student';
	if(isset($_POST['active_user']))
	{		
		$class = get_user_meta($_REQUEST['act_user_id'],'class_name',true);		
		$args = array('meta_query'	=>
			array('relation' => 'AND',
				array('key'	=>'class_name','value'=>$class),
				array('key'=>'roll_id','value'=>$_REQUEST['roll_id'])
			),
			'role'=>'student');
				
		$userbyroll_no	=	get_users($args);		
		$is_rollno = count($userbyroll_no);	
		
		if($is_rollno)
		{
			wp_redirect ( admin_url().'admin.php?page=smgt_student&tab=studentlist&message=3'); 
		}
		else
		{		
			$active_user_id		= 	$_REQUEST['act_user_id'];			
			update_user_meta($active_user_id, 'roll_id', $_REQUEST['roll_id']);
			$class_name		=	get_user_meta($active_user_id,'class_name',true);
			$user_info 	= 	get_userdata($_POST['act_user_id']);
				$to 	= 	$user_info->user_email;           
				$subject	= 	get_option('student_activation_title'); 
				$Seach['{{student_name}}']	 =	 $user_info->display_name;
				$Seach['{{user_name}}']		 =	 $user_info->user_login;
				$Seach['{{class_name}}']	 =	 get_class_name($class_name);
				$Seach['{{email}}']			 =	 $to;
				$Seach['{{school_name}}']	 =	 get_option( 'smgt_school_name' );			
				$MsgContent 	= 	string_replacement($Seach,get_option('student_activation_mailcontent'));
				smgt_send_mail($to,$subject,$MsgContent);
			//----------- STUDENT ASSIGNED TEACHER MAIL ------------//
			$TeacherIDs = check_class_exits_in_teacher_class($class_name);			
			$TeacherEmail = array();
			$string['{{school_name}}']  = get_option('smgt_school_name');
			$string['{{student_name}}'] =  get_display_name($_POST['act_user_id']);
			$subject = get_option('student_assign_teacher_mail_subject');
			$MessageContent = get_option('student_assign_teacher_mail_content');			
			foreach($TeacherIDs as $teacher)
			{		
				$TeacherData = get_userdata($teacher);		
				//$TeacherData->user_email;
				$string['{{teacher_name}}']= get_display_name($TeacherData->ID);
				$message = string_replacement($string,$MessageContent);				
				smgt_send_mail($TeacherData->user_email,$subject,$message);
			}		
			if(get_user_meta($active_user_id, 'hash', true))
				delete_user_meta($active_user_id, 'hash');
			wp_redirect ( admin_url().'admin.php?page=smgt_student&tab=studentlist&message=7');			
		}
	}
	 
	if(isset($_POST['exportstudentin_csv']))
	{
		
		if($_REQUEST['class_name'] != "" AND $_REQUEST['class_section'] = "")
		{			
			$student_list = get_users(array('meta_key' => 'class_name', 'meta_value' => $_REQUEST['class_name'], 'role'=>'student'));
		}
		elseif($_REQUEST['class_section']!="")
		{
			$args = array(
				'role'=>'student',
				'meta_query' => array(
				array(
					'key' => 'class_name',
					'value' => $_REQUEST['class_name'],					
				),
				array(
					'key' => 'class_section',
					'value' =>$_REQUEST['class_section'] 					
				)
				)
			);			
			$student_list = get_users($args);
		}
		
		/* elseif($_REQUEST['class_name'] == "all" AND $_REQUEST['class_section'] == "")
		{
			echo "eeee";
			die;
			$student_list = get_users(array('role'=>'student'));
		} */
		else
		{
			$student_list = get_users(array('role'=>'student'));
		}
		
		if(!empty($student_list))
		{
			$header = array();			
			$header[] = 'Username';
			$header[] = 'Email';
			$header[] = 'Roll No';
			$header[] = 'Class Name';
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
			$filename='Reports/export_student.csv';
			$fh = fopen(SMS_PLUGIN_DIR.'/admin/'.$filename, 'w') or die("can't open file");
			fputcsv($fh, $header);
			
			foreach($student_list as $retrive_data)
			{
				$row = array();
				$user_info = get_userdata($retrive_data->ID);
				
				$row[] = $user_info->user_login;
				$row[] = $user_info->user_email;
				$row[] =  get_user_meta($retrive_data->ID, 'roll_id',true);				
				$class_id=  get_user_meta($retrive_data->ID, 'class_name',true);	
				$classname=get_class_name($class_id);	
				$row[] = $classname;	
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
		$file=SMS_PLUGIN_DIR.'/admin/Reports/export_student.csv';//file location
		
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

if(isset($_POST['save_student']))
{
	$nonce = $_POST['_wpnonce'];
	if ( wp_verify_nonce( $nonce, 'save_teacher_admin_nonce' ) )
	{
		$firstname	=	MJ_smgt_onlyLetter_specialcharacter_validation($_POST['first_name']);
		$lastname	=	smgt_strip_tags_and_stripslashes($_POST['last_name']);
		$userdata 	= 	array(
			'user_login'	=>	MJ_smgt_username_validation($_POST['username']),			
			'user_nicename'	=>	NULL,
			'user_email'	=>	MJ_smgt_email_validation($_POST['email']),
			'user_url'		=>	NULL,
			'display_name'	=>	$firstname." ".$lastname,
		);
		
		if($_POST['password'] != "")
			$userdata['user_pass']=MJ_smgt_password_validation($_POST['password']);
			
		if(isset($_POST['smgt_user_avatar']) && $_POST['smgt_user_avatar'] != "")
		{
			$photo	=	$_POST['smgt_user_avatar'];
		}
		else
		{
			$photo	=	"";
		}
		if (get_option( 'smgt_enable_virtual_classroom' ) == 'yes')
		{
			$zoom_add_status = 'yes';
		}
		else
		{
			$zoom_add_status = 'no';
		}
		$usermetadata	=	array(
			'roll_id'	=>	MJ_smgt_address_description_validation($_POST['roll_id']),
			'middle_name'	=>	MJ_smgt_onlyLetter_specialcharacter_validation($_POST['middle_name']),
			'gender'	=>	MJ_smgt_onlyLetterSp_validation($_POST['gender']),
			'birth_date'=>	$_POST['birth_date'],
			'address'	=>	MJ_smgt_address_description_validation($_POST['address']),
			'city'		=>	MJ_smgt_city_state_country_validation($_POST['city_name']),
			'state'		=>	MJ_smgt_city_state_country_validation($_POST['state_name']),
			'zip_code'	=>	MJ_smgt_onlyLetterNumber_validation($_POST['zip_code']),
			'class_name'	=>	MJ_smgt_onlyNumberSp_validation($_POST['class_name']),
			'class_section'	=>	MJ_smgt_onlyNumberSp_validation($_POST['class_section']),
			'phone'		=>	MJ_smgt_phone_number_validation($_POST['phone']),
			'mobile_number'	=>	MJ_smgt_phone_number_validation($_POST['mobile_number']),
			'alternet_mobile_number'	=>	MJ_smgt_phone_number_validation($_POST['alternet_mobile_number']),
			'smgt_user_avatar'	=>	$photo,	
			'zoom_add_status'	=>	$zoom_add_status,		
			'created_by'=>get_current_user_id()			
		);
		$userbyroll_no	=	get_users(
			array('meta_query'	=>
				array('relation' => 'AND',
					array('key'	=>'class_name','value'=>$_POST['class_name']),
					array('key'=>'roll_id','value'=>smgt_strip_tags_and_stripslashes($_POST['roll_id']))
				),
				'role'=>'student')
		);
		$is_rollno = count($userbyroll_no);	
		if($_REQUEST['action']=='edit')
		{
			$userdata['ID']	=	$_REQUEST['student_id'];
			$roll_no_cheack = cheack_student_rollno_exist_or_not($_POST['roll_id'],$_REQUEST['student_id']);
			 if($roll_no_cheack == 1)
			{ 
				$result	=	update_user($userdata,$usermetadata,$firstname,$lastname,$role);
				// Custom Field File Update //
				$custom_field_file_array=array();
				 
				if(!empty($_FILES['custom_file']['name']))
				{
					$count_array=count($_FILES['custom_file']['name']);
					 
					for($a=0;$a<$count_array;$a++)
					{			
						foreach($_FILES['custom_file'] as $image_key=>$image_val)
						{
							foreach($image_val as $image_key1=>$image_val2)
							{
								if($_FILES['custom_file']['name'][$image_key1]!='')
								{ 
									$custom_file_array[$image_key1]=array(
									'name'=>$_FILES['custom_file']['name'][$image_key1],
									'type'=>$_FILES['custom_file']['type'][$image_key1],
									'tmp_name'=>$_FILES['custom_file']['tmp_name'][$image_key1],
									'error'=>$_FILES['custom_file']['error'][$image_key1],
									'size'=>$_FILES['custom_file']['size'][$image_key1]
									);							
								}						
							}
						}
					}	
					if(!empty($custom_file_array))
					{
						foreach($custom_file_array as $key=>$value)		
						{
						 			
							global $wpdb;
							$wpnc_custom_field_metas = $wpdb->prefix . 'custom_field_metas';
			
							$get_file_name=$custom_file_array[$key]['name'];
						 
							$custom_field_file_value=smgt_load_documets_new($value,$value,$get_file_name);	
							//var_dump($custom_field_file_value);							
							//Add File in Custom Field Meta//				
							$module='student';					
							$updated_at=date("Y-m-d H:i:s");
							$update_custom_meta_data =$wpdb->query($wpdb->prepare("UPDATE `$wpnc_custom_field_metas` SET `field_value` = '$custom_field_file_value',updated_at='$updated_at' WHERE `$wpnc_custom_field_metas`.`module` = %s AND  `$wpnc_custom_field_metas`.`module_record_id` = %d AND `$wpnc_custom_field_metas`.`custom_fields_id` = %d",$module,$result,$key));
							//var_dump("UPDATE `$wpnc_custom_field_metas` SET `field_value` = '$custom_field_file_value',updated_at='$updated_at' WHERE `$wpnc_custom_field_metas`.`module` = %s AND  `$wpnc_custom_field_metas`.`module_record_id` = %d AND `$wpnc_custom_field_metas`.`custom_fields_id` = %d",$module,$result,$key);
							/* var_dump($update_custom_meta_data);
							die; */
						} 	
					}		 		
				}
			
				$update_custom_field=$custom_field_obj->Smgt_update_custom_field_metas('student',$_POST['custom'],$result);
				
				wp_redirect ( admin_url().'admin.php?page=smgt_student&tab=studentlist&message=2');
			} 
			else
			{
				wp_redirect ( admin_url().'admin.php?page=smgt_student&tab=studentlist&message=3');
			} 
										
		}
		else
		{
			if( !email_exists( $_POST['email'] ) && !username_exists( smgt_strip_tags_and_stripslashes($_POST['username'] )))
			{			
				if($is_rollno)
				{
					wp_redirect ( admin_url().'admin.php?page=smgt_student&tab=studentlist&message=3'); 
				}
				else 
				{						
					$result	= add_newuser($userdata,$usermetadata,$firstname,$lastname,$role);
					
					// Custom Field File Insert //
					$custom_field_file_array=array();
					if(!empty($_FILES['custom_file']['name']))
					{
						$count_array=count($_FILES['custom_file']['name']);
						
						for($a=0;$a<$count_array;$a++)
						{			
							foreach($_FILES['custom_file'] as $image_key=>$image_val)
							{
								foreach($image_val as $image_key1=>$image_val2)
								{
									if($_FILES['custom_file']['name'][$image_key1]!='')
									{  	
										$custom_file_array[$image_key1]=array(
										'name'=>$_FILES['custom_file']['name'][$image_key1],
										'type'=>$_FILES['custom_file']['type'][$image_key1],
										'tmp_name'=>$_FILES['custom_file']['tmp_name'][$image_key1],
										'error'=>$_FILES['custom_file']['error'][$image_key1],
										'size'=>$_FILES['custom_file']['size'][$image_key1]
										);							
									}	
								}
							}
						}			
						if(!empty($custom_file_array))
						{
							foreach($custom_file_array as $key=>$value)		
							{	
								global $wpdb;
								$wpnc_custom_field_metas = $wpdb->prefix . 'custom_field_metas';
				
								$get_file_name=$custom_file_array[$key]['name'];	
								
								$custom_field_file_value=smgt_load_documets_new($value,$value,$get_file_name);		
								
								//Add File in Custom Field Meta//
								$custom_meta_data['module']='student';
								$custom_meta_data['module_record_id']=$result;
								$custom_meta_data['custom_fields_id']=$key;
								$custom_meta_data['field_value']=$custom_field_file_value;
								$custom_meta_data['created_at']=date("Y-m-d H:i:s");
								$custom_meta_data['updated_at']=date("Y-m-d H:i:s");	
								 
								$insert_custom_meta_data=$wpdb->insert($wpnc_custom_field_metas, $custom_meta_data );
								 
							} 	
						}		 		
					}
					$add_custom_field=$custom_field_obj->Smgt_add_custom_field_metas('student',$_POST['custom'],$result);					
					 
					if($result)
					{ 
						wp_redirect ( admin_url().'admin.php?page=smgt_student&tab=studentlist&message=1'); 	  
					}
				}
			}
			else 
			{
				wp_redirect ( admin_url().'admin.php?page=smgt_student&tab=studentlist&message=4');
			}
		}
    }
}	
	// -----------Delete Code--------
if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
{
	$childs=get_user_meta($_REQUEST['student_id'], 'parent_id', true);
	if(!empty($childs))
	{
		foreach($childs as $key=>$childvalue)
		{					
			$parents=get_user_meta($childvalue, 'child',true);
			if(!empty($parents))
			{
				if(($key = array_search($_REQUEST['student_id'], $parents)) !== false) 
				{
					unset($parents[$key]);						
					update_user_meta( $childvalue,'child', $parents );							
				}					
			}				
		}
	}
		
	$result=delete_usedata($_REQUEST['student_id']);
	if($result)
	{
		wp_redirect ( admin_url().'admin.php?page=smgt_student&tab=studentlist&message=5');
	}
}

if(isset($_REQUEST['delete_selected']))
{		
	if(!empty($_REQUEST['id']))
	foreach($_REQUEST['id'] as $id)
	{
		$childs=get_user_meta($id, 'parent_id', true);			
		if(!empty($childs))
		{
			foreach($childs as $key=>$childvalue)
			{						
				$parents=get_user_meta($childvalue, 'child',true);						
				if(!empty($parents))
				{
					if(($key = array_search($id, $parents)) !== false)
					{
						unset($parents[$key]);						
						update_user_meta( $childvalue,'child', $parents );								
					}						
				}					
			}
		}			
		$result=delete_usedata($id);
	}

if($result){
		wp_redirect ( admin_url().'admin.php?page=smgt_student&tab=studentlist&message=5');
	}
}

if(isset($_REQUEST['print']) && $_REQUEST['print'] == 'pdf')
{
	$sudent_id = $_REQUEST['student'];
	downlosd_smgt_result_pdf($sudent_id);
}

if(isset($_REQUEST['upload_csv_file']))
{
	$nonce = $_POST['_wpnonce'];
	if ( wp_verify_nonce( $nonce, 'upload_teacher_admin_nonce' ) )
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
				//$header = array_map('strtolower',array_shift($rows));
				$header = array_map('trim',array_map('strtolower',array_shift($rows)));
				$csv = array();
				foreach ($rows as $row) 
				{
					$csv = array_combine($header, $row);
					$username = $csv['username'];
					 
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

					if( is_wp_error($user_id) ){ // in case the user is generating errors after this checks
						echo '<script>alert("Problems with user: ' . $username . ', we are going to skip");</script>';
						continue;
					}
					
					if(!(is_multisite() && is_super_admin( $user_id ) ))

						wp_update_user(array ('ID' => $user_id, 'role' => 'student')) ;
						update_user_meta( $user_id, "active", true );						
						update_user_meta( $user_id, "class_name", $_POST['class_name']);					
					
						$userbyroll_no	=	get_users(
							array('meta_query'	=>
								array('relation' => 'AND',
									array('key'	=>'class_name','value'=>$_POST['class_name']),
									array('key'=>'roll_id','value'=>$csv['roll no'])
								),
								'role'=>'student'
							)
						);
						
						$is_rollno = count($userbyroll_no);
						if($is_rollno)
						{
							$roll = "";	
							add_user_meta($user_id,'hash',rand());
						}
						else
						{
							$roll	=	$csv['roll no'];
						}
							
					
					
						$user_id1 = wp_update_user( array( 'ID' => $user_id, 'display_name' =>$csv['first name'].' '.$csv['last name']) );
						if(isset($_POST['class_section']))
							update_user_meta( $user_id, "class_section", $_POST['class_section'] );
						if(isset($csv['roll no']))
							update_user_meta( $user_id, "roll_id", $roll );
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
				wp_redirect ( admin_url().'admin.php?page=smgt_student&tab=studentlist&message=6');
			} 
		}
    }
}
?>
<!-- POP up code -->
<div class="popup-bg">
    <div class="overlay-content">
		<div class="modal-content">
			<div class="result"></div>
			<div class="view-parent"></div>
		</div>
    </div>    
</div>
<?php 
if(isset($_REQUEST['attendance']) && $_REQUEST['attendance'] == 1)
{
?>
<script type="text/javascript">
$(document).ready(function() {	
	$('.sdate').datepicker({
		dateFormat: "yy-mm-dd",
		maxDate: 0,
		beforeShow: function (textbox, instance) 
			{
				instance.dpDiv.css({
					marginTop: (-textbox.offsetHeight) + 'px'                   
				});
			}
		}); 
	$('.edate').datepicker({
		dateFormat: "yy-mm-dd",
		maxDate: 0,
		beforeShow: function (textbox, instance) 
			{
				instance.dpDiv.css({
					marginTop: (-textbox.offsetHeight) + 'px'                   
				});
			}
		});		
} );
</script>
<style>
.page-inner #message::first-child {
	margin-bottom: 20px !important;
}
</style>
<div class="page-inner">
	<div class="page-title"> 
		<h3><img src="<?php echo get_option( 'smgt_school_logo' ) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo get_option( 'smgt_school_name' );?></h3>
	</div>
	<?php
	$student_data=get_userdata($_REQUEST['student_id']);
	?>
	<div id="main-wrapper">
		<div class="row">
			<div class="panel panel-white">
				<div class="panel-body">
				<h2 class="nav-tab-wrapper">
			    	<a href="?page=smgt_student&student_id=<?php echo $_REQUEST['student_id'];?>&attendance=1" class="nav-tab nav-tab-active">
					<?php echo '<span class="dashicons dashicons-menu"></span>'.__('View Attendance', 'school-mgt'); ?></a>
				</h2>
				<form name="wcwm_report" action="" method="post">
				
				<input type="hidden" name="attendance" value=1> 
				<input type="hidden" name="user_id" value=<?php echo $_REQUEST['student_id'];?>> 
					<!--<div class="form-group col-md-12">
						<h4 class="panel-title attendence_name"><i class="fa fa-user"></i> <?php echo get_user_name_byid($_REQUEST['student_id']);?></h4>
					</div>-->
					<div class="row">
						<div class="col-md-3 col-sm-4 col-xs-12">	
							<?php
							$umetadata=get_user_image($_REQUEST['student_id']);
							if(empty($umetadata['meta_value']))
							{
								echo '<img class="img-circle img-responsive member-profile user_height_width" src='.get_option( 'smgt_student_thumb' ).'>';
							}
							else
								echo '<img class="img-circle img-responsive member-profile user_height_width" src='.$umetadata['meta_value'].'>';
							?>
						</div>
							
						<div class="col-md-9 col-sm-8 col-xs-12 ">
							<div class="row">
								<h2><?php echo $student_data->display_name;?></h2>
							</div>
							<div class="row">
								<div class="col-md-4 col-sm-3 col-xs-12">
									<i class="fa fa-envelope"></i>&nbsp;
									
									<span class="email-span"><?php echo $student_data->user_email;?></span>
								</div>
								<div class="col-md-3 col-sm-3 col-xs-12">
									<i class="fa fa-phone"></i>&nbsp;
									<span><?php echo $student_data->phone;?></span>
								</div>
								<div class="col-md-5 col-sm-3 col-xs-12 no-padding">
									<i class="fa fa-list-alt"></i>&nbsp;
									<span><?php echo $student_data->roll_id;?></span>
								</div>
							</div>					
						</div>
					</div>
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
	
	//var_dump($attendance);
	$curremt_date =$start_date;
?>	
<script>
jQuery(document).ready(function() {
	var table =  jQuery('#attendance_list').DataTable({
		responsive: true,
		"order": [[ 0, "asc" ]],
		dom: 'Bfrtip',
				buttons: [
				{
            extend: 'print',
			title: 'View Attendance',},
			{
			extend: 'pdf',
			title: 'View Attendance',
			}
				],
		"aoColumns":[	                  
	    {"bSortable": true},
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
		
	<table id="attendance_list" class="display" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th width="200px"><?php _e('Student Name','school-mgt');?></th>
				<th width="200px"><?php _e('Class Name','school-mgt');?></th>
				<th width="200px"><?php _e('Date','school-mgt');?></th>
				<th><?php _e('Day','school-mgt');?></th>
				<th><?php _e('Attendance','school-mgt');?></th>
				<th><?php _e('Comment','school-mgt');?></th>
			</tr>
		</thead>
 
        <tfoot>
            <tr>
				<th width="200px"><?php _e('Student Name','school-mgt');?></th>
				<th width="200px"><?php _e('Class Name','school-mgt');?></th>
				<th width="200px"><?php _e('Date','school-mgt');?></th>
				<th><?php _e('Day','school-mgt');?></th>
				<th><?php _e('Attendance','school-mgt');?></th>
				<th><?php _e('Comment','school-mgt');?></th>
			</tr>
        </tfoot>
 
        <tbody>
			<?php
				/* while ($end_date >= $curremt_date)
				{
					echo '<tr>';
					echo '<td>';
					echo get_display_name($user_id);
					echo '</td>';
					
					
					echo '<td>';
					echo get_class_name_by_id(get_user_meta($user_id, 'class_name',true));
					echo '</td>';
					
					echo '<td>';
					echo smgt_getdate_in_input_box($curremt_date);
					echo '</td>';
					
					$attendance_status = smgt_get_attendence($user_id,$curremt_date);
					echo '<td>';
					echo date("D", strtotime($curremt_date));
					echo '</td>';
					
					if(!empty($attendance_status))
					{
						echo '<td>';
						$attendanec_status=smgt_get_attendence($user_id,$curremt_date);
						if($attendanec_status=="Present")
						{
							echo __('Present','school-mgt');
						}
						elseif($attendanec_status=="Late")
						{
							echo __('Late','school-mgt');
						}
						else
						{
							echo __('Absent','school-mgt');
						}
						echo '</td>';
					}
					else 
					{
						echo '<td>';
						echo __('Absent','school-mgt');
						echo '</td>';
					}
					echo '<td>';
					echo smgt_get_attendence_comment($user_id,$curremt_date);
					echo '</td>';
					echo '</tr>';
					$curremt_date = strtotime("+1 day", strtotime($curremt_date));
					$curremt_date = date("Y-m-d", $curremt_date);
				} */
				
				foreach($attendance as $attendance_data)
				{
						
					echo '<td>';
					echo get_display_name($attendance_data->user_id);
					echo '</td>';
					
					
					echo '<td>';
					echo get_class_name_by_id(get_user_meta($attendance_data->user_id, 'class_name',true));
					echo '</td>';
					
					echo '<td>';
					echo smgt_getdate_in_input_box($attendance_data->attendence_date);
					echo '</td>';
					

					echo '<td>';
					echo date("D", strtotime($attendance_data->attendence_date));
					echo '</td>';
					
					$attendance_status = $attendance_data->status;
					if(!empty($attendance_status))
					{
						echo '<td>';
						//$attendanec_status=smgt_get_attendence($user_id,$curremt_date);
						if($attendance_status=="Present")
						{
							echo __('Present','school-mgt');
						}
						elseif($attendance_status=="Late")
						{
							echo __('Late','school-mgt');
						}
						else
						{
							echo __('Absent','school-mgt');
						}
						echo '</td>';
					}
					else 
					{
						echo '<td>';
						echo __('Absent','school-mgt');
						echo '</td>';
					}
					
				    echo '<td>';
					echo $attendance_data->comment;
					echo '</td>';
					echo '</tr>';
					
				}
			?>
        </tbody>        
    </table>
	</div>
<?php } ?>
</div>
</div>
</div>
</div>
</div>
<?php 
}
else 
{
	$active_tab = isset($_GET['tab'])?$_GET['tab']:'studentlist';
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
			$message_string = __('Student Added Successfully.','school-mgt');
			break;
		case '2':
			$message_string = __('Student Updated Successfully.','school-mgt');
			break;
		case '3':
			$message_string = __('Student Roll No. Already Exist.','school-mgt');
			break;
		case '4':
			$message_string = __("Student's Username Or Email-id Already Exist.",'school-mgt');
			break;
		case '5':
			$message_string = __('Student Deleted Successfully.','school-mgt');
			break;
		case '6':
			$message_string = __('Student CSV Successfully Uploaded.','school-mgt');
			break;
		case '7':
			$message_string = __('Student Activated Successfully.','school-mgt');
			break;
		
	}
	if($message)
	{ ?>
		<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible">
			<p><?php echo $message_string;?></p>
			<button type="button" class="notice-dismiss" data-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>
		</div>
<?php } ?>
	<div class="row">
		<div class="col-md-12">
		<div class="panel panel-white">
			<div class="panel-body">
				<h2 class="nav-tab-wrapper">
				<a href="?page=smgt_student&tab=studentlist" class="nav-tab <?php echo $active_tab == 'studentlist' ? 'nav-tab-active' : ''; ?>">
				<?php echo '<span class="dashicons dashicons-menu"></span> '.__('Student List', 'school-mgt'); ?></a>
				 <?php if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
				{ ?>
				<a href="?page=smgt_student&tab=addstudent&&action=edit&student_id=<?php echo $_REQUEST['student_id'];?>" class="nav-tab <?php echo $active_tab == 'addstudent' ? 'nav-tab-active' : ''; ?>">
				<?php _e('Edit Student', 'school-mgt'); ?></a>  
				<?php 
				}
				else
				{?>
				<a href="?page=smgt_student&tab=addstudent" class="nav-tab <?php echo $active_tab == 'addstudent' ? 'nav-tab-active' : ''; ?>">
				<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.__('Add New student', 'school-mgt'); ?></a>  
				<?php }?>
				<?php if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'view_student')
				{ ?>
				<a href="?page=smgt_student&tab=view_student&action=view_student&student_id=<?php echo $_REQUEST['student_id'];?>" class="nav-tab <?php echo $active_tab == 'view_student' ? 'nav-tab-active' : ''; ?>">
				<?php echo '<span class="fa fa-eye"></span> '.__('View Student', 'school-mgt'); ?></a>
				<?php
				}
				?>
				<?php if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'view_receipt')
				{ ?>
				<a href="?page=smgt_student&tab=view_exam_receipt&action=view_receipt&student_id=<?php echo $_REQUEST['student_id'];?>" class="nav-tab <?php echo $active_tab == 'view_exam_receipt' ? 'nav-tab-active' : ''; ?>">
				<?php echo '<span class="dashicons dashicons-menu"></span> '.__('Exam Receipt List', 'school-mgt'); ?></a>
				<?php
				}
				?>
				<a href="?page=smgt_student&tab=uploadstudent" class="nav-tab <?php echo $active_tab == 'uploadstudent' ? 'nav-tab-active' : ''; ?>">
				<?php echo '<span class="dashicons dashicons-menu"></span> '.__('Upload Student CSV', 'school-mgt'); ?></a>
			   
				 <a href="?page=smgt_student&tab=exportstudent" class="nav-tab margin_bottom <?php echo $active_tab == 'exportstudent' ? 'nav-tab-active' : ''; ?>">
				<?php echo '<span class="dashicons dashicons-menu"></span> '.__('Export Student', 'school-mgt'); ?></a>
		
        
			</h2>
     <?php 
	 if($active_tab == 'studentlist')
	 {
		
	//Report 1 
	?>
   <div class="panel-body"> 
   
        <form method="post">  
   <div class="form-group col-md-3">
	<label for="class_id"><?php _e('Select Class','school-mgt');?></label>			
	<?php 
	$class_id="";
	if(isset($_REQUEST['class_id'])) $class_id=$_REQUEST['class_id']; ?>                 
		<select name="class_id"  id="class_list"  class="form-control ">
			<option value=""><?php _e('Select class Name','school-mgt');?></option>
			<?php 
			  foreach(get_allclass() as $classdata)
			  {  
			  ?>
			   <option  value="<?php echo $classdata['class_id'];?>" <?php selected($classdata['class_id'],$class_id)?>><?php echo $classdata['class_name'];?></option>
		 <?php }?>
		</select>
	</div>
	<div class="form-group col-md-3">
		<label for="class_id"><?php _e('Select Class Section','school-mgt');?></label>			
		<?php 
		$class_section="";
		?>
		<select name="class_section" class="form-control validate[required]" id="class_section">
			<option value=""><?php _e('Select Class Section','school-mgt');?></option>
			<?php
				if(isset($_REQUEST['class_section']))
				{
					$class_section=$_REQUEST['class_section']; 
					foreach(smgt_get_class_sections($_REQUEST['class_id']) as $sectiondata)
					{  ?>
					 <option value="<?php echo $sectiondata->id;?>" <?php selected($class_section,$sectiondata->id);  ?>><?php echo $sectiondata->section_name;?></option>
				<?php } 
				}
				?>	
		</select>
	</div>
	<div class="form-group col-md-3 button-possition">
    	<label for="subject_id">&nbsp;</label>
      	<input type="submit" value="<?php _e('Go','school-mgt');?>" name="filter_class"  class="btn btn-info"/>
    </div>       
	</form>
	</div>
		 <?php  
			if(isset($_REQUEST['filter_class']) )
			{
				if(empty($_REQUEST['class_id']) && empty($_REQUEST['class_section']))
				{
					$exlude_id = smgt_approve_student_list();
					$studentdata =get_users(array('role'=>'student'));
					
				}
				elseif(isset($_REQUEST['class_section']) && $_REQUEST['class_section'] != "")
				{
					$class_id =$_REQUEST['class_id'];
					$class_section =$_REQUEST['class_section'];
					 $studentdata = get_users(array('meta_key' => 'class_section', 'meta_value' =>$class_section,'meta_query'=> array(array('key' => 'class_name','value' => $class_id,'compare' => '=')),'role'=>'student'));	
				}
				elseif(isset($_REQUEST['class_id']) && ($_REQUEST['class_section']) == "")
				{
					$class_id =$_REQUEST['class_id'];
					 $studentdata = get_users(array('meta_key' => 'class_name', 'meta_value' => $class_id,'role'=>'student'));	
				}
			}	
			else 
			{

				$exlude_id = smgt_approve_student_list();
				$studentdata =get_users(array('role'=>'student'));
			}
         	?>  
    
        <div class="panel-body">
	<script>
	jQuery(document).ready(function() {
		var table =  jQuery('#students_list').DataTable({
        responsive: true,
		"order": [[ 2, "asc" ]],
		"aoColumns":[	                  
			{"bSortable": false},
			{"bSortable": false},
			{"bSortable": true},
			{"bSortable": true},
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
			<form id="frm-example" name="frm-example" method="post">
        <table id="students_list" class="display admin_student_datatable" cellspacing="0" width="100%">
        	 <thead>
            <tr>
				<th style="width: 20px;"><input name="select_all" value="all" id="checkbox-select-all" 
				type="checkbox" /></th> 
				<th><?php echo _e( 'Photo', 'school-mgt' ) ;?></th>
                <th><?php echo _e( 'Student Name', 'school-mgt' ) ;?></th>
                 <th> <?php echo _e( 'Roll No.', 'school-mgt' ) ;?></th>
				<th> <?php echo _e( 'Class', 'school-mgt' ) ;?></th>
				 <th> <?php echo _e( 'Section', 'school-mgt' ) ;?></th>
                <th> <?php echo _e( 'Student Email', 'school-mgt' ) ;?></th>
				<th> <?php echo _e( 'Status', 'school-mgt' ) ;?></th>
                <th><?php echo _e( 'Action', 'school-mgt' ) ;?></th>
            </tr>
        </thead>
 
        <tfoot>
            <tr>
				<th></th>
				 <th><?php echo _e( 'Photo', 'school-mgt' ) ;?></th>
               <th><?php echo _e( 'Student Name', 'school-mgt' ) ;?></th>
                <th> <?php echo _e( 'Roll No.', 'school-mgt' ) ;?></th>
			    <th> <?php echo _e( 'Class', 'school-mgt' ) ;?></th>
				<th> <?php echo _e( 'Section', 'school-mgt' ) ;?></th>
                <th> <?php echo _e( 'Student Email', 'school-mgt' ) ;?>
				<th> <?php echo _e( 'Status', 'school-mgt' ) ;?></th>
               <th><?php echo _e( 'Action', 'school-mgt' ) ;?></th>
                
            </tr>
        </tfoot>
 
        <tbody>
         <?php 
		 
			//$studentdata=get_usersdata('student');
		 	if(!empty($studentdata))
			{
				foreach ($studentdata as $retrieved_data){ 
			?>
			<tr>
				<td><input type="checkbox" class="select-checkbox" name="id[]" value="<?php echo $retrieved_data->ID;?>"></td>
				<td class="user_image">
				<?php
					$uid=$retrieved_data->ID;
					$umetadata=get_user_image($uid);
					if(empty($umetadata))
					{
						echo '<img src='.get_option( 'smgt_student_thumb' ).' height="50px" width="50px" class="img-circle" />';
					}
					else
					{
						echo '<img src='.$umetadata.' height="50px" width="50px" class="img-circle" />';
					}
				?>
				</td>
				<td class="name"><a href="?page=smgt_student&tab=addstudent&action=edit&student_id=<?php echo $retrieved_data->ID;?>">
				<?php echo $retrieved_data->display_name;?></a></td>
				<td class="roll_no">
					<?php 
						if(get_user_meta($retrieved_data->ID, 'roll_id', true))
						echo get_user_meta($retrieved_data->ID, 'roll_id',true);
					?>
				</td>
			    <td class="name"><?php $class_id=get_user_meta($retrieved_data->ID, 'class_name',true);
					echo $classname=get_class_name($class_id);
				?></td>
				<td class="name">
				<?php 
					$section_name=get_user_meta($retrieved_data->ID, 'class_section',true);
					if($section_name!=""){
						echo smgt_get_section_name($section_name); 
					}
					else
					{
						_e('No Section','school-mgt');;
					}
				?>
				</td>
				<td class="email"><?php echo $retrieved_data->user_email;?></td>
				<td> <?php 
					if( get_user_meta($retrieved_data->ID, 'hash', true))
					{
						echo '<span class="btn btn-default active-user" idtest="'.$retrieved_data->ID.'"> ';
							_e( 'Active', 'school-mgt' ) ;
						echo " </span>";
					}
					else
					{
						_e( 'Approved', 'school-mgt' );
					}	
					?>
				</td>
				<?php
				 
				?>
				<td class="action"> 
				<a href="?page=smgt_student&tab=view_student&action=view_student&student_id=<?php echo $retrieved_data->ID;?>" class="btn btn-success"><?php _e('View','school-mgt');?></a>  
				<a href="?page=smgt_student&tab=addstudent&action=edit&student_id=<?php echo $retrieved_data->ID;?>" class="btn btn-info"><?php _e('Edit','school-mgt');?></a>  
					<a href="?page=smgt_student&tab=studentlist&action=delete&student_id=<?php echo $retrieved_data->ID;?>" class="btn btn-danger" 
					onclick="return confirm('Are you sure you want to delete this record?');"><?php _e('Delete','school-mgt');?></a> 
					<?php
					$result=smgt_student_exam_receipt_check($retrieved_data->ID);
					if($result)
					{
					?>
						<a href="?page=smgt_student&tab=view_exam_receipt&action=view_receipt&student_id=<?php echo $retrieved_data->ID;?>" class="btn btn-primary"><?php _e('Exam Receipt','school-mgt');?></a>  
				<?php	
					}
					?>
					<a href="?page=smgt_student&tab=studentlist&action=result&student_id=<?php echo $retrieved_data->ID;?>" class="show-popup btn btn-default" 
					idtest="<?php echo $retrieved_data->ID; ?>"><i class="fa fa-bar-chart"></i> <?php _e('View Result', 'school-mgt');?></a>
					<a href="?page=smgt_student&student_id=<?php echo $retrieved_data->ID;?>&attendance=1" class="btn btn-default" 
					idtest="<?php echo $retrieved_data->ID; ?>"><i class="fa fa-eye"></i> <?php _e('View Attendance','school-mgt');?></a>											
				</td>
			</tr>
			<?php } 
			} ?>
          </tbody>        
        </table>
		<div class="print-button pull-left">
			<input id="delete_selected" type="submit" value="<?php _e('Delete Selected','school-mgt');?>" name="delete_selected" class="btn btn-danger delete_selected"/>
		</div>
		</form>
        	</div>
        </div>
		<?php 	}	
	if($active_tab == 'addstudent')
	{
		require_once SMS_PLUGIN_DIR. '/admin/includes/student/student.php';
	}
	if($active_tab == 'uploadstudent')
	{
	 	require_once SMS_PLUGIN_DIR. '/admin/includes/student/uploadstudent.php';
	}
	if($active_tab == 'view_student')
	{
	 	require_once SMS_PLUGIN_DIR. '/admin/includes/student/view_student.php';
	}
	if($active_tab == 'exportstudent')
	{
	 	require_once SMS_PLUGIN_DIR. '/admin/includes/student/exportstudent.php';
	}
	if($active_tab == 'view_exam_receipt')
	{
	 	require_once SMS_PLUGIN_DIR. '/admin/includes/student/view_exam_receipt.php';
	}
	?>
	</div>
</div>
</div>
</div>
</div>
<?php } ?>