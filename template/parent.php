<?php 
//-------- CHECK BROWSER JAVA SCRIPT ----------//
MJ_smgt_browser_javascript_check();
$active_tab = isset($_GET['tab'])?$_GET['tab']:'parentlist';
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
//--------------------------  SAVE PARENT ----------------------//
	if(isset($_POST['save_parent']))
	{
		$role='parent';
		$nonce = $_POST['_wpnonce'];
	    if ( wp_verify_nonce( $nonce, 'save_parent_admin_nonce' ) )
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
			
			/* if(isset($_POST['smgt_user_avatar']) && $_POST['smgt_user_avatar'] != "")
			{
				$photo=$_POST['smgt_user_avatar'];
			}
			else
			{
				$photo="";
			} */
			 /* var_dump($_FILES['upload_user_avatar_image']);
			 var_dump($_FILES['upload_user_avatar_image']);
			 var_dump($_FILES['smgt_user_avatar']);
			 die;
			if(isset($_FILES['upload_user_avatar_image']) && !empty($_FILES['upload_user_avatar_image']) && $_FILES['upload_user_avatar_image']['size'] !=0)
			{
				if($_FILES['upload_user_avatar_image']['size'] > 0)
					$member_image=smgt_load_documets($_FILES['upload_user_avatar_image'],'upload_user_avatar_image','pimg');
					$photo=content_url().'/uploads/school_assets/'.$member_image;
			}
			else
			{
				if(isset($_REQUEST['hidden_upload_user_avatar_image']))
				$member_image=$_REQUEST['hidden_upload_user_avatar_image'];
				$photo=$member_image;
				
			} */
			if(isset($_FILES['upload_user_avatar_image']) && !empty($_FILES['upload_user_avatar_image']) && $_FILES['upload_user_avatar_image']['size'] !=0)
		{
			if($_FILES['upload_user_avatar_image']['size'] > 0)
				$member_image=smgt_load_documets($_FILES['upload_user_avatar_image'],'upload_user_avatar_image','pimg');
				$photo=content_url().'/uploads/school_assets/'.$member_image;
		}
		else
		{
			if(isset($_REQUEST['hidden_upload_user_avatar_image']))
			$member_image=$_REQUEST['hidden_upload_user_avatar_image'];
			$photo=$member_image;
		}
			$usermetadata	=	array(
				'middle_name'=>MJ_smgt_onlyLetter_specialcharacter_validation($_POST['middle_name']),
				'gender'=>MJ_smgt_onlyLetterSp_validation($_POST['gender']),
				'birth_date'=>$_POST['birth_date'],
				'address'=>MJ_smgt_address_description_validation($_POST['address']),
				'city'=>MJ_smgt_city_state_country_validation($_POST['city_name']),
				'state'=>MJ_smgt_city_state_country_validation($_POST['state_name']),
				'zip_code'=>MJ_smgt_onlyLetterNumber_validation($_POST['zip_code']),
				'phone'=>MJ_smgt_phone_number_validation($_POST['phone']),
				'mobile_number'=>MJ_smgt_phone_number_validation($_POST['mobile_number']),
				'relation'=>MJ_smgt_onlyLetterSp_validation($_POST['relation']),
				'smgt_user_avatar'=>$photo,	
				'created_by'=>get_current_user_id()
			);
		
			if($_REQUEST['action']=='edit')
			{			
				$userdata['ID']=$_REQUEST['parent_id'];			
				$result=update_user($userdata,$usermetadata,$firstname,$lastname,$role);
				if($result)
				{ 
					wp_redirect ( home_url() . '?dashboard=user&page=parent&tab=parentlist&message=1'); 		
				}
			}
			else
			{
				if( !email_exists($_POST['email']) && !username_exists(smgt_strip_tags_and_stripslashes($_POST['username']))) 
				{
					$result=add_newuser($userdata,$usermetadata,$firstname,$lastname,$role);
					if($result)
					{ 
						wp_redirect ( home_url() . '?dashboard=user&page=parent&tab=parentlist&message=2'); 		
					} 
				}
				else 
				{ 
					wp_redirect ( home_url() . '?dashboard=user&page=parent&tab=parentlist&message=3'); 		
				}		  
			}
	    }
	}
	$addparent	=	0;
	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'addparent')
	{
		if(isset($_REQUEST['student_id']))
		{			
			$student=get_userdata($_REQUEST['student_id']);
			$addparent=1;
		}
	}
	//------------------------ DELETE PARENT ------------------//
	 if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
		{
			$childs=get_user_meta($_REQUEST['parent_id'], 'child', true);
			if(!empty($childs))
			{
				foreach($childs as $childvalue)
				{
					$parents=get_user_meta($childvalue, 'parent_id', true);
					if(!empty($parents))
					{
						if(($key = array_search($_REQUEST['parent_id'], $parents)) !== false) {
							unset($parents[$key]);
							update_user_meta( $childvalue,'parent_id', $parents );
						}
					}
				}
			}
			$result=delete_usedata($_REQUEST['parent_id']);	
			if($result)
			{ 
				wp_redirect ( home_url() . '?dashboard=user&page=parent&tab=parentlist&message=4'); 		
			}
		}
	$message = isset($_REQUEST['message'])?$_REQUEST['message']:'0';
	switch($message)
	{
		case '1':
			$message_string = __('Parent Updated Successfully.','school-mgt');
			break;
		case '2':
			$message_string = __('Parent Inserted Successfully.','school-mgt');
			break;	
		case '3':
			$message_string = __('Username Or Emailid Already Exist.','school-mgt');
			break;	
		case '4':
			$message_string = __('Parent Deleted Successfully.','school-mgt');
			break;	
		case '5':
			$message_string = __('Parent CSV Successfully Uploaded.','school-mgt');
			break;			
	}
	
	if($message)
	{ ?>
		<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
			</button>
			<?php echo $message_string;?>
		</div>
<?php } ?>	
<script>
	$(document).ready(function() {
		$('#parent_list').DataTable({
			responsive: true,
			language:<?php echo smgt_datatable_multi_language();?>	
		});
	} );
