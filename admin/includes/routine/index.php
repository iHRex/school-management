<?php 
$obj_route = new Class_routine();	
$obj_virtual_classroom = new smgt_virtual_classroom();	
if(isset($_POST['save_route']))
{
	$nonce = $_POST['_wpnonce'];
	if ( wp_verify_nonce( $nonce, 'save_root_admin_nonce' ) )
	{
		$teacherid = get_teacherid_by_subjectid($_POST['subject_id']);
		foreach($teacherid as $teacher_id)
		{
			$route_data=array('subject_id'=>MJ_smgt_onlyNumberSp_validation($_POST['subject_id']),
					'class_id'=>MJ_smgt_onlyNumberSp_validation($_POST['class_id']),
					'section_name'=>MJ_smgt_onlyNumberSp_validation($_POST['class_section']),
					'teacher_id'=>$teacher_id,
					'start_time'=>$_POST['start_time'].':'.$_POST['start_min'].':'.$_POST['start_ampm'],
					'end_time'=>MJ_smgt_onlyNumberSp_validation($_POST['end_time']).':'.MJ_smgt_onlyNumberSp_validation($_POST['end_min']).':'.MJ_smgt_onlyLetterSp_validation($_POST['end_ampm']),
					'weekday'=>MJ_smgt_onlyNumberSp_validation($_POST['weekday'])
			);
	 
			if($_REQUEST['action']=='edit')
			{
				$route_id=array('route_id'=>$_REQUEST['route_id']); 
				$obj_route->update_route($route_data,$route_id); 
				wp_redirect ( admin_url().'admin.php?page=smgt_route&tab=route_list&message=2');
				exit;
				// $message="Update Route Successfully";
			}
			else
			{
				$retuen_val = $obj_route->is_route_exist($route_data);
				
				if($retuen_val == 'success')
				{
					$obj_route->save_route($route_data);
					wp_redirect ( admin_url().'admin.php?page=smgt_route&tab=route_list&message=1');
					exit;
					// $message= __('Add Routine Successfully','school-mgt');
				}
				elseif($retuen_val == 'duplicate')
				{       
					wp_redirect ( admin_url().'admin.php?page=smgt_route&tab=route_list&message=4');
					exit;
				}
				elseif($retuen_val == 'teacher_duplicate')
				{
					wp_redirect ( admin_url().'admin.php?page=smgt_route&tab=route_list&message=5');
					exit;
				}                
			} 
		}
	}
}
if(isset($_POST['create_meeting']))
{
	$nonce = $_POST['_wpnonce'];
	if ( wp_verify_nonce( $nonce, 'create_meeting_admin_nonce' ) )
	{
		
		$result = $obj_virtual_classroom->smgt_create_meeting_in_zoom($_POST);
		if($result)
		{
			wp_redirect ( admin_url().'admin.php?page=smgt_virtual_classroom&tab=meeting_list&message=1');
		}
			
	}
}
if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete')
{
	$tablenm = "smgt_time_table";
	$result=delete_route($tablenm,$_REQUEST['route_id']);
	if($result)
	{
		wp_redirect ( admin_url().'admin.php?page=smgt_route&tab=route_list&message=3');
		exit;
	}
} ?>				
<div class="popup-bg">
    <div class="overlay-content">
		<a href="#" class="close-btn">X</a>
		<div class="edit_perent"></div>
		<div class="view-parent"></div>
		<a href="#" class="close-btn"><?php _e('Close','school-mgt');?></a>
    </div>   
</div>
<div class="popup-bg">
    <div class="overlay-content">
		<div class="create_meeting_popup"></div>
    </div>   
</div>
<?php $active_tab = isset($_GET['tab'])?$_GET['tab']:'route_list';	?>
<div class="page-inner">
	<div class="page-title">
		<h3><img src="<?php echo get_option( 'smgt_school_logo' ) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo get_option( 'smgt_school_name' );?></h3>
	</div>
