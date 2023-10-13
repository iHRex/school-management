<?php 
var_dump("sdds");
die;
$obj_mark = new Marks_Manage();
$active_tab=isset($_REQUEST['tab'])?$_REQUEST['tab']:'stud_attendance';
$role='student';
if(isset($_REQUEST['student_id'])) $student_id=$_REQUEST['student_id'];?>
 
<script type="text/javascript">
$(document).ready(function() {	
	$('.sdate').datepicker({dateFormat: "yy-mm-dd"}); 
	$('.edate').datepicker({dateFormat: "yy-mm-dd"});  
} );
</script>
<div class="panel-body panel-white">
<ul class="nav nav-tabs panel_tabs" role="tablist">
      <li class="<?php if($active_tab=='stud_attendance'){?>active<?php }?>">
          <a href="?dashboard=user&page=view-attendance&tab=stud_attendance&student_id=<?php echo $student_id;?>" class="nav-tab2">
             <i class="fa fa-align-justify"></i> <?php _e('Attendance', 'school-mgt'); ?></a>
          </a>
      </li>
     <li class="<?php if($active_tab=='sub_attendance'){?>active<?php }?>">
			<a href="?dashboard=user&page=view-attendance&tab=sub_attendance&student_id=<?php echo $student_id;?>" class="nav-tab2 <?php echo $active_tab == 'sub_attendance' ? 'active' : ''; ?>">
             <i class="fa fa-align-justify"></i> <?php _e('Subject Wise Attendance', 'school-mgt'); ?></a>
          </a>
      </li>     
