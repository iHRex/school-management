<?php 
	$obj_attend=new Attendence_Manage();
	$class_id =0;
	$current_date = date("y-m-d");
	$active_tab = isset($_GET['tab'])?$_GET['tab']:'attendence';
	$obj_attend=new Attendence_Manage();
	$class_id =0;
	$current_date = date("y-m-d");
	$active_tab = isset($_GET['tab'])?$_GET['tab']:'attendence';
	$MailCon = get_option('absent_mail_notification_content');
	$Mailsub= get_option('absent_mail_notification_subject');
	if(isset($_REQUEST['save_attendence']))
	{	
		$class_id		=	$_POST['class_id'];
		$parent_list 	= 	smgt_get_user_notice('parent',$class_id);		
		$attend_by		=	get_current_user_id();		
		
		if(isset($_POST['class_section']) && $_POST['class_section'] !=0)
		{
			$exlude_id 	= 	smgt_approve_student_list();
			$students 	= 	get_users(array('meta_key' => 'class_section', 'meta_value' =>$_REQUEST['class_section'],
				'meta_query'=> array(array('key' => 'class_name','value' => $class_id,'compare' => '=')),'role'=>'student','exclude'=>$exlude_id));	
		}
		else
		{ 
			$exlude_id 	= 	smgt_approve_student_list();
			$students 	= 	get_users(array('meta_key' => 'class_name', 'meta_value' => $class_id,'role'=>'student','exclude'=>$exlude_id));
		}
		
		$parent_list 	=	array();
		foreach($students as $stud)
		{			
			if(isset($_POST['attendanace_'.$stud->ID]))
			{
				if(isset($_POST['smgt_sms_service_enable']))
				{
					$current_sms_service 	= 	get_option( 'smgt_sms_service');					
					if($_POST['attendanace_'.$stud->ID] == 'Absent')
					{
						$parent_list 	= 	smgt_get_student_parent_id($stud->ID);						
						if(!empty($parent_list))
						{
							$parent_number 	=	array();
							foreach ($parent_list as $user_id)
							{
								$parent_number[] = "+".smgt_get_countery_phonecode(get_option( 'smgt_contry' )).get_user_meta($user_id, 'mobile_number',true);
							}
							//var_dump($parent_number); 
							$message_content = "Your Child ".get_user_name_byid($stud->ID)." is absent on ".$_POST['curr_date'];
							if(is_plugin_active('sms-pack/sms-pack.php'))
							{								
								$args = array();
								$args['mobile']=$parent_number;
								$args['message']=$message_content;					
								$args['message_from']='attendanace';					
								$args['message_side']='front';					
								if($current_sms_service=='telerivet' || $current_sms_service ="MSG91" || $current_sms_service=='bulksmsnigeria' || $current_sms_service=='bulksmsgateway.in' || $current_sms_service=='textlocal.in' ||$current_sms_service=='ViaNettSMS' || $current_sms_service=='africastalking')
								{
									$send = send_sms($args);					
								}
							}
							else
							{
								foreach ($parent_list as $user_id)
								{
									$parent = get_userdata($user_id);								
									$reciever_number = "+".smgt_get_countery_phonecode(get_option( 'smgt_contry' )).get_user_meta($user_id, 'mobile_number',true);				
									$message_content = "Your Child ".get_user_name_byid($stud->ID)." is absent absent on ".$_POST['curr_date'];
									if($current_sms_service == 'clickatell')
									{
										$clickatell=get_option('smgt_clickatell_sms_service');
										$to = $reciever_number;
										$message = str_replace(" ","%20",$message_content);
										$username = $clickatell['username']; //clickatell username
										$password = $clickatell['password']; // clickatell password
										$api_key = $clickatell['api_key'];//clickatell apikey
										$baseurl ="http://api.clickatell.com";									
										$url = "$baseurl/http/auth?user=$username&password=$password&api_id=$api_key";									
										$ret = file($url);									
										$sess = explode(":",$ret[0]);
										if ($sess[0] == "OK")
										{
											$sess_id = trim($sess[1]); // remove any whitespace
											$url = "$baseurl/http/sendmsg?session_id=$sess_id&to=$to&text=$message";									
											$ret = file($url);
											$send = explode(":",$ret[0]);										
										}				
									}
									if($current_sms_service == 'twillo')
									{
										require_once SMS_PLUGIN_DIR. '/lib/twilio/Services/Twilio.php';
										$twilio=get_option( 'smgt_twillo_sms_service');
										$account_sid = $twilio['account_sid']; //Twilio SID
										$auth_token = $twilio['auth_token']; // Twilio token
										$from_number = $twilio['from_number'];//My number
										$receiver = $reciever_number; //Receiver Number
										$message = $message_content; // Message Text									
										$client = new Services_Twilio($account_sid, $auth_token);
										$message_sent = $client->account->messages->sendMessage(
											$from_number, // From a valid Twilio number
											$receiver, // Text this number
											$message
										);				
									}
									if($current_sms_service == 'msg91')
									{
										//MSG91
										$mobile_number=get_user_meta($user_id, 'mobile_number',true);
										$country_code="+".smgt_get_countery_phonecode(get_option( 'smgt_contry' ));
										$message = $message_content; // Message Text
										smgt_msg91_send_mail_function($mobile_number,$message,$country_code);
									}		
									$MailArr['{{child_name}}'] = get_display_name($stud->ID);								
									$MailArr['{{school_name}}'] =  	get_option('smgt_school_name');								
									$Mail = string_replacement($MailArr,$MailCon);								
									$MailSub = string_replacement($MailArr,$Mailsub);								
									smgt_send_mail($parent->user_email,$MailSub,$Mail);								
								}
							} 
						} 
					} 				
				
				}
				//print_r($_POST['attendanace_'.$stud->ID]);
				$savedata = $obj_attend->insert_student_attendance($_POST['curr_date'],$class_id,$stud->ID,$attend_by,$_POST['attendanace_'.$stud->ID],$_POST['attendanace_comment_'.$stud->ID]);				
			}
		} 
			wp_redirect ( admin_url().'admin.php?page=smgt_attendence&message=1');
	}
	if(isset($_REQUEST['save_sub_attendence']))
	{			
		$class_id=$_POST['class_id'];
		$parent_list = smgt_get_user_notice('parent',$class_id);		
		$attend_by=get_current_user_id();		
		$exlude_id = smgt_approve_student_list();
		$students = get_users(array('meta_key' => 'class_name', 'meta_value' => $class_id,'role'=>'student','exclude'=>$exlude_id));
		foreach($students as $stud)
		{
			if(isset($_POST['attendanace_'.$stud->ID]))
			{
				if(isset($_POST['smgt_sms_service_enable']))
				{
					$current_sms_service = get_option( 'smgt_sms_service');
					if($_POST['attendanace_'.$stud->ID] == 'Absent')
					{
						$parent_list = smgt_get_student_parent_id($stud->ID);
						if(!empty($parent_list))
						{
							foreach ($parent_list as $user_id)
							{
								$sub = get_subject($_POST['sub_id']);								
								$parent = get_userdata($user_id);
								$reciever_number = "+".smgt_get_countery_phonecode(get_option( 'smgt_contry' )).get_user_meta($user_id, 'mobile_number',true);								
								$message_content = "Your Child ".get_user_name_byid($stud->ID)."  is absent in ".$sub->sub_name . " Subject on ".$_POST['curr_date'];
								if(is_plugin_active('sms-pack/sms-pack.php'))
								{
									$parent_number =array();
									foreach ($parent_list as $user_id)
									{
										$parent_number[] = "+".smgt_get_countery_phonecode(get_option( 'smgt_contry' )).get_user_meta($user_id, 'mobile_number',true);
									}							
									$args = array();
									$args['mobile']=$parent_number;
									$args['message']=$message_content;					
									$args['message_from']='attendanace';					
									$args['message_side']='backend';					
									if($current_sms_service=='telerivet' || $current_sms_service ="MSG91" || $current_sms_service=='bulksmsnigeria' || $current_sms_service=='bulksmsgateway.in' || $current_sms_service=='textlocal.in' ||$current_sms_service=='ViaNettSMS' || $current_sms_service=='africastalking')
									{
										$send = send_sms($args);					
									}
								}
								else
								{
								if($current_sms_service == 'clickatell')
								{
									$clickatell=get_option('smgt_clickatell_sms_service');
									$to = $reciever_number;
									$message = str_replace(" ","%20",$message_content);
									$username = $clickatell['username']; //clickatell username
									$password = $clickatell['password']; // clickatell password
									$api_key = $clickatell['api_key'];//clickatell apikey
									$sender_id = $clickatell['sender_id'];//clickatell sender_id
									$baseurl ="http://api.clickatell.com";								
									
									$url = "$baseurl/http/auth?user=$username&password=$password&api_id=$api_key";
										
									$ret = file($url);
									$sess = explode(":",$ret[0]);
									if ($sess[0] == "OK")
									{
										$sess_id = trim($sess[1]); // remove any whitespace
										$url = "$baseurl/http/sendmsg?session_id=$sess_id&to=$to&text=$message&from=$sender_id";
																	
										$ret = file($url);
										$send = explode(":",$ret[0]);										
									}								
								}
								if($current_sms_service == 'twillo')
								{
									//Twilio lib
									require_once SMS_PLUGIN_DIR. '/lib/twilio/Services/Twilio.php';
									$twilio=get_option( 'smgt_twillo_sms_service');
									$account_sid = $twilio['account_sid']; //Twilio SID
									$auth_token = $twilio['auth_token']; // Twilio token
									$from_number = $twilio['from_number'];//My number
									$receiver = $reciever_number; //Receiver Number
									$message = $message_content; // Message Text
									//twilio object
									$client = new Services_Twilio($account_sid, $auth_token);
									$message_sent = $client->account->messages->sendMessage(
											$from_number, // From a valid Twilio number
											$receiver, // Text this number
											$message
									);								
								}
								if($current_sms_service == 'msg91')
								{
									//MSG91
									$mobile_number=get_user_meta($user_id, 'mobile_number',true);
									$country_code="+".smgt_get_countery_phonecode(get_option( 'smgt_contry' ));
									$message = $message_content; // Message Text
									smgt_msg91_send_mail_function($mobile_number,$message,$country_code);
								}		
							}
								$MailArr['{{child_name}}'] = get_display_name($stud->ID);								
								$Mail = string_replacement($MailArr,$MailCon);								
								$MailSub = string_replacement($MailArr,$Mailsub);								
								smgt_send_mail($parent->user_email,$MailSub,$Mail);							
							}
						}
					}
				}				
				$savedata = $obj_attend->insert_subject_wise_attendance($_POST['curr_date'],$class_id,$stud->ID,$attend_by,$_POST['attendanace_'.$stud->ID],$_POST['sub_id'],$_POST['attendanace_comment_'.$stud->ID]);
			}					
		}		
			wp_redirect ( admin_url().'admin.php?page=smgt_attendence&message=1');
		
	 }
	//Teacher attendence 