<div id="main-wrapper" class="grade_page">
<?php
	$message = isset($_REQUEST['message'])?$_REQUEST['message']:'0';
	switch($message)
	{
		case '1':
			$message_string = __('Routine Added Successfully.','school-mgt');
			break;
		case '2':
			$message_string = __('Routine Updated Successfully.','school-mgt');
			break;		
		case '3':
			$message_string = __('Routine Deleted Successfully.','school-mgt');
			break;			
		case '4':
			$message_string = __('Routine Alredy Added For This Time Period.Please Try Again.','school-mgt');
			break;			
		case '5':
			$message_string = __('Teacher Is Not Available.','school-mgt');
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
<div class=" class_list">  
	<h2 class="nav-tab-wrapper">
    	<a href="?page=smgt_route&tab=route_list" class="nav-tab <?php echo $active_tab == 'route_list' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-menu"></span>'.__('Route List', 'school-mgt'); ?></a>
         <?php if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
		{ ?>
       <a href="?page=smgt_route&tab=addroute&action=edit&route_id=<?php echo $_REQUEST['route_id'];?>" class="nav-tab <?php echo $active_tab == 'addroute' ? 'nav-tab-active' : ''; ?>">
		<?php _e('Edit Route', 'school-mgt'); ?></a>  
		<?php 
		}
		else
		{?>
    	<a href="?page=smgt_route&tab=addroute" class="nav-tab <?php echo $active_tab == 'addroute' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-plus-alt"></span>'.__('Add Route', 'school-mgt'); ?></a>  
        <?php } ?>
        <a href="?page=smgt_route&tab=teacher_timetable" class="nav-tab margin_bottom <?php echo $active_tab == 'teacher_timetable' ? 'nav-tab-active' : ''; ?>">
        <?php echo '<span class="dashicons dashicons-calendar-alt"></span>'.__('Teacher Time Table','school-mgt');?>
        </a>
    </h2>
    <?php	
	if($active_tab == 'route_list')
	{	
	?>	
    <div class="panel panel-white">         
    <div class="panel-body">
        <div id="accordion" class="panel-group" aria-multiselectable="true" role="tablist">
        <?php
		$retrieve_class = get_all_data('smgt_class');		
		$i=0;
		if(!empty($retrieve_class))
		{
			foreach($retrieve_class as $class)
			{
				if(!empty($class))
				{	 ?>
					<div class="panel panel-default">
					<div id="heading_<?php echo $i;?>" class="panel-heading" role="tab">
						<h4 class="panel-title">
							<a class="collapsed" aria-controls="collapse_<?php echo $i;?>" aria-expanded="false" href="#collapse_<?php echo $i;?>" data-parent="#accordion" data-toggle="collapse">
							<?php _e('Class', 'school-mgt'); ?> : <?php echo $class->class_name; ?> </a>				
						</h4>
					</div>
					<div id="collapse_<?php echo $i;?>" class="panel-collapse collapse" aria-labelledby="heading_<?php echo $i;?>" role="tabpanel" aria-expanded="false" style="height: 0px;">
					  <div class="panel-body">
					<table class="table table-bordered">
					<?php			
					$sectionid=0;
					foreach(sgmt_day_list() as $daykey => $dayname)
					{ ?>
					<tr>
						<th width="100"><?php echo $dayname;?></th>
						<td>
						<?php
							$period = $obj_route->get_periad($class->class_id,$sectionid,$daykey);
							if(!empty($period))
								foreach($period as $period_data)
								{
									echo '<div class="btn-group m-b-sm">';
									echo '<button class="btn btn-primary dropdown-toggle" aria-expanded="false" data-toggle="dropdown"><span class="period_box" id='.$period_data->route_id.'>'.get_single_subject_name($period_data->subject_id);
									$start_time_data = explode(":", $period_data->start_time);
									$start_hour=str_pad($start_time_data[0],2,"0",STR_PAD_LEFT);
									$start_min=str_pad($start_time_data[1],2,"0",STR_PAD_LEFT);
									$start_am_pm=$start_time_data[2];
									
									$end_time_data = explode(":", $period_data->end_time);
									$end_hour=str_pad($end_time_data[0],2,"0",STR_PAD_LEFT);
									$end_min=str_pad($end_time_data[1],2,"0",STR_PAD_LEFT);
									$end_am_pm=$end_time_data[2];
									echo '<span class="time"> ('.$start_hour.':'.$start_min.' '.$start_am_pm.' - '.$end_hour.':'.$end_min.' '.$end_am_pm.') </span>';
									$create_meeting = '';
									$update_meeting = '';
									$delete_meeting = '';
									$meeting_statrt_link = '';
									if (get_option('smgt_enable_virtual_classroom') == 'yes')
									{
										$meeting_data = $obj_virtual_classroom->smgt_get_singal_meeting_by_route_data_in_zoom($period_data->route_id);
										if(empty($meeting_data))
										{
											$create_meeting = '<li><a href="#" id="'.$period_data->route_id.'" class="show-popup">'.__('Create Virtual Class','school-mgt').'</a></li>';
										}
										else
										{
											$create_meeting = '';
										}

										if(!empty($meeting_data))
										{
											$update_meeting = '<li><a href="admin.php?page=smgt_virtual_classroom&tab=edit_meeting&action=edit&meeting_id='.$meeting_data->meeting_id.'">'.__('Edit Virtual Class','school-mgt').'</a></li>';
											$delete_meeting = '<li><a href="admin.php?page=smgt_virtual_classroom&tab=meeting_list&action=delete&meeting_id='.$meeting_data->meeting_id.'" onclick="return confirm(\''.__( 'Are you sure you want to delete this record?', 'school-mgt' ).'\');">'.__('Delete Virtual Class','school-mgt').'</a></li>';
											$meeting_statrt_link = '<li><a href="'.$meeting_data->meeting_start_link.'" target="_blank">'.__('Virtual Class Start','school-mgt').'</a></li>';
										}
										else
										{
											$update_meeting = '';
											$delete_meeting = '';
											$meeting_statrt_link = '';
										}
									}
									//echo '<span class="time"> ('.$period_data->start_time.'- '.$period_data->end_time.') </span>';
									echo '</span><span class="caret"></span></button>';
									echo '<ul role="menu" class="dropdown-menu">
											<li><a href="?page=smgt_route&tab=addroute&action=edit&route_id='.$period_data->route_id.'">'.__('Edit Route','school-mgt').'</a></li>
											<li><a href="?page=smgt_route&tab=route_list&action=delete&route_id='.$period_data->route_id.'">'.__('Delete Route','school-mgt').'</a></li>'.$create_meeting .''.$update_meeting.''.$delete_meeting.''.$meeting_statrt_link.'
										</ul>';
									echo '</div>';							
								}
							 ?>
						</td>
					</tr>
					<?php	
					}
					?>
					</table> 
					</div>
					</div>
				</div>
				<?php
				}
				$sectionname="";
				$sectionid="";
				$class_sectionsdata=smgt_get_class_sections($class->class_id);
				if(!empty($class_sectionsdata))
				{				
					foreach($class_sectionsdata as $section)
					{ 
						$i++;
						$sectionname=$section->section_name;
						$sectionid=$section->id;
						?>
						<div class="panel panel-default">
						<div id="heading_<?php echo $i;?>" class="panel-heading" role="tab">
						<h4 class="panel-title">
						<a class="collapsed" aria-controls="collapse_<?php echo $i;?>" aria-expanded="false" href="#collapse_<?php echo $i;?>" data-parent="#accordion" data-toggle="collapse">
						<?php _e('Class', 'school-mgt'); ?> : <?php echo $class->class_name; ?> &nbsp;&nbsp;&nbsp;&nbsp;
						<?php 
						if(!empty($section->section_name))
						{ ?>
						<?php _e('Section', 'school-mgt'); ?> : <?php echo $section->section_name; ?>
						<?php }
						?>
					
						</a>
						</h4>
					   </div>
					   <div id="collapse_<?php echo $i;?>" class="panel-collapse collapse" aria-labelledby="heading_<?php echo $i;?>" role="tabpanel" aria-expanded="false" style="height: 0px;">
					   <div class="panel-body">
					   <table class="table table-bordered">
					<?php
						foreach(sgmt_day_list() as $daykey => $dayname)
						{ ?>
							<tr>
								<th width="100"><?php echo $dayname;?></th>
								<td>
									<?php
									$period = $obj_route->get_periad($class->class_id,$section->id,$daykey);				
									if(!empty($period))
									foreach($period as $period_data)
									{
										echo '<div class="btn-group m-b-sm">';
										echo '<button class="btn btn-primary dropdown-toggle" aria-expanded="false" data-toggle="dropdown"><span class="period_box" id='.$period_data->route_id.'>'.get_single_subject_name($period_data->subject_id);
										
										$start_time_data = explode(":", $period_data->start_time);
										$start_hour=str_pad($start_time_data[0],2,"0",STR_PAD_LEFT);
										$start_min=str_pad($start_time_data[1],2,"0",STR_PAD_LEFT);
										$start_am_pm=$start_time_data[2];
										
										$end_time_data = explode(":", $period_data->end_time);
										$end_hour=str_pad($end_time_data[0],2,"0",STR_PAD_LEFT);
										$end_min=str_pad($end_time_data[1],2,"0",STR_PAD_LEFT);
										$end_am_pm=$end_time_data[2];
										if (get_option('smgt_enable_virtual_classroom') == 'yes')
										{
											$meeting_data = $obj_virtual_classroom->smgt_get_singal_meeting_by_route_data_in_zoom($period_data->route_id);
											if(empty($meeting_data))
											{
												$create_meeting = '<li><a href="#" id="'.$period_data->route_id.'" class="show-popup">'.__('Create Virtual Class','school-mgt').'</a></li>';
											}
											else
											{
												$create_meeting = '';
											}

											if(!empty($meeting_data))
											{
												$update_meeting = '<li><a href="admin.php?page=smgt_virtual_classroom&tab=edit_meeting&action=edit&meeting_id='.$meeting_data->meeting_id.'">'.__('Edit Virtual Class','school-mgt').'</a></li>';
												$delete_meeting = '<li><a href="admin.php?page=smgt_virtual_classroom&tab=meeting_list&action=delete&meeting_id='.$meeting_data->meeting_id.'" onclick="return confirm(\''.__( 'Are you sure you want to delete this record?', 'school-mgt' ).'\');">'.__('Delete Virtual Class','school-mgt').'</a></li>';
												$meeting_statrt_link = '<li><a href="'.$meeting_data->meeting_start_link.'" target="_blank">'.__('Start Virtual Class','school-mgt').'</a></li>';
											}
											else
											{
												$update_meeting = '';
												$delete_meeting = '';
												$meeting_statrt_link = '';
											}
										}
										//echo '<span class="time"> ('.$period_data->start_time.' - '.$period_data->end_time.') </span>';
										echo '<span class="time"> ('.$start_hour.':'.$start_min.' '.$start_am_pm.' - '.$end_hour.':'.$end_min.' '.$end_am_pm.') </span>';
										echo '</span><span class="caret"></span></button>';
										echo '<ul role="menu" class="dropdown-menu edit_delete_drop ">
												<li><a href="?page=smgt_route&tab=addroute&action=edit&route_id='.$period_data->route_id.'">'.__('Edit','school-mgt').'</a></li>
												<li><a onclick="return confirm(\'Do you want to to delet route?\');" href="?page=smgt_route&tab=route_list&action=delete&route_id='.$period_data->route_id.'">'.__('Delete','school-mgt').'</a></li>
												'.$create_meeting .''.$update_meeting.''.$delete_meeting.''.$meeting_statrt_link.'
											</ul>';
										echo '</div>';							
									}
								 ?>
								</td>
							</tr>
					<?php 
						} ?>
					</table> 
					</div>
					</div>
					</div>		   
					<?php
					} 			
				}
				/* else
				{ ?>
				<div class="panel panel-default">
					<div id="heading_<?php echo $i;?>" class="panel-heading" role="tab">
						<h4 class="panel-title">
							<a class="collapsed" aria-controls="collapse_<?php echo $i;?>" aria-expanded="false" href="#collapse_<?php echo $i;?>" data-parent="#accordion" data-toggle="collapse">
							<?php _e('Class', 'school-mgt'); ?> : <?php echo $class->class_name; ?> </a>				
						</h4>
					</div>
					<div id="collapse_<?php echo $i;?>" class="panel-collapse collapse" aria-labelledby="heading_<?php echo $i;?>" role="tabpanel" aria-expanded="false" style="height: 0px;">
					  <div class="panel-body">
					<table class="table table-bordered">
					<?php			
					$sectionid=0;
					foreach(sgmt_day_list() as $daykey => $dayname)
					{ ?>
					<tr>
						<th width="100"><?php echo $dayname;?></th>
						<td>
						<?php
							$period = $obj_route->get_periad($class->class_id,$sectionid,$daykey);
							if(!empty($period))
								foreach($period as $period_data)
								{
									echo '<div class="btn-group m-b-sm">';
									echo '<button class="btn btn-primary dropdown-toggle" aria-expanded="false" data-toggle="dropdown"><span class="period_box" id='.$period_data->route_id.'>'.get_single_subject_name($period_data->subject_id);
									$start_time_data = explode(":", $period_data->start_time);
									$start_hour=str_pad($start_time_data[0],2,"0",STR_PAD_LEFT);
									$start_min=str_pad($start_time_data[1],2,"0",STR_PAD_LEFT);
									$start_am_pm=$start_time_data[2];
									
									$end_time_data = explode(":", $period_data->end_time);
									$end_hour=str_pad($end_time_data[0],2,"0",STR_PAD_LEFT);
									$end_min=str_pad($end_time_data[1],2,"0",STR_PAD_LEFT);
									$end_am_pm=$end_time_data[2];
									echo '<span class="time"> ('.$start_hour.':'.$start_min.' '.$start_am_pm.' - '.$end_hour.':'.$end_min.' '.$end_am_pm.') </span>';
									//echo '<span class="time"> ('.$period_data->start_time.'- '.$period_data->end_time.') </span>';
									echo '</span><span class="caret"></span></button>';
									echo '<ul role="menu" class="dropdown-menu">
											<li><a href="?page=smgt_route&tab=addroute&action=edit&route_id='.$period_data->route_id.'">'.__('Edit','school-mgt').'</a></li>
											<li><a href="?page=smgt_route&tab=route_list&action=delete&route_id='.$period_data->route_id.'">'.__('Delete','school-mgt').'</a></li>
										</ul>';
									echo '</div>';							
								}
							 ?>
						</td>
					</tr>
					<?php	
					}
					?>
					</table> 
					</div>
					</div>
				</div>
					
				<?php 
				} */
				$i++; 
			}
		}
		else
		{
			_e( 'Class data not avilable', 'school-mgt' );
		}
		?>
		</div>
        </div>
        </div>
       
     <?php 
		
	 }
	if($active_tab == 'addroute')
	{
		require_once SMS_PLUGIN_DIR. '/admin/includes/routine/add-route.php';		
	}
	 if($active_tab == 'teacher_timetable')
	 {
		?>
		 <div class="panel panel-white">
        	<div class="panel-heading clearfix">
				<h3 class="panel-title"><?php _e('Teacher Time Table','school-mgt');?></h3>
			</div>
		 <div class="panel-body">
		 <div id="accordion" class="panel-group" aria-multiselectable="true" role="tablist">
        <?php 
		
		$teacherdata=get_usersdata('teacher');
		if(!empty($teacherdata))
		{	
			$i=0;
			
		foreach($teacherdata as $retrieved_data)
		{ ?>
        <div class="panel panel-default">
        	<div id="heading_<?php echo $i;?>" class="panel-heading" role="tab">
				<h4 class="panel-title">
					<a class="collapsed" aria-controls="collapse_<?php echo $i;?>" aria-expanded="false" href="#collapse_<?php echo $i;?>" data-parent="#accordion" data-toggle="collapse">
					<?php _e('Teacher','school-mgt');?>: <?php echo $retrieved_data->display_name;?> </a>				
				</h4>
			</div>
			
        <div id="collapse_<?php echo $i;?>" class="panel-collapse collapse" aria-labelledby="heading_<?php echo $i;?>" role="tabpanel" aria-expanded="false" style="height: 0px;">
             <div class="panel-body">
        <table class="table table-bordered">
        <?php 
        $i++;
		foreach(sgmt_day_list() as $daykey => $dayname)
		{	?>
		<tr>
       <th width="100"><?php echo $dayname;?></th>
        <td>
        	 <?php
			 	$period = $obj_route->get_periad_by_teacher($retrieved_data->ID,$daykey);
				if(!empty($period))
					foreach($period as $period_data)
					{
						echo '<div class="btn-group m-b-sm">';
						echo '<button class="btn btn-primary dropdown-toggle" aria-expanded="false" data-toggle="dropdown"><span class="period_box" id='.$period_data->route_id.'>'.get_single_subject_name($period_data->subject_id);
						
						$start_time_data = explode(":", $period_data->start_time);
						$start_hour=str_pad($start_time_data[0],2,"0",STR_PAD_LEFT);
						$start_min=str_pad($start_time_data[1],2,"0",STR_PAD_LEFT);
						$start_am_pm=$start_time_data[2];
						
						$end_time_data = explode(":", $period_data->end_time);
						$end_hour=str_pad($end_time_data[0],2,"0",STR_PAD_LEFT);
						$end_min=str_pad($end_time_data[1],2,"0",STR_PAD_LEFT);
						$end_am_pm=$end_time_data[2];
						echo '<span class="time"> ('.$start_hour.':'.$start_min.' '.$start_am_pm.' - '.$end_hour.':'.$end_min.' '.$end_am_pm.') </span>';
						$create_meeting = '';
						$update_meeting = '';
						$delete_meeting = '';
						$meeting_statrt_link = '';
						if (get_option('smgt_enable_virtual_classroom') == 'yes')
						{
							$meeting_data = $obj_virtual_classroom->smgt_get_singal_meeting_by_route_data_in_zoom($period_data->route_id);
							if(empty($meeting_data))
							{
								$create_meeting = '<li><a href="#" id="'.$period_data->route_id.'" class="show-popup">'.__('Create Virtual Class','school-mgt').'</a></li>';
							}
							else
							{
								$create_meeting = '';
							}

							if(!empty($meeting_data))
							{
								$update_meeting = '<li><a href="admin.php?page=smgt_virtual_classroom&tab=edit_meeting&action=edit&meeting_id='.$meeting_data->meeting_id.'">'.__('Edit Virtual Class','school-mgt').'</a></li>';
								$delete_meeting = '<li><a href="admin.php?page=smgt_virtual_classroom&tab=meeting_list&action=delete&meeting_id='.$meeting_data->meeting_id.'" onclick="return confirm(\''.__( 'Are you sure you want to delete this record?', 'school-mgt' ).'\');">'.__('Delete Virtual Class','school-mgt').'</a></li>';
								$meeting_statrt_link = '<li><a href="'.$meeting_data->meeting_start_link.'" target="_blank">'.__('Virtual Class Start','school-mgt').'</a></li>';
							}
							else
							{
								$update_meeting = '';
								$delete_meeting = '';
								$meeting_statrt_link = '';
							}
						}
						echo '<span>'.get_class_name($period_data->class_id).'</span>';
						echo '</span></span><span class="caret"></span></button>';
						echo '<ul role="menu" class="dropdown-menu">
                                <li><a href="?page=smgt_route&tab=addroute&action=edit&route_id='.$period_data->route_id.'">'.__('Edit','school-mgt').'</a></li>
                                <li><a href="?page=smgt_route&tab=route_list&action=delete&route_id='.$period_data->route_id.'">'.__('Delete','school-mgt').'</a></li>
                                '.$create_meeting .''.$update_meeting.''.$delete_meeting.''.$meeting_statrt_link.'
						    </ul>';
						echo '</div>';					
					}
				?>
			</td>
        </tr>
		<?php	
		}
		?>
        </table>
         </div>
        </div>
        </div>
         
	<?php }	}
		else
		{
			_e( 'Teacher data not avilable', 'school-mgt' );
		}
		?>
	</div>
	</div>
	<?php } ?>	
</div>
</div>
</div>
</div>
</div>