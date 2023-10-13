<script>
$(".ui-datepicker-next, .ui-datepicker-prev").hover(function () {
$(this).addClass("hover");
},
function () {
$(this).removeClass("hover");
});
</script>
<style>
.hover
{
background-image:url('paper.gif')!important;
}
</style>
<?php  
//-------- CHECK BROWSER JAVA SCRIPT ----------//
MJ_smgt_browser_javascript_check();
$active_tab = isset($_GET['tab'])?$_GET['tab']:'noticelist';
//--------------- ACCESS WISE ROLE -----------//
$user_access=smgt_get_userrole_wise_access_right_array();
if (isset ( $_REQUEST ['page'] ))
{	
	if($user_access['view']=='0')
	{	
		MJ_smgt_access_right_page_not_access_message();
		die;
	}
	if(!empty($_REQUEST['action']))
	{
		if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == $user_access['page_link'] && ($_REQUEST['action']=='edit'))
		{
			if($user_access['edit']=='0')
			{	
				MJ_smgt_access_right_page_not_access_message();
				die;
			}			
		}
		if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == $user_access['page_link'] && ($_REQUEST['action']=='delete'))
		{
			if($user_access['delete']=='0')
			{	
				MJ_smgt_access_right_page_not_access_message();
				die;
			}	
		}
		if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == $user_access['page_link'] && ($_REQUEST['action']=='insert'))
		{
			if($user_access['add']=='0')
			{	
				MJ_smgt_access_right_page_not_access_message();
				die;
			}	
		} 
	}
}
//-------------------- SAVE NOTICE ---------------------------//
if(isset($_POST['save_notice']))
	{	
        $nonce = $_POST['_wpnonce'];
	    if ( wp_verify_nonce( $nonce, 'save_notice_admin_nonce' ) )
		{
			$start_date = date('Y-m-d',strtotime($_REQUEST['start_date']));
			$end_date = date('Y-m-d',strtotime($_REQUEST['end_date']));
			if($start_date > $end_date )
			{
				echo '<script type="text/javascript">alert("'.__('End Date should be greater than the Start Date','school-mgt').'");</script>';
			}
			else
			{
				if(isset($_POST['class_id']))
					$class_id 	=	$_REQUEST['class_id'];
			
				if($_REQUEST['action']=='edit')
				{
					$args = array(
						'ID'           => $_REQUEST['notice_id'],
						'post_title'   => MJ_smgt_popup_category_validation($_REQUEST['notice_title']),
						'post_content' => MJ_smgt_address_description_validation($_REQUEST['notice_content']),
					);
					
					$result1	=	wp_update_post( $args );
					$result2	=	update_post_meta($_REQUEST['notice_id'], 'notice_for', $_REQUEST['notice_for']);
					$result3	=	update_post_meta($_REQUEST['notice_id'], 'start_date',$_REQUEST['start_date']);
					$result4	=	update_post_meta($_REQUEST['notice_id'], 'end_date',$_REQUEST['end_date']);
								
					if(isset($_POST['class_id']))
						$result5	=	update_post_meta($_REQUEST['notice_id'], 'smgt_class_id',$_REQUEST['class_id']);
					
					if(isset($_POST['class_section']))
						$result6	=	update_post_meta($_REQUEST['notice_id'], 'smgt_section_id',$_REQUEST['class_section']);
					
					$role	=	$_POST['notice_for'];
					$smgt_sms_service_enable=0;
					$current_sms_service_active		=	get_option( 'smgt_sms_service');
					
					 if(isset($_POST['smgt_sms_service_enable']))
						$smgt_sms_service_enable 	= 	$_POST['smgt_sms_service_enable'];
				
					if($smgt_sms_service_enable)
					{	
						$current_sms_service 	= 	get_option( 'smgt_sms_service');
						if(!empty($current_sms_service))
						{
							$userdata	=	smgt_get_user_notice($role,$_REQUEST['class_id'],$_REQUEST['class_section']);
							
							if(!empty($userdata))
							{
								$mail_id 	= 	array();
								$i	 = 	0;
								foreach($userdata as $user)
								{						
									if($role == 'parent' && $class_id != 'all')
									$mail_id[]	=	$user['ID'];
									else 
										$mail_id[]	=	$user->ID;
									
									$i++;
								}
								$parent_number=array();
								foreach($mail_id as $user)
								{
									$parent_number[] = "+".smgt_get_countery_phonecode(get_option( 'smgt_contry' )).get_user_meta($user, 'mobile_number',true);
								}
								
								if(is_plugin_active('sms-pack/sms-pack.php'))
								{
									$args = array();
									$args['mobile']=$parent_number;
									$args['message_from']="notice";
									$args['message']=$_POST['sms_template'];					
									if($current_sms_service=='telerivet' || $current_sms_service ="MSG91" || $current_sms_service=='bulksmsgateway.in' || $current_sms_service=='textlocal.in' || $current_sms_service=='bulksmsnigeria' || $current_sms_service=='africastalking')
									{				
										$send = send_sms($args);							
									}
								}
									
								foreach($mail_id as $user_id)
								{							
									$user_info 	= 	get_userdata(1);			
									$reciever_number 	= 	"+".smgt_get_countery_phonecode(get_option( 'smgt_contry' )).get_user_meta($user_id, 'mobile_number',true);						
									$message_content 	= 	$_POST['sms_template'];						
									//$current_sms_service = "dgdggd";
									if($current_sms_service == 'clickatell')
									{			
										$clickatell		=	get_option('smgt_clickatell_sms_service');
										$to 	= 	$reciever_number;
										$message 	= 	str_replace(" ","%20",$message_content);
										$username 	= 	$clickatell['username']; //clickatell username
										$password 	= 	$clickatell['password']; // clickatell password
										$api_key 	= 	$clickatell['api_key'];//clickatell apikey
										$baseurl 	=	"http://api.clickatell.com";
						
										// auth call
										$url = "$baseurl/http/auth?user=$username&password=$password&api_id=$api_key";
						
										// do auth call
										$ret = file($url);
						
										// explode our response. return string is on first line of the data returned
										$sess = explode(":",$ret[0]);
										if ($sess[0] == "OK") {
											
											$sess_id = trim($sess[1]); // remove any whitespace
											$url = "$baseurl/http/sendmsg?session_id=$sess_id&to=$to&text=$message";
											
											// do sendmsg call
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
							}
						}
					}
					if($result1 || $result2 || $result3 || $result4 || isset($result5))
					{ 
						wp_redirect ( home_url() . '?dashboard=user&page=notice&tab=noticelist&message=2'); 
					}
				}
				else
				{			
					$current_sms_service 	= 	get_option( 'smgt_sms_service');
					$post_id 	= 	wp_insert_post( array(
						'post_status' 	=>	'publish',
						'post_type' 	=> 	'notice',
						'post_title' 	=> 	MJ_smgt_popup_category_validation($_REQUEST['notice_title']),
						'post_content' 	=> 	MJ_smgt_address_description_validation($_REQUEST['notice_content'])
					));
					
					if(!empty($_POST['notice_for']))
					{
						delete_post_meta($post_id, 'notice_for');
						$result		=	add_post_meta($post_id, 'notice_for',$_POST['notice_for']);
						$result		=	add_post_meta($post_id, 'start_date',$_POST['start_date']);
						$result		=	add_post_meta($post_id, 'end_date',$_POST['end_date']);
						
						if(isset($_POST['class_id']))
						$result		=	add_post_meta($post_id, 'smgt_class_id',$_POST['class_id']);
					
						if(isset($_POST['class_section']))
						$result6	=	update_post_meta($_REQUEST['notice_id'], 'smgt_section_id',$_REQUEST['class_section']);
					
						$role	=	$_POST['notice_for'];
						$smgt_sms_service_enable	=	0;
						$smgt_mail_service_enable	=	0;
						$current_sms_service_active =	get_option( 'smgt_sms_service');
						
									
						$userdata	=	smgt_get_user_notice($role,$_POST['class_id']);		
							
						if(!empty($userdata))
						{
							if(isset($_POST['smgt_mail_service_enable']))
							$smgt_mail_service_enable = $_POST['smgt_mail_service_enable'];
							
							if($smgt_mail_service_enable)
							{
								$mail_id = array();
								$i = 0;
								$startdate	= 	strtotime($_POST['start_date']);
								$enddate 	= 	strtotime($_POST['end_date']);
								if($startdate == $enddate)
								{
									$date	 =	smgt_getdate_in_input_box($_POST['start_date']);
								}
								else
								{
									$date	 =	smgt_getdate_in_input_box($_POST['start_date'])." To ".smgt_getdate_in_input_box($_POST['end_date']);
								}
								
								$search['{{notice_title}}']	 	= 	$_REQUEST['notice_title'];
								$search['{{notice_date}}'] 		= 	$date;
								$search['{{notice_for}}'] 		= 	$_POST['notice_for'];
								$search['{{notice_comment}}']	=	$_REQUEST['notice_content'];								
								$search['{{school_name}}'] 		= 	get_option('smgt_school_name');								
								$message = string_replacement($search,get_option('notice_mailcontent'));					
								foreach($userdata as $user)
								{
									if(get_option('smgt_mail_notification') == '1')
									{
										wp_mail($user->user_email,get_option('notice_mailsubject'),$message);
									}
									if($role == 'parent' && $class_id != 'all')
										$mail_id[]=$user['ID'];
									else 
										$mail_id[]=$user->ID;						
										$i++;
								}
							}
							
						if(isset($_POST['smgt_sms_service_enable']))
							$smgt_sms_service_enable = $_POST['smgt_sms_service_enable'];
						
							if($smgt_sms_service_enable)
							{
								if(!empty($current_sms_service))
								{
									$parent_number=array();
									foreach($mail_id as $user)
									{
										$parent_number[] = "+".smgt_get_countery_phonecode(get_option( 'smgt_contry' )).get_user_meta($user, 'mobile_number',true);
									}			
									if(is_plugin_active('sms-pack/sms-pack.php'))
									{							
										$args 	= 	array();
										$args['mobile']		=	$parent_number;
										$args['message_from']	=	"notice";
										$args['message'] 	= 	$_POST['sms_template'];
										
										if($current_sms_service == 'telerivet'|| $current_sms_service == 'MSG91' || $current_sms_service=='bulksmsgateway.in' || $current_sms_service=='bulksmsnigeria' || $current_sms_service=='textlocal.in' || $current_sms_service=='africastalking')
										{				
											$send = send_sms($args);						
										}
									} 		 
									foreach($mail_id as $user_id)
									{
										$user_info = get_userdata(1);				 	
										$reciever_number = "+".smgt_get_countery_phonecode(get_option( 'smgt_contry' )).get_user_meta($user_id, 'mobile_number',true);				 		
										$message_content = $_POST['sms_template'];
										$current_sms_service = get_option( 'smgt_sms_service');
										
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
												$mobile_number=get_user_meta($user_id, 'mobile_number',true);
												$country_code="+".smgt_get_countery_phonecode(get_option( 'smgt_contry' ));
												$message = $message_content; // Message Text
												smgt_msg91_send_mail_function($mobile_number,$message,$country_code);
											}		
									} 
								}
							}
					}
						if($result){ 
							wp_redirect ( home_url() . '?dashboard=user&page=notice&tab=noticelist&message=1'); 
						}
					}			
				}	
			}
	    }
	}
	if(isset($_REQUEST['delete_selected']))
	{		
		if(!empty($_REQUEST['id']))
		foreach($_REQUEST['id'] as $id)
			$result=wp_delete_post($id);
		if($result)
			{
				wp_redirect ( home_url() . '?dashboard=user&page=notice&tab=noticelist&message=3'); 
			}
	}
	//----------------------------- SAVE NOTICE -----------------------------------//
	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete')
	{
		$result=wp_delete_post($_REQUEST['notice_id']);
		if($result)
		{
			wp_redirect ( home_url() . '?dashboard=user&page=notice&tab=noticelist&message=3'); 
		}
	}
?>
<script>
$(document).ready(function() {
    $('#notice_list').DataTable({
        responsive: true,
		language:<?php echo smgt_datatable_multi_language();?>	
    });
});
</script>
<!-- View Popup Code -->	
<div class="popup-bg">
    <div class="overlay-content">    
    	<div class="notice_content"></div>    
    </div>
</div>

<div class="panel-body panel-white">
<?php
	$message = isset($_REQUEST['message'])?$_REQUEST['message']:'0';
	switch($message)
	{
		case '1':
			$message_string = __('Record Successfully Insert!','school-mgt');
			break;
		case '2':
			$message_string = __('Record Successfully Updated!','school-mgt');
			break;	
		case '3':
			$message_string = __('Notice Delete Successfully','school-mgt');
			break;
	}
	
	if($message)
	{ ?>
		<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
			</button>
			<?php echo $message_string;?>
		</div>
<?php
	} ?>
	<ul class="nav nav-tabs panel_tabs" role="tablist">
		<li class=" <?php echo $active_tab == 'noticelist' ? 'active' : ''; ?>">
			<a href="?dashboard=user&page=notice&tab=noticelist" class="nav-tab2"> <strong>
				<i class="fa fa-align-justify"> </i> <?php _e('Notice List', 'school-mgt'); ?></strong>
			</a>
		</li>
		<li class=" <?php echo $active_tab == 'addnotice' ? 'active' : ''; ?>">
		<?php if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
		{?>
			<a href="?dashboard=user&page=notice&tab=addnotice&action=edit&notice_id=<?php echo $_REQUEST['notice_id'];?>" class="nav-tab2 <?php echo $active_tab == 'addnotice' ? 'nav-tab-active' : ''; ?>">
		<?php _e('Edit Notice', 'school-mgt'); ?></a>  
		<?php 
		}
		else
		{
			if($user_access['add']=='1')
			{?>
			<a href="?dashboard=user&page=notice&tab=addnotice" class="nav-tab2  <?php echo $active_tab == 'addnotice' ? 'nav-tab-active' : ''; ?>"><?php echo '<span class="fa fa-plus-circle"></span>'.__(' Add Notice', 'school-mgt'); ?></a>  
        <?php 
			}
		}?>
		</li>
	</ul>
	<div class="tab-content"> 
	<?php
	if($active_tab == 'noticelist')
	{ 
		$user_id=get_current_user_id();
		
		
		//------- NOTICE DATA FOR STUDENT ---------//
		if($school_obj->role == 'student')
		{
			$own_data=$user_access['own_data'];
			if($own_data == '1')
			{ 
				$class_name  	= 	get_user_meta(get_current_user_id(),'class_name',true);		
				$class_section  = 	get_user_meta(get_current_user_id(),'class_section',true);	
				$notice_list = student_notice_dashbord($class_name,$class_section);
			}
			else
			{
				$args['post_type'] = 'notice';
				$args['posts_per_page'] = -1;
				$args['post_status'] = 'public';
				$q = new WP_Query();
				$notice_list = $q->query( $args );
			}
			 
		}
		//------- NOTICE DATA FOR TEACHER ---------//
		elseif($school_obj->role == 'teacher')
		{
			$own_data=$user_access['own_data'];
			if($own_data == '1')
			{ 
				$notice_list =teacher_notice_dashbord();
			}
			else
			{
				$args['post_type'] = 'notice';
				$args['posts_per_page'] = -1;
				$args['post_status'] = 'public';
				$q = new WP_Query();
				$notice_list = $q->query( $args );
			}
		}
		//------- NOTICE DATA FOR PARENT ---------//
		elseif($school_obj->role == 'parent')
		{
			$own_data=$user_access['own_data'];
			if($own_data == '1')
			{  
				$notice_list = parent_notice_dashbord();
			}
			else
			{
				$args['post_type'] = 'notice';
				$args['posts_per_page'] = -1;
				$args['post_status'] = 'public';
				$q = new WP_Query();
				$notice_list = $q->query( $args );
			}
		}
		//------- NOTICE DATA FOR SUPPORT STAFF ---------//
		else
		{ 
			$own_data=$user_access['own_data'];
			if($own_data == '1')
			{ 
				$notice_list = supportstaff_notice_dashbord();
			}
			else
			{
				$args['post_type'] = 'notice';
				$args['posts_per_page'] = -1;
				$args['post_status'] = 'public';
				$q = new WP_Query();
				$notice_list = $q->query( $args );
			}
		} 
	?>
		<div class="panel-body">
			<div class="table-responsive">
				<table id="notice_list"class="display dataTable notice_datatable" cellspacing="0" width="100%">
					<thead>
						<tr>                
							<th width="190px"><?php _e( 'Notice Title', 'school-mgt' ) ;?></th>
							<th><?php _e( 'Notice Comment', 'school-mgt' ) ;?></th>
							<th><?php _e('Notice Start Date','school-mgt');?></th>
							<th><?php _e('Notice End Date','school-mgt');?></th>
							<th><?php _e( 'Notice For', 'school-mgt' ) ;?></th>
							  <th><?php _e('Class','school-mgt');?></th>
							<th width="60px"><?php _e( 'Action', 'school-mgt' ) ;?></th>                     
						</tr>
					</thead>
			 
					<tfoot>
						<tr>
							<th><?php  _e( 'Notice Title', 'school-mgt' ) ;?></th>
							<th><?php  _e( 'Notice Comment', 'school-mgt' ) ;?></th>
							<th><?php _e('Notice Start Date','school-mgt');?></th>
							<th><?php _e('Notice End Date','school-mgt');?></th>
							<th><?php  _e( 'Notice For', 'school-mgt' ) ;?></th>
							   <th><?php _e('Class','school-mgt');?></th>
							<th><?php _e( 'Action', 'school-mgt' ) ;?></th>
						</tr>
					</tfoot> 
					<tbody>
					<?php 		
						if (! empty ($notice_list))
						{
							foreach ($notice_list as $retrieved_data ) 
							{ ?>
				
								<tr>
									<td><?php echo $retrieved_data->post_title;?></td>
									<td><?php 
										$strlength		= 	strlen($retrieved_data->post_content);
										if($strlength > 60)
										{
											echo substr($retrieved_data->post_content, 0,60).'...';
										}
										else
										{
											echo $retrieved_data->post_content;	
										}												
									?></td>
									<td><?php echo smgt_getdate_in_input_box(get_post_meta($retrieved_data->ID,'start_date',true));?></td> 
									<td><?php echo smgt_getdate_in_input_box(get_post_meta($retrieved_data->ID,'end_date',true));?></td> 			      
									<td><?php print get_post_meta( $retrieved_data->ID, 'notice_for',true);?></td>
									<td>
									 <?php 
									 if(get_post_meta( $retrieved_data->ID, 'smgt_class_id',true) !="" && get_post_meta( $retrieved_data->ID, 'smgt_class_id',true) =="all")
									 {
										 _e('all','school-mgt');
									 }
									 elseif(get_post_meta( $retrieved_data->ID, 'smgt_class_id',true) !=""){
									 echo get_class_name(get_post_meta( $retrieved_data->ID, 'smgt_class_id',true));}?></td>            									
									<td>
										<a href="#" class="btn btn-primary view-notice" id="<?php echo $retrieved_data->ID;?>"> <?php _e('View','school-mgt');?></a>
										 <?php
										if($user_access['edit']=='1')
										{
										?>
											<a href="?dashboard=user&page=notice&tab=addnotice&action=edit&notice_id=<?php echo $retrieved_data->ID; ?>" class="btn btn-info"> <?php _e('Edit','school-mgt');?></a>
										<?php
										}
										if($user_access['delete']=='1')
										{
										?>
											<a href="?dashboard=user&page=notice&tab=noticelist&action=delete&notice_id=<?php echo $retrieved_data->ID;?>" class="btn btn-danger" 
											onclick="return confirm('<?php _e('Are you sure you want to delete this record?','school-mgt');?>');"> <?php _e('Delete','school-mgt');?></a>
										<?php
										}
										?>
									</td>
								</tr>	
				<?php       }
						}					
						?>
					</tbody>       
				</table>	
			</div>
		</div>
	<?php
	}
	if($active_tab == 'addnotice')
	{	 ?>
		<script type="text/javascript">
		$(document).ready(function() {
			 $('#notice_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
			$("#notice_Start_date").datepicker({
				dateFormat: "yy-mm-dd",
				minDate:0,
				onSelect: function (selected) {
					var dt = new Date(selected);
					dt.setDate(dt.getDate() + 0);
					$("#notice_end_date").datepicker("option", "minDate", dt);
				}
			});
			$("#notice_end_date").datepicker({
			   dateFormat: "yy-mm-dd",
				onSelect: function (selected) {
					var dt = new Date(selected);
					dt.setDate(dt.getDate() - 0);
					$("#notice_Start_date").datepicker("option", "maxDate", dt);
				}
			});
		});
		</script>
		<?php
			$edit=0;
			if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
			{
				$edit=1;
				$post = get_post($_REQUEST['notice_id']);
			}
		?>
		<div class="panel-body"> 
			<form name="class_form" action="" method="post" class="form-horizontal" id="notice_form">
				  <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
				<input type="hidden" name="action" value="<?php echo $action;?>">
				<div class="form-group">
					<label class="col-sm-2 control-label" for="notice_title"><?php _e('Notice Title','school-mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8">
						<input id="notice_title" class="form-control validate[required,custom[popup_category_validation]] text-input" maxlength="50" type="text" value="<?php if($edit){ echo $post->post_title;}?>" name="notice_title">
						 <input type="hidden" name="notice_id"   value="<?php if($edit){ echo $post->ID;}?>"/> 
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="notice_content"><?php _e('Notice Comment','school-mgt');?></label>
					<div class="col-sm-8">
					<textarea name="notice_content" class="form-control validate[custom[address_description_validation]]" maxlength="150" id="notice_content"><?php if($edit){ echo $post->post_content;}?></textarea>
						
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="notice_content"><?php _e('Notice Start Date','school-mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8">
					<input id="notice_Start_date" class="datepicker form-control validate[required] text-input" type="text" value="<?php if($edit){ echo date("Y-m-d",strtotime(get_post_meta($post->ID,'start_date',true)));}?>" name="start_date" readonly>
						
					</div>
				</div>
				<?php wp_nonce_field( 'save_notice_admin_nonce' ); ?>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="notice_content"><?php _e('Notice End Date','school-mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8">
					<input id="notice_end_date" class="datepicker form-control validate[required] text-input" type="text" value="<?php if($edit){ echo date("Y-m-d",strtotime(get_post_meta($post->ID,'end_date',true)));}?>" name="end_date" readonly>
						
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label " for="notice_for"><?php _e('Notice For','school-mgt');?></label>
					<div class="col-sm-8">
						<select name="notice_for" id="notice_for" class="form-control notice_for_ajax">
						   <option value = "all"><?php _e('All','school-mgt');?></option>
						   <option value="teacher" <?php if($edit) echo selected(get_post_meta( $post->ID, 'notice_for',true),'teacher');?>><?php _e('Teacher','school-mgt');?></option>
						   <option value="student" <?php if($edit) echo selected(get_post_meta( $post->ID, 'notice_for',true),'student');?>><?php _e('Student','school-mgt');?></option>
						   <option value="parent" <?php if($edit) echo selected(get_post_meta( $post->ID, 'notice_for',true),'parent');?>><?php _e('Parent','school-mgt');?></option>
						   <option value="supportstaff" <?php if($edit) echo selected(get_post_meta( $post->ID, 'notice_for',true),'supportstaff');?>><?php _e('Support Staff','school-mgt');?></option>
						</select>				
					</div>
				</div>
				
				<div id="smgt_select_class">
				<div class="form-group">
					<label class="col-sm-2 control-label" for="sms_template"><?php _e('Select Class','school-mgt');?></label>
					<div class="col-sm-8">
					<?php if($edit){ $classval=get_post_meta( $post->ID, 'smgt_class_id',true); }elseif(isset($_POST['class_id'])){$classval=$_POST['class_id'];}else{$classval='';}?>
						 <select name="class_id"  id="class_list" class="form-control">
							<option value="all"><?php _e('All','school-mgt');?></option>
							<?php
							  foreach(get_allclass() as $classdata)
							  {  
							  ?>
							   <option  value="<?php echo $classdata['class_id'];?>" <?php echo selected($classval,$classdata['class_id']);?>><?php echo $classdata['class_name'];?></option>
						 <?php }?>
						</select>
					</div>
				</div>
				</div>
				<div class="form-group" id="smgt_select_section">
					<label class="col-sm-2 control-label" for="class_name"><?php _e('Class Section','school-mgt');?></label>
					<div class="col-sm-8">
						<?php if($edit){ $sectionval=get_post_meta( $post->ID, 'smgt_section_id',true); }elseif(isset($_POST['class_section'])){$sectionval=$_POST['class_section'];}else{$sectionval='';}?>
						<select name="class_section" class="form-control" id="class_section">
							<option value=""><?php _e('Select Class Section','school-mgt');?></option>
							<?php
							if($edit){
								foreach(smgt_get_class_sections($classval) as $sectiondata)
								{  ?>
								 <option value="<?php echo $sectiondata->id;?>" <?php selected($sectionval,$sectiondata->id);  ?>><?php echo $sectiondata->section_name;?></option>
							<?php } 
							}?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label " for="enable"><?php _e('Send Mail','school-mgt');?></label>
					<div class="col-sm-8">
						 <div class="checkbox">
							<label>
								<input id="chk_sms_sent_mail" type="checkbox" <?php $smgt_mail_service_enable = 0;if($smgt_mail_service_enable) echo "checked";?> value="1" name="smgt_mail_service_enable">
							</label>
						</div>				 
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label " for="enable"><?php _e('Send SMS','school-mgt');?></label>
					<div class="col-sm-8">
						 <div class="checkbox">
							<label>
								<input id="chk_sms_sent" type="checkbox" <?php $smgt_sms_service_enable = 0;if($smgt_sms_service_enable) echo "checked";?> value="1" name="smgt_sms_service_enable">
							</label>
						</div>				 
					</div>
				</div>
				<div id="hmsg_message_sent" class="hmsg_message_none">
					<div class="form-group">
						<label class="col-sm-2 control-label" for="sms_template"><?php _e('SMS Text','school-mgt');?><span class="require-field">*</span></label>
						<div class="col-sm-8">
							<textarea name="sms_template" class="form-control validate[required]" maxlength="160"></textarea>
							<label><?php _e('Max. 160 Character','school-mgt');?></label>
						</div>
					</div>
				</div>
				<div class="col-sm-offset-2 col-sm-8">        	
					<input type="submit" value="<?php if($edit){ _e('Save Notice','school-mgt'); }else{ _e('Add Notice','school-mgt');}?>" name="save_notice" class="btn btn-success" />
				</div>
			</form>
		</div>
	<?php
	}
	?>
	</div>
</div>
<?php ?>