if(isset($_REQUEST['save_teach_attendence']))
{
	$attend_by=get_current_user_id();
	$teacher = get_users(array('role' => 'teacher'));
	foreach($teacher as $stud)
	{
		if(isset($_POST['attendanace_'.$stud->ID]))
		{
			$savedata = $obj_attend->insert_teacher_attendance($_POST['tcurr_date'],$stud->ID,$attend_by,$_POST['attendanace_'.$stud->ID],$_POST['attendanace_comment_'.$stud->ID]);
		}
	}
	/* if($savedata != false)
	{  */
		wp_redirect ( admin_url().'admin.php?page=smgt_attendence&tab=teacher_attendence&message=1');
	/* } */
}
if(isset($_POST['export_attendance_in_csv']))
{
	$obj_attend=new Attendence_Manage();
	$student_attendance_list=$obj_attend->get_all_attendence();
	if(!empty($student_attendance_list))
	{
			$header = array();			
			$header[] = 'Roll No';
			$header[] = 'Student Name';
			$header[] = 'User_id';
			$header[] = 'Class_name';
			$header[] = 'Class_id';
			$header[] = 'Attend_by_name';
			$header[] = 'Attend_by';
			$header[] = 'Attendence_date';
			$header[] = 'Status';
			$header[] = 'Role_name';
			$header[] = 'Comment';			
			
			$filename='Reports/export_attendance.csv';
			
			$fh = fopen(SMS_PLUGIN_DIR.'/admin/'.$filename, 'w') or die("can't open file");
			fputcsv($fh, $header);
			foreach($student_attendance_list as $retrive_data)
			{
				if($retrive_data->role_name == 'student')
				{
					$row = array();
					$user_info = get_userdata($retrive_data->user_id);
					
					$roll_no= get_user_meta($retrive_data->user_id, 'roll_id',true);
					if(!empty($roll_no))
					{
						$roll_no=$roll_no;
					}
					else
					{
						$roll_no='-';
					}					
					$row[] = $roll_no;
					$row[] = $user_info->display_name;
					$row[] = $retrive_data->user_id;
					$class_id= $retrive_data->class_id;	
					$classname=get_class_name($class_id);
					if(!empty($classname))
					{
						$classname=$classname;
					}
					else
					{
						$classname='-';
					}	
					$row[] = $classname;	
					$row[] = $retrive_data->class_id;	
					$attend_by = get_userdata($retrive_data->attend_by);				
					$row[] =  $attend_by->display_name;				
					$row[] =  $retrive_data->attend_by;				
					$row[] =  $retrive_data->attendence_date;
					$row[] =  $retrive_data->status;
					$row[] =  $retrive_data->role_name;
					$row[] =  $retrive_data->comment;
					
					fputcsv($fh, $row);		
				}					
			}
			
			fclose($fh);

		//download csv file.
		ob_clean();
		$file=SMS_PLUGIN_DIR.'/admin/Reports/export_attendance.csv';//file location
		
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
		wp_redirect ( admin_url().'admin.php?page=smgt_attendence&tab=export_attendance&message=3');
	}
}
if(isset($_REQUEST['upload_attendance_csv_file']))
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
			$header = array_map('strtolower',array_shift($rows));
			$csv = array();
			foreach ($rows as $row) 
			{
				$csv = array_combine($header, $row);				
			
				if($csv['role_name']== 'student')
				{					
					$curr_date=date('Y-m-d', strtotime($csv['attendence_date']));					
					$class_id=$csv['class_id'];
					$user_id=$csv['user_id'];
					$attend_by=$csv['attend_by'];
					$status=$csv['status'];
					$attendanace_comment=$csv['comment'];
					
					$savedata = $obj_attend->insert_student_attendance($curr_date,$class_id,$user_id,$attend_by,$status,$attendanace_comment);	
					
					$success = 1;
				}
			}
		}
		else
		{
			foreach($errors as &$error) echo $error;
		}
				
		if(isset($success))
		{				
			wp_redirect ( admin_url().'admin.php?page=smgt_attendence&message=4');
		} 
	}
}
?>

