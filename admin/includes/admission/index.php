<!-- POP up code -->
<div class="popup-bg">
    <div class="overlay-content admission_popup">
		<div class="modal-content">
			<div class="result"></div>
		</div>
    </div>    
</div>
<?php
$obj_admission=new smgt_admission;
//------------ ACTIVE ADMISSION ------------//
if(isset($_POST['active_user_admission']))
	{		
		$userbyroll_no	=	get_users(
			array('meta_query'	=>
				array('relation' => 'AND',
					array('key'	=>'class_name','value'=>$_POST['class_name']),
					array('key'=>'roll_id','value'=>smgt_strip_tags_and_stripslashes($_POST['roll_id']))
				),
				'role'=>'student')
		);
		$is_rollno = count($userbyroll_no);	
		
		if($is_rollno)
		{
			wp_redirect ( admin_url().'admin.php?page=smgt_admission&tab=admission_list&message=6'); 
		}
		else
		{		
			$active_user_id		= 	$_REQUEST['act_user_id'];
			update_user_meta($active_user_id, 'roll_id', $_REQUEST['roll_id']);
			update_user_meta($active_user_id, 'class_name', $_REQUEST['class_name']);
			update_user_meta($active_user_id, 'class_section', $_REQUEST['class_section']);
			if( email_exists($_REQUEST['email'] ) )
			{ // if the email is registered, we take the user from this
				if( !empty($_REQUEST['password']) )
					wp_set_password($_REQUEST['password'], $active_user_id );
			}
			 
			$user_info 	= 	get_userdata($_POST['act_user_id']);
			if(!empty($user_info))
			{
			//--------- SEND STUDENT MAIL ACTIVE ACCOUNT -----------//	
			
				$string = array();
				$string['{{user_name}}']   =  $user_info->display_name;
				$string['{{school_name}}'] =  get_option('smgt_school_name');
				$string['{{role}}']        =  "student";
				$string['{{login_link}}']  =  site_url() .'/index.php/school-management-login-page';
				$string['{{username}}']    =  $user_info->user_login;
				$string['{{class_name}}']  =  get_class_name($_REQUEST['class_section']);
				$string['{{email}}']  	   =  $user_info->user_email;
				$string['{{Password}}']    =  $_REQUEST['password'];
							
				$MsgContent                =  get_option('add_approve_admission_mail_content');		
				$MsgSubject				   =  get_option('add_approve_admisson_mail_subject');
				$message = string_replacement($string,$MsgContent);
				$MsgSubject = string_replacement($string,$MsgSubject);
			
				$email= $user_info->user_email;
				smgt_send_mail($email,$MsgSubject,$message); 
			}	
				 
				$role_upadte="student";
				$status="Approved";
				$result = new WP_User($active_user_id);
				$result->set_role($role_upadte);
				$result=update_user_meta($active_user_id, 'role', $role_upadte );
				$result=update_user_meta($active_user_id, 'status', $status );     
				$role_parents="parent"; 
				
				//---------- ADD PARENTS -------------------//
				$patents_add=$obj_admission->smgt_add_parent($active_user_id,$role_parents); 
				
			if(get_user_meta($active_user_id, 'hash', true))  
			{
				delete_user_meta($active_user_id, 'hash'); 
			}
				
			wp_redirect ( admin_url().'admin.php?page=smgt_student&tab=studentlist&message=7');			
		}
	}

//------------- SAVE STUDENT ADMISSION FORM ------------------//

