<?php 

if(isset($_POST['save_notification']))
{
	$nonce = $_POST['_wpnonce'];
	if ( wp_verify_nonce( $nonce, 'save_notice_admin_nonce' ) )
	{
		global $wpdb;
		$smgt_notification = $wpdb->prefix. 'smgt_notification';
		$exlude_id = smgt_approve_student_list();
		if(isset($_POST['selected_users']) && $_POST['selected_users'] != 'All')
		{
			$token = get_user_meta($_POST['selected_users'],'token_id',true);
			$title = MJ_smgt_popup_category_validation($_POST['title']);
			$text = MJ_smgt_address_description_validation($_POST['message_body']);
			$bicon = get_user_meta($_POST['selected_users'],'bicon',true);
			$new_bicon = (int)$bicon + 1;
			$badge = $new_bicon;
			$a = array('registration_ids'=>array($token),'notification'=>array('title'=>$title,'text'=>$text,'badge'=>$badge));
			$json = json_encode($a);
			
			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 300,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => $json,
			  CURLOPT_HTTPHEADER => array(
				"authorization: key=".get_option('smgt_notification_fcm_key'),
				"cache-control: no-cache",
				"content-type: application/json",
				"postman-token: ff7ad440-bbe0-6a2a-160d-83369683bc63"
			  ),
			));
			
			$response1 = curl_exec($curl);
			
			$err = curl_error($curl);

			curl_close($curl);
			
			
			update_user_meta($_POST['selected_users'],'bicon',$new_bicon);
			
			$data['student_id'] = $_POST['selected_users'];
			$data['title'] = MJ_smgt_popup_category_validation($_POST['title']);
			$data['message'] = MJ_smgt_address_description_validation($_POST['message_body']);
			// $data['device_token'] = 'abc123';
			// $data['device_type'] = 1;
			// $data['bicon'] = 1;
			$data['created_date'] = date('Y-m-d');
			$data['created_by'] = get_current_user_id();
			$result=$wpdb->insert( $smgt_notification,$data );
		}
		elseif(isset($_POST['class_id']) && $_POST['class_id'] == 'All')
		{
			foreach(get_allclass() as $class)
			{
				//$class_section = smgt_get_class_sections($class['class_id']);
				// if(!empty($class_section))
				// {
					// foreach($class_section as $section)
					// {
						$query_data['exclude']=$exlude_id;
						
						// $query_data['meta_key'] = 'class_section';
						// $query_data['meta_value'] = $section->id;
						$query_data['meta_query'] = array(array('key' => 'class_name','value' => $class['class_id'],'compare' => '=') );
						$results = get_users($query_data);
						if(!empty($results))
						{
							foreach($results as $retrive_data)
							{
								$token = get_user_meta($retrive_data->ID,'token_id',true);
								$title = MJ_smgt_popup_category_validation($_POST['title']);
								$text = MJ_smgt_address_description_validation($_POST['message_body']);
								$bicon = get_user_meta($retrive_data->ID,'bicon',true);
								$new_bicon = $bicon + 1;
								$badge = $new_bicon;
								$a = array('registration_ids'=>array($token),'notification'=>array('title'=>$title,'text'=>$text,'badge'=>$badge));
								$json = json_encode($a);
								
								$curl = curl_init();

								curl_setopt_array($curl, array(
								  CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
								  CURLOPT_RETURNTRANSFER => true,
								  CURLOPT_ENCODING => "",
								  CURLOPT_MAXREDIRS => 10,
								  CURLOPT_TIMEOUT => 300,
								  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
								  CURLOPT_CUSTOMREQUEST => "POST",
								  CURLOPT_POSTFIELDS => $json,
								  CURLOPT_HTTPHEADER => array(
									"authorization: key=".get_option('smgt_notification_fcm_key'),
									"cache-control: no-cache",
									"content-type: application/json",
									"postman-token: ff7ad440-bbe0-6a2a-160d-83369683bc63"
								  ),
								));

								$response1 = curl_exec($curl);
								
								$err = curl_error($curl);

								curl_close($curl);
								
								
								update_user_meta($retrive_data->ID,'bicon',$new_bicon);
								
								$data['student_id'] = $retrive_data->ID;
								$data['title'] = MJ_smgt_popup_category_validation($_POST['title']);
								$data['message'] = MJ_smgt_address_description_validation($_POST['message_body']);
								// $data['device_token'] = 'abc123';
								// $data['device_type'] = 1;
								// $data['bicon'] = 1;
								$data['created_date'] = date('Y-m-d');
								$data['created_by'] = get_current_user_id();
								$result=$wpdb->insert( $smgt_notification,$data );
							}
						}
						
					//}
				//}
				
			}
		}
		elseif(isset($_POST['class_section']) && $_POST['class_section'] == 'All')
		{
			// $class_section = smgt_get_class_sections($_POST['class_id']);
			
			// if(!empty($class_section))
			// {
				// foreach($class_section as $section)
				// {
					$query_data['exclude']=$exlude_id;
					
					// $query_data['meta_key'] = 'class_section';
					// $query_data['meta_value'] = $section->id;
					$query_data['meta_query'] = array(array('key' => 'class_name','value' => $_POST['class_id'],'compare' => '=') );
					$results = get_users($query_data);
					
					if(!empty($results))
					{
						foreach($results as $retrive_data)
						{
							$token = get_user_meta($retrive_data->ID,'token_id',true);
							$title = MJ_smgt_popup_category_validation($_POST['title']);
							$text = MJ_smgt_address_description_validation($_POST['message_body']);
							$bicon = get_user_meta($retrive_data->ID,'bicon',true);
							$new_bicon = $bicon + 1;
							$badge = $new_bicon;
							$a = array('registration_ids'=>array($token),'notification'=>array('title'=>$title,'text'=>$text,'badge'=>$badge));
							$json = json_encode($a);
							
							$curl = curl_init();

							curl_setopt_array($curl, array(
							  CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
							  CURLOPT_RETURNTRANSFER => true,
							  CURLOPT_ENCODING => "",
							  CURLOPT_MAXREDIRS => 10,
							  CURLOPT_TIMEOUT => 300,
							  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
							  CURLOPT_CUSTOMREQUEST => "POST",
							  CURLOPT_POSTFIELDS => $json,
							  CURLOPT_HTTPHEADER => array(
								"authorization: key=".get_option('smgt_notification_fcm_key'),
								"cache-control: no-cache",
								"content-type: application/json",
								"postman-token: ff7ad440-bbe0-6a2a-160d-83369683bc63"
							  ),
							));

							$response1 = curl_exec($curl);
							
							$err = curl_error($curl);

							curl_close($curl);
							
							
							update_user_meta($retrive_data->ID,'bicon',$new_bicon);
							
							$data['student_id'] = $retrive_data->ID;
							$data['title'] = MJ_smgt_popup_category_validation($_POST['title']);
							$data['message'] = MJ_smgt_address_description_validation($_POST['message_body']);
							// $data['device_token'] = 'abc123';
							// $data['device_type'] = 1;
							// $data['bicon'] = 1;
							$data['created_date'] = date('Y-m-d');
							$data['created_by'] = get_current_user_id();
							$result=$wpdb->insert( $smgt_notification,$data );
						}
					}
					
				// }
			// }
		}
		else
		{
			$query_data['exclude']=$exlude_id;
			$query_data['meta_key'] = 'class_section';
			$query_data['meta_value'] = $_POST['class_section'];
			$query_data['meta_query'] = array(array('key' => 'class_name','value' => $_POST['class_id'],'compare' => '=') );
			$results = get_users($query_data);
			if(!empty($results))
			{
				foreach($results as $retrive_data)
				{
					$token = get_user_meta($retrive_data->ID,'token_id',true);
					$title = MJ_smgt_popup_category_validation($_POST['title']);
					$text = MJ_smgt_address_description_validation($_POST['message_body']);
					$bicon = get_user_meta($retrive_data->ID,'bicon',true);
					$new_bicon = $bicon + 1;
					$badge = $new_bicon;
					$a = array('registration_ids'=>array($token),'notification'=>array('title'=>$title,'text'=>$text,'badge'=>$badge));
					$json = json_encode($a);
					
					$curl = curl_init();

					curl_setopt_array($curl, array(
					  CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
					  CURLOPT_RETURNTRANSFER => true,
					  CURLOPT_ENCODING => "",
					  CURLOPT_MAXREDIRS => 10,
					  CURLOPT_TIMEOUT => 300,
					  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					  CURLOPT_CUSTOMREQUEST => "POST",
					  CURLOPT_POSTFIELDS => $json,
					  CURLOPT_HTTPHEADER => array(
						"authorization: key=".get_option('smgt_notification_fcm_key'),
						"cache-control: no-cache",
						"content-type: application/json",
						"postman-token: ff7ad440-bbe0-6a2a-160d-83369683bc63"
					  ),
					));

					$response1 = curl_exec($curl);
					
					$err = curl_error($curl);

					curl_close($curl);
					
					
					update_user_meta($retrive_data->ID,'bicon',$new_bicon);
					
					$data['student_id'] = $retrive_data->ID;
					$data['title'] = MJ_smgt_popup_category_validation($_POST['title']);
					$data['message'] = MJ_smgt_address_description_validation($_POST['message_body']);
					// $data['device_token'] = 'abc123';
					// $data['device_type'] = 1;
					// $data['bicon'] = 1;
					$data['created_date'] = date('Y-m-d');
					$data['created_by'] = get_current_user_id();
					$result=$wpdb->insert( $smgt_notification,$data );
				}
			}
		}
		if($result)
		{
		  wp_redirect ( admin_url().'admin.php?page=smgt_notification&tab=notificationlist&message=1');
		
		}
    }
}	
if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete')
{
	$result=smgt_delete_notification($_REQUEST['notification_id']);
	if($result)
	{
		wp_redirect ( admin_url().'admin.php?page=smgt_notification&tab=notificationlist&message=2');
	}
}
$active_tab = isset($_GET['tab'])?$_GET['tab']:'notificationlist';
	
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
			$message_string = __('Notification Insert Successfully !','school-mgt');
			break;
		case '2':
			$message_string = __('Notification Deleted Successfully.','school-mgt');
			break;	
		case '3':
			$message_string = __('','school-mgt');
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
    	<a href="?page=smgt_notification&tab=notificationlist" class="nav-tab <?php echo $active_tab == 'notificationlist' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-menu"></span>'.__('Notification List', 'school-mgt'); ?></a>
    	
		<a href="?page=smgt_notification&tab=addnotification" class="nav-tab margin_bottom <?php echo $active_tab == 'addnotification' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-plus-alt"></span>'.__('Add Notification', 'school-mgt'); ?></a>  
       
    </h2>
     <?php 
	//Report 1 
	if($active_tab == 'notificationlist')
	{ 
	?>	
  
	<div class="panel-body">
	<script>
jQuery(document).ready(function() {
	var table =  jQuery('#parent_list').DataTable({
        responsive: true,
		// "order": [[ 2, "asc" ]],
		// "aoColumns":[	                  
	                  // {"bSortable": false},
	                  // {"bSortable": false},	                  	                
	                  // {"bSortable": true},
	                  // {"bSortable": true},	                  
	                  // {"bSortable": false}],
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
        <table id="parent_list" class="display admin_notification_datatable" cellspacing="0" width="100%">
        	 <thead>
            <tr>
				<!--<th style="width: 20px;"><input name="select_all" value="all" id="checkbox-select-all" 
				type="checkbox" /></th>--> 
				<th><?php echo _e('Student Name', 'school-mgt' ) ;?></th>
                <th><?php echo _e( 'Title', 'school-mgt' ) ;?></th>
                <th> <?php echo _e( 'Message', 'school-mgt' ) ;?></th>
                <th> <?php echo _e( 'Action', 'school-mgt' ) ;?></th>
            </tr>
        </thead>
 
        <tfoot>
            <tr>
				<!--<th></th>-->
				<th><?php echo _e('Student Name', 'school-mgt' ) ;?></th>
                <th><?php echo _e( 'Title', 'school-mgt' ) ;?></th>
                <th> <?php echo _e( 'Message', 'school-mgt' ) ;?></th>
                <th> <?php echo _e( 'Action', 'school-mgt' ) ;?></th>
            </tr>
        </tfoot>
 
        <tbody>
         <?php 
			global $wpdb;
			$smgt_notification = $wpdb->prefix. 'smgt_notification';	
			$result =$wpdb->get_results("SELECT * FROM $smgt_notification");
			
			if($result)
			{
				foreach ($result as $retrieved_data){ ?>	
				<tr>
				<!--<td><input type="checkbox" class="select-checkbox" name="id[]" 
				value="<?php //echo $retrieved_data->notification_id;?>"></td>-->
					
					<td><?php echo get_user_name_byid($retrieved_data->student_id); ?></td>
					<td><?php echo $retrieved_data->title; ?></td>
					<td><?php echo $retrieved_data->message; ?></td>
					<td><a href="?page=smgt_notification&tab=notificationlist&action=delete&notification_id=<?php echo $retrieved_data->notification_id;?>" class="btn btn-danger" onclick="return confirm('<?php _e('Are you sure you want to delete this record?','school-mgt');?>');"> <?php _e('Delete','school-mgt');?></a> </td>
				</tr>
				<?php } 
				
		}?>
     
        </tbody>
        
        </table>
		<!--<div class="print-button pull-left">
			<input id="delete_selected" type="submit" value="<?php _e('Delete Selected','school-mgt');?>" name="delete_selected" class="btn btn-danger delete_selected"/>
			
		</div>-->
		</form>
        </div>
        </div>
       

     <?php 
	 }
	
	if($active_tab == 'addnotification')
	 {
	require_once SMS_PLUGIN_DIR. '/admin/includes/notification/add-notification.php';
	 }
	 ?>				
	 			</div><!-- Panel white -->
	 		</div><!-- col-md-12 -->
	 	</div><!-- Row -->
	 </div><!-- #mainwrapper -->
</div><!-- page-inner -->
<?php ?>