<?php 
$active_tab=isset($_REQUEST['tab'])?$_REQUEST['tab']:'registration_mail';
$changed = 0;
if(isset($_REQUEST['save_registration_template']))
{
	update_option('registration_mailtemplate',$_REQUEST['registratoin_mailtemplate_content']);
	update_option('registration_title',$_REQUEST['registration_title']);	
	$search=array('{{student_name}}','{{school_name}}');
	$replace = array('ashvin','A1 School');
	$message_content = str_replace($search, $replace,get_option('registration_mailtemplate'));
	$changed = 1;
}
if(isset($_REQUEST['save_activation_mailtemplate']))
{
	update_option('student_activation_mailcontent',$_REQUEST['activation_mailcontent']);
	update_option('student_activation_title',$_REQUEST['student_activation_title']);	
	$search=array('{{student_name}}','{{school_name}}');
	$replace = array('ashvin','A1 School');
	$message_content = str_replace($search, $replace,get_option('student_activation_mailcontent'));	
	$changed = 1;
}
if(isset($_REQUEST['save_feepayment_mailtemplate']))
{
	update_option('fee_payment_mailcontent',$_REQUEST['fee_payment_mailcontent']);
	update_option('fee_payment_title',$_REQUEST['fee_payment_title']);	
	$search=array('{{student_name}}','{{parent_name}}','{{roll_number}}','{{class_name}}','{{fee_type}}','{{fee_amount}}','{{school_name}}');
	$replace = array('ashvin','Bhaskar','101','Two','First Sem Fee','5000','A1 School');
	$message_content = str_replace($search, $replace,get_option('student_activation_mailcontent'));	
	$changed = 1;
}
if(isset($_REQUEST['save_homework_mailtemplate']))
{
	update_option('homework_mailcontent',$_REQUEST['homework_mailcontent']);
	update_option('homework_title',$_REQUEST['homework_title']);	
	$search=array('{{parent_name}}','{{student_name}}','{{title}}','{{submision_date}}','{{school_name}}');
	$replace = array('ashvin','Bhaskar','Title','2017/9/25','A1 School');
	$message_content = str_replace($search, $replace,get_option('student_activation_mailcontent'));	
	$changed = 1;
}
if(isset($_REQUEST['save_messege_recived_mailtemplate']))
{
	update_option('message_received_mailsubject',$_REQUEST['message_received_mailsubject']);
	update_option('message_received_mailcontent',$_REQUEST['message_received_mailcontent']);	
	$changed = 1;	
}


if(isset($_REQUEST['save_adduser_mailtemplate']))
{
	update_option('add_user_mail_subject',$_REQUEST['add_user_mail_subject']);
	update_option('add_user_mail_content',$_REQUEST['add_user_mail_content']);
	$changed = 1;
}
if(isset($_REQUEST['save_holiday_mailtemplate']))
{
	update_option('holiday_mailsubject',$_REQUEST['holiday_mailsubject']);
	update_option('holiday_mailcontent',$_REQUEST['holiday_mailcontent']);
	$changed = 1;	
}
if(isset($_REQUEST['save_bus_alocation_mailtemplate']))
{
	update_option('school_bus_alocation_mail_content',$_REQUEST['school_bus_alocation_mail_content']);
	update_option('school_bus_alocation_mail_subject',$_REQUEST['school_bus_alocation_mail_subject']);
	$changed = 1;
}



/* if(isset($_REQUEST['save_gennerateinvoice_mailtemplate']))
{
	update_option('generate_invoice_mail_subject',$_REQUEST['generate_invoice_mail_subject']);
	update_option('generate_invoice_mail_content',$_REQUEST['generate_invoice_mail_content']);		
} */
if(isset($_REQUEST['save_student_assign_teacher_mailtemplate']))
{
	update_option('student_assign_teacher_mail_subject',$_REQUEST['student_assign_teacher_mail_subject']);
	update_option('student_assign_teacher_mail_content',$_REQUEST['student_assign_teacher_mail_content']);
	$changed = 1;
}
if(isset($_REQUEST['save_payment_recived_mailtemplate']))
{
	update_option('payment_recived_mailsubject',$_REQUEST['payment_recived_mailsubject']);
	update_option('payment_recived_mailcontent',$_REQUEST['payment_recived_mailcontent']);	
	$changed = 1;
}
if(isset($_REQUEST['save_admission_template']))
{
	update_option('admissiion_title',$_REQUEST['admissiion_title']);
	update_option('admission_mailtemplate_content',$_REQUEST['admission_mailtemplate_content']);
	$changed = 1;
}
if(isset($_REQUEST['save_approve_admission_mailtemplate']))
{
	update_option('add_approve_admisson_mail_subject',$_REQUEST['add_approve_admisson_mail_subject']);
	update_option('add_approve_admission_mail_content',$_REQUEST['add_approve_admission_mail_content']);
	$changed = 1;
}

if(isset($_REQUEST['save_homework_mailtemplate_parent']))
{
	update_option('parent_homework_mail_subject',$_REQUEST['parent_homework_mail_subject']);
	update_option('parent_homework_mail_content',$_REQUEST['parent_homework_mail_content']);
	$changed = 1;
}
if(isset($_REQUEST['save_student_absent_mailtemplate']))
{
	update_option('absent_mail_notification_subject',$_REQUEST['absent_mail_notification_subject']);
	update_option('absent_mail_notification_content',$_REQUEST['absent_mail_notification_content']);
	$changed = 1;
}

if(isset($_REQUEST['save_exam_receipt_generate']))
{
	update_option('exam_receipt_subject',$_REQUEST['exam_receipt_subject']);
	update_option('exam_receipt_content',$_REQUEST['exam_receipt_content']);
	$changed = 1;
}
if(isset($_REQUEST['save_bed_template']))
{
	update_option('bed_subject',$_REQUEST['bed_subject']);
	update_option('bed_content',$_REQUEST['bed_content']);
	$changed = 1;
}
if(isset($_REQUEST['save_student_assign_to_teacher_mailtemplate']))
{
	update_option('student_assign_to_teacher_subject',$_REQUEST['student_assign_to_teacher_subject']);
	update_option('',$_REQUEST['']);
	$changed = 1;
}
if(isset($_REQUEST['save_notice_mailtemplate']))
{
	update_option('notice_mailsubject',$_REQUEST['notice_mailsubject']);
	update_option('notice_mailcontent',$_REQUEST['notice_mailcontent']);
	$changed = 1;
}
if(isset($_REQUEST['virtual_class_invite_teacher_form_template']))
{
	update_option('virtual_class_invite_teacher_mail_subject',$_REQUEST['virtual_class_invite_teacher_mail_subject']);
	update_option('virtual_class_invite_teacher_mail_content',$_REQUEST['virtual_class_invite_teacher_mail_content']);
	$changed = 1;
}
if(isset($_REQUEST['virtual_class_teacher_reminder_template']))
{
	update_option('virtual_class_teacher_reminder_mail_subject',$_REQUEST['virtual_class_teacher_reminder_mail_subject']);
	update_option('virtual_class_teacher_reminder_mail_content',$_REQUEST['virtual_class_teacher_reminder_mail_content']);
	$changed = 1;
}
if(isset($_REQUEST['virtual_class_student_reminder_template']))
{
	update_option('virtual_class_student_reminder_mail_subject',$_REQUEST['virtual_class_student_reminder_mail_subject']);
	update_option('virtual_class_student_reminder_mail_content',$_REQUEST['virtual_class_student_reminder_mail_content']);
	$changed = 1;
}
if($changed)
{
	wp_redirect( admin_url().'admin.php?page=smgt_email_template&message=1');
}
?>
<script type="text/javascript">
$(document).ready(function() {	
	$('.sdate').datepicker({dateFormat: "yy-mm-dd"}); 
	$('.edate').datepicker({dateFormat: "yy-mm-dd"}); 
} );
</script>