</ul>

 <div class="tab-content">
     <?php if($active_tab == 'stud_attendance')
     {
		$student_data=get_userdata($_REQUEST['student_id']);
	?> 
		<div class="panel-body">
		<form name="wcwm_report" action="" method="post">
			<input type="hidden" name="attendance" value=1> 
			<input type="hidden" name="user_id" value=<?php echo $_REQUEST['student_id'];?>>  
			<!--<div class="form-group col-md-12">
				<h4 class="panel-title attendence_name"><i class="fa fa-user"></i> <?php echo get_user_name_byid($_REQUEST['student_id']);?></h4>
			</div>-->
					<div class="row">
						<div class="col-md-3 col-sm-4 col-xs-12">	
							<?php
							$umetadata=get_user_image($_REQUEST['student_id']);
							if(empty($umetadata['meta_value']))
							{
								echo '<img class="img-circle img-responsive member-profile" src='.get_option( 'smgt_student_thumb' ).' style="height:150px;width:150px;"/>';
							}
							else
								echo '<img class="img-circle img-responsive member-profile" src='.$umetadata['meta_value'].' style="height:150px;width:150px;" />';
							?>
						</div>
						
						<div class="col-md-9 col-sm-8 col-xs-12 ">
							<div class="row">
								<h2><?php echo $student_data->display_name;?></h2>
							</div>
							<div class="row">
								<div class="col-md-4 col-sm-3 col-xs-12">
									<i class="fa fa-envelope"></i>&nbsp;
									
									<span class="email-span"><?php echo $student_data->user_email;?></span>
								</div>
								<div class="col-md-3 col-sm-3 col-xs-12">
									<i class="fa fa-phone"></i>&nbsp;
									<span><?php echo $student_data->phone;?></span>
								</div>
								<div class="col-md-5 col-sm-3 col-xs-12 no-padding">
									<i class="fa fa-list-alt"></i>&nbsp;
									<span><?php echo $student_data->roll_id;?></span>
								</div>
							</div>					
						</div>
					</div>
			<div class="form-group col-md-3">
				<label for="exam_id"><?php _e('Start Date','school-mgt');?></label>
			   <input type="text"  class="form-control sdate" name="sdate" value="<?php if(isset($_REQUEST['sdate'])) echo $_REQUEST['sdate'] ;else echo date('Y-m-d');?>" readonly>								
			</div>
			<div class="form-group col-md-3">
				<label for="exam_id"><?php _e('End Date','school-mgt');?></label>
				<input type="text" class="form-control edate" name="edate" value="<?php if(isset($_REQUEST['edate'])) echo $_REQUEST['edate']; else echo date('Y-m-d');?>" readonly>								
			</div>
			<div class="form-group col-md-3 button-possition">
				<label for="subject_id">&nbsp;</label>
				<input type="submit" name="view_attendance" Value="<?php _e('Go','school-mgt');?>"  class="btn btn-info"/>
			</div>	
		</form>
		<div class="clearfix"></div>
		<?php if(isset($_REQUEST['view_attendance']))
		{
			
			$start_date = $_REQUEST['sdate'];			
			$end_date = $_REQUEST['edate'];			
			$user_id = $_REQUEST['user_id'];
				/* var_dump($start_date);
				var_dump($end_date);
				var_dump($user_id); die; */
				
			 $period = new DatePeriod(
				 new DateTime($start_date),
				 new DateInterval('P1D'),
				 new DateTime($end_date)
			); 			
			$attendance = smgt_view_student_attendance($start_date,$end_date,$user_id);			
			$curremt_date = $start_date;
		?>
		<script>
		jQuery(document).ready(function() {
			var table =  jQuery('#attendance_list').DataTable({
				responsive: true,
				"order": [[ 0, "asc" ]],
				"aoColumns":[	                  
				{"bSortable": true},
				{"bSortable": true},
				{"bSortable": true},
				{"bSortable": true},
				{"bSortable": true},	           
				{"bSortable": false}],		
			});
		});
		</script>
	<div class="panel-body">
		<div class="table-responsive">
			<table id="attendance_list" class="display" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th><?php _e('Student Name','school-mgt');?></th>
						<th><?php _e('Class Name','school-mgt');?></th>
						<th><?php _e('Date','school-mgt');?></th>
						<th><?php _e('Day','school-mgt');?></th>
						<th><?php _e('Attendance','school-mgt');?></th>
						<th><?php _e('Comment','school-mgt');?></th>
					</tr>
				</thead> 
				<tfoot>
					<tr>
						<th><?php _e('Student Name','school-mgt');?></th>
						<th><?php _e('Class Name','school-mgt');?></th>
						<th><?php _e('Date','school-mgt');?></th>
						<th><?php _e('Day','school-mgt');?></th>
						<th><?php _e('Attendance','school-mgt');?></th>
						<th><?php _e('Comment','school-mgt');?></th>
					</tr>
				</tfoot> 
				<tbody>
					<?php
						while ($end_date >= $curremt_date)
						{	
							echo '<tr>';
							echo '<td>';
								echo get_display_name($user_id);
							echo '</td>';
							echo '<td>';
								echo get_class_name_by_id(get_user_meta($user_id, 'class_name',true));
							echo '</td>';
							echo '<td>';
								echo smgt_getdate_in_input_box($curremt_date);
							echo '</td>';
							
							$attendance_status = smgt_get_attendence($user_id,$curremt_date);
							echo '<td>';
							echo date("D", strtotime($curremt_date));
							echo '</td>';
							
							if(!empty($attendance_status))
							{
								echo '<td>';
								echo smgt_get_attendence($user_id,$curremt_date);
								echo '</td>';
							}
							else 
							{
								echo '<td>';
								echo __('Absent','school-mgt');
								echo '</td>';
							}
							echo '<td>';
							echo smgt_get_attendence_comment($user_id,$curremt_date);
							echo '</td>';
							echo '</tr>';
							$curremt_date = strtotime("+1 day", strtotime($curremt_date));
							$curremt_date = date("Y-m-d", $curremt_date);
						}
					?>
				</tbody>        
			</table>
		</div>
	</div>
	
					
					<!--<table class="table col-md-12">
					<tr>
					<th width="200px"><?php _e('Date','school-mgt');?></th>
					<th><?php _e('Day','school-mgt');?></th>
					<th><?php _e('Attendance','school-mgt');?></th>
					<th><?php _e('Comment','school-mgt');?></th>
					</tr>
					<?php 
					while ($end_date >= $curremt_date)
					{
						echo '<tr>';
						echo '<td>';
						echo smgt_getdate_in_input_box($curremt_date);
						echo '</td>';
						
						$attendance_status = smgt_get_attendence($user_id,$curremt_date);
						echo '<td>';
						echo date("D", strtotime($curremt_date));
						echo '</td>';
						
						if(!empty($attendance_status))
						{
							echo '<td>';
							echo smgt_get_attendence($user_id,$curremt_date);
							echo '</td>';
						}
						else 
						{
							echo '<td>';
							echo __('Absent','school-mgt');
							echo '</td>';
						}
						echo '<td>';
						echo smgt_get_attendence_comment($user_id,$curremt_date);
						echo '</td>';
						echo '</tr>';
						$curremt_date = strtotime("+1 day", strtotime($curremt_date));
						$curremt_date = date("Y-m-d", $curremt_date);
					}
				?>
				</table>-->

				<?php } ?>
				</div>
	<?php }
	
	if($active_tab == 'sub_attendance')
	{ 
		$student_data=get_userdata($_REQUEST['student_id']);
	?>
<script type="text/javascript">
$(document).ready(function() {	
	$('#subject_attendance').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});	 
	$('#curr_date').datepicker({dateFormat: "yy-mm-dd"}); 	
} );
</script>
		 <div class="panel-body">
				<form name="wcwm_report" action="" id="subject_attendance" method="post">
				<input type="hidden" name="attendance" value=1> 
				<input type="hidden" name="user_id" value=<?php echo $student_id;?>> 
				<!--<div class="form-group col-md-12">
						<h4 class="panel-title attendence_name"><i class="fa fa-user"></i> <?php echo get_user_name_byid($_REQUEST['student_id']);?></h4>
					</div>-->
				<div class="row">
						<div class="col-md-3 col-sm-4 col-xs-12">	
							<?php
							$umetadata=get_user_image($_REQUEST['student_id']);
							if(empty($umetadata['meta_value']))
							{
								echo '<img class="img-circle img-responsive member-profile" src='.get_option( 'smgt_student_thumb' ).' style="height:150px;width:150px;"/>';
							}
							else
								echo '<img class="img-circle img-responsive member-profile" src='.$umetadata['meta_value'].' style="height:150px;width:150px;" />';
							?>
						</div>
						
						<div class="col-md-9 col-sm-8 col-xs-12 ">
							<div class="row">
								<h2><?php echo $student_data->display_name;?></h2>
							</div>
							<div class="row">
								<div class="col-md-4 col-sm-3 col-xs-12">
									<i class="fa fa-envelope"></i>&nbsp;
									
									<span class="email-span"><?php echo $student_data->user_email;?></span>
								</div>
								<div class="col-md-3 col-sm-3 col-xs-12">
									<i class="fa fa-phone"></i>&nbsp;
									<span><?php echo $student_data->phone;?></span>
								</div>
								<div class="col-md-5 col-sm-3 col-xs-12 no-padding">
									<i class="fa fa-list-alt"></i>&nbsp;
									<span><?php echo $student_data->roll_id;?></span>
								</div>
							</div>					
						</div>
					</div>
					<div class="form-group col-md-3">
						<label for="exam_id"><?php _e('Start Date','school-mgt');?></label>									
							<input type="text"  class="form-control sdate" name="sdate" value="<?php if(isset($_REQUEST['sdate'])) echo smgt_getdate_in_input_box($_REQUEST['sdate']);else echo date('Y-m-d');?>" readonly>							
					</div>
					<div class="form-group col-md-3">
						<label for="exam_id"><?php _e('End Date','school-mgt');?></label>
						<input type="text"   class="form-control edate" name="edate" value="<?php if(isset($_REQUEST['edate'])) echo smgt_getdate_in_input_box($_REQUEST['edate']);else echo date('Y-m-d');?>" readonly>								
					</div>
					
					<div class="form-group col-md-3">
						<label for="class_id"><?php _e('Select Subject','school-mgt');?><span class="require-field">*</span></label>			
						<?php $class_id=get_user_meta($student_id,'class_name',true); ?>
							<select name="sub_id"  class="form-control validate[required]">
								<option value=" "><?php _e('Select Subject','school-mgt');?></option>
								<?php 
								$sub_id=0;
								if(isset($_POST['sub_id'])){
									$sub_id=$_POST['sub_id'];
								}
								$allsubjects = smgt_get_subject_by_classid($class_id);
								foreach($allsubjects as $subjectdata)
								{ ?>
									<option value="<?php echo $subjectdata->subid;?>" <?php selected($subjectdata->subid,$sub_id); ?>><?php echo $subjectdata->sub_name;?></option>
							<?php } ?>
							</select>						
					</div>
					<div class="form-group col-md-3 button-possition">
						<label for="subject_id">&nbsp;</label>
						<input type="submit" name="view_attendance" Value="<?php _e('Go','school-mgt');?>"  class="btn btn-info"/>
					</div>	
				</form>
				<div class="clearfix"></div>
		
        
         <?php if(isset($_REQUEST['view_attendance']))
				{
					$start_date = $_REQUEST['sdate'];
					$end_date = $_REQUEST['edate'];
					$user_id = $_REQUEST['user_id'];
					 $sub_id = $_REQUEST['sub_id'];
					$attendance = smgt_view_student_attendance($start_date,$end_date,$user_id);
					
					$curremt_date =$start_date;
					?>
					<div class="table-responsive">
						<table class="table col-md-12">
						<tr>
						<th width="200px"><?php _e('Date','school-mgt');?></th>
						<th><?php _e('Day','school-mgt');?></th>
						<th><?php _e('Attendance','school-mgt');?></th>
						<th><?php _e('Comment','school-mgt');?></th>
						</tr>
						<?php 
						while ($end_date >= $curremt_date)
						{
							echo '<tr>';
							echo '<td>';
							echo smgt_getdate_in_input_box($curremt_date);
							echo '</td>';
							
							$sub_attendance_status = smgt_get_sub_attendence($user_id,$curremt_date,$sub_id);
							echo '<td>';
							echo date("D", strtotime($curremt_date));
							echo '</td>';
							
							if(!empty($sub_attendance_status))
							{
								echo '<td>';
								echo smgt_get_sub_attendence($user_id,$curremt_date,$sub_id);
								echo '</td>';
							}
							else 
							{
								echo '<td>';
								echo __('Absent','school-mgt');
								echo '</td>';
							}
							echo '<td>';
							echo smgt_get_sub_attendence_comment($user_id,$curremt_date,$sub_id);
							echo '</td>';
							echo '</tr>';
							$curremt_date = strtotime("+1 day", strtotime($curremt_date));
							$curremt_date = date("Y-m-d", $curremt_date);
						} ?>
						</table>
					</div>
				<?php }?>
				</div>
 <?php } ?>
</div>
</div>