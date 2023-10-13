<?php
// Schedule
$obj_route = new Class_routine ();
$obj_virtual_classroom = new smgt_virtual_classroom();
if(isset($_POST['create_meeting']))
{
	$nonce = $_POST['_wpnonce'];
	if ( wp_verify_nonce( $nonce, 'create_meeting_admin_nonce' ) )
	{
		$result = $obj_virtual_classroom->smgt_create_meeting_in_zoom($_POST);
		if($result)
		{
			wp_redirect ( home_url().'?dashboard=user&page=virtual_classroom&tab=meeting_list&message=1');
		}	
	}
}
// if($school_obj->role == 'supportstaff')
// {
// 	echo "403 : Access Denied.";
// 	die;
// }
?>
<div class="popup-bg">
    <div class="overlay-content">
		<div class="create_meeting_popup"></div>
    </div>   
</div>
<div class="panel-body panel-white">
	<ul class="nav nav-tabs panel_tabs" role="tablist">
		<li class="active">
			<a href="#schedule" role="tab" data-toggle="tab">
				<i class="fa fa-align-justify"></i>  <?php _e('Class Timetable', 'school-mgt'); ?></a>
			</a>
		</li>
	</ul>
	<div class="tab-content">
		<div class="panel-body">
			<div class="panel-group" id="accordion">
			<?php
			$i = 0;
			if($school_obj->role == 'teacher' OR $school_obj->role == 'supportstaff')
			{
				$retrieve_class = get_allclass();
				$i=0;
				if(!empty($retrieve_class))
				{				
					foreach ( $retrieve_class as $class )
					{
						if(!empty($class))
						{ ?>
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordion"
											href="#collapse<?php echo $i;?>">
											<?php echo _e( 'Class', 'school-mgt' ) ;?> : <?php echo $class['class_name'];?>
										</a>
									</h4>
								</div>
								<div id="collapse<?php echo $i;?>" class="panel-collapse collapse">
									<div class="panel-body">
										<table class="table table-bordered" cellspacing="0" cellpadding="0"
											border="0">
									<?php
											foreach ( sgmt_day_list() as $daykey => $dayname )
											{
											?>
											<tr>
												<th width="100"><?php echo $dayname;?></th>
												<td>
											<?php
												//------- NEW LINE ADDED FOR ERROR ---------//
													$sectionid=0;
												//-----------------------------------------//
													$period = $obj_route->get_periad ( $class['class_id'],$sectionid, $daykey);
													 
													if (! empty ( $period ))
														foreach ( $period as $period_data ) 
														{ 
															echo '<div class="btn-group m-b-sm">';
															echo '<button class="btn btn-primary dropdown-toggle" aria-expanded="false" data-toggle="dropdown"><span class="period_box" id=' . $period_data->route_id . '>' . get_single_subject_name ( $period_data->subject_id );
															
															$start_time_data = explode(":", $period_data->start_time);
															$start_hour=str_pad($start_time_data[0],2,"0",STR_PAD_LEFT);
															$start_min=str_pad($start_time_data[1],2,"0",STR_PAD_LEFT);
															$start_am_pm=$start_time_data[2];
															
															$end_time_data = explode(":", $period_data->end_time);
															$end_hour=str_pad($end_time_data[0],2,"0",STR_PAD_LEFT);
															$end_min=str_pad($end_time_data[1],2,"0",STR_PAD_LEFT);
															$end_am_pm=$end_time_data[2];
															echo '<span class="time"> ('.$start_hour.':'.$start_min.' '.$start_am_pm.' - '.$end_hour.':'.$end_min.' '.$end_am_pm.') </span>';
															$virtual_classroom_page_name = 'virtual_classroom';
															$virtual_classroom_access_right = smgt_get_userrole_wise_filter_access_right_array($virtual_classroom_page_name);
															if (get_option('smgt_enable_virtual_classroom') == 'yes')
															{
																if ($virtual_classroom_access_right['view'] == '1')
																{
																	$meeting_data = $obj_virtual_classroom->smgt_get_singal_meeting_by_route_data_in_zoom($period_data->route_id);
																	if(empty($meeting_data))
																	{
																		if ($virtual_classroom_access_right['add'] == '1') 
																		{
																			$create_meeting = '<li><a href="#" id="'.$period_data->route_id.'" class="show-popup">'.__('Create Virtual Class','school-mgt').'</a></li>';
																		}
																	}
																	else
																	{
																		$create_meeting = '';
																	}

																	if(!empty($meeting_data))
																	{
																		if ($virtual_classroom_access_right['edit'] == '1') 
																		{
																			$update_meeting = '<li><a href="?dashboard=user&page=virtual_classroom&tab=edit_meeting&action=edit&meeting_id='.$meeting_data->meeting_id.'">'.__('Edit Virtual Class','school-mgt').'</a></li>';
																		}
																		if ($virtual_classroom_access_right['delete'] == '1') 
																		{
																			$delete_meeting = '<li><a href="?dashboard=user&page=virtual_classroom&tab=meeting_list&action=delete&meeting_id='.$meeting_data->meeting_id.'" onclick="return confirm(\''.__( 'Are you sure you want to delete this record?', 'school-mgt' ).'\');">'.__('Delete Virtual Class','school-mgt').'</a></li>';
																		}
																		$meeting_statrt_link = '<li><a href="'.$meeting_data->meeting_start_link.'" target="_blank">'.__('Start Virtual Class','school-mgt').'</a></li>';
																	}
																	else
																	{
																		$update_meeting = '';
																		$delete_meeting = '';
																		$meeting_statrt_link = '';
																	}
																}
																echo "</span></span><span class='caret'></span></button>";
																echo '<ul role="menu" class="dropdown-menu">
																	'.$create_meeting .''.$update_meeting.''.$delete_meeting.''.$meeting_statrt_link.'
																</ul>';
																echo '</div>';
															}
														}
													?>
												</td>
											</tr>
									<?php	} ?>
										</table>
									</div>
								</div>
							</div>
				 <?php 	}						
						$sectionname="";
						$sectionid="";
						$class_sectionsdata=smgt_get_class_sections($class['class_id']);
						if(!empty($class_sectionsdata))
						{
							foreach($class_sectionsdata as $section)
							{  
								$i++;
								?>
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a data-toggle="collapse" data-parent="#accordion"
												href="#collapse<?php echo $i;?>">
												<?php _e('Class', 'school-mgt'); ?> : <?php echo $class['class_name']; ?> &nbsp;&nbsp;&nbsp;&nbsp;
												<?php 
												if(!empty($section->section_name))
												{ ?>
												<?php _e('Section', 'school-mgt'); ?> : <?php echo $section->section_name; ?>
												<?php }
												?>
											</a>
										</h4>
									</div>
									<div id="collapse<?php echo $i;?>" class="panel-collapse collapse">
										<div class="panel-body">
											<table class="table table-bordered table_left" cellspacing="0" cellpadding="0"
												border="0">
										<?php
												foreach ( sgmt_day_list() as $daykey => $dayname )
												{
												?>
													<tr>
														<th width="100"><?php echo $dayname;?></th>
															<td>
																<?php
																$period = $obj_route->get_periad ( $class['class_id'],$section->id, $daykey );
																if (! empty ( $period ))
																	foreach ( $period as $period_data )
																	{?>
																	<?php 
																		echo '<button class="btn btn-primary"><span class="period_box" id=' . $period_data->route_id . '>' . get_single_subject_name ( $period_data->subject_id );
																		
																		$start_time_data = explode(":", $period_data->start_time);
																		$start_hour=str_pad($start_time_data[0],2,"0",STR_PAD_LEFT);
																		$start_min=str_pad($start_time_data[1],2,"0",STR_PAD_LEFT);
																		$start_am_pm=$start_time_data[2];
																		
																		$end_time_data = explode(":", $period_data->end_time);
																		$end_hour=str_pad($end_time_data[0],2,"0",STR_PAD_LEFT);
																		$end_min=str_pad($end_time_data[1],2,"0",STR_PAD_LEFT);
																		$end_am_pm=$end_time_data[2];
																		echo '<span class="time"> ('.$start_hour.':'.$start_min.' '.$start_am_pm.' - '.$end_hour.':'.$end_min.' '.$end_am_pm.') </span>';
																		echo "</span></button>";
																	}
																	?>
															</td>
													</tr>
										<?php	} ?>
											</table>
										</div>
									</div>
								</div>
						<?php 
							}
						}	
					$i++;
					}
				}
				else
				{
					_e( 'Class data not avilable', 'school-mgt' );
				}
			}
			else if($school_obj->role == 'student')
			{
			    $class = $school_obj->class_info;
			    $sectionname="";
			    $section=0;
			    $section = get_user_meta(get_current_user_id(),'class_section',true);
				if($section!="")
				{
					$sectionname = smgt_get_section_name($section);
				}
				else
				{
					$section=0;
				}
			?>
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-parent="#accordion"
								href="#collapse<?php echo $i;?>">
									<?php echo _e( 'Class', 'school-mgt' ) ;?> <?php echo $class->class_name." ".$sectionname; ?></a>
						</h4>
					</div>
					<div id="collapse<?php echo $i;?>" class="panel-collapse collapse in">
						<div class="panel-body">
							<table class="table table-bordered" cellspacing="0" cellpadding="0"
								border="0">
						<?php
								foreach ( sgmt_day_list() as $daykey => $dayname ) 
								{ ?>
									<tr>
										<th width="100"><?php echo $dayname;?></th>
											<td>
												<?php
													$period = $obj_route->get_periad ( $class->class_id,$section,$daykey );
													if (! empty ( $period ))
														foreach ( $period as $period_data )
														{
															$meeting_data = $obj_virtual_classroom->smgt_get_singal_meeting_by_route_data_in_zoom($period_data->route_id);
															if(!empty($meeting_data))
															{
																$data_toggle = 'data-toggle="dropdown"';
															}
															else
															{
																$data_toggle = '';
															}
															echo '<div class="btn-group m-b-sm">';
															echo '<button class="btn btn-primary dropdown-toggle" aria-expanded="false" '.$data_toggle.'><span class="period_box" id=' . $period_data->route_id . '>' . get_single_subject_name ( $period_data->subject_id );
															$start_time_data = explode(":", $period_data->start_time);
															$start_hour=str_pad($start_time_data[0],2,"0",STR_PAD_LEFT);
															$start_min=str_pad($start_time_data[1],2,"0",STR_PAD_LEFT);
															$start_am_pm=$start_time_data[2];
															
															$end_time_data = explode(":", $period_data->end_time);
															$end_hour=str_pad($end_time_data[0],2,"0",STR_PAD_LEFT);
															$end_min=str_pad($end_time_data[1],2,"0",STR_PAD_LEFT);
															$end_am_pm=$end_time_data[2];
															echo '<span class="time"> ('.$start_hour.':'.$start_min.' '.$start_am_pm.' - '.$end_hour.':'.$end_min.' '.$end_am_pm.') </span>';
															$virtual_classroom_page_name = 'virtual_classroom';
															$virtual_classroom_access_right = smgt_get_userrole_wise_filter_access_right_array($virtual_classroom_page_name);
															if (get_option('smgt_enable_virtual_classroom') == 'yes')
															{
																if ($virtual_classroom_access_right['view'] == '1')
																{
																	if(!empty($meeting_data))
																	{
																		$meeting_join_link = '<li><a href="'.$meeting_data->meeting_join_link.'" target="_blank">'.__('Join Virtual Class','school-mgt').'</a></li>';
																	}
																	else
																	{
																		$meeting_join_link = '';
																	}
																}
																echo "<span class='caret'></span></button>";
																echo '<ul role="menu" class="dropdown-menu">
																	'.$meeting_join_link.'
																</ul>';
																echo '</div>';
															}
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
			else if($school_obj->role == 'parent')
			{
				$chil_array =$school_obj->child_list;
				$i = 0;
				if(!empty($chil_array))
				{
					foreach($chil_array as $child_id)
					{
						$i++;
						$sectionname="";
						$section=0;
						$class = $school_obj->get_user_class_id($child_id);
						$section = get_user_meta($child_id,'class_section',true);
						if($section!="")
						{
							$sectionname = smgt_get_section_name($section);
						}
						else
						{
							$section=0;
						}
						?>
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a data-toggle="collapse" data-parent="#accordion"
										href="#collapse<?php echo $i;?>">
									<?php echo _e( 'Class', 'school-mgt' ) ;?> <?php echo $class->class_name." ".$sectionname; ?></a>
								</h4>
							</div>
							<div id="collapse<?php echo $i;?>" class="panel-collapse collapse <?php if($i== 1) echo 'in';?>">
								<div class="panel-body">
									<table class="table table-bordered" cellspacing="0" cellpadding="0"
										border="0">
									<?php
										foreach ( sgmt_day_list() as $daykey => $dayname )
										{
										?>
											<tr>
												<th width="100"><?php echo $dayname;?></th>
												<td>
													<?php  
													$period = $obj_route->get_periad ( $class->class_id,$section,$daykey );
														if (! empty ( $period ))
															foreach ( $period as $period_data ) 
															{
																$meeting_data = $obj_virtual_classroom->smgt_get_singal_meeting_by_route_data_in_zoom($period_data->route_id);
																if(!empty($meeting_data))
																{
																	$data_toggle = 'data-toggle="dropdown"';
																}
																else
																{
																	$data_toggle = '';
																}
																echo '<div class="btn-group m-b-sm">';
																echo '<button class="btn btn-primary dropdown-toggle" aria-expanded="false" '.$data_toggle.'><span class="period_box" id=' . $period_data->route_id . '>' . get_single_subject_name ( $period_data->subject_id );
																$start_time_data = explode(":", $period_data->start_time);
																$start_hour=str_pad($start_time_data[0],2,"0",STR_PAD_LEFT);
																$start_min=str_pad($start_time_data[1],2,"0",STR_PAD_LEFT);
																$start_am_pm=$start_time_data[2];
																
																$end_time_data = explode(":", $period_data->end_time);
																$end_hour=str_pad($end_time_data[0],2,"0",STR_PAD_LEFT);
																$end_min=str_pad($end_time_data[1],2,"0",STR_PAD_LEFT);
																$end_am_pm=$end_time_data[2];
																echo '<span class="time"> ('.$start_hour.':'.$start_min.' '.$start_am_pm.' - '.$end_hour.':'.$end_min.' '.$end_am_pm.') </span>';
																$virtual_classroom_page_name = 'virtual_classroom';
																$virtual_classroom_access_right = smgt_get_userrole_wise_filter_access_right_array($virtual_classroom_page_name);
																if (get_option('smgt_enable_virtual_classroom') == 'yes')
																{
																	if ($virtual_classroom_access_right['view'] == '1')
																	{
																		if(!empty($meeting_data))
																		{
																			$meeting_join_link = '<li><a href="'.$meeting_data->meeting_join_link.'" target="_blank">'.__('Join Virtual Class','school-mgt').'</a></li>';
																		}
																		else
																		{
																			$meeting_join_link = '';
																		}
																	}
																	echo "<span class='caret'></span></button>";
																	echo '<ul role="menu" class="dropdown-menu">
																		'.$meeting_join_link.'
																	</ul>';
																	echo '</div>';
																}
															}
														?>
												</td>
											</tr>
								<?php 	} ?>
									</table>
								</div>
							</div>
						</div>
						<?php 
					}
				}
				else
				{
					_e( 'Child data not avilable', 'school-mgt' );
				}
			} 
		?>		
		</div>
	</div>
</div>	
<?php ?>