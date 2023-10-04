<?php 	
	$obj_attend=new Attendence_Manage();
	$class_id =0;
	$current_date = date("y-m-d");
?>
<script type="text/javascript">
$(document).ready(function() {
	$('#teacher_attendance').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
	$('#curr_date_teacher').datepicker({
		maxDate:'0',
		dateFormat: "yy-mm-dd",
		beforeShow: function (textbox, instance) 
		{
			instance.dpDiv.css({
				marginTop: (-textbox.offsetHeight) + 'px'                   
			});
		}
		}); 
} );
</script>
<div class="panel-body"> 
	<form method="post" id="teacher_attendance">           
        <div class="form-group col-md-3">
			<label class="col-sm-2 control-label" for="curr_date"><?php _e('Date','school-mgt');?></label>			
			<input id="curr_date_teacher" class="form-control" type="text" value="<?php if(isset($_POST['tcurr_date'])) echo $_POST['tcurr_date']; else echo  date("Y-m-d");?>" name="tcurr_date" readonly>			
		</div>
		<div class="form-group col-md-3 button-possition">
			<label for="subject_id">&nbsp;</label>
			<input type="submit" value="<?php _e('Take/View  Attendance','school-mgt');?>" name="teacher_attendence"  class="btn btn-info"/>
		</div>
    </form>
</div>
<div class="clearfix"> </div>
<?php 
    if(isset($_REQUEST['teacher_attendence']) || isset($_REQUEST['save_teach_attendence']))
	{	
		$attendanace_date=$_REQUEST['tcurr_date'];
		$holiday_dates=get_all_date_of_holidays();
		/* var_dump($attendanace_date);
		var_dump($holiday_dates); */
		if (in_array($attendanace_date, $holiday_dates))
		{
			?>
			<div class="alert_msg alert alert-warning alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
				<?php _e('This day is holiday you are not able to take attendance','school-mgt');?>
			</div>
		<?php 
		}
		else
		{
    ?>
	<div class="panel-body"> 
        <form method="post">        
			<input type="hidden" name="class_id" value="<?php echo $class_id;?>" />
			<input type="hidden" name="tcurr_date" value="<?php echo $_POST['tcurr_date'];?>" />
            <div class="panel-heading">
				<h4 class="panel-title"><?php _e('Teacher Attendance','school-mgt');?> , 
				<?php _e('Date','school-mgt')?> : <?php echo $_POST['tcurr_date'];?></h4>
			</div>
			<div class="col-md-12 padding_payment">
				<div class="table-responsive">
					<table class="table">
						<tr>
							<th><?php _e('Srno','school-mgt');?></th>
							<th><?php _e('Teacher','school-mgt');?></th>
							<th><?php _e('Attendance','school-mgt');?></th>
							<th><?php _e('Comment','school-mgt');?></th>
						</tr>
						<?php 
						$date = $_POST['tcurr_date'];
						$i=1;
						$teacher = get_users(array('role'=>'teacher'));
						foreach ($teacher as $user)
						{
							//$class_id=get_user_meta($user->ID, 'class_name', true);
							$class_id=0;
							$check_attendance = $obj_attend->check_attendence($user->ID,$class_id,$date);
							
							$attendanc_status = "Present";
							if(!empty($check_attendance))
							{
								$attendanc_status = $check_attendance->status;
								 
							}
							   // $check_result=$obj_attend->get_teacher_attendence($user->ID,$_POST['tcurr_date']);
							echo '<tr>';  
							echo '<tr>';
						  
							echo '<td>'.$i.'</td>';
							echo '<td><span>' .$user->first_name.' '.$user->last_name. '</span></td>';
							?>
							<td><label class="radio-inline"><input type="radio" name = "attendanace_<?php echo $user->ID?>" value ="Present" <?php checked( $attendanc_status, 'Present' );?>>
							<?php _e('Present','school-mgt');?></label>
							<label class="radio-inline"> <input type="radio" name = "attendanace_<?php echo $user->ID?>" value ="Absent" <?php checked( $attendanc_status, 'Absent' );?>>
							<?php _e('Absent','school-mgt');?></label>
							<label class="radio-inline"><input type="radio" name = "attendanace_<?php echo $user->ID?>" value ="Late" <?php checked( $attendanc_status, 'Late' );?>>
							<?php _e('Late','school-mgt');?></label></td>
							<td><input type="text" name="attendanace_comment_<?php echo $user->ID?>" class="form-control" 
							value="<?php if(!empty($check_attendance)) echo $check_attendance->comment;?>"></td><?php 
							
							echo '</tr>';
							$i++;
						}
						?>   
					</table>
				</div>
			</div>		
        <div class="cleatrfix"></div>
        <div class="col-sm-8">    
        <?php //f($_REQUEST['tcurr_date'] == date("Y-m-d")){?>       	    	
        	<input type="submit" value="<?php _e("Save  Attendance","school-mgt");?>" name="save_teach_attendence" class="btn btn-success" />
        	<?php //}?>
        </div>       
        </form>
       </div>
       <?php }
	}	   ?>