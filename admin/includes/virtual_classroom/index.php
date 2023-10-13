<?php 
require_once SMS_PLUGIN_DIR. '/lib/vendor/autoload.php';
$obj_virtual_classroom = new smgt_virtual_classroom;
$active_tab = isset($_GET['tab'])?$_GET['tab']:'meeting_list';
// EDIT MEETING IN ZOOM
if(isset($_POST['edit_meeting']))
{
	$nonce = $_POST['_wpnonce'];
	if ( wp_verify_nonce( $nonce, 'edit_meeting_admin_nonce' ) )
	{
		$result = $obj_virtual_classroom->smgt_create_meeting_in_zoom($_POST);
		if($result)
		{
			wp_redirect ( admin_url().'admin.php?page=smgt_virtual_classroom&tab=meeting_list&message=2');
		}		
	}
}
// DELETE STUDENT IN ZOOM
if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
{
	$result= $obj_virtual_classroom->smgt_delete_meeting_in_zoom($_REQUEST['meeting_id']);
	if($result)
	{
		wp_redirect ( admin_url().'admin.php?page=smgt_virtual_classroom&tab=meeting_list&message=3');
	}
}
/*Delete selected Subject*/
if(isset($_REQUEST['delete_selected']))
{		
	if(!empty($_REQUEST['id']))
	{
		foreach($_REQUEST['id'] as $meeting_id)
		{
			$result= $obj_virtual_classroom->smgt_delete_meeting_in_zoom($meeting_id);
		}
	}
	if($result)
	{
		wp_redirect ( admin_url().'admin.php?page=smgt_virtual_classroom&tab=meeting_list&message=3');
	}
}
?>
<!-- POP up code -->
<div class="popup-bg">
    <div class="overlay-content">
	    <div class="modal-content">
		    <div class="view_meeting_detail_popup">
		    </div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
	var table =  jQuery('#meeting_list').DataTable({
	responsive: true,
	 'order': [1, 'asc'],
	 "aoColumns":[
	 				  {"bSortable": false},
	                  {"bSortable": true},
	                  {"bSortable": true},
	                  {"bSortable": true},
	                  {"bSortable": true},
	                  {"bSortable": true},
	                  {"bSortable": true},
	                  {"bSortable": true},
	                  {"bSortable": true},
	                  {"bSortable": true},
	                  {"bSortable": false}],
	language:<?php echo smgt_datatable_multi_language();?>	

       });	

    $('#checkbox-select-all').on('click', function(){
     
      var rows = table.rows({ 'search': 'applied' }).nodes();
      $('input[type="checkbox"]', rows).prop('checked', this.checked);
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
<!-- End POP-UP Code -->
<div class="page-inner">
	<div class="page-title">
		<h3><img src="<?php echo get_option( 'smgt_school_logo' ) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo get_option( 'smgt_school_name' );?></h3>
	</div>
	<div  id="main-wrapper" class="class_list">
	<?php
		$message = isset($_REQUEST['message'])?$_REQUEST['message']:'0';
		switch($message)
		{
			case '1':
				$message_string = __('Virtual Class Added Successfully.','school-mgt');
				break;
			case '2':
				$message_string = __('Virtual Class Updated Successfully.','school-mgt');
				break;
			case '3':
				$message_string = __('Virtual Class Deleted Successfully.','school-mgt');
				break;
			case '4':
				$message_string = __('Your Access Token Is Updated.','school-mgt');
				break;
			case '5':
				$message_string = __('Something Wrong.','school-mgt');
				break;
			case '6':
				$message_string = __('First Start Your Virtual Class.','school-mgt');
				break;
		}
		
		if($message)
		{ ?>
		<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible">
			<p><?php echo $message_string;?></p>
			<button type="button" class="notice-dismiss" data-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>
		</div>
		<?php 
		} 
		?>
		<div class="panel panel-white">
			<div class="panel-body">		
				<h2 class="nav-tab-wrapper">
			    	<a href="?page=smgt_virtual_classroom&tab=meeting_list" class="nav-tab margin_bottom <?php echo $active_tab == 'meeting_list' ? 'nav-tab-active' : ''; ?>">
					<?php echo '<span class="dashicons dashicons-menu"></span>'. __('Virtual Class List', 'school-mgt'); ?></a>
			        <?php
			        if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
					{?>
			         	<a href="?page=smgt_virtual_classroom&tab=edit_meeting&&action=edit&meeting_id=<?php echo $_REQUEST['meeting_id'];?>" class="nav-tab <?php echo $active_tab == 'edit_meeting' ? 'nav-tab-active' : ''; ?>"><?php _e('Edit Virtual Class', 'school-mgt'); ?></a>  
					<?php 
					}
					if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'view')
					{?>
			         	<a href="?page=smgt_virtual_classroom&tab=view_past_participle_list&&action=view" class="nav-tab <?php echo $active_tab == 'view_past_participle_list' ? 'nav-tab-active' : ''; ?>"><?php _e('View Past Participle List', 'school-mgt'); ?></a>  
					<?php 
					}
					?>
			    </h2>
			    <?php
				if($active_tab == 'meeting_list')
				{	
					$meeting_list_data = $obj_virtual_classroom->smgt_get_all_meeting_data_in_zoom();
				?>	
				<div class="panel-body">
					<form id="frm-example" name="frm-example" method="post">
						<div class="table-responsive">
							<table id="meeting_list" class="display datatable" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th style="width: 20px;"><input name="select_all" value="all" id="checkbox-select-all" type="checkbox" /></th>
										<th><?php _e('Subject','school-mgt');?></th>
										<th><?php _e('Class Name','school-mgt');?></th>
										<th><?php _e('Class Section','school-mgt');?></th>
										<th><?php _e('Teacher','school-mgt');?></th>
										<th><?php _e('Day','school-mgt');?></th>
										<th><?php _e('Created By','school-mgt');?></th>
										<th><?php _e('Start Time','school-mgt');?></th>
										<th><?php _e('End Time','school-mgt');?></th>
										<th ><?php _e('Topic','school-mgt');?></th>
										<th><?php _e('Action','school-mgt');?></th>
									</tr>
								</thead>
					 
								<tfoot>
									<tr>
										<th></th>
										<th><?php _e('Subject','school-mgt');?></th>
										<th><?php _e('Class Name','school-mgt');?></th>
										<th><?php _e('Class Section','school-mgt');?></th>
										<th><?php _e('Teacher','school-mgt');?></th>
										<th><?php _e('Day','school-mgt');?></th>
										<th><?php _e('Created By','school-mgt');?></th>
										<th><?php _e('Start Time','school-mgt');?></th>
										<th><?php _e('End Time','school-mgt');?></th>
										<th><?php _e('Topic','school-mgt');?></th>
										<th><?php _e('Action','school-mgt');?></th>
									</tr>
								</tfoot>
								<tbody>
								<?php 
								foreach ($meeting_list_data as $retrieved_data)
								{
									if($retrieved_data->weekday_id == '2')
									{
										$day = __('Monday','school-mgt');
									}
									elseif($retrieved_data->weekday_id == '3')
									{
										$day = __('Tuesday','school-mgt');
									}
									elseif($retrieved_data->weekday_id == '4')
									{
										$day = __('Wednesday','school-mgt');
									}
									elseif($retrieved_data->weekday_id == '5')
									{
										$day = __('Thursday','school-mgt');
									}
									elseif($retrieved_data->weekday_id == '6')
									{
										$day = __('Friday','school-mgt');
									}
									elseif($retrieved_data->weekday_id == '7')
									{
										$day = __('Saturday','school-mgt');
									}
									elseif($retrieved_data->weekday_id == '1')
									{
										$day = __('Sunday','school-mgt');
									}
									$route_data = get_route_by_id($retrieved_data->route_id);
									$stime = explode(":",$route_data->start_time);
									$start_hour=str_pad($stime[0],2,"0",STR_PAD_LEFT);
									$start_min=str_pad($stime[1],2,"0",STR_PAD_LEFT);
									$start_am_pm=$stime[2];
									$start_time = $start_hour.':'.$start_min.' '.$start_am_pm;
									$etime = explode(":",$route_data->end_time);
									$end_hour=str_pad($etime[0],2,"0",STR_PAD_LEFT);
									$end_min=str_pad($etime[1],2,"0",STR_PAD_LEFT);
									$end_am_pm=$etime[2];
									$end_time = $end_hour.':'.$end_min.' '.$end_am_pm;
								?>
									<tr>
										<td><input type="checkbox" class="select-checkbox" name="id[]" value="<?php echo $retrieved_data->meeting_id;?>"></td>
										<td><?php $subid=$retrieved_data->subject_id;
											echo get_single_subject_name($subid);
										?></td>
										<td><?php $cid=$retrieved_data->class_id;
											echo  $clasname=get_class_name($cid);
										?></td>
										<td><?php if($retrieved_data->section_id!=0){ echo smgt_get_section_name($retrieved_data->section_id); }else { _e('No Section','school-mgt');}?></td>
										<td><?php echo get_teacher($retrieved_data->teacher_id);
										?></td>
										<td><?php echo $day; ?></td>
										<td><?php echo get_display_name($retrieved_data->created_by); ?></td>
										<td><?php echo smgt_getdate_in_input_box($retrieved_data->start_date).' : '.$start_time;
										?></td>
										<td><?php echo smgt_getdate_in_input_box($retrieved_data->end_date).' : '.$end_time;
										?></td>
										<!-- <td><?php echo $start_time;?></td>
										<td><?php echo $end_time;?></td> -->
										<td>
											<?php
											if(!empty($retrieved_data->agenda))
											{
												echo $retrieved_data->agenda;
											}
											else
											{
												echo "-";
											}
											?>
										</td>
										<td>
										<a href="" class="btn btn-default show-popup" meeting_id="<?php echo $retrieved_data->meeting_id; ?>"><i class="fa fa-eye"></i> <?php _e('View','school-mgt');?></a> 
										<a href="<?php echo $retrieved_data->meeting_start_link;?>" class="btn btn-primary" target="_blank"><i class="fa fa-video-camera" aria-hidden="true"></i> <?php _e('Start Virtual Class','school-mgt');?> </a>
										<a href="?page=smgt_virtual_classroom&tab=edit_meeting&action=edit&meeting_id=<?php echo $retrieved_data->meeting_id;?>" class="btn btn-info"><?php _e('Edit','school-mgt');?> </a>
										<a href="?page=smgt_virtual_classroom&tab=meeting_list&action=delete&meeting_id=<?php echo $retrieved_data->meeting_id;?>" class="btn btn-danger" onclick="return confirm('<?php _e('Are you sure you want to delete this record?','school-mgt');?>');"> <?php _e('Delete','school-mgt');?></a>
										<a href="?page=smgt_virtual_classroom&tab=view_past_participle_list&action=view&meeting_uuid=<?php echo $retrieved_data->uuid;?>" class="btn btn-success"><?php _e('View Past Participle List','school-mgt');?> </a>
										</td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
						<div class="print-button pull-left">
							<input id="delete_selected" type="submit" value="<?php _e('Delete Selected','school-mgt');?>" name="delete_selected" class="btn btn-danger delete_selected"/>
						</div>
					</form>
		        </div>
			    <?php 
				}
				if($active_tab == 'edit_meeting')
				{
					require_once SMS_PLUGIN_DIR. '/admin/includes/virtual_classroom/edit_meeting.php';
				}
				elseif($active_tab == 'view_past_participle_list')
				{
					require_once SMS_PLUGIN_DIR. '/admin/includes/virtual_classroom/view_past_participle_list.php';
				}
				?>
		 	</div>
		</div>
	</div>
</div>
<?php ?>