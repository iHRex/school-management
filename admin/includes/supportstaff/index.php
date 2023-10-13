 <script type="text/javascript">
	$(document).ready(function() 
	{			
		 $("body").on("click",".staff_csv_selected",function()
		 {
			//var checked = $(".selected_teacher input:checked").length;
			if ($('.selected_staff:checked').length == 0 )
			{
				alert("<?php esc_html_e('Please Select At least One Record','school-mgt');?>");
				return false;
			}		
		});  
	});
	</script>
<?php 
$role='supportstaff';
if(isset($_POST['save_supportstaff']))
{
	$nonce = $_POST['_wpnonce'];
	if ( wp_verify_nonce( $nonce, 'save_supportstaff_admin_nonce' ) )
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
		
		$usermetadata=array('middle_name'=>MJ_smgt_onlyLetter_specialcharacter_validation($_POST['middle_name']),
							'gender'=>MJ_smgt_onlyLetterSp_validation($_POST['gender']),
							'birth_date'=>$_POST['birth_date'],
							'address'=>MJ_smgt_address_description_validation($_POST['address']),
							'city'=>MJ_smgt_city_state_country_validation($_POST['city_name']),
							'state'=>MJ_smgt_city_state_country_validation($_POST['state_name']),
							'zip_code'=>MJ_smgt_onlyLetterNumber_validation($_POST['zip_code']),
							
							'phone'=>MJ_smgt_phone_number_validation($_POST['phone']),
							'mobile_number'=>MJ_smgt_phone_number_validation($_POST['mobile_number']),
							'alternet_mobile_number'=>MJ_smgt_phone_number_validation($_POST['alternet_mobile_number']),
							'working_hour'=>MJ_smgt_onlyLetter_specialcharacter_validation($_POST['working_hour']),
							'possition'=>MJ_smgt_address_description_validation($_POST['possition']),
							'smgt_user_avatar'=>$photo,
							
		);
		
		if($_REQUEST['action']=='edit')
		{
			$userdata['ID']=$_REQUEST['supportstaff_id'];
			$result=update_user($userdata,$usermetadata,$firstname,$lastname,$role);
			//var_dump($result);
			if($result)
			{
				wp_redirect ( admin_url().'admin.php?page=smgt_supportstaff&tab=supportstaff_list&message=2'); 
			}		
		}
		else
		{
			if( !email_exists( $_POST['email'] ) && !username_exists( smgt_strip_tags_and_stripslashes($_POST['username']))) {
				$result=add_newuser($userdata,$usermetadata,$firstname,$lastname,$role);
				if($result)
				{ 
						wp_redirect ( admin_url().'admin.php?page=smgt_supportstaff&tab=supportstaff_list&message=1');
				 }
			}
			else 
			{ 
				wp_redirect ( admin_url().'admin.php?page=smgt_supportstaff&tab=supportstaff_list&message=3');
			}
		}
	}
}

	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
		{
			
			$result=delete_usedata($_REQUEST['supportstaff_id']);
			if($result)
			{
				wp_redirect ( admin_url().'admin.php?page=smgt_supportstaff&tab=supportstaff_list&message=4');
			}
		}
if(isset($_REQUEST['delete_selected']))
	{		
		if(!empty($_REQUEST['id']))
		foreach($_REQUEST['id'] as $id)
			$result=delete_usedata($id);
		if($result)
			{
				wp_redirect ( admin_url().'admin.php?page=smgt_supportstaff&tab=supportstaff_list&message=4');
			}
	}
	//-------------- EXPORT Staff DATA ---------------//
