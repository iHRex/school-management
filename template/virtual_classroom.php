<?php 
$obj_virtual_classroom = new smgt_virtual_classroom;
//-------- CHECK BROWSER JAVA SCRIPT ----------//
MJ_smgt_browser_javascript_check();
$active_tab = isset($_GET['tab'])?$_GET['tab']:'meeting_list';
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
// EDIT MEETING IN ZOOM
if(isset($_POST['edit_meeting']))
{
	$nonce = $_POST['_wpnonce'];
	if ( wp_verify_nonce( $nonce, 'edit_meeting_nonce' ) )
	{
		$result = $obj_virtual_classroom->smgt_create_meeting_in_zoom($_POST);
		if($result)
		{
			wp_redirect ( home_url().'?dashboard=user&page=virtual_classroom&tab=meeting_list&message=2');
		}		
	}
}
// DELETE STUDENT IN ZOOM
if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
{
	$result= $obj_virtual_classroom->smgt_delete_meeting_in_zoom($_REQUEST['meeting_id']);
	if($result)
	{
		wp_redirect ( home_url().'?dashboard=user&page=virtual_classroom&tab=meeting_list&message=3');
	}
}
?>
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
	                  {"bSortable": false}],
	language:<?php echo smgt_datatable_multi_language();?>		
       });	

    $('#meeting_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1}); 
    $("#start_date").datepicker({
        dateFormat: "yy-mm-dd",
		minDate:0,
        onSelect: function (selected) {
            var dt = new Date(selected);
            dt.setDate(dt.getDate() + 0);
            $("#end_date").datepicker("option", "minDate", dt);
        }
    });
    $("#end_date").datepicker({
       dateFormat: "yy-mm-dd",
	   minDate:0,
        onSelect: function (selected) {
            var dt = new Date(selected);
            dt.setDate(dt.getDate() + 0);
            $("#start_date").datepicker("option", "maxDate", dt);
        }
    });
   });  
