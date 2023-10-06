<script type="text/javascript">
$(document).ready(function() {
	 $('#email_template_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});	
} );
</script>
<div class="panel-body">
<form id="email_template_form" class="form-horizontal" method="post" action="" name="parent_form">
<div class="form-group">
	<label for="learner_complete_quiz_notification_title" class="col-sm-3 control-label">Email Subject <span class="require-field">*</span></label>
	<div class="col-md-8">
		<input id="student_activation_title" class="form-control validate[required]" name="fee_payment_title" id="fee_payment_title" placeholder="Enter Email Subject" value="<?php echo get_option('fee_payment_title'); ?>">
	</div>
</div>
<div class="form-group">
	<label for="learner_complete_quiz_notification_mailcontent" class="col-sm-3 control-label">Emails Sent to Parents When A Generate Invoice <span class="require-field">*</span></label>
	<div class="col-md-8">
		<textarea id="fee_payment_mailcontent" name="fee_payment_mailcontent" class="form-control validate[required]"><?php echo get_option('fee_payment_mailcontent');?></textarea>
	</div>
</div>
<div class="form-group">
	<div class="col-sm-offset-3 col-md-8">
		<label><?php _e('You can use following variables in the email template:','school-mgt');?></label><br>				
		<label><strong>{{student_name}} - </strong><?php _e('The student full name','school-mgt');?></label><br>
		<label><strong>{{parent_name}} - </strong><?php _e('The parent name','school-mgt');?></label><br>
		<label><strong>{{roll_number}} - </strong><?php _e('Student roll number','school-mgt');?></label><br>
		<label><strong>{{class_name}} - </strong><?php _e('Class name of student','school-mgt');?></label><br>
		<label><strong>{{fee_type}} - </strong><?php _e('Fees Type','school-mgt');?></label><br>
		<label><strong>{{fee_amount}} - </strong><?php _e('Fee Amount','school-mgt');?></label><br>
		<label><strong>{{school_name}} - </strong><?php _e('School name','school-mgt');?></label><br>
		<label><strong>{{start_year}} - </strong><?php _e('Start Year','school-mgt');?></label><br>
		<label><strong>{{end_year}} - </strong><?php _e('End Year','school-mgt');?></label><br>			
	</div>
</div>
<div class="col-sm-offset-3 col-sm-8">        	
    <input type="submit" value="<?php  _e('Save','school-mgt')?>" name="save_feepayment_mailtemplate" class="btn btn-success"/>
</div>
</form>
</div>