<script type="text/javascript">
$(document).ready(function() {
	$('#notification_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
} );
</script>
<div class="mailbox-content overflow-hidden">
<style>
.multiselect-container.dropdown-menu
{
	height:auto;
}
</style>
<form name="class_form" action="" method="post" class="form-horizontal" id="notification_form">
   
    
		<div class="form-group">
			<label class="col-sm-2 control-label" for="sms_template"><?php _e('Select Class','school-mgt');?></label>
			<div class="col-sm-8">
			
				 <select name="class_id"  id="notification_class_list_id" class="form-control max_width_100">
                	<option value="All"><?php _e('All','school-mgt');?></option>
                    <?php
					  foreach(get_allclass() as $classdata)
					  {  
					  ?>
					   <option  value="<?php echo $classdata['class_id'];?>" ><?php echo $classdata['class_name'];?></option>
				 <?php }?>
                </select>
			</div>
		</div>
		
			<div class="form-group notification_class_section_id">
			<label class="col-sm-2 control-label" for="class_name"><?php _e('Class Section','school-mgt');?></label>
			<div class="col-sm-8">
                        <select name="class_section" class="form-control max_width_100" id="notification_class_section_id">
                        	<option value="All"><?php _e('All','school-mgt');?></option>
                        </select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label"><?php _e('Select Users','school-mgt');?></label>
			<div class="col-sm-8">
			<span class="notification_user_display_block">
				<select name="selected_users" id="notification_selected_users" class="form-control max_width_100">
				<option value="All"><?php _e('All','school-mgt');?></option>				
					<?php 
					// $student_list = get_all_student_list();
					// foreach($student_list  as $retrive_data)
					// {
						// echo '<option value="'.$retrive_data->ID.'">'.$retrive_data->display_name.'</option>';
					// }
					?>
				</select>
			</span>
			</div>
		</div>
		<?php wp_nonce_field( 'save_notice_admin_nonce' ); ?>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="subject"><?php _e('Title','school-mgt');?><span class="require-field">*</span></label>
            <div class="col-sm-8">
				<input id="title" class="form-control validate[required,custom[popup_category_validation]] text-input" type="text" maxlength="50" name="title" >
            </div>
		</div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="message"><?php _e('Message','school-mgt');?><span class="require-field">*</span></label>
            <div class="col-sm-8">
                <textarea name="message_body" id="message_body" maxlength="150" class="form-control validate[required,custom[address_description_validation]] text-input"></textarea>
            </div>
		</div>
											
        <div class="form-group">
            <div class="col-sm-10">
                <div class="pull-right">
                    <input type="submit" value="<?php _e('Save Notification','school-mgt') ?>" name="save_notification" class="btn btn-success"/>
                </div>
            </div>
        </div>       
    </form>
</div>