if(isset($_POST['student_admission']))
{
	$nonce = $_POST['_wpnonce'];
	if ( wp_verify_nonce( $nonce, 'save_admission_form' ) )
	{
		$role=$_POST['role'];
		if(isset($_FILES['father_doc']) && !empty($_FILES['father_doc']) && $_FILES['father_doc']['size'] !=0)
		{			
			if($_FILES['father_doc']['size'] > 0)
				$upload_docs=smgt_load_documets_new($_FILES['father_doc'],$_FILES['father_doc'],$_POST['father_document_name']);		
		}
		else
		{
			$upload_docs='';
		}
		$father_document_data=array();
		if(!empty($upload_docs))
		{
			$father_document_data[]=array('title'=>$_POST['father_document_name'],'value'=>$upload_docs);
		}
		else
		{
			$father_document_data[]='';
		}
		
		if(isset($_FILES['mother_doc']) && !empty($_FILES['mother_doc']) && $_FILES['mother_doc']['size'] !=0)
		{			
			if($_FILES['mother_doc']['size'] > 0)
				$upload_docs1=smgt_load_documets_new($_FILES['mother_doc'],$_FILES['mother_doc'],$_POST['mother_document_name']);		
		}
		else
		{
			$upload_docs1='';
		}
		$mother_document_data=array();
		if(!empty($upload_docs1))
		{
			$mother_document_data[]=array('title'=>$_POST['mother_document_name'],'value'=>$upload_docs1);
		}
		else
		{
			$mother_document_data[]='';
		}
		if ($_REQUEST['action']=='edit')
		{
			//----------EDIT-------------//
			$result= $obj_admission->smgt_add_admission($_POST,$father_document_data,$mother_document_data,$role);
		 	if($result)
			{   
				wp_redirect ( admin_url().'admin.php?page=smgt_admission&tab=admission_list&message=1'); 	  
			} 
		}
		else
		{
			//-------- Email Check --------//
			if(email_exists($_POST['email']))
			{
				wp_redirect ( admin_url().'admin.php?page=smgt_admission&tab=admission_form&message=2');
			} 
			elseif(email_exists($_POST['father_email']))
			{
				wp_redirect ( admin_url().'admin.php?page=smgt_admission&tab=admission_form&message=3');
			}
			elseif(email_exists($_POST['mother_email']))
			{
				wp_redirect ( admin_url().'admin.php?page=smgt_admission&tab=admission_form&message=4');
			}
			else
			{
				// wp_redirect ( admin_url().'admin.php?page=smgt_admission&tab=admission_list&message=1'); 
				//----------ADD-------------//
				  $result= $obj_admission->smgt_add_admission($_POST,$father_document_data,$mother_document_data,$role);
			 
			 	if($result)
				{   
					wp_redirect ( admin_url().'admin.php?page=smgt_admission&tab=admission_list&message=1'); 	  
				} 
			}
	    }
	}

}
//------------- DELETE ADMISSION  ------------------//
if(isset($_REQUEST['delete_selected']))
{		
	if(!empty($_REQUEST['id']))
	{
		foreach($_REQUEST['id'] as $id)
		{
			$result=delete_usedata($id);
		}
	}
	if($result)
	{
		wp_redirect ( admin_url().'admin.php?page=smgt_admission&tab=admission_list&message=8');
	}
}

