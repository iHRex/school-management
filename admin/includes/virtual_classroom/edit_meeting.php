<?php
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
<script type="text/javascript">
$(document).ready(function() {
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
} );
</script>
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
		<!-- <div class="form-group">
			<label class="col-sm-2 control-label" for="duration"><?php _e('Duration(Minute)','school-mgt');?></label>
			<div class="col-sm-8">
				<input id="duration" class="form-control" type="text" value="<?php echo $meeting_data->duration; ?>" name="duration">
			</div>
		</div> -->
		<!-- <div class="form-group">
			<label class="col-sm-2 control-label" for="title"><?php _e('Title','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="title" class="form-control validate[required,custom[popup_category_validation]]" type="text" value="<?php echo $meeting_data->title; ?>" name="title" maxlength="50">
			</div>
		</div> -->
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
		<?php wp_nonce_field( 'edit_meeting_admin_nonce' ); ?>
		
		<div class="col-sm-offset-2 col-sm-8">        	
        	<input type="submit" value="<?php if($edit){ _e('Save Meeting','school-mgt'); }else{ _e('Create Meeting','school-mgt');}?>" name="edit_meeting" class="btn btn-success" />
        </div>        
     </form>
    </div>
    <?php
?>