<script type="text/javascript">
$(document).ready(function() {
	$('#student_attendance').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
	$('#curr_date').datepicker({
		maxDate:'0',
		dateFormat: "yy-mm-dd",
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
<div id="main-wrapper" class=" attendance_list"> 
<?php
	$message = isset($_REQUEST['message'])?$_REQUEST['message']:'0';
	switch($message)
	{
		case '1':
			$message_string = __('Attendance successfully saved!','school-mgt');
			break;
		case '2':
			$message_string = __('','school-mgt');
			break;			
		case '3':
			$message_string = __('Attendance records not found.','school-mgt');
			break;
		case '4':
			$message_string = __('Attendance records successfully imported.','school-mgt');
			break;	
	}
	
	if($message)
	{ ?>
		<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible">
			<p><?php echo $message_string;?></p>
			<button type="button" class="notice-dismiss" data-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>
		</div>
<?php } ?>
<div class="panel panel-white">
<div class="panel-body">    
	<h2 class="nav-tab-wrapper">	
    	<a href="?page=smgt_attendence&tab=attendence" class="nav-tab <?php echo $active_tab == 'attendence' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-groups"></span>'.__('Attendance', 'school-mgt'); ?></a>
        <a href="?page=smgt_attendence&tab=teacher_attendence" class="nav-tab <?php echo $active_tab == 'teacher_attendence' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-businessman"></span>'.__('Teacher  Attendance', 'school-mgt'); ?></a>
        <a href="?page=smgt_attendence&tab=subject_attendence" class="nav-tab margin_bottom <?php echo $active_tab == 'subject_attendence' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-groups"></span>'.__('Subject Wise Attendance', 'school-mgt'); ?></a>
		<a href="?page=smgt_attendence&tab=export_attendance" class="nav-tab margin_top_attendance_qr margin_bottom <?php echo $active_tab == 'export_attendance' ? 'nav-tab-active' : ''; ?>">
			<?php echo '<span class="dashicons dashicons-groups"></span>'.__('Export Attendance', 'school-mgt'); ?></a>	
		<a href="?page=smgt_attendence&tab=import_attendence" class="nav-tab margin_top_attendance_qr margin_bottom <?php echo $active_tab == 'import_attendence' ? 'nav-tab-active' : ''; ?>">
			<?php echo '<span class="dashicons dashicons-groups"></span>'.__('Import Attendance', 'school-mgt'); ?></a>		
    </h2>
    <?php
	if($active_tab == 'attendence')
	{ ?>	 
		<div class="panel-body"> 
        <form method="post" id="student_attendance">  
          <input type="hidden" name="class_id" value="<?php echo $class_id;?>" />
          <div class="form-group col-md-3">
			<label class="control-label" for="curr_date"><?php _e('Date','school-mgt');?></label>			
				<input id="curr_date" class="form-control" type="text" value="<?php if(isset($_POST['curr_date'])) echo $_POST['curr_date']; else echo  date("Y-m-d");?>" name="curr_date" readonly>			
		</div>
		<div class="form-group col-md-3">
			<label for="class_id"><?php _e('Select Class','school-mgt');?><span class="require-field">*</span></label>			
			<?php if(isset($_REQUEST['class_id'])) $class_id=$_REQUEST['class_id']; ?>                 
                    <select name="class_id"  id="class_list"  class="form-control validate[required]">
                        <option value=" "><?php _e('Select class Name','school-mgt');?></option>
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
			if(isset($_REQUEST['class_section'])) $class_section=$_REQUEST['class_section']; ?>
			<select name="class_section" class="form-control" id="class_section">
					<option value=""><?php _e('Select Class Section','school-mgt');?></option>
					<?php if(isset($_REQUEST['class_section'])){
						$class_section=$_REQUEST['class_section']; 
						foreach(smgt_get_class_sections($_REQUEST['class_id']) as $sectiondata)
						{  ?>
						 <option value="<?php echo $sectiondata->id;?>" <?php selected($class_section,$sectiondata->id);  ?>><?php echo $sectiondata->section_name;?></option>
					<?php } 
					} ?>	
			</select>
				</div>
		 <div class="form-group col-md-3 button-possition">
    	<label for="subject_id">&nbsp;</label>
      	<input type="submit" value="<?php _e('Take/View  Attendance','school-mgt');?>" name="attendence"  class="btn btn-info"/>
    </div>
</form>
</div>
<div class="clearfix"> </div>
<?php 
    if(isset($_REQUEST['attendence']) || isset($_REQUEST['save_attendence']))
    {
		$attendanace_date=$_REQUEST['curr_date'];
		$holiday_dates=get_all_date_of_holidays();
		if (in_array($attendanace_date, $holiday_dates))
		{
			?>
			<div class="alert_msg alert alert-warning alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
				<?php _e('This day is holiday you are not able to take attendance','school-mgt');?>
			</div>
		<?php 
		}
		else
		{
		
			if(isset($_REQUEST['class_id']) && $_REQUEST['class_id'] != "")
				$class_id 	=	$_REQUEST['class_id'];
			else 
				$class_id 	=	 0;
				if($class_id == 0)
				{ ?>
					<div class="panel-heading">
						<h4 class="panel-title"><?php _e('Please Select Class','school-mgt');?></h4>
					</div>
			 <?php }
					else
					{
						$class_section=0;
						if(isset($_REQUEST['class_section']) && $_REQUEST['class_section'] !=0)
						{
							$class_section	=	$_REQUEST['class_section'];
							$exlude_id 		= 	smgt_approve_student_list();
							$student 	= 	get_users(array('meta_key' => 'class_section', 'meta_value' =>$_REQUEST['class_section'],'meta_query'=> array(array('key' => 'class_name','value' => $class_id,'compare' => '=')),'role'=>'student','exclude'=>$exlude_id));
							sort($student);
						}
						else
						{ 
						  $exlude_id = smgt_approve_student_list();
							$student = get_users(array('meta_key' => 'class_name', 'meta_value' => $class_id,'role'=>'student','exclude'=>$exlude_id));
							sort($student);
						} ?>
				   <div class="panel-body">  
			<form method="post"  class="form-horizontal">           
				<input type="hidden" name="class_id" value="<?php echo $class_id;?>" />
				<input type="hidden" name="class_section" value="<?php echo $class_section;?>" />
				<input type="hidden" name="curr_date" value="<?php if(isset($_POST['curr_date'])) echo smgt_getdate_in_input_box($_POST['curr_date']); else echo  date("Y-m-d");?>" />
			
			 <div class="panel-heading">
				<h4 class="panel-title"> <?php _e('Class','school-mgt')?> : <?php echo get_class_name($class_id);?> , 
				<?php _e('Date','school-mgt')?> : <?php echo smgt_getdate_in_input_box($_POST['curr_date']);?></h4>
			 </div>
			
		<div class="col-md-12 padding_payment">
			<div class="table-responsive">
				<table class="table">
					<tr><!--  
						<?php if($_REQUEST['curr_date'] == date("Y-m-d")){ ?> 
						   <th width="100px"><input type="checkbox" name="selectall" id="selectall"/></th>
						  <th width="100px"><?php _e('Status','school-mgt');?></th>
						  <?php }
						  else { ?>
							<th width="100px"><?php _e('Status','school-mgt');?></th>
							<?php 
						   }  ?>-->
						  <th><?php _e('Srno','school-mgt');?></th>
						  <th><?php _e('Roll No.','school-mgt');?></th>
						<th><?php _e('Student Name','school-mgt');?></th>
						 <th><?php _e('Attendance','school-mgt');?></th>
						 <th><?php _e('Comment','school-mgt');?></th>
					</tr>
					<?php
					$date = $_POST['curr_date'];
					$i = 1;

					 foreach ( $student as $user ) {
							$date = $_POST['curr_date'];                   
							$check_attendance = $obj_attend->check_attendence($user->ID,$class_id,$date);
							$attendanc_status = "Present";
							if(!empty($check_attendance))
							{
								$attendanc_status = $check_attendance->status;                    	
							}                   
						echo '<tr>';              
						echo '<td>'.$i.'</td>';
						echo '<td><span>' .get_user_meta($user->ID, 'roll_id',true). '</span></td>';
						echo '<td><span>' .$user->first_name.' '.$user->last_name. '</span></td>';
						?>
						<td><label class="radio-inline"><input type="radio" name = "attendanace_<?php echo $user->ID?>" value ="Present" <?php checked( $attendanc_status, 'Present' );?>>
						<?php _e('Present','school-mgt');?></label>
						<label class="radio-inline"> <input type="radio" name = "attendanace_<?php echo $user->ID?>" value ="Absent" <?php checked( $attendanc_status, 'Absent' );?>>
						<?php _e('Absent','school-mgt');?></label>
						<label class="radio-inline"><input type="radio" name = "attendanace_<?php echo $user->ID?>" value ="Late" <?php checked( $attendanc_status, 'Late' );?>>
						<?php _e('Late','school-mgt');?></label></td>
						<td><input type="text" name="attendanace_comment_<?php echo $user->ID?>" class="form-control" 
						value="<?php if(!empty($check_attendance)) echo $check_attendance->comment;?>"></td>
						<?php 
						
						echo '</tr>';
						$i++;}?>
						   
				</table>
			</div>
			<div class="form-group">
				<label class="col-sm-4 control-label " for="enable"><?php _e('If student absent then Send  SMS to his/her parents','school-mgt');?></label>
				<div class="col-sm-2" style="padding-left: 0px;">
					 <div class="checkbox">
						<label>
							<input id="chk_sms_sent1" type="checkbox" <?php $smgt_sms_service_enable = 0;if($smgt_sms_service_enable) echo "checked";?> value="1" name="smgt_sms_service_enable">
						</label>
					</div>				 
				</div>
			</div>
		</div>
		<div class="col-sm-12"> 					    	
			<input type="submit" value="<?php _e('Save  Attendance','school-mgt');?>" name="save_attendence" class="btn btn-success" />
		</div>
		</form>
	 </div>
<?php }
	}
}
	}
	if($active_tab == 'teacher_attendence')
	{ 
		require_once SMS_PLUGIN_DIR. '/admin/includes/attendence/teacher-attendence.php';
	}
	if($active_tab == 'subject_attendence')
	{ 
		require_once SMS_PLUGIN_DIR. '/admin/includes/attendence/subject-attendence.php';
	}
	if($active_tab == 'import_attendence')
	{ 
		require_once SMS_PLUGIN_DIR. '/admin/includes/attendence/import_attendence.php';
	}
	if($active_tab == 'export_attendance')
	{ 
		require_once SMS_PLUGIN_DIR. '/admin/includes/attendence/export_attendance.php';
	}
?>
	</div>
	</div>
</div>
</div>