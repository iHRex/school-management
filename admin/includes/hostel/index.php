<?php 
$obj_hostel=new smgt_hostel;
$tablename='smgt_hostel'; 
//----------insert and update--------------------
	if(isset($_POST['save_hostel']))
	{
		$nonce = $_POST['_wpnonce'];
		if ( wp_verify_nonce( $nonce, 'save_hostel_admin_nonce' ) )
		{
			if($_REQUEST['action']=='edit')
			{
				$result=$obj_hostel->smgt_insert_hostel($_POST);
				if($result)
				{
					wp_redirect ( admin_url().'admin.php?page=smgt_hostel&tab=hostel_list&message=2');
				}
			}
			else
			{
				$result=$obj_hostel->smgt_insert_hostel($_POST);
				if($result)
				{
					wp_redirect ( admin_url().'admin.php?page=smgt_hostel&tab=hostel_list&message=1');
				}
			}
	    }
	}
//---------delete record--------------------
	 
	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete')
	{
		$result=$obj_hostel->smgt_delete_hostel($_REQUEST['hostel_id']);
		if($result)
		{
			wp_redirect ( admin_url().'admin.php?page=smgt_hostel&tab=hostel_list&message=3');
		}
	}
	if(isset($_REQUEST['delete_selected']))
	{		
		if(!empty($_REQUEST['id']))
		foreach($_REQUEST['id'] as $id)
		{
			$result=$obj_hostel->smgt_delete_hostel($id);
		}
		if($result)
		{
			wp_redirect ( admin_url().'admin.php?page=smgt_hostel&tab=hostel_list&message=3');
		}
	}	
	//----------insert and update ROOM--------------------
	if(isset($_POST['save_room']))
	{
		$nonce = $_POST['_wpnonce'];
		if ( wp_verify_nonce( $nonce, 'save_room_admin_nonce' ) )
		{
			if($_REQUEST['action']=='edit_room')
			{
				$result=$obj_hostel->smgt_insert_room($_POST);
				if($result)
				{
					wp_redirect ( admin_url().'admin.php?page=smgt_hostel&tab=room_list&message=5');
				}
			}
			else
			{
				$result=$obj_hostel->smgt_insert_room($_POST);
				if($result)
				{
					wp_redirect ( admin_url().'admin.php?page=smgt_hostel&tab=room_list&message=4');
				}
			}
	    }
	}
	//--------- delete record ROOM --------------------
	 
	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete_room')
	{
		$result=$obj_hostel->smgt_delete_room($_REQUEST['room_id']);
		if($result)
		{
			wp_redirect ( admin_url().'admin.php?page=smgt_hostel&tab=room_list&message=6');
		}
	}
	if(isset($_REQUEST['delete_selected_room']))
	{		
		if(!empty($_REQUEST['id']))
		foreach($_REQUEST['id'] as $id)
		{
			$result=$obj_hostel->smgt_delete_room($id);
		}
		if($result)
		{
			wp_redirect ( admin_url().'admin.php?page=smgt_hostel&tab=room_list&message=6');
		}
	}	
	//----------insert and update Beds--------------------
	if(isset($_POST['save_bed']))
	{
		$nonce = $_POST['_wpnonce'];
		if ( wp_verify_nonce( $nonce, 'save_bed_admin_nonce' ) )
		{
		
			if($_REQUEST['action']=='edit_bed')
			{
				$bed_id=$_REQUEST['bed_id'];
				$room_id=$_REQUEST['room_id'];
				 
				global $wpdb;
				$table_smgt_beds=$wpdb->prefix.'smgt_beds';
				$result_bed =$wpdb->get_results("SELECT * FROM $table_smgt_beds WHERE room_id=$room_id and id !=".$bed_id);
				$bed=count($result_bed);
				$bed_capacity=smgt_get_bed_capacity_by_id($room_id);
				if($bed < $bed_capacity)
				{
					$result=$obj_hostel->smgt_insert_bed($_POST);
					if($result)
					{
						wp_redirect ( admin_url().'admin.php?page=smgt_hostel&tab=bed_list&message=8');
					}
				}
				else
				{
					wp_redirect ( admin_url().'admin.php?page=smgt_hostel&tab=add_bed&action=edit_bed&bed_id='.$bed_id.'&message=10');
					die;
				}
			}
			else
			{
				$assign_bed=smgt_hostel_room_bed_count($_POST['room_id']);
				$bed_capacity=smgt_get_bed_capacity_by_id($_POST['room_id']);
				$bed_capacity_int=(int)$bed_capacity;
				 
				if($assign_bed >= $bed_capacity_int)
				{
					wp_redirect ( admin_url().'admin.php?page=smgt_hostel&tab=add_bed&message=10');
					die;
				}
				else
				{
					$result=$obj_hostel->smgt_insert_bed($_POST);
					if($result)
					{
						wp_redirect ( admin_url().'admin.php?page=smgt_hostel&tab=bed_list&message=7');
					}
				}
			}
	    }
	}
	//--------- delete record BED --------------------
	 
	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete_bed')
	{
		$result=$obj_hostel->smgt_delete_bed($_REQUEST['bed_id']);
		if($result)
		{
			wp_redirect ( admin_url().'admin.php?page=smgt_hostel&tab=bed_list&message=9');
		}
	}
	if(isset($_REQUEST['delete_selected_bed']))
	{		
		if(!empty($_REQUEST['id']))
		foreach($_REQUEST['id'] as $id)
		{
			$result=$obj_hostel->smgt_delete_bed($id);
		}
		if($result)
		{
			wp_redirect ( admin_url().'admin.php?page=smgt_hostel&tab=bed_list&message=9');
		}
	}
