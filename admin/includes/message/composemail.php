<script type="text/javascript">
$(document).ready(function() 
{
	$('#message_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
} );
</script>
<div class="mailbox-content">
	<h2><?php 
	$edit=0;
	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
	{
		echo esc_html( __( 'Edit Message', 'school-mgt') );
		$edit=1;
		 $exam_data= get_exam_by_id($_REQUEST['exam_id']);
	}
	?></h2>     
<script type="text/javascript">
$(document).ready(function() 
{	
	 $('#selected_users').multiselect({ 
		 nonSelectedText :"<?php esc_html_e('Select Users','school-mgt');?>",
		includeSelectAllOption: true,
		enableFiltering: true,
		enableCaseInsensitiveFiltering: true         
     });
	 $('#selected_class').multiselect({ 
		 nonSelectedText :'<?php _e("Select Class","school-mgt");?>',
         includeSelectAllOption: true,
		enableFiltering: true,
		enableCaseInsensitiveFiltering: true            
     });
	$("body").on("click",".save_message_selected_user",function()
	{		
		var class_selection_type = $(".class_selection_type").val();	
				
		if(class_selection_type == 'multiple')
		{
			var checked = $(".multiselect_validation1 .dropdown-menu input:checked").length;

			if(!checked)
			{
				alert("<?php esc_html_e('Please select atleast one class','school-mgt');?>");
				return false;
			}	
		}			
	});  
	jQuery("body").on("change", ".input-file[type=file]", function ()
	{ 
		"use strict";
		var file = this.files[0]; 		
		var ext = $(this).val().split('.').pop().toLowerCase(); 
		//Extension Check 
		if($.inArray(ext, [,'pdf','doc','docx','xls','xlsx','ppt','pptx','gif','png','jpg','jpeg','']) == -1)
		{
			  alert('<?php _e("Only pdf,doc,docx,xls,xlsx,ppt,pptx,gif,png,jpg,jpeg formate are allowed. '  + ext + ' formate are not allowed.","school-mgt") ?>');
			$(this).replaceWith('<input class="btn_top input-file" name="message_attachment[]" type="file" />');
			return false; 
		} 
		//File Size Check 
		if (file.size > 20480000) 
		{
			alert("<?php esc_html_e('Too large file Size. Only file smaller than 10MB can be uploaded.','school-mgt');?>");
			$(this).replaceWith('<input class="btn_top input-file" name="message_attachment[]" type="file" />'); 
			return false; 
		}
	}); 
});
function add_new_attachment()
{
	$(".attachment_div").append('<div class="form-group"><label class="col-sm-2 control-label" for="photo"><?php _e('Attachment ','school-mgt');?></label><div class="col-sm-4"><input  class="btn_top input-file" name="message_attachment[]" type="file" /></div><div class="col-sm-2"><input type="button" value="<?php _e('Delete','school-mgt');?>" onclick="delete_attachment(this)" class="remove_cirtificate doc_label btn btn-danger"></div></div>');
}
function delete_attachment(n)
{
	n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);				
}
</script>
<form name="class_form" action="" method="post" class="form-horizontal" id="message_form" enctype="multipart/form-data">
    <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
	<input type="hidden" name="action" value="<?php echo $action;?>">
    <div class="form-group">
        <label class="col-sm-2 control-label" for="to"><?php _e('Message To','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<select name="receiver" class="form-control validate[required] text-input min_width_100" id="send_to">						
					<option value="student"><?php _e('Students','school-mgt');?></option>	
					<option value="teacher"><?php _e('Teachers','school-mgt');?></option>	
					<option value="parent"><?php _e('Parents','school-mgt');?></option>	
					<option value="supportstaff"><?php _e('Support Staff','school-mgt');?></option>	
					<?php //echo smgt_get_all_user_in_message();?>
				</select>
			</div>	
    </div>
	<div class="form-group class_selection">
        <label class="col-sm-2 control-label" for="to"><?php _e('Class Selection Type','school-mgt');?></label>
		<div class="col-sm-8">
			<select name="class_selection_type" class="form-control text-input class_selection_type min_width_100">						
				<option value="single"><?php _e('Single','school-mgt');?></option>	
				<option value="multiple"><?php _e('Multiple','school-mgt');?></option>	
			</select>
		</div>	
    </div>
	<div class="form-group multiple_class_div">
		<label class="col-sm-2 control-label" ><?php _e('Select Class','school-mgt');?><span class="require-field">*</span></label>
		<div class="col-sm-8 multiselect_validation1">			
			 <select name="multi_class_id[]" class="form-control" id="selected_class" multiple="true">
				<?php
				  foreach(get_allclass() as $classdata)
				  {  
					?>
						<option  value="<?php echo $classdata['class_id'];?>" ><?php echo $classdata['class_name'];?></option>
					<?php 
				  }
				?>
			</select>
		</div>
	</div>
    <div id="smgt_select_class" class="single_class_div">
		<div class="form-group class_list_id">
			<label class="col-sm-2 control-label" for="sms_template"><?php _e('Select Class','school-mgt');?></label>
			<div class="col-sm-8">			
				 <select name="class_id"  id="class_list_id" class="form-control min_width_100">
                	<option value=""><?php _e('All','school-mgt');?></option>
                    <?php
					  foreach(get_allclass() as $classdata)
					  {  
					  ?>
					   <option  value="<?php echo $classdata['class_id'];?>" ><?php echo $classdata['class_name'];?></option>
				 <?php }?>
                </select>
			</div>
		</div>
	</div>
		
	<div class="form-group class_section_id">
		<label class="col-sm-2 control-label" for="class_name"><?php _e('Class Section','school-mgt');?></label>
		<div class="col-sm-8">
			<?php if(isset($_POST['class_section'])){$sectionval=$_POST['class_section'];}else{$sectionval='';}?>
				<select name="class_section" class="form-control min_width_100" id="class_section_id">
					<option value=""><?php _e('Select Class Section','school-mgt');?></option>
					<?php
					if($edit){
						foreach(smgt_get_class_sections($user_info->class_name) as $sectiondata)
						{  ?>
						 <option value="<?php echo $sectiondata->id;?>" <?php selected($sectionval,$sectiondata->id);  ?>><?php echo $sectiondata->section_name;?></option>
					<?php } 
					}?>
				</select>
		</div>
	</div>
	<div class="form-group single_class_div support_staff_user_div">
		<div id="messahe_test"></div>
		<label class="col-sm-2 control-label"><?php _e('Select Users','school-mgt');?></label>
		<div class="col-sm-8">
		<span class="user_display_block">
			<select name="selected_users[]" id="selected_users" class="form-control min_width_250px" multiple="true">					
				<?php 
				$student_list = get_all_student_list();
				foreach($student_list  as $retrive_data)
				{
					echo '<option value="'.$retrive_data->ID.'">'.$retrive_data->display_name.'</option>';
				}
				?>
			</select>
		</span>
		</div>
	</div>
		<div id="class_student_list"></div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="subject"><?php _e('Subject','school-mgt');?><span class="require-field">*</span></label>
            <div class="col-sm-8">
				<input id="subject" class="form-control validate[required,custom[popup_category_validation]] text-input" maxlength="50" type="text" name="subject" >
            </div>
		</div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="subject"><?php _e('Message Comment','school-mgt');?><span class="require-field">*</span></label>
            <div class="col-sm-8">
                <textarea name="message_body" id="message_body" maxlength="150" class="form-control validate[required,custom[address_description_validation]] text-input"></textarea>
            </div>
		</div>
		<div class="attachment_div">
			<div class="form-group">
				<label class="col-sm-2 control-label" for="photo"><?php _e('Attachment ','school-mgt');?></label>
				<div class="col-sm-4">
				 <input  class="btn_top input-file" name="message_attachment[]" type="file" />
				</div>										
			</div>							
       	</div>	
		<div class="form-group">		
			<div class="col-sm-offset-2 col-sm-10">
				<input type="button" value="<?php esc_attr_e('Add More Attachment','school-mgt') ?>"  onclick="add_new_attachment()" class="btn more_attachment">
			</div>	
		</div>									
		<div class="form-group">
			<label class="col-sm-2 control-label " for="enable"><?php _e('Send SMS','school-mgt');?></label>
			<div class="col-sm-8">
				 <div class="checkbox">
				 	<label>
  						<input id="chk_sms_sent" type="checkbox"  value="1" name="smgt_sms_service_enable">
  					</label>
  				</div>
			</div>
		</div>
		<div id="hmsg_message_sent" class="hmsg_message_none">
		<div class="form-group">
			<label class="col-sm-2 control-label" for="sms_template"><?php _e('SMS Text','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<textarea name="sms_template" class="form-control validate[required]" maxlength="160"></textarea>
				<label><?php _e('Max. 160 Character','school-mgt');?></label>
			</div>
		</div>
		</div>			
        <div class="form-group">
            <div class="col-sm-10">
                <div class="pull-right">
                    <input type="submit" value="<?php if($edit){ _e('Save Message','school-mgt'); }else{ _e('Send Message','school-mgt');}?>" name="save_message" class="btn btn-success save_message_selected_user"/>
                </div>
            </div>
        </div>       
    </form>
</div>