<div class="page-inner">
	<div class="page-title"> 
		<h3><img src="<?php echo get_option( 'smgt_school_logo' ) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo get_option( 'smgt_school_name' );?></h3>
	</div>
<script>
$(document).ready(function() {
	$('#email_template_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
} );
</script>	
<div id="main-wrapper">
<?php
	$message = isset($_REQUEST['message'])?$_REQUEST['message']:'0';
	switch($message)
	{
		case '1':
			$message_string = __('Email Template Updated successfully.','school-mgt');
			break;
	}
	
	if($message)
	{ ?>
		<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible">
			<p><?php echo $message_string;?></p>
			<button type="button" class="notice-dismiss" data-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>
		</div>
<?php } ?>
<div class="row">
<div class="col-md-12">
<div class="panel panel-white">
<div class="panel-body">
<div class="panel-group" id="accordion">


	<div class="panel panel-default">
		<div class="panel-heading">
		  <h4 class="panel-title">
			<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOnenew">
			  <?php _e('Request For Admission Mail Template', 'school-mgt'); ?>
			</a>
		  </h4>
		</div>
		<div id="collapseOnenew" class="panel-collapse collapse in">
		  <div class="panel-body">
			<form id="email_template_form" class="form-horizontal" method="post" action="" name="parent_form">
				<div class="form-group">
					<label for="first_name" class="col-sm-3 control-label"><?php _e('Email Subject', 'school-mgt'); ?><span class="require-field">*</span></label>
					<div class="col-md-8">
						<input class="form-control validate[required]" name="admissiion_title" id="admissiion_title" placeholder="Enter Admission subject" value="<?php echo get_option('admissiion_title'); ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="first_name" class="col-sm-3 control-label"><?php _e('Subject', 'school-mgt'); ?><span class="require-field">*</span></label>
					<div class="col-md-8">
						<textarea name="admission_mailtemplate_content" class="form-control min_height_200 validate[required]"><?php echo get_option('admission_mailtemplate_content');?></textarea>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-3 col-md-8">
						<label><?php _e('You can use following variables in the email template:','school-mgt');?></label><br>
						<label><strong>{{student_name}} - </strong><?php _e('Student name','school-mgt');?></label><br>
						<label><strong>{{user_name}} - </strong><?php _e('User name of student','school-mgt');?></label><br>
						<label><strong>{{email}} - </strong><?php _e('Email of student','school-mgt');?></label><br>
						<label><strong>{{school_name}} - </strong><?php _e('School name','school-mgt');?></label>				
					</div>
				</div>
				<div class="col-sm-offset-3 col-sm-8">        	
					<input type="submit" value="<?php  _e('Save','school-mgt')?>" name="save_admission_template" class="btn btn-success"/>
				</div>
			</form>
		  </div>
		</div>
	</div> 
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapsefour_new">
					<?php _e('Approve Admission Mail Template', 'school-mgt'); ?>
				</a>
			</h4>
		</div>
		<div id="collapsefour_new" class="panel-collapse collapse">
			<div class="panel-body">
				<form id="email_template_form" class="form-horizontal" method="post" action="" name="parent_form">
					<div class="form-group">
						<label for="add_approve_admisson_mail_subject" class="col-sm-3 control-label"><?php _e('Email Subject', 'school-mgt'); ?> <span class="require-field">*</span></label>
						<div class="col-md-8">
							<input class="form-control validate[required]" name="add_approve_admisson_mail_subject" id="add_approve_admisson_mail_subject" placeholder="Enter Email Subject" value="<?php echo get_option('add_approve_admisson_mail_subject'); ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="add_approve_admission_mail_content" class="col-sm-3 control-label"><?php _e('Emails Sent to user When', 'school-mgt'); ?><span class="require-field">*</span></label>
						<div class="col-md-8">
							<textarea id="add_approve_admission_mail_content" name="add_approve_admission_mail_content" class="form-control min_height_200 validate[required]"><?php echo get_option('add_approve_admission_mail_content');?></textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-3 col-md-8">
							<label><?php _e('You can use following variables in the email template:','school-mgt');?></label><br>				
							<label><strong>{{user_name}} - </strong><?php _e('The student full name','school-mgt');?></label><br>
							<label><strong>{{school_name}} - </strong><?php _e('School name','school-mgt');?></label><br>
							<label><strong>{{role}} - </strong><?php _e('Role','school-mgt');?></label><br>					
							<label><strong>{{login_link}} - </strong><?php _e('Login Link','school-mgt');?></label><br>					
							<label><strong>{{username}} - </strong><?php _e('Username','school-mgt');?></label><br>					
							<label><strong>{{password}} - </strong><?php _e('Password','school-mgt');?></label><br>					
						</div>
					</div>
					<div class="col-sm-offset-3 col-sm-8">        	
						<input type="submit" value="<?php  _e('Save','school-mgt')?>" name="save_approve_admission_mailtemplate" class="btn btn-success"/>
					</div>
				</form>
			</div>
		</div>
	</div>

  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
          <?php _e('Registration Mail Template', 'school-mgt'); ?>
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse">
      <div class="panel-body">
        <form id="email_template_form" class="form-horizontal" method="post" action="" name="parent_form">
			<div class="form-group">
				<label for="first_name" class="col-sm-3 control-label"><?php _e('Email Subject', 'school-mgt'); ?><span class="require-field">*</span></label>
				<div class="col-md-8">
					<input class="form-control validate[required]" name="registration_title" id="registration_title" placeholder="Enter email subject" value="<?php echo get_option('registration_title'); ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="first_name" class="col-sm-3 control-label"><?php _e('Subject', 'school-mgt'); ?><span class="require-field">*</span></label>
				<div class="col-md-8">
					<textarea name="registratoin_mailtemplate_content" class="form-control min_height_200 validate[required]"><?php echo get_option('registration_mailtemplate');?></textarea>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-3 col-md-8">
					<label><?php _e('You can use following variables in the email template:','school-mgt');?></label><br>
					<label><strong>{{student_name}} - </strong><?php _e('The student full name or login name (whatever is available)','school-mgt');?></label><br>
					<label><strong>{{user_name}} - </strong><?php _e('User name of student','school-mgt');?></label><br>
					<label><strong>{{class_name}} - </strong><?php _e('Class name of student','school-mgt');?></label><br>
					<label><strong>{{email}} - </strong><?php _e('Email of student','school-mgt');?></label><br>
					<label><strong>{{school_name}} - </strong><?php _e('School name','school-mgt');?></label>				
				</div>
			</div>
			<div class="col-sm-offset-3 col-sm-8">        	
				<input type="submit" value="<?php  _e('Save','school-mgt')?>" name="save_registration_template" class="btn btn-success"/>
			</div>
		</form>
      </div>
    </div>
  </div>
  
  
  <div class="panel panel-default">
    <div class="panel-heading">
		<h4 class="panel-title">
			<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapsetwo">
				<?php _e('Student Activation Mail Template', 'school-mgt'); ?>
			</a>
		</h4>
    </div>
    <div id="collapsetwo" class="panel-collapse collapse">
		<div class="panel-body">
			<form id="email_template_form" class="form-horizontal" method="post" action="" name="parent_form">
				<div class="form-group">
					<label for="learner_complete_quiz_notification_title" class="col-sm-3 control-label"><?php _e('Email Subject', 'school-mgt'); ?><span class="require-field">*</span></label>
					<div class="col-md-8">
						<input id="student_activation_title" class="form-control validate[required]" name="student_activation_title" id="student_activation_title" placeholder="Enter Email Subject" value="<?php echo get_option('student_activation_title'); ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="learner_complete_quiz_notification_mailcontent" class="col-sm-3 control-label"><?php _e('Subject', 'school-mgt'); ?><span class="require-field">*</span></label>
					<div class="col-md-8">
						<textarea id="activation_mailcontent" name="activation_mailcontent" class="form-control validate[required] min_height_200"><?php echo get_option('student_activation_mailcontent');?></textarea>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-3 col-md-8">
						<label><?php _e('You can use following variables in the email template:','school-mgt');?></label><br>				
						<label><strong>{{student_name}} - </strong><?php _e('The student full name or login name (whatever is available)','school-mgt');?></label><br>							
						<label><strong>{{user_name}} - </strong><?php _e('User name of student','school-mgt');?></label><br>
						<label><strong>{{class_name}} - </strong><?php _e('Class name of student','school-mgt');?></label><br>
						<label><strong>{{email}} - </strong><?php _e('Email of student','school-mgt');?></label><br>
						<label><strong>{{school_name}} - </strong><?php _e('School name','school-mgt');?></label><br>			
					</div>
				</div>
				<div class="col-sm-offset-3 col-sm-8">        	
					<input type="submit" value="<?php  _e('Save','school-mgt')?>" name="save_activation_mailtemplate" class="btn btn-success"/>
				</div>
			</form>
			</div>
		</div>
	</div>
  
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapsethree">
          <?php _e('Fee Payment Mail Template', 'school-mgt'); ?>
        </a>
      </h4>
    </div>
    <div id="collapsethree" class="panel-collapse collapse">
      <div class="panel-body">
        <form id="email_template_form" class="form-horizontal" method="post" action="" name="parent_form">
			<div class="form-group">
				<label for="learner_complete_quiz_notification_title" class="col-sm-3 control-label"><?php _e('Email Subject', 'school-mgt'); ?><span class="require-field">*</span></label>
				<div class="col-md-8">
					<input id="student_activation_title" class="form-control validate[required]" name="fee_payment_title" id="fee_payment_title" placeholder="Enter Email Subject" value="<?php echo get_option('fee_payment_title'); ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="learner_complete_quiz_notification_mailcontent" class="col-sm-3 control-label"><?php _e('Subject', 'school-mgt'); ?><span class="require-field">*</span></label>
				<div class="col-md-8">
					<textarea id="fee_payment_mailcontent" name="fee_payment_mailcontent" class="form-control validate[required] min_height_200"><?php echo get_option('fee_payment_mailcontent');?></textarea>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-3 col-md-8">
					<label><?php _e('You can use following variables in the email template:','school-mgt');?></label><br>					
					<label><strong>{{parent_name}} - </strong><?php _e('The parent name','school-mgt');?></label><br>				
					<label><strong>{{school_name}} - </strong><?php _e('School name','school-mgt');?></label><br>					
				</div>
			</div>
			<div class="col-sm-offset-3 col-sm-8">        	
				<input type="submit" value="<?php  _e('Save','school-mgt')?>" name="save_feepayment_mailtemplate" class="btn btn-success"/>
			</div>
		</form>
      </div>
    </div>
  </div>
  
  
<div class="panel panel-default">
    <div class="panel-heading">
		<h4 class="panel-title">
			<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapsefour">
				<?php _e('Add User', 'school-mgt'); ?>
			</a>
		</h4>
    </div>
    <div id="collapsefour" class="panel-collapse collapse">
		<div class="panel-body">
			<form id="email_template_form" class="form-horizontal" method="post" action="" name="parent_form">
				<div class="form-group">
					<label for="add_user_mail_subject" class="col-sm-3 control-label"><?php _e('Email Subject', 'school-mgt'); ?> <span class="require-field">*</span></label>
					<div class="col-md-8">
						<input class="form-control validate[required]" name="add_user_mail_subject" id="add_user_mail_subject" placeholder="Enter Email Subject" value="<?php echo get_option('add_user_mail_subject'); ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="add_user_mail_content" class="col-sm-3 control-label"><?php _e('Emails Sent to user When', 'school-mgt'); ?><span class="require-field">*</span></label>
					<div class="col-md-8">
						<textarea id="add_user_mail_content" name="add_user_mail_content" class="form-control validate[required] min_height_200"><?php echo get_option('add_user_mail_content');?></textarea>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-3 col-md-8">
						<label><?php _e('You can use following variables in the email template:','school-mgt');?></label><br>				
						<label><strong>{{user_name}} - </strong><?php _e('The student full name','school-mgt');?></label><br>
						<label><strong>{{school_name}} - </strong><?php _e('The parent name','school-mgt');?></label><br>
						<label><strong>{{role}} - </strong><?php _e('Student roll number','school-mgt');?></label><br>					
						<label><strong>{{login_link}} - </strong><?php _e('Student roll number','school-mgt');?></label><br>					
						<label><strong>{{username}} - </strong><?php _e('Student roll number','school-mgt');?></label><br>					
						<label><strong>{{password}} - </strong><?php _e('Student roll number','school-mgt');?></label><br>					
					</div>
				</div>
				<div class="col-sm-offset-3 col-sm-8">        	
					<input type="submit" value="<?php  _e('Save','school-mgt')?>" name="save_adduser_mailtemplate" class="btn btn-success"/>
				</div>
			</form>
		</div>
    </div>
</div>
  

<!--<div class="panel panel-default">
    <div class="panel-heading">
		<h4 class="panel-title">
			<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapsesix">
				<?php _e('Student Assign to Teacher mail template', 'school-mgt'); ?>
			</a>
		</h4>
    </div>
    <div id="collapsesix" class="panel-collapse collapse">
		<div class="panel-body">
			<form id="email_template_form" class="form-horizontal" method="post" action="" name="parent_form">
				<div class="form-group">
					<label for="student_assign_teacher_mail_subject" class="col-sm-3 control-label"><?php _e('Email Subject', 'school-mgt'); ?> <span class="require-field">*</span></label>
					<div class="col-md-8">
						<input class="form-control validate[required]" name="student_assign_teacher_mail_subject" id="student_assign_teacher_mail_subject" placeholder="Enter Email Subject" value="<?php echo get_option('student_assign_teacher_mail_subject'); ?>" />
					</div>
				</div>
				<div class="form-group">
					<label for="student_assign_teacher_mail_content" class="col-sm-3 control-label"><?php _e('Emails Sent to user When student Generate Invoice', 'school-mgt'); ?><span class="require-field">*</span></label>
					<div class="col-md-8">
						<textarea id="student_assign_teacher_mail_content" name="student_assign_teacher_mail_content" class="form-control validate[required]"><?php echo get_option('student_assign_teacher_mail_content');?></textarea>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-3 col-md-8">
						<label><?php _e('You can use following variables in the email template:','school-mgt');?></label><br>				
						<label><strong>{{student_name}} - </strong><?php _e('The student full name','school-mgt');?></label><br>
						<label><strong>{{school_name}} - </strong><?php _e('School Name','school-mgt');?></label><br>										
						<label><strong>{{teacher_name}} - </strong><?php _e('The Teacher name','school-mgt');?></label><br>										
					</div>
				</div>
				<div class="col-sm-offset-3 col-sm-8">        	
					<input type="submit" value="<?php  _e('Save','school-mgt')?>" name="save_student_assign_teacher_mailtemplate" class="btn btn-success"/>
				</div>
			</form>
		</div>
    </div>
</div>-->

<div class="panel panel-default">
    <div class="panel-heading">
		<h4 class="panel-title">
			<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapsesix">
				<?php _e('Student Assign to Teacher mail template', 'school-mgt'); ?>
			</a>
		</h4>
    </div>
    <div id="collapsesix" class="panel-collapse collapse">
		<div class="panel-body">
			<form id="email_template_form" class="form-horizontal" method="post" action="" name="parent_form">
				<div class="form-group">
					<label for="student_assign_teacher_mail_subject" class="col-sm-3 control-label"><?php _e('Email Subject', 'school-mgt'); ?> <span class="require-field">*</span></label>
					<div class="col-md-8">
						<input class="form-control validate[required]" name="student_assign_teacher_mail_subject" id="student_assign_teacher_mail_subject" placeholder="Enter Email Subject" value="<?php echo get_option('student_assign_teacher_mail_subject'); ?>" />
					</div>
				</div>
				<div class="form-group">
					<label for="student_assign_teacher_mail_content" class="col-sm-3 control-label "><?php _e('Message', 'school-mgt'); ?><span class="require-field">*</span></label>
					<div class="col-md-8">
						<textarea id="student_assign_teacher_mail_content" name="student_assign_teacher_mail_content" class="form-control validate[required] min_height_200"><?php echo get_option('student_assign_teacher_mail_content');?></textarea>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-3 col-md-8">
						<label><?php _e('You can use following variables in the email template:','school-mgt');?></label><br>				
						<label><strong>{{student_name}} - </strong><?php _e('The student full name','school-mgt');?></label><br>
						<label><strong>{{school_name}} - </strong><?php _e('School Name','school-mgt');?></label><br>										
						<label><strong>{{teacher_name}} - </strong><?php _e('The Teacher name','school-mgt');?></label><br>										
					</div>
				</div>
				<div class="col-sm-offset-3 col-sm-8">        	
					<input type="submit" value="<?php  _e('Save','school-mgt')?>" name="save_student_assign_teacher_mailtemplate" class="btn btn-success"/>
				</div>
			</form>
		</div>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
		<h4 class="panel-title">
			<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseseven">
				<?php _e('Message Received', 'school-mgt'); ?>
			</a>
		</h4>
    </div>
    <div id="collapseseven" class="panel-collapse collapse">
		<div class="panel-body">
			<form id="email_template_form" class="form-horizontal" method="post" action="" name="parent_form">
				<div class="form-group">
					<label for="message_received_mailsubject" class="col-sm-3 control-label"><?php _e('Subject', 'school-mgt'); ?> <span class="require-field">*</span></label>
					<div class="col-md-8">
						<input class="form-control validate[required]" name="message_received_mailsubject" id="message_received_mailsubject" placeholder="Enter Email Subject" value="<?php echo get_option('message_received_mailsubject'); ?>" />
					</div>
				</div>
				<div class="form-group">
					<label for="message_received_mailcontent" class="col-sm-3 control-label"><?php _e('Message', 'school-mgt'); ?><span class="require-field">*</span></label>
					<div class="col-md-8">
						<textarea id="message_received_mailcontent" name="message_received_mailcontent" class="form-control validate[required] min_height_200"><?php echo get_option('message_received_mailcontent');?></textarea>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-3 col-md-8">
						<label><?php _e('You can use following variables in the email template:','school-mgt');?></label><br>						
						<label><strong>{{from_mail}} - </strong><?php _e('Message sender name','school-mgt');?></label><br>
						<label><strong>{{school_name}} - </strong><?php _e('School Name','school-mgt');?></label><br>										
						<label><strong>{{receiver_name}} - </strong><?php _e('Message Receive Name','school-mgt');?></label><br>										
						<label><strong>{{message_content}} - </strong><?php _e('Message Content','school-mgt');?></label><br>										
					</div>
				</div>
				<div class="col-sm-offset-3 col-sm-8">        	
					<input type="submit" value="<?php  _e('Save','school-mgt')?>" name="save_messege_recived_mailtemplate" class="btn btn-success"/>
				</div>
			</form>
		</div>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
		<h4 class="panel-title">
			<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseight">
				<?php _e('Attendance Absent Notification', 'school-mgt'); ?>
			</a>
		</h4>
    </div>
    <div id="collapseight" class="panel-collapse collapse">
		<div class="panel-body">
			<form id="email_template_form" class="form-horizontal" method="post" action="" name="parent_form">
				<div class="form-group">
					<label for="absent_mail_notification_subject" class="col-sm-3 control-label"><?php _e('Subject', 'school-mgt'); ?> <span class="require-field">*</span></label>
					<div class="col-md-8">
						<input class="form-control validate[required]" name="absent_mail_notification_subject" id="absent_mail_notification_subject" placeholder="Enter Email Subject" value="<?php echo get_option('absent_mail_notification_subject'); ?>" />
					</div>
				</div>
				<div class="form-group">
					<label for="absent_mail_notification_content" class="col-sm-3 control-label"><?php _e('Emails Sent to user if student absent', 'school-mgt'); ?><span class="require-field">*</span></label>
					<div class="col-md-8">
						<textarea id="absent_mail_notification_content" name="absent_mail_notification_content" class="form-control validate[required] min_height_200"><?php echo get_option('absent_mail_notification_content');?></textarea>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-3 col-md-8">
						<label><?php _e('You can use following variables in the email template:','school-mgt');?></label><br>						
						<label><strong>{{child_name}} - </strong><?php _e('Enter name of child','school-mgt');?></label><br>	
					</div>
				</div>
				<div class="col-sm-offset-3 col-sm-8">        	
					<input type="submit" value="<?php  _e('Save','school-mgt')?>" name="save_student_absent_mailtemplate" class="btn btn-success"/>
				</div>
			</form>
		</div>
    </div>
</div>


<div class="panel panel-default">
    <div class="panel-heading">
		<h4 class="panel-title">
			<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapsnine">
				<?php _e('Student Assigned to Teacher Student mail template', 'school-mgt'); ?>
			</a>
		</h4>
    </div>
    <div id="collapsnine" class="panel-collapse collapse">
		<div class="panel-body">
			<form id="email_template_form" class="form-horizontal" method="post" action="" name="parent_form">
				<div class="form-group">
					<label for="student_assign_to_teacher_subject" class="col-sm-3 control-label"><?php _e('Subject', 'school-mgt'); ?> <span class="require-field">*</span></label>
					<div class="col-md-8">
						<input class="form-control validate[required]" name="student_assign_to_teacher_subject" id="student_assign_to_teacher_subject" placeholder="Enter Email Subject" value="<?php echo get_option('student_assign_to_teacher_subject'); ?>" />
					</div>
				</div>
				<div class="form-group">
					<label for="" class="col-sm-3 control-label"><?php _e('Emails Sent to user When Student Assigned to Teacher', 'school-mgt'); ?><span class="require-field">*</span></label>
					<div class="col-md-8">
						<textarea id="" name="" class="form-control validate[required] min_height_200"><?php echo get_option('');?></textarea>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-3 col-md-8">
						<label><?php _e('You can use following variables in the email template:','school-mgt');?></label><br>						
						<label><strong>{{teacher_name}} - </strong><?php _e('Enter teacher name','school-mgt');?></label><br>	
						<label><strong>{{school_name}} - </strong><?php _e('Enter school name','school-mgt');?></label><br>	
						<label><strong>{{student_name}} - </strong><?php _e('Enter student name','school-mgt');?></label><br>	
						<label><strong>{{class_name}} - </strong><?php _e('Enter Class name','school-mgt');?></label><br>	
					</div>
				</div>
				<div class="col-sm-offset-3 col-sm-8">        	
					<input type="submit" value="<?php  _e('Save','school-mgt')?>" name="save_student_assign_to_teacher_mailtemplate" class="btn btn-success"/>
				</div>
			</form>
		</div>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
		<h4 class="panel-title">
			<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapsten">
				<?php _e('Payment Received against Invoice', 'school-mgt'); ?>
			</a>
		</h4>
    </div>
    <div id="collapsten" class="panel-collapse collapse">
		<div class="panel-body">
			<form id="email_template_form" class="form-horizontal" method="post" action="" name="parent_form">
				<div class="form-group">
					<label for="payment_recived_mailsubject" class="col-sm-3 control-label"><?php _e('Subject', 'school-mgt'); ?> <span class="require-field">*</span></label>
					<div class="col-md-8">
						<input class="form-control validate[required]" name="payment_recived_mailsubject" id="payment_recived_mailsubject" placeholder="Enter Email Subject" value="<?php echo get_option('payment_recived_mailsubject'); ?>" />
					</div>
				</div>
				<div class="form-group">
					<label for="payment_recived_mailcontent" class="col-sm-3 control-label"><?php _e('Message', 'school-mgt'); ?><span class="require-field">*</span></label>
					<div class="col-md-8">
						<textarea id="payment_recived_mailcontent" name="payment_recived_mailcontent" class="form-control validate[required] min_height_200"><?php echo get_option('payment_recived_mailcontent');?></textarea>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-3 col-md-8">
						<label><?php _e('You can use following variables in the email template:','school-mgt');?></label><br>						
						<label><strong>{{school_name}} - </strong><?php _e('Enter school name','school-mgt');?></label><br>
						<label><strong>{{student_name}} - </strong><?php _e('Enter student name','school-mgt');?></label><br>
						<label><strong>{{invoice_no}} - </strong><?php _e('Enter Invoice No','school-mgt');?></label><br>
					</div>
				</div>
				<div class="col-sm-offset-3 col-sm-8">        	
					<input type="submit" value="<?php  _e('Save','school-mgt')?>" name="save_payment_recived_mailtemplate" class="btn btn-success"/>
				</div>
			</form>
		</div>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
		<h4 class="panel-title">
			<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseleven">
				<?php _e('Notice', 'school-mgt'); ?>
			</a>
		</h4>
    </div>
    <div id="collapseleven" class="panel-collapse collapse">
		<div class="panel-body">
			<form id="email_template_form" class="form-horizontal" method="post" action="" name="parent_form">
				<div class="form-group">
					<label for="notice_mailsubject" class="col-sm-3 control-label"><?php _e('Subject', 'school-mgt'); ?> <span class="require-field">*</span></label>
					<div class="col-md-8">
						<input class="form-control validate[required]" name="notice_mailsubject" id="notice_mailsubject" placeholder="Enter Email Subject" value="<?php echo get_option('notice_mailsubject'); ?>" />
					</div>
				</div>
				<div class="form-group">
					<label for="notice_mailcontent" class="col-sm-3 control-label"><?php _e('Message', 'school-mgt'); ?><span class="require-field">*</span></label>
					<div class="col-md-8">
						<textarea id="notice_mailcontent" name="notice_mailcontent" class="form-control validate[required] min_height_200"><?php echo get_option('notice_mailcontent');?></textarea>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-3 col-md-8">
						<label><?php _e('You can use following variables in the email template:','school-mgt');?></label><br>						
						<label><strong>{{notice_title}} - </strong><?php _e('Enter notice title','school-mgt');?></label><br>
						<label><strong>{{notice_date}} 	- </strong><?php _e('Enter notice date','school-mgt');?></label><br>
						<label><strong>{{notice_for}}	 - </strong><?php _e('Enter role name for notice','school-mgt');?></label><br>
						<label><strong>{{notice_comment}} - </strong><?php _e('Enter notice comment','school-mgt');?></label><br>
					</div>
				</div>
				<div class="col-sm-offset-3 col-sm-8">        	
					<input type="submit" value="<?php  _e('Save','school-mgt')?>" name="save_notice_mailtemplate" class="btn btn-success"/>
				</div>
			</form>
		</div>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
		<h4 class="panel-title">
			<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapstwelve">
				<?php _e('Holiday', 'school-mgt'); ?>
			</a>
		</h4>
    </div>
    <div id="collapstwelve" class="panel-collapse collapse">
		<div class="panel-body">
			<form id="email_template_form" class="form-horizontal" method="post" action="" name="parent_form">
				<div class="form-group">
					<label for="holiday_mailsubject" class="col-sm-3 control-label"><?php _e('Subject', 'school-mgt'); ?> <span class="require-field">*</span></label>
					<div class="col-md-8">
						<input class="form-control validate[required]" name="holiday_mailsubject" id="holiday_mailsubject" placeholder="Enter Email Subject" value="<?php echo get_option('holiday_mailsubject'); ?>" />
					</div>
				</div>
				<div class="form-group">
					<label for="holiday_mailcontent" class="col-sm-3 control-label"><?php _e('Message', 'school-mgt'); ?><span class="require-field">*</span></label>
					<div class="col-md-8">
						<textarea id="holiday_mailcontent" name="holiday_mailcontent" class="form-control validate[required] min_height_200"><?php echo get_option('holiday_mailcontent');?></textarea>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-3 col-md-8">
						<label><?php _e('You can use following variables in the email template:','school-mgt');?></label><br>						
						<label><strong>{{holiday_title}} - </strong><?php _e('Enter holiday title','school-mgt');?></label><br>
						<label><strong>{{holiday_date}} 	- </strong><?php _e('Enter holiday date','school-mgt');?></label><br>						
					</div>
				</div>
				<div class="col-sm-offset-3 col-sm-8">        	
					<input type="submit" value="<?php  _e('Save','school-mgt')?>" name="save_holiday_mailtemplate" class="btn btn-success"/>
				</div>
			</form>
		</div>
    </div>
</div>


<div class="panel panel-default">
    <div class="panel-heading">
		<h4 class="panel-title">
			<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapstharty">
				<?php _e('School Bus Allocation', 'school-mgt'); ?>
			</a>
		</h4>
    </div>
    <div id="collapstharty" class="panel-collapse collapse">
		<div class="panel-body">
			<form id="email_template_form" class="form-horizontal" method="post" action="" name="parent_form">
				<div class="form-group">
					<label for="school_bus_alocation_mail_subject" class="col-sm-3 control-label"><?php _e('Subject', 'school-mgt'); ?> <span class="require-field">*</span></label>
					<div class="col-md-8">
						<input class="form-control validate[required]" name="school_bus_alocation_mail_subject" id="school_bus_alocation_mail_subject" placeholder="Enter Email Subject" value="<?php echo get_option('school_bus_alocation_mail_subject'); ?>" />
					</div>
				</div>
				<div class="form-group">
					<label for="school_bus_alocation_mail_content" class="col-sm-3 control-label"><?php _e('Message', 'school-mgt'); ?><span class="require-field">*</span></label>
					<div class="col-md-8">
						<textarea id="school_bus_alocation_mail_content" name="school_bus_alocation_mail_content" class="form-control validate[required] min_height_200"><?php echo get_option('school_bus_alocation_mail_content');?></textarea>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-3 col-md-8">
						<label><?php _e('You can use following variables in the email template:','school-mgt');?></label><br>						
						<label><strong>{{route_name}} - </strong><?php _e('Enter route name','school-mgt');?></label><br>
						<label><strong>{{vehicle_identifier}} 	- </strong><?php _e('Enter Vehicle Identifier ','school-mgt');?></label><br>						
						<label><strong>{{vehicle_registration_number}} 	- </strong><?php _e('Enter Vehicle Registration Number ','school-mgt');?></label><br>						
						<label><strong>{{driver_name}} 	- </strong><?php _e('Enter Driver Name','school-mgt');?></label><br>						
						<label><strong>{{driver_phone_number}} 	- </strong><?php _e('Enter Driver Phone Number','school-mgt');?></label><br>						
						<label><strong>{{driver_address}} 	- </strong><?php _e('Enter Driver Address','school-mgt');?></label><br>						
						<label><strong>{{school_name}} 	- </strong><?php _e('Enter school name','school-mgt');?></label><br>						
					</div>
				</div>
				<div class="col-sm-offset-3 col-sm-8">        	
					<input type="submit" value="<?php  _e('Save','school-mgt')?>" name="save_bus_alocation_mailtemplate" class="btn btn-success"/>
				</div>
			</form>
		</div>
    </div>
</div>

  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapsforty">
          <?php _e('HomeWork Mail Template For Student', 'school-mgt'); ?>
        </a>
      </h4>
    </div>
    <div id="collapsforty" class="panel-collapse collapse">
      <div class="panel-body">
        <form id="email_template_form" class="form-horizontal" method="post" action="" name="parent_form">
			<div class="form-group">
				<label for="learner_complete_quiz_notification_title" class="col-sm-3 control-label"><?php _e('Email Subject ','school-mgt');?><span class="require-field">*</span></label>
				<div class="col-md-8">
					<input class="form-control validate[required]" name="homework_title" id="homework_title" placeholder="Enter Email Subject" value="<?php echo get_option('homework_title'); ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="learner_complete_quiz_notification_mailcontent" class="col-sm-3 control-label"><?php _e('Emails Sent Students When Give Homework','school-mgt');?><span class="require-field">*</span></label>
				<div class="col-md-8">
					<textarea id="homework_mailcontent" name="homework_mailcontent" class="form-control validate[required] min_height_200"><?php echo get_option('homework_mailcontent');?></textarea>
				</div>
			</div>
			<div class="form-group">
						<div class="col-sm-offset-3 col-md-8">
							<label><?php _e('You can use following variables in the Homework email template:','school-mgt');?></label><br>				
							<label><strong>{{student_name}} - </strong><?php _e('The student full name or login name (whatever is available)','school-mgt');?></label><br>							
							<label><strong>{{title}} - </strong><?php _e('Student homework title','school-mgt');?></label><br>
							<label><strong>{{submition_date}} - </strong><?php _e('Submission Date','school-mgt');?></label><br>
							<label><strong>{{school_name}} - </strong><?php _e('School name','school-mgt');?></label><br>			
	                    </div>
			</div>
			<div class="col-sm-offset-3 col-sm-8">        	
				<input type="submit" value="<?php  _e('Save','school-mgt')?>" name="save_homework_mailtemplate" class="btn btn-success"/>
			</div>
		</form>
      </div>
    </div>
  </div>
  
  
   <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapsfifteen">
          <?php _e('HomeWork Mail Template For Parent', 'school-mgt'); ?>
        </a>
      </h4>
    </div>
    <div id="collapsfifteen" class="panel-collapse collapse">
      <div class="panel-body">
        <form id="email_template_form" class="form-horizontal" method="post" action="" name="parent_form">
			<div class="form-group">
				<label for="learner_complete_quiz_notification_title" class="col-sm-3 control-label"><?php _e('Email Subject ','school-mgt');?><span class="require-field">*</span></label>
				<div class="col-md-8">
					<input id="student_activation_title" class="form-control validate[required]" name="parent_homework_mail_subject" id="parent_homework_mail_subject" placeholder="Enter Email Subject" value="<?php echo get_option('parent_homework_mail_subject'); ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="learner_complete_quiz_notification_mailcontent" class="col-sm-3 control-label"><?php _e('Emails Sent to Parents When A Give Homework','school-mgt');?><span class="require-field">*</span></label>
				<div class="col-md-8">
					<textarea id="parent_homework_mail_content" name="parent_homework_mail_content" class="form-control validate[required] min_height_200"><?php echo get_option('parent_homework_mail_content');?></textarea>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-3 col-md-8">
					<label><?php _e('You can use following variables in the email template:','school-mgt');?></label><br>				
					<label><strong>{{student_name}} - </strong><?php _e('The student full name','school-mgt');?></label><br>
					<label><strong>{{parent_name}} - </strong><?php _e('The parent name','school-mgt');?></label><br>
					<label><strong>{{title}} - </strong><?php _e('Student homework title','school-mgt');?></label><br>
					<label><strong>{{submition_date}} - </strong><?php _e('Submission Date','school-mgt');?></label><br>
					<label><strong>{{school_name}} - </strong><?php _e('School name','school-mgt');?></label><br>	
				</div>
			</div>
			<div class="col-sm-offset-3 col-sm-8">        	
				<input type="submit" value="<?php  _e('Save','school-mgt')?>" name="save_homework_mailtemplate_parent" class="btn btn-success"/>
			</div>
		</form>
      </div>
    </div>
  </div>
  
   <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapsfifteenone">
          <?php _e('Student Exam Hall Receipt', 'school-mgt'); ?>
        </a>
      </h4>
    </div>
    <div id="collapsfifteenone" class="panel-collapse collapse">
      <div class="panel-body">
        <form id="email_template_form" class="form-horizontal" method="post" action="" name="parent_form">
			<div class="form-group">
				<label for="learner_complete_quiz_notification_title" class="col-sm-3 control-label"><?php _e('Email Subject ','school-mgt');?><span class="require-field">*</span></label>
				<div class="col-md-8">
					<input id="student_activation_title" class="form-control validate[required]" name="exam_receipt_subject" id="exam_receipt_subject" placeholder="Enter Email Subject" value="<?php echo get_option('exam_receipt_subject'); ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="learner_complete_quiz_notification_mailcontent" class="col-sm-3 control-label"><?php _e('Message','school-mgt');?><span class="require-field">*</span></label>
				<div class="col-md-8">
					<textarea id="exam_receipt_content" name="exam_receipt_content" class="form-control validate[required] min_height_200"><?php echo get_option('exam_receipt_content');?></textarea>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-3 col-md-8">
					<label><?php _e('You can use following variables in the email template:','school-mgt');?></label><br>				
					<label><strong>{{student_name}} - </strong><?php _e('The student full name','school-mgt');?></label><br>
					<label><strong>{{school_name}} - </strong><?php _e('School name','school-mgt');?></label><br>	
				</div>
			</div>
			<div class="col-sm-offset-3 col-sm-8">        	
				<input type="submit" value="<?php  _e('Save','school-mgt')?>" name="save_exam_receipt_generate" class="btn btn-success"/>
			</div>
		</form>
      </div>
    </div>
  </div>
  
   
   <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapsfifteentwo">
          <?php _e('Hostel Bed Assigned Template', 'school-mgt'); ?>
        </a>
      </h4>
    </div>
    <div id="collapsfifteentwo" class="panel-collapse collapse">
      <div class="panel-body">
        <form id="email_template_form" class="form-horizontal" method="post" action="" name="parent_form">
			<div class="form-group">
				<label for="learner_complete_quiz_notification_title" class="col-sm-3 control-label"><?php _e('Email Subject ','school-mgt');?><span class="require-field">*</span></label>
				<div class="col-md-8">
					<input id="student_activation_title" class="form-control validate[required]" name="bed_subject" id="bed_subject" placeholder="Enter Email Subject" value="<?php echo get_option('bed_subject'); ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="learner_complete_quiz_notification_mailcontent" class="col-sm-3 control-label"><?php _e('Message','school-mgt');?><span class="require-field">*</span></label>
				<div class="col-md-8">
					<textarea id="bed_content" name="bed_content" class="form-control validate[required] min_height_200"><?php echo get_option('bed_content');?></textarea>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-3 col-md-8">
					<label><?php _e('You can use following variables in the email template:','school-mgt');?></label><br>				
					<label><strong>{{student_name}} - </strong><?php _e('The student full name','school-mgt');?></label><br>
					<label><strong>{{hostel_name}} - </strong><?php _e('Hostel name','school-mgt');?></label><br>
					<label><strong>{{room_id}} - </strong><?php _e('Room number','school-mgt');?></label><br>
					<label><strong>{{bed_id}} - </strong><?php _e('Bed number','school-mgt');?></label><br>
					<label><strong>{{school_name}} - </strong><?php _e('School name','school-mgt');?></label><br>	
				</div>
			</div>
			<div class="col-sm-offset-3 col-sm-8">        	
				<input type="submit" value="<?php  _e('Save','school-mgt')?>" name="save_bed_template" class="btn btn-success"/>
			</div>
		</form>
      </div>
    </div>
  </div>

<div class="panel panel-default">
    <div class="panel-heading">
	    <h4 class="panel-title">
	        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapsfifteenthree">
	          <?php _e('Virtual ClassRoom Teacher Invite Template', 'school-mgt'); ?>
	        </a>
	    </h4>
    </div>
    <div id="collapsfifteenthree" class="panel-collapse collapse">
      	<div class="panel-body">
	        <form id="email_template_form" class="form-horizontal" method="post" action="" name="virtual_class_invite_teacher_form">
				<div class="form-group">
					<label for="learner_complete_quiz_notification_title" class="col-sm-3 control-label"><?php _e('Email Subject ','school-mgt');?><span class="require-field">*</span></label>
					<div class="col-md-8">
						<input id="virtual_class_invite_teacher_mail_subject" class="form-control validate[required]" name="virtual_class_invite_teacher_mail_subject" id="virtual_class_invite_teacher_mail_subject" placeholder="Enter Email Subject" value="<?php echo get_option('virtual_class_invite_teacher_mail_subject'); ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="virtual_class_invite_teacher_mail_content" class="col-sm-3 control-label"><?php _e('Message','school-mgt');?><span class="require-field">*</span></label>
					<div class="col-md-8">
						<textarea id="bed_content" name="virtual_class_invite_teacher_mail_content" class="form-control validate[required] min_height_200"><?php echo get_option('virtual_class_invite_teacher_mail_content');?></textarea>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-3 col-md-8">
						<label><?php _e('You can use following variables in the email template:','school-mgt');?></label><br>				
						<label><strong>{{class_name}} - </strong><?php _e('Class Name','school-mgt');?></label><br>
						<label><strong>{{time}} - </strong><?php _e('Time','school-mgt');?></label><br>
						<label><strong>{{virtual_class_id}} - </strong><?php _e('Virtual Class ID','school-mgt');?></label><br>
						<label><strong>{{password}} - </strong><?php _e('Password','school-mgt');?></label><br>
						<label><strong>{{join_zoom_virtual_class}} - </strong><?php _e('Join Zoom Virtual Class','school-mgt');?></label><br>
						<label><strong>{{start_zoom_virtual_class}} - </strong><?php _e('Start Zoom Virtual Class','school-mgt');?></label><br>
						<label><strong>{{school_name}} - </strong><?php _e('School name','school-mgt');?></label><br>
					</div>
				</div>
				<div class="col-sm-offset-3 col-sm-8">        	
					<input type="submit" value="<?php  _e('Save','school-mgt')?>" name="virtual_class_invite_teacher_form_template" class="btn btn-success"/>
				</div>
			</form>
      	</div>
    </div>
</div>
<!-- Virtual ClassRoom Teacher Reminder Template -->
<div class="panel panel-default">
    <div class="panel-heading">
	    <h4 class="panel-title">
	        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapsfifteenfour">
	          <?php _e('Virtual ClassRoom Teacher Reminder Template', 'school-mgt'); ?>
	        </a>
	    </h4>
    </div>
    <div id="collapsfifteenfour" class="panel-collapse collapse">
      	<div class="panel-body">
	        <form id="email_template_form" class="form-horizontal" method="post" action="" name="virtual_class_teacher_reminder_form">
				<div class="form-group">
					<label for="learner_complete_quiz_notification_title" class="col-sm-3 control-label"><?php _e('Email Subject ','school-mgt');?><span class="require-field">*</span></label>
					<div class="col-md-8">
						<input id="virtual_class_invite_teacher_mail_subject" class="form-control validate[required]" name="virtual_class_teacher_reminder_mail_subject" id="virtual_class_invite_teacher_mail_subject" placeholder="Enter Email Subject" value="<?php echo get_option('virtual_class_teacher_reminder_mail_subject'); ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="virtual_class_invite_teacher_mail_content" class="col-sm-3 control-label"><?php _e('Message','school-mgt');?><span class="require-field">*</span></label>
					<div class="col-md-8">
						<textarea id="bed_content" name="virtual_class_teacher_reminder_mail_content" class="form-control validate[required] min_height_200"><?php echo get_option('virtual_class_teacher_reminder_mail_content');?></textarea>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-3 col-md-8">
						<label><?php _e('You can use following variables in the email template:','school-mgt');?></label><br>		
						<label><strong>{{teacher_name}} - </strong><?php _e('Teacher Name','school-mgt');?></label><br>	
						<label><strong>{{class_name}} - </strong><?php _e('Class Name','school-mgt');?></label><br>
						<label><strong>{{subject_name}} - </strong><?php _e('subject Name','school-mgt');?></label><br>
						<label><strong>{{date}} - </strong><?php _e('Date','school-mgt');?></label><br>
						<label><strong>{{time}} - </strong><?php _e('Time','school-mgt');?></label><br>
						<label><strong>{{virtual_class_id}} - </strong><?php _e('Virtual Class ID','school-mgt');?></label><br>
						<label><strong>{{password}} - </strong><?php _e('Password','school-mgt');?></label><br>
						<label><strong>{{start_zoom_virtual_class}} - </strong><?php _e('Start Zoom Virtual Class','school-mgt');?></label><br>
						<label><strong>{{school_name}} - </strong><?php _e('School name','school-mgt');?></label><br>
					</div>
				</div>
				<div class="col-sm-offset-3 col-sm-8">        	
					<input type="submit" value="<?php  _e('Save','school-mgt')?>" name="virtual_class_teacher_reminder_template" class="btn btn-success"/>
				</div>
			</form>
      	</div>
    </div>
</div>
<!-- Virtual ClassRoom Student Reminder Template -->
<div class="panel panel-default">
    <div class="panel-heading">
	    <h4 class="panel-title">
	        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapsfifteenfive">
	          <?php _e('Virtual ClassRoom Student Reminder Template', 'school-mgt'); ?>
	        </a>
	    </h4>
    </div>
    <div id="collapsfifteenfive" class="panel-collapse collapse">
      	<div class="panel-body">
	        <form id="email_template_form" class="form-horizontal" method="post" action="" name="virtual_class_student_reminder_form">
				<div class="form-group">
					<label for="learner_complete_quiz_notification_title" class="col-sm-3 control-label"><?php _e('Email Subject ','school-mgt');?><span class="require-field">*</span></label>
					<div class="col-md-8">
						<input id="virtual_class_invite_teacher_mail_subject" class="form-control validate[required]" name="virtual_class_student_reminder_mail_subject" id="virtual_class_invite_teacher_mail_subject" placeholder="Enter Email Subject" value="<?php echo get_option('virtual_class_student_reminder_mail_subject'); ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="virtual_class_invite_teacher_mail_content" class="col-sm-3 control-label"><?php _e('Message','school-mgt');?><span class="require-field">*</span></label>
					<div class="col-md-8">
						<textarea id="bed_content" name="virtual_class_student_reminder_mail_content" class="form-control validate[required] min_height_200"><?php echo get_option('virtual_class_student_reminder_mail_content');?></textarea>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-3 col-md-8">
						<label><?php _e('You can use following variables in the email template:','school-mgt');?></label><br>		
						<label><strong>{{student_name}} - </strong><?php _e('Student Name','school-mgt');?></label><br>
						<label><strong>{{class_name}} - </strong><?php _e('Class Name','school-mgt');?></label><br>
						<label><strong>{{subject_name}} - </strong><?php _e('subject Name','school-mgt');?></label><br>
						<label><strong>{{teacher_name}} - </strong><?php _e('Teacher Name','school-mgt');?></label><br>
						<label><strong>{{date}} - </strong><?php _e('Date','school-mgt');?></label><br>
						<label><strong>{{time}} - </strong><?php _e('Time','school-mgt');?></label><br>
						<label><strong>{{virtual_class_id}} - </strong><?php _e('Virtual Class ID','school-mgt');?></label><br>
						<label><strong>{{password}} - </strong><?php _e('Password','school-mgt');?></label><br>
						<label><strong>{{join_zoom_virtual_class}} - </strong><?php _e('join Zoom Virtual Class','school-mgt');?></label><br>
						<label><strong>{{school_name}} - </strong><?php _e('School name','school-mgt');?></label><br>
					</div>
				</div>
				<div class="col-sm-offset-3 col-sm-8">        	
					<input type="submit" value="<?php  _e('Save','school-mgt')?>" name="virtual_class_student_reminder_template" class="btn btn-success"/>
				</div>
			</form>
      	</div>
    </div>
</div>
	
</div>
</div>
</div>
</div>
</div>
</div>