//---------- Assign Beds -------------------
	if(isset($_POST['assign_room']))
	{
		$nonce = $_POST['_wpnonce'];
		if ( wp_verify_nonce( $nonce, 'save_assign_room_admin_nonce' ) )
		{
			$result=$obj_hostel->smgt_assign_room($_POST);
			if($result)
			{
				wp_redirect ( admin_url().'admin.php?page=smgt_hostel&tab=room_list&message=11');
			}
		} 
	}	
	//--------- delete Assign BED --------------------
	 
	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete_assign_bed')
	{
		$result=$obj_hostel->smgt_delete_assigned_bed($_REQUEST['room_id'],$_REQUEST['bed_id'],$_REQUEST['student_id']);
		if($result)
		{
			wp_redirect ( admin_url().'admin.php?page=smgt_hostel&tab=room_list&message=12');
		}
	}
$active_tab = isset($_GET['tab'])?$_GET['tab']:'hostel_list';

?>
<div class="page-inner">
<div class="page-title">
		<h3><img src="<?php echo get_option( 'smgt_school_logo' ) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo get_option( 'smgt_school_name' );?></h3>
	</div>
<div id="main-wrapper"  class=" class_list"> 
<?php
	$message = isset($_REQUEST['message'])?$_REQUEST['message']:'0';
	switch($message)
	{
		case '1':
			$message_string = __('Hostel Added Successfully.','school-mgt');
			break;
		case '2':
			$message_string = __('Hostel Updated Successfully.','school-mgt');
			break;	
		case '3':
			$message_string = __('Hostel Deleted Successfully.','school-mgt');
			break;
		case '4':
			$message_string = __('Room Added Successfully.','school-mgt');
			break;
		case '5':
			$message_string = __('Room Updated Successfully.','school-mgt');
			break;	
		case '6':
			$message_string = __('Room Deleted Successfully.','school-mgt');
			break;
		case '7':
			$message_string = __('Bed Added Successfully.','school-mgt');
			break;
		case '8':
			$message_string = __('Bed Updated Successfully.','school-mgt');
			break;	
		case '9':
			$message_string = __('Bed Deleted Successfully.','school-mgt');
			break;
		case '10':
			$message_string = __('This room has no extra bed capacity','school-mgt');
			break;
		case '11':
			$message_string = __('Room Assign Successfully','school-mgt');
			break;
		case '12':
			$message_string = __('Assigned Bed Deleted Successfully.','school-mgt');
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
    	<a href="?page=smgt_hostel&tab=hostel_list" class="nav-tab margin_bottom <?php echo $active_tab == 'hostel_list' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-menu"></span>'.__('Hostel List', 'school-mgt'); ?></a>
         <?php if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
		{?>
       <a href="?page=smgt_hostel&tab=add_hostel&action=edit&hostel_id=<?php echo $_REQUEST['hostel_id'];?>" class="nav-tab margin_bottom <?php echo $active_tab == 'add_hostel' ? 'nav-tab-active' : ''; ?>">
		<?php _e('Edit Hostel', 'school-mgt'); ?></a>  
		<?php 
		}
		else
		{?>
    	<a href="?page=smgt_hostel&tab=add_hostel" class="nav-tab margin_bottom <?php echo $active_tab == 'add_hostel' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-plus-alt"></span>'.__('Add Hostel', 'school-mgt'); ?></a>  
        <?php } ?>
		<a href="?page=smgt_hostel&tab=room_list" class="nav-tab margin_bottom <?php echo $active_tab == 'room_list' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-menu"></span>'.__('Room List', 'school-mgt'); ?></a>
		<?php if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'view_assign_room')
		{?>
		   <a href="?page=smgt_hostel&tab=assign_room&action=view_assign_room&room_id=<?php echo $_REQUEST['room_id'];?>" class="nav-tab margin_bottom <?php echo $active_tab == 'assign_room' ? 'nav-tab-active' : ''; ?>">
			<?php _e('Assign Room', 'school-mgt'); ?></a>  
			<?php 
		}
		else
		{?>
         <?php if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit_room')
			{?>
			   <a href="?page=smgt_hostel&tab=add_room&action=edit_room&room_id=<?php echo $_REQUEST['room_id'];?>" class="nav-tab margin_bottom <?php echo $active_tab == 'add_room' ? 'nav-tab-active' : ''; ?>">
				<?php _e('Edit Room', 'school-mgt'); ?></a>  
				<?php 
			}
			else
			{?>
				<a href="?page=smgt_hostel&tab=add_room" class="nav-tab margin_bottom <?php echo $active_tab == 'add_room' ? 'nav-tab-active' : ''; ?>">
				<?php echo '<span class="dashicons dashicons-plus-alt"></span>'.__('Add Room', 'school-mgt'); ?></a>  
				<?php
			} 
		}?>
		
		<a href="?page=smgt_hostel&tab=bed_list" class="nav-tab margin_bottom <?php echo $active_tab == 'bed_list' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-menu"></span>'.__('Beds List', 'school-mgt'); ?></a>
         <?php if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit_bed')
		{?>
       <a href="?page=smgt_hostel&tab=add_bed&action=edit_bed&bed_id=<?php echo $_REQUEST['bed_id'];?>" class="nav-tab margin_bottom <?php echo $active_tab == 'add_bed' ? 'nav-tab-active' : ''; ?>">
		<?php _e('Edit beds', 'school-mgt'); ?></a>  
		<?php 
		}
		else
		{?>
    	<a href="?page=smgt_hostel&tab=add_bed" class="nav-tab margin_bottom <?php echo $active_tab == 'add_bed' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-plus-alt"></span>'.__('Add Beds', 'school-mgt'); ?></a>  
        <?php } ?>
		 
    </h2>
    <?php
	
	if($active_tab == 'hostel_list')
	{	
		$retrieve_class = get_all_data($tablename);
	?>	
         <div class="panel-body">
		 <script>
jQuery(document).ready(function() {
	var table =  jQuery('#hostel_list').DataTable({
        responsive: true,
		"order": [[ 1, "asc" ]],
		"aoColumns":[	                  
	                  {"bSortable": false},	                 
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
				<table id="hostel_list" class="display" cellspacing="0" width="100%">
					<thead>
						<tr>      
							<th style="width: 20px;"><input name="select_all" value="all" id="checkbox-select-all" 
							type="checkbox" /></th>          
							<th><?php _e('Hostel Name','school-mgt');?></th>
							<th><?php _e('Hostel Type','school-mgt');?></th>
							<th><?php _e('Description','school-mgt');?></th>
							<th><?php _e('Action','school-mgt');?> </th>               
						</tr>
					</thead>
		 
					<tfoot>
						<tr>
							<th></th>
							 <th><?php _e('Hostel Name','school-mgt');?></th>
							<th><?php _e('Hostel Type','school-mgt');?></th>
							<th><?php _e('Description','school-mgt');?></th>
							<th><?php _e('Action','school-mgt');?> </th>        
						</tr>
					</tfoot>
		 
					<tbody>
					<?php 	
					foreach ($retrieve_class as $retrieved_data)
					{ 		
					 ?>
						<tr>
							<td><input type="checkbox" class="select-checkbox" name="id[]" 
							value="<?php echo $retrieved_data->id;?>"></td>
							<td><?php echo $retrieved_data->hostel_name;?></td>
							<td><?php echo $retrieved_data->hostel_type;?></td>
							<td><?php echo $retrieved_data->Description;?></td>
						   <td><a href="?page=smgt_hostel&tab=add_hostel&action=edit&hostel_id=<?php echo $retrieved_data->id;?>" class="btn btn-info"><?php _e('Edit','school-mgt');?></a>
						   <a href="?page=smgt_hostel&tab=hostel_list&action=delete&hostel_id=<?php echo $retrieved_data->id;?>" class="btn btn-danger" 
						   onclick="return confirm('<?php _e('Are you sure you want to delete this record?','school-mgt');?>');"><?php _e('Delete','school-mgt');?></a></td>
						</tr>
						<?php
					} ?>
				 
					</tbody>
			
				</table>
				<div class="print-button pull-left">
					<input id="delete_selected" type="submit" value="<?php _e('Delete Selected','school-mgt');?>" name="delete_selected" class="btn btn-danger delete_selected"/>
				</div>
			</form>
       	</div>
       </div>
     <?php 
	}
	if($active_tab == 'room_list')
	{	
		$table_name_smgt_room='smgt_room';
		$retrieve_class = get_all_data($table_name_smgt_room);
	?>	
         <div class="panel-body">
		 <script>
jQuery(document).ready(function() {
	var table =  jQuery('#room_list').DataTable({
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
   
	 $("#delete_selected_room").on('click', function()
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
				<table id="room_list" class="display" cellspacing="0" width="100%">
					<thead>
						<tr>      
							<th style="width: 20px;"><input name="select_all" value="all" id="checkbox-select-all" 
							type="checkbox" /></th>          
							<th><?php _e('Room Unique ID','school-mgt');?></th>
							<th><?php _e('Hostel Name','school-mgt');?></th>
							<th><?php _e('Room Category','school-mgt');?></th>
							<th><?php _e('Bed Capacity','school-mgt');?></th>
							<th><?php _e('Availability','school-mgt');?></th>
							<th><?php _e('Description','school-mgt');?></th>
							<th><?php _e('Action','school-mgt');?> </th>               
						</tr>
					</thead>
		 
					<tfoot>
						<tr>
							<th></th>
							<th><?php _e('Room Unique ID','school-mgt');?></th>
							<th><?php _e('Hostel Name','school-mgt');?></th>
							<th><?php _e('Room Category','school-mgt');?></th>
							<th><?php _e('Bed Capacity','school-mgt');?></th>
							<th><?php _e('Availability','school-mgt');?></th>
							<th><?php _e('Description','school-mgt');?></th>
							<th><?php _e('Action','school-mgt');?> </th>          
						</tr>
					</tfoot>
		 
					<tbody>
					<?php 	
					foreach ($retrieve_class as $retrieved_data)
					{ 		
					 ?>
						<tr>
							<td><input type="checkbox" class="select-checkbox" name="id[]" 
							value="<?php echo $retrieved_data->id;?>"></td>
							<td><?php echo $retrieved_data->room_unique_id;?></td>
							<td><?php echo smgt_get_hostel_name_by_id($retrieved_data->hostel_id);?></td>
							<td><?php echo get_the_title($retrieved_data->room_category);?></td>
							<td><?php echo $retrieved_data->beds_capacity;?></td>
							<?php 
								$room_cnt =smgt_hostel_room_status_check($retrieved_data->id);
								
								$bed_capacity=(int)$retrieved_data->beds_capacity;
								
								if($room_cnt >= $bed_capacity)
								{
								?> 
									<td><label style='margin: 0;line-height: 25px;background-color:red;color:white;padding:0px 10px;'><?php _e('Occupied','school-mgt');?></label></td>
								<?php
								}
								else 
								{?>
									<td><label style='margin: 0;line-height: 25px;background-color:green;color:white;padding:0px 10px;'><?php _e('Available','school-mgt');?></label></td>
								<?php 
								}
								?>
							<td><?php echo $retrieved_data->room_description;?></td>
							
						   <td>
								<a href="?page=smgt_hostel&tab=add_room&action=edit_room&room_id=<?php echo $retrieved_data->id;?>" class="btn btn-info"><?php _e('Edit','school-mgt');?></a>
								<a href="?page=smgt_hostel&tab=room_list&action=delete_room&room_id=<?php echo $retrieved_data->id;?>" class="btn btn-danger" 
								onclick="return confirm('<?php _e('Are you sure you want to delete this record?','school-mgt');?>');"><?php _e('Delete','school-mgt');?></a>
								<a href="?page=smgt_hostel&tab=assign_room&action=view_assign_room&room_id=<?php echo $retrieved_data->id;?>" class="btn btn-primary"><?php _e('View or Assign Room','school-mgt');?></a>
							</td>
						</tr>
						<?php
					}
					?>
				 
					</tbody>
			
				</table>
				<div class="print-button pull-left">
					<input id="delete_selected_room" type="submit" value="<?php _e('Delete Selected','school-mgt');?>" name="delete_selected_room" class="btn btn-danger delete_selected"/>
				</div>
			</form>
       	</div>
       </div>
     <?php 
	}
	if($active_tab == 'bed_list')
	{	
		$table_name_ssmgt_beds='smgt_beds';
		$retrieve_class = get_all_data($table_name_ssmgt_beds);
	?>	
         <div class="panel-body">
		 <script>
jQuery(document).ready(function() {
	var table =  jQuery('#bed_list').DataTable({
        responsive: true,
		"order": [[ 1, "asc" ]],
		"aoColumns":[	                  
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
   
	 $("#delete_selected_bed").on('click', function()
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
				<table id="bed_list" class="display" cellspacing="0" width="100%">
					<thead>
						<tr>      
							<th style="width: 20px;"><input name="select_all" value="all" id="checkbox-select-all" 
							type="checkbox" /></th>          
							<th><?php _e('Bed Unique ID','school-mgt');?></th>
							<th><?php _e('Room Unique ID','school-mgt');?></th>
							<th><?php _e('Availability','school-mgt');?></th>
							<th><?php _e('Description','school-mgt');?></th>
							<th><?php _e('Action','school-mgt');?> </th>               
						</tr>
					</thead>
		 
					<tfoot>
						<tr>
							<th></th>
							<th><?php _e('Bed Unique ID','school-mgt');?></th>
							<th><?php _e('Room Unique ID','school-mgt');?></th>
							<th><?php _e('Availability','school-mgt');?></th>
							<th><?php _e('Description','school-mgt');?></th>
							<th><?php _e('Action','school-mgt');?> </th>              
						</tr>
					</tfoot>
		 
					<tbody>
					<?php 	
					foreach ($retrieve_class as $retrieved_data)
					{ 		
					 ?>
						<tr>
							<td><input type="checkbox" class="select-checkbox" name="id[]" 
							value="<?php echo $retrieved_data->id;?>"></td>
							<td><?php echo $retrieved_data->bed_unique_id;?></td>
							<td><?php echo smgt_get_room_unique_id_by_id($retrieved_data->room_id);?></td>
							<?php 
							if($retrieved_data->bed_status == '0')
							{	?>
								<td><label style='margin: 0;line-height: 25px;background-color:green;color:white;padding:0px 10px;'><?php _e('Available','school-mgt');?></label></td>
								<?php 
							}
							else 
							{?>
								<td><label style='margin: 0;line-height: 25px;background-color:red;color:white;padding:0px 10px;'><?php _e('Occupied','school-mgt');?></label></td>
							<?php 
							}?>
							<td><?php echo $retrieved_data->bed_description;?></td>
							
						   <td><a href="?page=smgt_hostel&tab=add_bed&action=edit_bed&bed_id=<?php echo $retrieved_data->id;?>" class="btn btn-info"><?php _e('Edit','school-mgt');?></a>
						   <a href="?page=smgt_hostel&tab=bed_list&action=delete_bed&bed_id=<?php echo $retrieved_data->id;?>" class="btn btn-danger" 
						   onclick="return confirm('<?php _e('Are you sure you want to delete this record?','school-mgt');?>');"><?php _e('Delete','school-mgt');?></a></td>
						</tr>
						<?php
					} ?>
					</tbody>
				</table>
				<div class="print-button pull-left">
					<input id="delete_selected_bed" type="submit" value="<?php _e('Delete Selected','school-mgt');?>" name="delete_selected_bed" class="btn btn-danger delete_selected"/>
				</div>
			</form>
       	</div>
       </div>
     <?php 
	}
	if($active_tab == 'add_hostel')
	{
		require_once SMS_PLUGIN_DIR. '/admin/includes/hostel/add_hostel.php';
	
	}
	if($active_tab == 'add_room')
	{
		require_once SMS_PLUGIN_DIR. '/admin/includes/hostel/add_room.php';
		
	}
	if($active_tab == 'add_bed')
	{
		require_once SMS_PLUGIN_DIR. '/admin/includes/hostel/add_bed.php';
	}
	if($active_tab == 'assign_room')
	{
		require_once SMS_PLUGIN_DIR. '/admin/includes/hostel/assign_room.php';
	}
	?>
	 		</div>
	 	</div>
	 </div>
</div>