</script>

<div class="panel-body panel-white">
	<ul class="nav nav-tabs panel_tabs" role="tablist">
		<li class="<?php if($active_tab=='parentlist'){?>active<?php }?>">
			<a href="?dashboard=user&page=parent&tab=parentlist" class="nav-tab2">
				<i class="fa fa-align-justify"></i> <?php _e('Parent List', 'school-mgt'); ?></a>
			</a>
		</li>
		<li class="<?php if($active_tab=='addparent'){?>active<?php }?>">
		  <?php if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
			{
			?>
				<a href="?dashboard=user&page=parent&tab=addparent&&action=edit&parent_id=<?php echo $_REQUEST['parent_id'];?>" class="nav-tab2 <?php echo $active_tab == 'addparent' ? 'active' : ''; ?>">
				<i class="fa fa"></i> <?php _e('Edit Parent', 'school-mgt'); ?></a>
			 <?php 
			}
			else
			{
				if($user_access['add']=='1')
				{			
				?>				
					<a href="?dashboard=user&page=parent&tab=addparent&action=insert" class="nav-tab2 <?php echo $active_tab == 'addparent' ? 'active' : ''; ?>">
					<i class="fa fa-plus-circle"></i> <?php _e('Add New Parent', 'school-mgt'); ?></a>
				<?php
				}
			}
			?>	  
		</li>
	 <?php if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'view_parent')
	   {?>
	  <li class="<?php if($active_tab=='view_parent'){?>active<?php }?>">
			<a href="?dashboard=user&page=parent&tab=view_parent&action=view_parent&parent_id=<?php echo $_REQUEST['parent_id'];?>" class="nav-tab2">
				<i class="fa fa-eye"></i> <?php _e('View Parent', 'school-mgt'); ?></a>
			</a>
      </li>
	  <?php
	   } ?>
	</ul>
	<div class="tab-content">
     <?php 
		if($active_tab == 'parentlist')		
        { ?>
        	<div class="panel-body">
				<form name="wcwm_report" action="" method="post">
					<div class="table-responsive">
						<table id="parent_list" class="display dataTable" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th width="75px"><?php echo _e('Photo', 'school-mgt' ) ;?></th>
									<th><?php echo _e( 'Parent Name', 'school-mgt' ) ;?></th>
									<th> <?php echo _e( 'Parent Email', 'school-mgt' ) ;?></th>
									<th> <?php echo _e( 'Action', 'school-mgt' ) ;?></th>
									
								</tr>
							</thead>
							<tfoot>
								<tr>
								   <th width="75px"><?php echo _e('Photo', 'school-mgt' ) ;?></th>
									<th><?php echo _e( 'Parent Name', 'school-mgt' ) ;?></th>
									<th> <?php echo _e( 'Parent Email', 'school-mgt' ) ;?></th>
									 <th> <?php echo _e( 'Action', 'school-mgt' ) ;?></th>
								 </tr>
							</tfoot>
							<tbody>
							 <?php 
							 	$user_id=get_current_user_id();
								//------- PARENT DATA FOR STUDENT ---------//
								if($school_obj->role == 'student')
								{
									$own_data=$user_access['own_data'];
									if($own_data == '1')
									{ 
										$parentdata1=$school_obj->parent_list;
										foreach($parentdata1 as $pid)
										{
											$parentdata[]=get_userdata($pid);
										}
									}
									else
									{
										$parentdata=get_usersdata('parent');
									}
								}
								//------- PARENT DATA FOR TEACHER ---------//
								elseif($school_obj->role == 'teacher')
								{
									$parentdata=get_usersdata('parent');
								}
								//------- PARENT DATA FOR PARENT ---------//
								elseif($school_obj->role == 'parent')
								{
									$own_data=$user_access['own_data'];
									if($own_data == '1')
									{ 
										$parentdata[]=get_userdata($user_id);	
									}
									else
									{
										$parentdata=get_usersdata('parent');
									}
								}
								//------- PARENT DATA FOR SUPPORT STAFF ---------//
								else
								{ 
									$own_data=$user_access['own_data'];
									if($own_data == '1')
									{ 
										$parentdata= get_users(
																 array(
																		'role' => 'parent',
																		'meta_query' => array(
																		array(
																				'key' => 'created_by',
																				'value' => $user_id,
																				'compare' => '='
																			)
																		)
																));	
									}
									else
									{
										$parentdata=get_usersdata('parent');
									}
								}
								if($parentdata)
								{
									foreach ($parentdata as $retrieved_data)
									{ ?>	
									<tr>
										<td class="user_image "><?php $uid=$retrieved_data->ID;
											$umetadata=get_user_image($uid);
											if(empty($umetadata))
											{
												echo '<img src='.get_option( 'smgt_parent_thumb' ).' height="50px" width="50px" class="img-circle" />';
											}
											else
											{
												echo '<img src='.$umetadata.' height="50px" width="50px" class="img-circle"/>';
											}
										?>
										</td>
										<td class="name"><a href="#"><?php echo $retrieved_data->display_name;?></a></td>
										<td class="email"><?php echo $retrieved_data->user_email;?></td>
										<td class="action">
											<a href="?dashboard=user&page=parent&tab=view_parent&action=view_parent&parent_id=<?php echo $retrieved_data->ID;?>" class="btn btn-success"><?php _e('View','school-mgt');?></a>	
											<?php
											if($user_access['edit']=='1')
											{
											?>
											<a href="?dashboard=user&page=parent&tab=addparent&action=edit&parent_id=<?php echo $retrieved_data->ID;?>" class="btn btn-info"> <?php echo _e( ' Edit', 'school-mgt' ) ;?></a>
											<?php
											}
											if($user_access['delete']=='1')
											{ ?>
											<a href="?dashboard=user&page=parent&tab=parentlist&action=delete&parent_id=<?php echo $retrieved_data->ID;?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this record?');"><?php echo _e( ' Delete', 'school-mgt' ) ;?> </a>
											<?php
											}
											?>
										</td>
								</tr>
									<?php 
									}
								}
								?>
							</tbody>
						</table>
					</div>
				</form>
			</div>
	 <?php
		}
		if($active_tab == 'addparent')
		{
			$students = get_student_groupby_class();
			$role='parent';
			?>
			<script type="text/javascript">
			$(document).ready(function() {
				 $('#parent_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
				 $('#birth_date').datepicker({
					 maxDate : 0,
					 dateFormat: "yy-mm-dd",
					changeMonth: true,
					changeYear: true,
					yearRange:'-65:+25',
					beforeShow: function (textbox, instance) 
					{
						instance.dpDiv.css({
							marginTop: (-textbox.offsetHeight) + 'px'                   
						});
					},
					onChangeMonthYear: function(year, month, inst) {
						$(this).val(month + "/" + year);
					}
				}); 
				
				var numItems = $('.parents_child').length;
				if(numItems == 1)
				{$('#revove_item').hide();}
					 
			});
			</script>
		<?php 
			$edit=0;
			if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit' ) {
				$edit=1;	
				$user_info = get_userdata($_REQUEST['parent_id']);
			} ?>       
			<div class="panel-body">
			<form name="parent_form" action="" method="post" class="form-horizontal" id="parent_form" enctype="multipart/form-data">
			<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
			<input type="hidden" name="action" value="<?php echo $action;?>">
			<input type="hidden" name="role" value="<?php echo $role;?>"  />
			<div class="form-group">
				<label class="col-sm-2 control-label" for="first_name"><?php _e('First Name','school-mgt');?><span class="require-field">*</span></label>
				<div class="col-sm-8">
					<input id="first_name" class="form-control validate[required,custom[onlyLetter_specialcharacter]] text-input" maxlength="50" type="text" value="<?php if($edit){ echo $user_info->first_name;}elseif(isset($_POST['first_name'])) echo $_POST['first_name'];?>" name="first_name">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="middle_name"><?php _e('Middle Name','school-mgt');?></label>
				<div class="col-sm-8">
					<input id="middle_name" class="form-control validate[custom[onlyLetter_specialcharacter]]" maxlength="50" type="text"  value="<?php if($edit){ echo $user_info->middle_name;}elseif(isset($_POST['middle_name'])) echo $_POST['middle_name'];?>" name="middle_name">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="last_name"><?php _e('Last Name','school-mgt');?><span class="require-field">*</span></label>
				<div class="col-sm-8">
					<input id="last_name" class="form-control validate[required,custom[onlyLetter_specialcharacter]] text-input" maxlength="50" type="text"  value="<?php if($edit){ echo $user_info->last_name;}elseif(isset($_POST['last_name'])) echo $_POST['last_name'];?>" name="last_name">
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
					value="<?php if($edit){ echo smgt_getdate_in_input_box($user_info->birth_date);}elseif(isset($_POST['birth_date'])) echo smgt_getdate_in_input_box($_POST['birth_date']);?>" readonly>
				</div>
			</div>	
			  <?php 
					if($edit)
					{
					   $parent_data = get_user_meta($user_info->ID, 'child', true);
					   if(!empty($parent_data)) 	
						{
							foreach($parent_data as $id1)
							{ ?>
								<div class="form-group parents_child">
									<label class="col-sm-2 control-label" for="student_list"><?php _e('Child','school-mgt');?><span class="require-field">*</span></label>
									<div class="col-sm-8">
										<select name="chield_list[]" id="student_list" class="form-control validate[required]">
										<?php 
										foreach ($students as $label => $opt){ ?>
											<optgroup label="<?php echo "Class : ".$label; ?>">
												<?php foreach ($opt as $id => $name): ?>
												<option value="<?php echo $id; ?>" <?php selected($id, $id1);  ?> ><?php echo $name; ?></option>
												<?php endforeach; ?>
											</optgroup>
											<?php } ?>
										</select>
									</div>
								</div>
					<?php 
							}
						}
						else
						{ ?>
							<div class="form-group parents_child">
								<label class="col-sm-2 control-label" for="student_list"><?php _e('Child','school-mgt');?><span class="require-field">*</span></label>
								<div class="col-sm-8">                  
									<select name="chield_list[]" id="student_list" class="form-control validate[required]">
									 <?php 
										foreach ($students as $label => $opt)
										{ ?>
											
											<optgroup label="<?php echo "Class : ".$label; ?>">
											<?php foreach ($opt as $id => $name): ?>
												<option value="<?php echo $id; ?>"><?php echo $name; ?></option>
											<?php endforeach; ?>
											</optgroup>
									<?php }  ?>
								   </select>
								</div>
							</div>
							
						<?php }
					}
				else
				{ 	?>
			<div class="form-group parents_child">
				<label class="col-sm-2 control-label" for="student_list"><?php _e('Child','school-mgt');?><span class="require-field">*</span></label>
				<div class="col-sm-8">                  
					<select name="chield_list[]" id="student_list" class="form-control validate[required]">
					 <?php 
						foreach ($students as $label => $opt)
						{ ?>
							
							<optgroup label="<?php echo "Class : ".$label; ?>">
							<?php foreach ($opt as $id => $name): ?>
								<option value="<?php echo $id; ?>"><?php echo $name; ?></option>
							<?php endforeach; ?>
							</optgroup>
					<?php }  ?>
				   </select>
				</div>
			</div>
			<?php } ?>		
			 <a href="" id="add-another_item"><?php _e('Add Other Child','school-mgt');?> </a>
			 <a href="#" id="revove_item"> <?php _e('Remove','school-mgt');?> </a>
			 <div class="marginbottom"></div>
			<script type="text/javascript">jQuery(document).ready(function($) {
				function deleteParentElement(n){
					n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
				}
				$('#add-another_item').on('click',function(event) {
					event.preventDefault();
					var $this = $(this);
					var $last = $this.prev(); // $this.parents('.something').prev() also useful
					var $clone = $last.clone(true);
					var $inputs = $clone.find('input,textarea,select');
					/* $inputs.val(''); */
					$last.after($clone);
					$inputs.eq(0).focus();
					
					var numItems = $('.parents_child').length;
					if(numItems > 1)
					{
						 $('#revove_item').show();
					}
					
				});		
				$('#revove_item').on('click',function(event) {
					event.preventDefault();
					var numItems = $('.parents_child').length;
					if(numItems > 1)
					{
						 $(this).prev().prev().remove();
						 if(numItems == 2)
							 $('#revove_item').hide();
					}
					else
					{ $('#revove_item').hide();}
				});	
		
			}); 
			</script>	 
			<div class="form-group">
				<label class="col-sm-2 control-label" for="relation"><?php _e('Relation','school-mgt');?><span class="require-field">*</span></label>
				<div class="col-sm-8">
					<?php if($edit){ $relationval=$user_info->relation; }elseif(isset($_POST['relation'])){$relationval=$_POST['relation'];}else{$relationval='';}?>
						 <select name="relation" class="form-control validate[required]" id="relation">
							<option value=""><?php _e('select relation','school-mgt');?></option>
							<option value="<?php _e('Father','school-mgt');?>" <?php selected( $relationval, 'Father'); ?>><?php _e('Father','school-mgt');?></option>
							<option value="<?php _e('Mother','school-mgt');?>" <?php selected( $relationval, 'Mother'); ?>><?php _e('Mother','school-mgt');?></option>
						 </select>
				</div>	
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="address"><?php _e('Address','school-mgt');?><span class="require-field">*</span></label>
				<div class="col-sm-8">
					<input id="address" class="form-control validate[required,custom[address_description_validation]]" maxlength="150" type="text"  name="address" 
					value="<?php if($edit){ echo $user_info->address;}elseif(isset($_POST['address'])) echo $_POST['address'];?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="city_name"><?php _e('City','school-mgt');?><span class="require-field">*</span></label>
				<div class="col-sm-8">
					<input id="city_name" class="form-control validate[required,custom[city_state_country_validation]]" maxlength="50" type="text"  name="city_name" 
					value="<?php if($edit){ echo $user_info->city;}elseif(isset($_POST['city_name'])) echo $_POST['city_name'];?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="state_name"><?php _e('State','school-mgt');?></label>
				<div class="col-sm-8">
					<input id="state_name" class="form-control validate[custom[city_state_country_validation]]" maxlength="50" type="text"  name="state_name" 
					value="<?php if($edit){ echo $user_info->state;}elseif(isset($_POST['state_name'])) echo $_POST['state_name'];?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="zip_code"><?php _e('Zip Code','school-mgt');?><span class="require-field">*</span></label>
				<div class="col-sm-8">
					<input id="zip_code" class="form-control  validate[required,custom[onlyLetterNumber]]" maxlength="15" type="text"  name="zip_code" 
					value="<?php if($edit){ echo $user_info->zip_code;}elseif(isset($_POST['zip_code'])) echo $_POST['zip_code'];?>">
				</div>
			</div>
			
			<?php wp_nonce_field( 'save_parent_admin_nonce' ); ?>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="mobile_number"><?php _e('Mobile Number','school-mgt');?><span class="require-field">*</span></label>
				<div class="col-sm-1">
				
				<input type="text" readonly value="+<?php echo smgt_get_countery_phonecode(get_option( 'smgt_contry' ));?>"  class="form-control country_code" name="phonecode">
				</div>
				<div class="col-sm-7">
					<input id="mobile_number" class="form-control btn_top validate[required,custom[phone_number],minSize[6],maxSize[15]] text-input" type="text"  name="mobile_number" maxlength="10"
					value="<?php if($edit){ echo $user_info->mobile_number;}elseif(isset($_POST['mobile_number'])) echo $_POST['mobile_number'];?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label " for="phone"><?php _e('Phone','school-mgt');?><span class="require-field">*</span></label>
				<div class="col-sm-8">
					<input id="phone" class="form-control validate[required,custom[phone_number],minSize[6],maxSize[15]] text-input" type="text"  name="phone" 
					value="<?php if($edit){ echo $user_info->phone;}elseif(isset($_POST['phone'])) echo $_POST['phone'];?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label " for="email"><?php _e('Email','school-mgt');?><span class="require-field">*</span></label>
				<div class="col-sm-8">
					<input id="email" class="form-control validate[required,custom[email]] text-input" maxlength="100" type="text"  name="email" 
					value="<?php if($edit){ echo $user_info->user_email;}elseif(isset($_POST['email'])) echo $_POST['email'];?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="username"><?php _e('User Name','school-mgt');?><span class="require-field">*</span></label>
				<div class="col-sm-8">
					<input id="username" class="form-control validate[required,custom[username_validation]]" maxlength="50" type="text"  name="username" 
					value="<?php if($edit){ echo $user_info->user_login;}elseif(isset($_POST['username'])) echo $_POST['username'];?>" <?php if($edit) echo "readonly";?>>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="password"><?php _e('Password','school-mgt');?><?php if(!$edit) {?><span class="require-field">*</span><?php }?></label>
				<div class="col-sm-8">
					<input id="password" class="form-control <?php if(!$edit){ echo 'validate[required,minSize[8],maxSize[12]]'; }else{ echo 'validate[minSize[8],maxSize[12]]'; } ?>" type="password"  name="password" value="">
				</div>
			</div>
			
		<div class="form-group">
				<label class="col-sm-2 control-label" for="photo"><?php _e('Image','school-mgt');?></label>
				<div class="col-sm-2">
					<input type="text" id="amgt_user_avatar_url" class="form-control" name="smgt_user_avatar"  
					value="<?php if($edit)echo esc_url( $user_info->smgt_user_avatar );elseif(isset($_POST['smgt_user_avatar'])) echo $_POST['smgt_user_avatar']; ?>" />
					<input type="hidden" class="form-control" name="hidden_upload_user_avatar_image"  
					value="<?php if($edit)echo esc_url( $user_info->smgt_user_avatar );elseif(isset($_POST['hidden_upload_user_avatar_image'])) echo $_POST['hidden_upload_user_avatar_image']; ?>" />
				</div>	
					<div class="col-sm-3">
						 <input id="upload_user_avatar" class="btn_top" name="upload_user_avatar_image" onchange="fileCheck(this);" type="file" />
				</div>
				<div class="clearfix"></div>
				
				<div class="col-sm-offset-2 col-sm-8">
					<div id="upload_user_avatar_preview" >
						<?php if($edit) 
						{
							if($user_info->smgt_user_avatar == "")
							{ ?>
								<img class="image_preview_css" src="<?php echo get_option( 'smgt_student_thumb' ); ?>">
						<?php }
						else { ?>
							<img class="image_preview_css" src="<?php if($edit)echo esc_url( $user_info->smgt_user_avatar ); ?>" />
						<?php }
						}
					else { 	?>
							<img class="image_preview_css" src="<?php echo get_option( 'smgt_student_thumb' ); ?>">
				 <?php } ?>
					</div>
				</div>
			</div>
			<div class="col-sm-offset-2 col-sm-8">        	
				<input type="submit" value="<?php if($edit){ _e('Save Parent','school-mgt'); }else{ _e('Add Parent','school-mgt');}?>" name="save_parent" class="btn btn-success"/>
			</div>      
			</form>
			</div>
		<?php
		}
		if($active_tab == 'view_parent')
		{
			?>
			<script>
			$(document).ready(function(){
				$(".view_more_details_div").on("click", ".view_more_details", function(event)
				{
					$('.view_more_details_div').css("display", "none");
					$('.view_more_details_less_div').css("display", "block");
					$('.user_more_details').css("display", "block");
				});		
				$(".view_more_details_less_div").on("click", ".view_more_details_less", function(event)
				{
					$('.view_more_details_div').css("display", "block");
					$('.view_more_details_less_div').css("display", "none");
					$('.user_more_details').css("display", "none");
				});
			});

			</script>
			<style>
			.bounce {
			  -moz-animation: bounce 2s infinite;
			  -webkit-animation: bounce 2s infinite;
			  animation: bounce 2s infinite;
			}

			@keyframes bounce {
			  0%, 20%, 50%, 80%, 100% {
				transform: translateY(0);
			  }
			  40% {
				transform: translateY(-15px);
			  }
			  60% {
				transform: translateY(-5px);
			  }
			}
			</style>
			<?php
			 $parent_data=get_userdata($_REQUEST['parent_id']);
			 $user_meta =get_user_meta($_REQUEST['parent_id'], 'child', true); 
			?>
			<div class="panel-body">	
				<div class="box-body">
					<div class="row">
						<div class="col-md-3 col-sm-4 col-xs-12">	
							<?php
							$umetadata=get_user_image($parent_data->ID);
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
								<h2><?php echo $parent_data->display_name;?></h2>
							</div>
							<div class="row">
								<div class="col-md-4 col-sm-3 col-xs-12">
									<i class="fa fa-envelope"></i>&nbsp;
									<span class="email-span"><?php echo $parent_data->user_email;?></span>
								</div>
								<div class="col-md-3 col-sm-3 col-xs-12">
									<i class="fa fa-phone"></i>&nbsp;
									<span><?php echo $parent_data->phone;?></span>
								</div>
								<div class="col-md-5 col-sm-3 col-xs-12 no-padding">
									<i class="fa fa-map-marker"></i>&nbsp;
									<span><?php echo $parent_data->address;?></span>
								</div>
							</div>					
						</div>
					</div>
						
					<div class="row">
						<div class="view-more view_more_details_div" style="display:block;">
							<h4><?php _e( 'View More', 'school-mgt' ) ;?></h4>
								<i class="fa fa-angle-down fa-2x bounce view_more_details"></i>
						</div>
						<div class="view-more view_more_details_less_div " style="display:none;">
							<h4><?php _e( 'View Less', 'school-mgt' ) ;?></h4>
								<i class="fa fa-angle-up fa-2x view_more_details_less"></i>
						</div>
					</div>
					<hr>
						<div class="user_more_details" style="display: none;">
							<div class="card">
								<div class="card-head">
									<i class="fa fa-user"></i>
									<span><b><?php _e( 'Personal Information', 'school-mgt' ) ;?></b></span>
								</div>
								<div class="card-body">
									<div class="row">							
										<div class="col-md-2">
											<p class="user-lable"><?php _e( 'Name', 'school-mgt' ) ;?></p>
										</div>
										<div class="col-md-4">
											<p class="user-info">: <?php echo $parent_data->display_name;?></p>
										</div>
										
									<!--</div>
									<div class="row">-->							
										<div class="col-md-2">
											<p class="user-lable"><?php _e( 'Birth Date', 'school-mgt' ) ;?></p>
										</div>
										<div class="col-md-4">
											<p class="user-info">: <?php echo smgt_getdate_in_input_box($parent_data->birth_date);?></p>
										</div>
										<div class="col-md-2">
												<p class="user-lable"><?php _e( 'Gender', 'school-mgt' ) ;?></p>
											</div>
										<div class="col-md-4">
												<p class="user-info">: <?php echo $parent_data->gender;?></p>
										</div>
									<!--</div>
									<div class="row">-->
																	
										 <div class="col-md-2">
												<p class="user-lable"><?php _e( 'Relation', 'school-mgt' ) ;?></p>
											</div>
										<div class="col-md-4">
												<p class="user-info">: <?php echo $parent_data->relation;?></p>
										</div>
										
										 
									 
										</div>
									</div>						
								</div>
							<div class="card">
								<div class="card-head">
									<i class="fa fa-map-marker"></i>
									<span> <b><?php _e( 'Contact Information', 'school-mgt' ) ;?> </b></span>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-md-2">
											<p class="user-lable"><?php _e( 'Address', 'school-mgt' ) ;?></p>
										</div>
										<div class="col-md-4">
											<p class="user-info">: <?php echo $parent_data->address;?><br></p>
										</div>
										<div class="col-md-2">
											<p class="user-lable"><?php _e( 'City', 'school-mgt' ) ;?></p>
										</div>
										<div class="col-md-4">
											<p class="user-info">: <?php echo $parent_data->city;?></p>
										</div>
										<div class="col-md-2">
											<p class="user-lable"><?php _e( 'State', 'school-mgt' ) ;?></p>
										</div>
										<div class="col-md-4">
											<p class="user-info">: <?php echo $parent_data->state;?></p>
										</div>
										<div class="col-md-2">
											<p class="user-lable"><?php _e( 'Zipcode', 'school-mgt' ) ;?></p>
										</div>
										<div class="col-md-4">
											<p class="user-info">: <?php echo $parent_data->zip_code;?></p>
										</div>
										<div class="col-md-2">
											<p class="user-lable"><?php _e( 'Phone Number', 'school-mgt' ) ;?></p>
										</div>
										<div class="col-md-4">
											<p class="user-info">: <?php echo $parent_data->phone;?></p>
										</div>
									</div>											
								</div>
								 
							</div>
						</div>
					</div>
			</div>
			   
			<div class="panel-body">
				<div class="row">	
					<ul class="nav nav-tabs">
						<li class="active"><a data-toggle="tab" href="#Section1"><i class="fa fa-user"></i><b><?php _e( ' Child', 'school-mgt' ); ?></b></a></li>
					</ul>
					<script>
					jQuery(document).ready(function() {
						var table =  jQuery('#child_list').DataTable({
							responsive: true,
							"order": [[ 0, "asc" ]],
							"aoColumns":[	                  
							{"bSortable": false},
							{"bSortable": true},
							{"bSortable": true},
							{"bSortable": true},
							{"bSortable": true}],	
							language:<?php echo smgt_datatable_multi_language();?>	
						});
					});
					</script>
					<div class="tab-content">
						<div id="Section1" class="tab-pane fade in active">
							<div class="row">
								<div class="col-lg-12">
									<div class="card">
										<div class="card-content">
											 <div class="table-responsive">
												  <table id="child_list" class="display table" cellspacing="0" width="100%">
												  <thead>
														<tr>
														  <th><?php _e('Photo','school-mgt');?></th>
														  <th><?php _e('Child Name','school-mgt');?></th>
														  <th><?php _e('Roll No','school-mgt');?></th>
														  <th><?php _e('Class','school-mgt');?></th>
														  <th><?php _e('Child Email','school-mgt');?></th>
														</tr>
													</thead>
													<tfoot>
														<tr>
														  <th><?php _e('Photo','school-mgt');?></th>
														  <th><?php _e('Child Name','school-mgt');?></th>
														  <th><?php _e('Roll No','school-mgt');?></th>
														  <th><?php _e('Class','school-mgt');?></th>
														  <th><?php _e('Child Email','school-mgt');?></th>
														</tr>
													</tfoot>
													<tbody>
													<?php
													if(!empty($user_meta))
													{
														foreach($user_meta as $childsdata)
														{
														$child=get_userdata($childsdata);?>
													<tr>
													  <td><?php 
														if($childsdata)
														{
															$umetadata=get_user_image($childsdata);
														}
														if(empty($umetadata['meta_value']))
														{
															echo '<img src='.get_option( 'smgt_student_thumb' ).' height="50px" width="50px" class="img-circle" />';
														}
														else
															echo '<img src='.$umetadata['meta_value'].' height="50px" width="50px" class="img-circle"/>';?></td>
													  <td><?php echo $child->first_name." ".$child->last_name;?></td>
													  <td><?php echo get_user_meta($child->ID, 'roll_id',true);?></td>
													  <td>
														<?php  $class_id=get_user_meta($child->ID, 'class_name',true);
														echo $classname=get_class_name($class_id);?>
													  </td> 
													  <td><?php echo $child->user_email;?></td> 
													</tr>
													<?php
														}
													}
													?>
												</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					<div id="Section2" class="tab-pane fade">
								 
					</div>
					 
					</div>
				</div>
			</div>
		 
<?php
		}
?>
	</div>
</div>