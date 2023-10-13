<script type="text/javascript">
	$(document).ready(function() 
	{			
		 $("body").on("click",".parent_csv_selected",function()
		 {
			//var checked = $(".selected_teacher input:checked").length;
			if ($('.selected_parent:checked').length == 0 )
			{
				alert("<?php esc_html_e('Please Select At least One Record','school-mgt');?>");
				return false;
			}		
		});  
	});
</script>
<?php 
	$role='parent';
	if(isset($_POST['save_parent']))
	{
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
			
			 
			if(isset($_POST['smgt_user_avatar']) && $_POST['smgt_user_avatar'] != "")
			{
				$photo=$_POST['smgt_user_avatar'];
			}
			else
			{
				$photo="";
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
					wp_redirect ( admin_url().'admin.php?page=smgt_parent&tab=parentlist&message=1'); 
				}
			}
			else
			{
				if( !email_exists($_POST['email']) && !username_exists(smgt_strip_tags_and_stripslashes($_POST['username']))) 
				{
					$result=add_newuser($userdata,$usermetadata,$firstname,$lastname,$role);
					if($result)
					{ 
						wp_redirect ( admin_url().'admin.php?page=smgt_parent&tab=parentlist&message=2'); 
					} 
				}
				else 
				{ 
					wp_redirect ( admin_url().'admin.php?page=smgt_parent&tab=parentlist&message=3'); 
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
	
	$active_tab = isset($_GET['tab'])?$_GET['tab']:'parentlist';
	
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
			wp_redirect ( admin_url().'admin.php?page=smgt_parent&tab=parentlist&message=4'); 
		}
	}