</script>
<!-- Nav tabs -->
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
}
if($message)
{ ?>
	<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		</button>
		<?php echo $message_string;?>
	</div>
<?php 
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
<div class="panel-body panel-white">
	<ul class="nav nav-tabs panel_tabs" role="tablist">
		<li class=" <?php echo $active_tab == 'meeting_list' ? 'active' : ''; ?>">
			<a href="?dashboard=user&page=virtual_classroom&tab=meeting_list" class="nav-tab2"> <strong>
				<i class="fa fa-align-justify"> </i> <?php _e('Virtual Class List', 'school-mgt'); ?></strong>
			</a>
		</li>
		<?php
	    if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
		{?>
	     	<li class=" <?php echo $active_tab == 'edit_meeting' ? 'active' : ''; ?>">
			<a href="?dashboard=user&page=virtual_classroom&tab=edit_meeting" class="nav-tab2"> <strong>
				<i class="fa fa-align-justify"> </i> <?php _e('Edit Virtual Class', 'school-mgt'); ?></strong>
			</a>
			</li> 
		<?php 
		}
		if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'view')
		{?>
	     	<li class=" <?php echo $active_tab == 'view_past_participle_list' ? 'active' : ''; ?>">
			<a href="?dashboard=user&page=virtual_classroom&tab=view_past_participle_list" class="nav-tab2"> <strong>
				<i class="fa fa-align-justify"> </i> <?php _e('View Past Participle List', 'school-mgt'); ?></strong>
			</a>
			</li> 
		<?php 
		}
		?>
	</ul>
	<!-- Tab panes -->
	<?php
	if($active_tab == 'meeting_list')
	{
		$user_id=get_current_user_id();
		//------- MEETING DATA FOR TEACHER ---------//
		if($school_obj->role == 'teacher')
		{
			
		}
		//------- MEETING DATA FOR STUDENT ---------//
		elseif($school_obj->role == 'student')
		{
			$class_id = get_user_meta(get_current_user_id(),'class_name',true);
			$section_id = get_user_meta(get_current_user_id(),'class_section',true);
			if($section_id)
			{
				$meeting_list_data = $obj_virtual_classroom->smgt_get_meeting_by_class_id_and_section_id_data_in_zoom($class_id,$section_id);
			}
			else
			{
				$meeting_list_data = $obj_virtual_classroom->smgt_get_meeting_by_class_id_data_in_zoom($class_id);
			}
		}
		//------- MEETING DATA FOR SUPPORT STAFF ---------//
		else
		{
			$meeting_list_data = $obj_virtual_classroom->smgt_get_all_meeting_data_in_zoom();
		} 
		?>
		<div class="panel-body">
			<form id="frm-example" name="frm-example" method="post">
				<div class="table-responsive">
					<table id="meeting_list" class="display datatable" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th><?php _e('Subject','school-mgt');?></th>
								<th><?php _e('Class Name','school-mgt');?></th>
								<th><?php _e('Class Section','school-mgt');?></th>
								<th><?php _e('Teacher','school-mgt');?></th>
								<th><?php _e('Day','school-mgt');?></th>
								<th><?php _e('Start Time','school-mgt');?></th>
								<th><?php _e('End Time','school-mgt');?></th>
								<th ><?php _e('Topic','school-mgt');?></th>
								<th><?php _e('Action','school-mgt');?></th>
							</tr>
						</thead>
			 
						<tfoot>
							<tr>
								<th><?php _e('Subject','school-mgt');?></th>
								<th><?php _e('Class Name','school-mgt');?></th>
								<th><?php _e('Class Section','school-mgt');?></th>
								<th><?php _e('Teacher','school-mgt');?></th>
								<th><?php _e('Day','school-mgt');?></th>
								<th><?php _e('Start Time','school-mgt');?></th>
								<th><?php _e('End Time','school-mgt');?></th>
								<th ><?php _e('Topic','school-mgt');?></th>
								<th><?php _e('Action','school-mgt');?></th>
							</tr>
						</tfoot>
						<tbody>
						<?php 
						if($school_obj->role == 'parent')
						{
							$chil_array =$school_obj->child_list;
							if(!empty($chil_array))
							{
								foreach($chil_array as $child_id)
								{
									$class_id = get_user_meta($child_id,'class_name',true);
									$section_id = get_user_meta($child_id,'class_section',true);
									if($section_id)
									{
										$meeting_list_data = $obj_virtual_classroom->smgt_get_meeting_by_class_id_and_section_id_data_in_zoom($class_id,$section_id);
									}
									else
									{
										$meeting_list_data = $obj_virtual_classroom->smgt_get_meeting_by_class_id_data_in_zoom($class_id);
									}
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
											<td><?php $subid=$retrieved_data->subject_id;
												echo get_single_subject_name($subid);
											?></td>
											<td><?php $cid=$retrieved_data->class_id;
												echo  $clasname=get_class_name($cid);
											?></td>
											<td><?php if($retrieved_data->section_id!=0){ echo smgt_get_section_name($retrieved_data->section_id); }else { _e('No Section','school-mgt');}?></td>
											<td><?php echo get_teacher($retrieved_data->teacher_id); ?></td>
											<td><?php echo $day; ?></td>
											<td><?php echo smgt_getdate_in_input_box($retrieved_data->start_date.' : '.$start_time);
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
											<a href="<?php echo $retrieved_data->meeting_join_link;?>" class="btn btn-success" target="_blank"><i class="fa fa-video-camera" aria-hidden="true"></i> <?php _e('Join Virtual Class','school-mgt');?> </a>
											</td>
										</tr>
									<?php 
									}
								}
							}
						}
						elseif ($school_obj->role == 'teacher')
						{
							$retrieve_class = get_allclass();
							foreach ($retrieve_class as $data)
							{
								$meeting_list_data = $obj_virtual_classroom->smgt_get_meeting_by_class_id_data_in_zoom($data['class_id']);
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
										<td><?php $subid=$retrieved_data->subject_id;
											echo get_single_subject_name($subid);
										?></td>
										<td><?php $cid=$retrieved_data->class_id;
											echo  $clasname=get_class_name($cid);
										?></td>
										<td><?php if($retrieved_data->section_id!=0){ echo smgt_get_section_name($retrieved_data->section_id); }else { _e('No Section','school-mgt');}?></td>
										<td><?php echo get_teacher($retrieved_data->teacher_id); ?></td>
										<td><?php echo $day; ?></td>
										<td><?php echo smgt_getdate_in_input_box($retrieved_data->start_date.' : '.$start_time);
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
										<?php if ($school_obj->role == 'teacher' OR $school_obj->role == 'supportstaff')
										{
										?>
											<a href="" class="btn btn-default show-popup" meeting_id="<?php echo $retrieved_data->meeting_id; ?>"><i class="fa fa-eye"></i> <?php _e('View','school-mgt');?></a>
											<a href="<?php echo $retrieved_data->meeting_start_link;?>" class="btn btn-primary" target="_blank"><i class="fa fa-video-camera" aria-hidden="true"></i> <?php _e('Start Virtual Class','school-mgt');?> </a> 
											<a href="?dashboard=user&page=virtual_classroom&tab=view_past_participle_list&action=view&meeting_uuid=<?php echo $retrieved_data->uuid;?>" class="btn btn-success"><i class="fa fa-video-camera" aria-hidden="true"></i> <?php _e('View Past Participle List','school-mgt');?> </a>
										<?php
										}
										elseif ($school_obj->role == 'student')
										{
										?> 
										<a href="<?php echo $retrieved_data->meeting_join_link;?>" class="btn btn-success" target="_blank"><i class="fa fa-video-camera" aria-hidden="true"></i> <?php _e('Meeting Join Link','school-mgt');?> </a>
										<?php 
										}
										if($user_access['edit']=='1')
										{
										?>
											<a href="?dashboard=user&page=virtual_classroom&tab=edit_meeting&action=edit&meeting_id=<?php echo $retrieved_data->meeting_id;?>" class="btn btn-info"><?php _e('Edit','school-mgt');?> </a>
										<?php
										}
										if($user_access['delete']=='1')
										{
										?>
											<a href="?dashboard=user&page=virtual_classroom&tab=meeting_list&action=delete&meeting_id=<?php echo $retrieved_data->meeting_id;?>" class="btn btn-danger" onclick="return confirm('<?php _e('Are you sure you want to delete this record?','school-mgt');?>');"> <?php _e('Delete','school-mgt');?></a>
										<?php
										}
										?> 
										</td>
									</tr>
								<?php 
								}
							}
						}
						else
						{
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
									<td><?php $subid=$retrieved_data->subject_id;
										echo get_single_subject_name($subid);
									?></td>
									<td><?php $cid=$retrieved_data->class_id;
										echo  $clasname=get_class_name($cid);
									?></td>
									<td><?php if($retrieved_data->section_id!=0){ echo smgt_get_section_name($retrieved_data->section_id); }else { _e('No Section','school-mgt');}?></td>
									<td><?php echo get_teacher($retrieved_data->teacher_id); ?></td>
									<td><?php echo $day; ?></td>
									<td><?php echo smgt_getdate_in_input_box($retrieved_data->start_date.' : '.$start_time);
									?></td>
									<td><?php echo smgt_getdate_in_input_box($retrieved_data->end_date).' : '.$end_time;
									?></td>
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
									<!-- <td><?php echo $start_time;?></td>
									<td><?php echo $end_time;?></td> -->
									<td>
									<?php if ($school_obj->role == 'teacher' OR $school_obj->role == 'supportstaff')
									{
									?>
										<a href="<?php echo $retrieved_data->meeting_start_link;?>" class="btn btn-primary" target="_blank"><i class="fa fa-video-camera" aria-hidden="true"></i> <?php _e('Start Virtual Class','school-mgt');?> </a>
										<a href="?dashboard=user&page=virtual_classroom&tab=view_past_participle_list&action=view&meeting_uuid=<?php echo $retrieved_data->uuid;?>" class="btn btn-success"><?php _e('View Past Participle List','school-mgt');?> </a>
									<?php
									}
									elseif ($school_obj->role == 'student')
									{
									?> 
									<a href="<?php echo $retrieved_data->meeting_join_link;?>" class="btn btn-success" target="_blank"><i class="fa fa-video-camera" aria-hidden="true"></i> <?php _e('Meeting&nbsp;&nbsp;Join Link','school-mgt');?> </a>
									<?php 
									}
									if($user_access['edit']=='1')
									{
									?>
										<a href="?dashboard=user&page=virtual_classroom&tab=edit_meeting&action=edit&meeting_id=<?php echo $retrieved_data->meeting_id;?>" class="btn btn-info"><?php _e('Edit','school-mgt');?> </a>
									<?php
									}
									if($user_access['delete']=='1')
									{
									?>
										<a href="?dashboard=user&page=virtual_classroom&tab=meeting_list&action=delete&meeting_id=<?php echo $retrieved_data->meeting_id;?>" class="btn btn-danger" onclick="return confirm('<?php _e('Are you sure you want to delete this record?','school-mgt');?>');"> <?php _e('Delete','school-mgt');?></a>
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
	elseif($active_tab == 'edit_meeting')
	{
		$meeting_data = $obj_virtual_classroom->smgt_get_singal_meeting_data_in_zoom($_REQUEST['meeting_id']);
		$route_data = get_route_by_id($meeting_data->route_id);
		$start_time_data = explode(":", $route_data->start_time);
		$end_time_data = explode(":", $route_data->end_time);
		if ($start_time_data[1] == 0 OR $end_time_data[1] == 0)
		{
			$start_time_minit = '00';
			$end_time_minit = '00';
		}
		else
		{
			$start_time_minit = $start_time_data[1];
			$end_time_minit = $end_time_data[1];
		}
		$start_time  = date("H:i A", strtotime("$start_time_data[0]:$start_time_minit $start_time_data[2]"));
		$end_time  = date("H:i A", strtotime("$end_time_data[0]:$end_time_minit $end_time_data[2]"));
	?>
		<div class="panel-body">   
	        <form name="route_form" action="" method="post" class="form-horizontal" id="meeting_form">
	        <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
			<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">
			<input type="hidden" name="meeting_id" value="<?php echo $_REQUEST['meeting_id'];?>">
			<input type="hidden" name="route_id" value="<?php echo $meeting_data->route_id;?>">
			<input type="hidden" name="class_id" value="<?php echo $route_data->class_id;?>">
			<input type="hidden" name="subject_id" value="<?php echo $route_data->subject_id;?>">
			<input type="hidden" name="class_section_id" value="<?php echo $route_data->section_name;?>">
			<input type="hidden" name="duration" value="<?php echo $meeting_data->duration;?>">
			<input type="hidden" name="weekday" value="<?php echo $route_data->weekday;?>">
			<input type="hidden" name="start_time" value="<?php echo $start_time;?>">
			<input type="hidden" name="end_time" value="<?php echo $end_time;?>">
			<input type="hidden" name="teacher_id" value="<?php echo $route_data->teacher_id;?>">
			<input type="hidden" name="zoom_meeting_id" value="<?php echo $meeting_data->zoom_meeting_id;?>">
			<input type="hidden" name="uuid" value="<?php echo $meeting_data->uuid;?>">
			<input type="hidden" name="meeting_join_link" value="<?php echo $meeting_data->meeting_join_link;?>">
			<input type="hidden" name="meeting_start_link" value="<?php echo $meeting_data->meeting_start_link;?>">
	        <div class="form-group">
				<label class="col-sm-2 control-label" for="class_name"><?php _e('Class Name','school-mgt');?></label>
				<div class="col-sm-8">
					<input id="class_name" class="form-control" maxlength="50" type="text" value="<?php echo get_class_name($route_data->class_id); ?>" name="class_name" disabled>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="class_section"><?php _e('Class Section','school-mgt');?></label>
				<div class="col-sm-8">
					<input id="class_section" class="form-control" maxlength="50" type="text" value="<?php echo smgt_get_section_name($route_data->section_id); ?>" name="class_section" disabled>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="Subject"><?php _e('Subject','school-mgt');?></label>
				<div class="col-sm-8">
					<input id="subject" class="form-control" type="text" value="<?php echo get_single_subject_name($route_data->subject_id); ?>" name="class_section" disabled>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="start_time"><?php _e('Start Time','school-mgt');?></label>
				<div class="col-sm-8">
					<input id="start_time" class="form-control" type="text" value="<?php echo $start_time; ?>" name="start_time" disabled>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="end_time"><?php _e('End Time','school-mgt');?></label>
				<div class="col-sm-8">
					<input id="end_time" class="form-control" type="text" value="<?php echo $end_time; ?>" name="end_time" disabled>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="start_date"><?php _e('Start Date','school-mgt');?><span class="require-field">*</span></label>
				<div class="col-sm-8">
					<input id="start_date" class="datepicker form-control validate[required] text-input" type="text" placeholder="<?php esc_html_e('Enter Start Date','school-mgt');?>" name="start_date" value="<?php echo date("Y-m-d",strtotime($meeting_data->start_date)); ?>" readonly>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="end_date"><?php _e('End Date','school-mgt');?><span class="require-field">*</span></label>
				<div class="col-sm-8">
					<input id="end_date" class="datepicker form-control validate[required] text-input" type="text" placeholder="<?php esc_html_e('Enter Exam Date','school-mgt');?>" name="end_date" value="<?php echo date("Y-m-d",strtotime($meeting_data->end_date)); ?>" readonly>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label" for="agenda"><?php _e('Topic','school-mgt');?></label>
				<div class="col-sm-8">
					<textarea name="agenda" class="form-control validate[custom[address_description_validation]]" placeholder="<?php esc_html_e('Enter Agenda','school-mgt');?>" maxlength="250" id=""><?php echo $meeting_data->agenda; ?></textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="title"><?php _e('Password','school-mgt');?></label>
				<div class="col-sm-8">
					<input id="password" class="form-control validate[minSize[8],maxSize[12]]" type="password" value="<?php echo $meeting_data->password; ?>" name="password">
				</div>
			</div>
			<?php wp_nonce_field( 'edit_meeting_nonce' ); ?>
			<div class="col-sm-offset-2 col-sm-8">        	
	        	<input type="submit" value="<?php _e('Save Meeting','school-mgt'); ?>" name="edit_meeting" class="btn btn-success" />
	        </div>        
	     	</form>
	    </div>
	<?php
	}
	elseif($active_tab == 'view_past_participle_list')
	{
		$past_participle_list = $obj_virtual_classroom->smgt_view_past_participle_list_in_zoom($_REQUEST['meeting_uuid']);
	?>
	<script type="text/javascript">
	$(document).ready(function() {
		var table =  jQuery('#past_participle_list').DataTable({
		responsive: true,
		 'order': [1, 'asc'],
		dom: 'lBfrtip',
		buttons: [
		{
			extend: 'print',
			text:'<?php _e("Print","school-mgt");?>',
			title: '<?php _e("Past Participle List","school-mgt");?>',
		}],
		"aoColumns":[
              {"bSortable": true},
              {"bSortable": true},
		    ],
		language:<?php echo smgt_datatable_multi_language();?>		
	       });	
	   });  
	</script>
	<div class="panel-body">
		<form id="frm-example" name="frm-example" method="post">
			<div class="table-responsive">
				<table id="past_participle_list" class="display datatable" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th><?php _e('Name','school-mgt');?></th>
							<th><?php _e('Email','school-mgt');?></th>
						</tr>
					</thead>
		 
					<tfoot>
						<tr>
							<th><?php _e('Name','school-mgt');?></th>
							<th><?php _e('Email','school-mgt');?></th>
						</tr>
					</tfoot>
					<tbody>
					<?php 
					foreach ($past_participle_list->participants as $retrieved_data)
					{
					?>
						<tr>
							<td><?php echo $retrieved_data->name;?></td>
							<td><?php echo $retrieved_data->user_email;?></td>
						</tr>
					<?php 
					}
					?>
					</tbody>
				</table>
			</div>
		</form>
	</div>
	<?php
	}
	?>
</div>