// -----------Delete Code--------
if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
{		
	$result=delete_usedata($_REQUEST['admission_id']);
	if($result)
	{
		wp_redirect ( admin_url().'admin.php?page=smgt_admission&tab=admission_list&message=8');
	}
}
$active_tab = isset($_GET['tab'])?$_GET['tab']:'admission_list';
{
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
			$message_string = __('Request For Admission Added Successfully.','school-mgt');
			break;
		case '2':
			$message_string = __('Student Email-id Already Exist.','school-mgt');
			break;	
		case '3':
			$message_string = __('Father Email-id Already Exist.','school-mgt');
			break;	
		case '4':
			$message_string = __('Mother Email-id Already Exist.','school-mgt');
			break;	
		case '5':
			$message_string = __('Student Admission Successfully.','school-mgt');
			break;
		case '6':
			$message_string = __('Student Roll No. Already Exist.','school-mgt');
			break;
		case '7':
			$message_string = __('Student Activated Successfully.','school-mgt');
			break;
		case '8':
		   $message_string = __('Student Admission Deleted Successfully..','school-mgt');
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
							<a href="?page=smgt_admission&tab=admission_list" class="nav-tab <?php echo $active_tab == 'admission_list' ? 'nav-tab-active' : ''; ?>">
							<?php echo '<span class="dashicons dashicons-menu"></span> '.__('Admission List', 'school-mgt'); ?></a>
					
							<a href="?page=smgt_admission&tab=admission_form" class="nav-tab <?php echo $active_tab == 'admission_form' ? 'nav-tab-active' : ''; ?>">
							<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.__('Admission Form', 'school-mgt'); ?></a>  
							<?php 
							if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'view_admission')
							{ ?>
								<a href="?page=smgt_admission&tab=view_admission&action=view_admission&id=<?php echo $_REQUEST['id'];?>" class="nav-tab <?php echo $active_tab == 'view_admission' ? 'nav-tab-active' : ''; ?>">
								<?php echo '<span class="fa fa-eye"></span> '.__('View Admission Details', 'school-mgt'); ?></a>
								<?php
							}
							?>
						</h2>
					 <?php 
					if($active_tab == 'admission_list')
					{
						$studentdata =get_users(array('role'=>'student_temp'));
					?>  
						<script>
							jQuery(document).ready(function() {
								var table =  jQuery('#students_list').DataTable({
								responsive: true,
								"order": [[ 1, "asc" ]],
								"aoColumns":[	                  
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
						<div class="panel-body">
							<div class="table-responsive">
								<form id="frm-example" name="frm-example" method="post">
									<table id="students_list" class="display admin_student_datatable" cellspacing="0" width="100%">
										 <thead>
										<tr>
											<th style="width: 20px;"><input name="select_all" value="all" id="checkbox-select-all" 
											type="checkbox" /></th> 
											<th><?php echo _e( 'Student Name', 'school-mgt' ) ;?></th>
											 <th> <?php echo _e( 'Gender', 'school-mgt' ) ;?></th>
											 <th> <?php echo _e( 'Address', 'school-mgt' ) ;?></th>
											 <th> <?php echo _e( 'Phone', 'school-mgt' ) ;?></th>
											<th> <?php echo _e( 'Student Email', 'school-mgt' ) ;?></th> 
											<th> <?php echo _e( 'Previous School', 'school-mgt' ) ;?></th>
											<th><?php echo _e( 'Action', 'school-mgt' ) ;?></th>
										</tr>
									</thead>
							 
									<tfoot>
										<tr>
											<th></th>
										   <th><?php echo _e( 'Student Name', 'school-mgt' ) ;?></th>
											<th> <?php echo _e( 'Gender', 'school-mgt' ) ;?></th>
											<th> <?php echo _e( 'Address', 'school-mgt' ) ;?></th>
											<th> <?php echo _e( 'Phone', 'school-mgt' ) ;?></th>
											<th> <?php echo _e( 'Student Email', 'school-mgt' ) ;?></th> 
											<th> <?php echo _e( 'Previous School', 'school-mgt' ) ;?></th>
										   <th><?php echo _e( 'Action', 'school-mgt' ) ;?></th>
										</tr>
									</tfoot>
							 
									<tbody>
									 <?php 
										if(!empty($studentdata))
										{
											foreach ($studentdata as $retrieved_data){
											$user_info = get_userdata($retrieved_data->ID);
										 
										?>
										<tr>
											<td><input type="checkbox" class="select-checkbox" name="id[]" value="<?php echo $retrieved_data->ID; ?>"></td>
											<td class="name"><?php echo $retrieved_data->display_name;?></td>
											<td class=""><?php echo $user_info->gender;?></td>
											<td class=""><?php echo $user_info->address;?></td>
											<td class=""><?php echo $user_info->phone;?></td>
											<td class="email"><?php echo $retrieved_data->user_email;?></td>
											<td class=""><?php echo $user_info->preschool_name;?></td>
											<td class="action">  
												<a href="?page=smgt_admission&tab=view_admission&action=view_admission&id=<?php echo $retrieved_data->ID;?>" class="btn btn-success"><?php _e('View','school-mgt');?></a> 
												<a href="?page=smgt_admission&tab=admission_form&action=edit&id=<?php echo $retrieved_data->ID;?>" class="btn btn-info"><?php _e('Edit','school-mgt');?></a>
												<a href="?page=smgt_admission&tab=studentlist&action=delete&admission_id=<?php echo $retrieved_data->ID;?>" class="btn btn-danger" 
					                          onclick="return confirm('Are you sure you want to delete this record?');"><?php _e('Delete','school-mgt');?></a> 
												<?php 
												if($user_info->role =="student_temp")
												{  
												?>
													<a href="?page=smgt_admission&tab=admission_list&action=approve&id=<?php echo $retrieved_data->ID;?>" class="btn btn-info show-admission-popup" student_id="<?php echo $retrieved_data->ID; ?>"> <?php esc_html_e('Approve', 'school-mgt' ) ;?></a>
												<?php
												}
												?>
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
					if($active_tab == 'admission_form')
					{
						require_once SMS_PLUGIN_DIR. '/admin/includes/admission/admission_form.php';
					}
					if($active_tab == 'view_admission')
					{
						require_once SMS_PLUGIN_DIR. '/admin/includes/admission/view_admission.php';
					}
					?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
}
?>