if(isset($_REQUEST['delete_selected']))
{		
	if(!empty($_REQUEST['id']))
	foreach($_REQUEST['id'] as $id)
	{
		$childs=get_user_meta($id, 'child', true);
		if(!empty($childs))
		{
			foreach($childs as $childvalue)
			{
				$parents=get_user_meta($childvalue, 'parent_id', true);
				if(!empty($parents))
				{
					if(($key = array_search($id, $parents)) !== false)
					{
						unset($parents[$key]);
						update_user_meta( $childvalue,'parent_id', $parents );
					}
				}
			}
		}
		$result=delete_usedata($id);	
	}
		
	if($result) { 
		wp_redirect ( admin_url().'admin.php?page=smgt_parent&tab=parentlist&message=4'); 
	}
}	
//-------------- EXPORT Parent DATA ---------------//
if(isset($_POST['parent_csv_selected']))
{
	if(isset($_POST['id']))
	{	
		 foreach($_POST['id'] as $s_id)
		 {
			$staff_list[]=get_userdata($s_id);
		 }
			if(!empty($staff_list))
			{
				$header = array();			
				$header[] = 'Username';
				$header[] = 'Email';
				$header[] = 'Password';
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
				$filename='Reports/export_parent.csv';
				$fh = fopen(SMS_PLUGIN_DIR.'/admin/'.$filename, 'w') or die("can't open file");
				fputcsv($fh, $header);
				foreach($staff_list as $retrive_data)
				{
					$row = array();
					$user_info = get_userdata($retrive_data->ID);
					
					$row[] =  $user_info->user_login;
					$row[] =  $user_info->user_email;
					$row[] =  $user_info->user_pass;
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
			$file=SMS_PLUGIN_DIR.'/admin/Reports/export_parent.csv';//file location
			
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
//------------------ IMPORT Parent MEMBER --------------------------//
if(isset($_REQUEST['upload_parent_csv_file']))
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
						if( !empty($password) ) // if user not exist and password is empty but the column is set, it will be generated
							$password = $csv['password'];	
							$user_id = wp_create_user($username, $password, $email);
							
						
					}

					if( is_wp_error($user_id) )
					{ // in case the user is generating errors after this checks
						echo '<script>alert("Problems with user: ' . $username . ', we are going to skip");</script>';
						continue;
					}

					 if(!(is_multisite() && is_super_admin( $user_id ) ))
						wp_update_user(array ('ID' => $user_id, 'role' => 'parent')) ;
						
					
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
				wp_redirect ( admin_url().'admin.php?page=smgt_parent&tab=parentlist&message=5');
			} 
		}
    }
}	
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
			$message_string = __('Parent Updated Successfully.','school-mgt');
			break;
		case '2':
			$message_string = __('Parent Added Successfully.','school-mgt');
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
    	<a href="?page=smgt_parent&tab=parentlist" class="nav-tab <?php echo $active_tab == 'parentlist' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-menu"></span>'.__('Parent List', 'school-mgt'); ?></a>
    	
        <?php if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
		{?>
        <a href="?page=smgt_parent&tab=addparent&&action=edit&parent_id=<?php echo $_REQUEST['parent_id'];?>" class="nav-tab <?php echo $active_tab == 'addparent' ? 'nav-tab-active' : ''; ?>">
		<?php _e('Edit Parent', 'school-mgt'); ?></a>  
		<?php 
		}
		else
		{?>
			<a href="?page=smgt_parent&tab=addparent" class="nav-tab  <?php echo $active_tab == 'addparent' ? 'nav-tab-active' : ''; ?>">
			<?php echo '<span class="dashicons dashicons-plus-alt"></span>'.__('Add New Parent', 'school-mgt'); ?></a>  
		<?php
		}?>
		<?php if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'view_parent')
		{?>
        <a href="?page=smgt_parent&tab=view_parent&&action=view_parent&parent_id=<?php echo $_REQUEST['parent_id'];?>" class="nav-tab <?php echo $active_tab == 'view_parent' ? 'nav-tab-active' : ''; ?>">
		<span class="fa fa-eye"></span><?php _e(' View Parent', 'school-mgt'); ?></a>  
		<?php 
		}?>
       <a href="?page=smgt_parent&tab=uploadparent" class="nav-tab <?php echo $active_tab == 'uploadparent' ? 'nav-tab-active' : ''; ?>"><?php echo '<span class="dashicons dashicons-menu"></span> '.__('Upload Parent CSV', 'school-mgt'); ?>
		</a>
    </h2>
     <?php 
	//Report 1 
	if($active_tab == 'parentlist')
	{ 
	?>  
<div class="panel-body">
<script>
jQuery(document).ready(function() {
	var table =  jQuery('#parent_list').DataTable({
        responsive: true,
		"order": [[ 2, "asc" ]],
		"aoColumns":[	                  
		  {"bSortable": false},
		  {"bSortable": false},	                  	                
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
        <table id="parent_list" class="display admin_parent_datatable" cellspacing="0" width="100%">
        	 <thead>
            <tr>
				<th style="width: 20px;"><input name="select_all" value="all" id="checkbox-select-all" 
				type="checkbox" /></th> 
				<th width="75px"><?php echo _e('Photo', 'school-mgt' ) ;?></th>
                <th><?php echo _e( 'Parent Name', 'school-mgt' ) ;?></th>
                <th> <?php echo _e( 'Parent Email', 'school-mgt' ) ;?></th>
                <th><?php echo _e( 'Action', 'school-mgt' ) ;?></th>
            </tr>
        </thead>
 
        <tfoot>
            <tr>
				<th></th>
				<th><?php echo _e( 'Photo', 'school-mgt' ) ;?></th>
               <th><?php echo _e( 'Parent Name', 'school-mgt' ) ;?></th>
                <th> <?php echo _e( 'Parent Email', 'school-mgt' ) ;?></th>
                <th><?php echo _e( 'Action', 'school-mgt' ) ;?></th>
                
            </tr>
        </tfoot>
 
        <tbody>
         <?php 
			$parentdata=get_usersdata('parent');
			if($parentdata)
			{
				foreach ($parentdata as $retrieved_data){ ?>	
				<tr>
				<td><input type="checkbox" class="select-checkbox selected_parent" name="id[]" 
				value="<?php echo $retrieved_data->ID;?>"></td>
					<td class="user_image "><?php $uid=$retrieved_data->ID;
								$umetadata=get_user_image($uid);
								if(empty($umetadata))
									{
										echo '<img src='.get_option( 'smgt_parent_thumb' ).' height="50px" width="50px" class="img-circle" />';
									}
								else
								echo '<img src='.$umetadata.' height="50px" width="50px" class="img-circle"/>';
					?></td>
					<td class="name"><a href="?page=smgt_parent&tab=addparent&action=edit&parent_id=<?php echo $retrieved_data->ID;?>"><?php echo $retrieved_data->display_name;?></a></td>
					<td class="email"><?php echo $retrieved_data->user_email;?></td>
					
					<td class="action">
					<a href="?page=smgt_parent&tab=view_parent&action=view_parent&parent_id=<?php echo $retrieved_data->ID;?>" class="btn btn-success"><?php _e('View','school-mgt');?></a>
					<a href="?page=smgt_parent&tab=addparent&action=edit&parent_id=<?php echo $retrieved_data->ID;?>" class="btn btn-info"> <?php echo _e( ' Edit', 'school-mgt' ) ;?></a>
					<a href="?page=smgt_parent&tab=parentlist&action=delete&parent_id=<?php echo $retrieved_data->ID;?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this record?');"><?php echo _e( ' Delete', 'school-mgt' ) ;?> </a>
					</td>
				   
				</tr>
				<?php } 
				
		}?>
     
        </tbody>
        
        </table>
		<div class="print-button pull-left">
			<input id="delete_selected" type="submit" value="<?php _e('Delete Selected','school-mgt');?>" name="delete_selected" class="btn btn-danger delete_selected"/>
			<input type="submit" class="btn delete_margin_bottom btn-primary parent_csv_selected margin_top_10_res" name="parent_csv_selected" value="<?php esc_attr_e('Export Selected', 'school-mgt' ) ;?> " />
		</div>
		</form>
        </div>
        </div>
       

     <?php 
	 }
	
	if($active_tab == 'addparent')
	{
		require_once SMS_PLUGIN_DIR. '/admin/includes/parent/add-newparent.php';
	}
	if($active_tab == 'view_parent')
	{
		require_once SMS_PLUGIN_DIR. '/admin/includes/parent/view_parent.php';
	}
	if($active_tab == 'uploadparent')
	{
		require_once SMS_PLUGIN_DIR. '/admin/includes/parent/upload_parent.php';
	}
	 ?>				
	 			</div><!-- Panel white -->
	 		</div><!-- col-md-12 -->
	 	</div><!-- Row -->
	 </div><!-- #mainwrapper -->
</div><!-- page-inner -->
<?php ?>