if(isset($_POST['staff_csv_selected']))
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
				$filename='Reports/export_staff.csv';
				$fh = fopen(SMS_PLUGIN_DIR.'/admin/'.$filename, 'w') or die("can't open file");
				fputcsv($fh, $header);
				foreach($staff_list as $retrive_data)
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
			$file=SMS_PLUGIN_DIR.'/admin/Reports/export_staff.csv';//file location
			
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
//------------------ IMPORT STAFF MEMBER --------------------------//
if(isset($_REQUEST['upload_staff_csv_file']))
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

					 if(!( in_array("administrator", smgt_get_roles($user_id), FALSE) || is_multisite() && is_super_admin( $user_id ) ))
						wp_update_user(array ('ID' => $user_id, 'role' => 'supportstaff')) ;
						
					
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
				wp_redirect ( admin_url().'admin.php?page=smgt_supportstaff&tab=supportstaff_list&message=5');
			} 
		}
    }
}
$active_tab = isset($_GET['tab'])?$_GET['tab']:'supportstaff_list';
	
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
			$message_string = __('Support Staff Added Successfully.','school-mgt');
			break;
		case '2':
			$message_string = __('Support Staff Updated Successfully.','school-mgt');
			break;	
		case '3':
			$message_string = __('Username Or Email-id Already Exist.','school-mgt');
			break;
		case '4':
			$message_string = __('Support Staff Deleted Successfully.','school-mgt');
			break;	
		case '5':
			$message_string = __('Support Staff CSV Successfully Uploaded.','school-mgt');
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
    	<a href="?page=smgt_supportstaff&tab=supportstaff_list" class="nav-tab <?php echo $active_tab == 'supportstaff_list' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-menu"></span>'.__('Support Staff List', 'school-mgt'); ?></a>
    	
        <?php if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
		{?>
        <a href="?page=smgt_supportstaff&tab=addsupportstaff&&action=edit&supportstaff_id=<?php echo $_REQUEST['supportstaff_id'];?>" class="nav-tab <?php echo $active_tab == 'addsupportstaff' ? 'nav-tab-active' : ''; ?>">
		<?php _e('Edit Support Staff', 'school-mgt'); ?></a>  
		<?php 
		}
		else
		{?>
			<a href="?page=smgt_supportstaff&tab=addsupportstaff" class="nav-tab  <?php echo $active_tab == 'addsupportstaff' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.__('Add New Support Staff', 'school-mgt'); ?></a>  
		<?php }?>
		<?php if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'view_supportstaff')
		{?>
        <a href="?page=smgt_supportstaff&tab=view_supportstaff&action=view_supportstaff&supportstaff_id=<?php echo $_REQUEST['supportstaff_id'];?>" class="nav-tab <?php echo $active_tab == 'view_supportstaff' ? 'nav-tab-active' : ''; ?>">
		<span class="fa fa-eye"></span><?php _e(' View Support Staff', 'school-mgt'); ?></a>  
		<?php 
		}?>
       <a href="?page=smgt_supportstaff&tab=uploadstaff" class="nav-tab <?php echo $active_tab == 'uploadstaff' ? 'nav-tab-active' : ''; ?>"><?php echo '<span class="dashicons dashicons-menu"></span> '.__('Upload Support Staff CSV', 'school-mgt'); ?>
		</a>
       
    </h2>
     <?php 
	//Report 1 
	if($active_tab == 'supportstaff_list')
	{ 
	
	?>	
    
    <form name="wcwm_report" action="" method="post">
    
        <div class="panel-body">
		<script>
jQuery(document).ready(function() {
	var table =  jQuery('#supportstaff_list').DataTable({
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
        <table id="supportstaff_list" class="display admin_supportstaff_datatable" cellspacing="0" width="100%">
        	 <thead>
            <tr>
			<th style="width: 20px;"><input name="select_all" value="all" id="checkbox-select-all" 
				type="checkbox" /></th> 
			   <th><?php  _e( 'Photo', 'school-mgt' ) ;?></th>
                <th><?php _e( 'Name', 'school-mgt' ) ;?></th>			  
                <th> <?php _e( 'Email', 'school-mgt' ) ;?></th>
                <th><?php  _e( 'Action', 'school-mgt' ) ;?></th>
            </tr>
        </thead>
 
        <tfoot>
            <tr>
				<th></th>
				<th><?php  _e( 'Photo', 'school-mgt' ) ;?></th>
              <th><?php _e( 'Name', 'school-mgt' ) ;?></th>			  
                <th> <?php _e( 'Email', 'school-mgt' ) ;?></th>
                <th><?php  _e( 'Action', 'school-mgt' ) ;?></th>
                
            </tr>
        </tfoot>
 
        <tbody>
         <?php 
		$teacherdata=get_usersdata('supportstaff');
		 if(!empty($teacherdata))
		 {
		 	foreach (get_usersdata('supportstaff') as $retrieved_data){ 
			
			
		 ?>
            <tr>
			<td><input type="checkbox" class="select-checkbox selected_staff" name="id[]" 
				value="<?php echo $retrieved_data->ID;?>"></td>
				<td class="user_image" width="50px"><?php $uid=$retrieved_data->ID;
							$umetadata=get_user_image($uid);
		 	if(empty($umetadata))
									{
										echo '<img src='.get_option( 'smgt_supportstaff_thumb' ).' height="50px" width="50px" class="img-circle" />';
									}
							else
							echo '<img src='.$umetadata.' height="50px" width="50px" class="img-circle"/>';
				?></td>
                <td class="name"><a href="?page=smgt_supportstaff&tab=addsupportstaff&action=edit&supportstaff_id=<?php echo $retrieved_data->ID;?>"><?php echo $retrieved_data->display_name;?></a></td>
               
			
                <td class="email"><?php echo $retrieved_data->user_email;?></td>
               	<td class="action"> 
				<a href="?page=smgt_supportstaff&tab=view_supportstaff&action=view_supportstaff&supportstaff_id=<?php echo $retrieved_data->ID;?>" class="btn btn-success"><?php _e('View','school-mgt');?></a>
				<a href="?page=smgt_supportstaff&tab=addsupportstaff&action=edit&supportstaff_id=<?php echo $retrieved_data->ID;?>" class="btn btn-info"> <?php _e('Edit', 'school-mgt' ) ;?></a>
                <a href="?page=smgt_supportstaff&tab=supportstaff_list&action=delete&supportstaff_id=<?php echo $retrieved_data->ID;?>" class="btn btn-danger" 
                onclick="return confirm('<?php _e('Are you sure you want to delete this record?','school-mgt');?>');">
                <?php _e( 'Delete', 'school-mgt' ) ;?> </a>
                
                </td>
               
            </tr>
            <?php } 
			
		}?>
     
        </tbody>
        
        </table>
		<div class="print-button pull-left">
			<input id="delete_selected" type="submit" value="<?php _e('Delete Selected','school-mgt');?>" name="delete_selected" class="btn btn-danger delete_selected"/>
			<input type="submit" class="btn delete_margin_bottom btn-primary staff_csv_selected margin_top_10_res" name="staff_csv_selected" value="<?php esc_attr_e('Export Selected', 'school-mgt' ) ;?> " />
		</div>
		</form>
        </div>
        </div>
       
</form>
     <?php 
	 }
	
	if($active_tab == 'addsupportstaff')
	 {
		require_once SMS_PLUGIN_DIR. '/admin/includes/supportstaff/add-staff.php';
	 }
	 if($active_tab == 'view_supportstaff')
	 {
		require_once SMS_PLUGIN_DIR. '/admin/includes/supportstaff/view_supportstaff.php';
	 }
	 if($active_tab == 'uploadstaff')
	 {
		require_once SMS_PLUGIN_DIR. '/admin/includes/supportstaff/upload_staff.php';
	 }
	 ?>
</div>
			
		</div>
	</div>
</div>