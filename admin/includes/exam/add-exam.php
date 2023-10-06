<!--Group POP up code -->
<div class="popup-bg">
	<div class="overlay-content admission_popup">
		<div class="modal-content">
			<div class="category_list">
			</div>     
		</div>
	</div>     
</div>
<script type="text/javascript">
$(document).ready(function()
 {
	 $('#exam_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
	 $("#exam_start_date").datepicker({
        dateFormat: "yy-mm-dd",
		minDate:0,
        onSelect: function (selected) {
            var dt = new Date(selected);
            dt.setDate(dt.getDate() + 0);
            $("#exam_end_date").datepicker("option", "minDate", dt);
        }
    });
    $("#exam_end_date").datepicker({
       dateFormat: "yy-mm-dd",
	   minDate:0,
        onSelect: function (selected) {
            var dt = new Date(selected);
            dt.setDate(dt.getDate() + 0);
            $("#exam_start_date").datepicker("option", "maxDate", dt);
        }
    });
	jQuery("body").on("change", ".input-file[type=file]", function ()
	{ 
		var file = this.files[0]; 
		var file_id = jQuery(this).attr('id'); 
		var ext = $(this).val().split('.').pop().toLowerCase(); 
		//Extension Check 
		if($.inArray(ext, ['pdf']) == -1)
		{
			  alert('<?php esc_html_e("Only pdf formate are allowed.","school-mgt") ?>');
			$(this).replaceWith('<input type="file" name="exam_syllabus" class="form-control file_validation input-file">');
			return false; 
		} 
		 //File Size Check 
		 if (file.size > 20480000) 
		 {
			alert("<?php esc_html_e('Too large file Size. Only file smaller than 10MB can be uploaded.','school-mgt');?>");
			$(this).replaceWith('<input type="file" name="exam_syllabus" class="form-control file_validation input-file">'); 
			return false; 
		 }
	 });
		
		 
} );
</script>
<script type="text/javascript">
	//alert("hello");
	jQuery('.onlyletter_number_space_validation').keypress(function(e) 
	{     
		var regex = new RegExp("^[0-9a-zA-Z \b]+$");
		var key = String.fromCharCode(!event.charCode ? event.which: event.charCode);
		if (!regex.test(key)) 
		{
			event.preventDefault();
			return false;
		} 
   });  
	</script>
<?php
	$edit=0;
	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
	{
		$edit=1;
		$exam_data= get_exam_by_id($_REQUEST['exam_id']);
	}
?>
    <div class="panel-body">	
        <form name="exam_form" action="" method="post" class="form-horizontal" enctype="multipart/form-data" id="exam_form">
          <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
		<input type="hidden" name="action" value="<?php echo $action;?>">
        <div class="form-group">
			<label class="col-sm-2 control-label " for="exam_name"><?php _e('Exam Name','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="exam_name" class="form-control validate[required,custom[popup_category_validation]]" maxlength="50" type="text" value="<?php if($edit){ echo $exam_data->exam_name;}?>"  placeholder="<?php esc_html_e('Enter Exam Name','school-mgt');?>"  name="exam_name">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="class_id"><?php _e('Class Name','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<select name="class_id" class="form-control validate[required] width_100" id="class_list">
					<option value=""><?php echo _e( 'Select Class', 'school-mgt' ) ;?></option>
					<?php $classval='';
					if($edit){  
						$classval=$exam_data->class_id; 
						foreach(get_allclass() as $class)
						{ ?>
						<option value="<?php echo $class['class_id'];?>" <?php selected($class['class_id'],$classval);  ?>>
						<?php echo get_class_name($class['class_id']);?></option> 
					<?php }
					}else
					{
						foreach(get_allclass() as $classdata)
						{ ?>
						<option value="<?php echo $classdata['class_id'];?>" <?php selected($classdata['class_id'],$classval);  ?>><?php echo $classdata['class_name'];?></option> 
					<?php }
					}
					?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="class_name"><?php _e('Section Name','school-mgt');?></label>
			<div class="col-sm-8">
				<?php if($edit){ $sectionval=$exam_data->section_id; }elseif(isset($_POST['class_section'])){$sectionval=$_POST['class_section'];}else{$sectionval='';}?>
					<select name="class_section" class="form-control width_100" id="class_section">
						<option value=""><?php _e('Select Class Section','school-mgt');?></option>
						<?php
						if($edit){
							foreach(smgt_get_class_sections($exam_data->class_id) as $sectiondata)
							{  ?>
							 <option value="<?php echo $sectiondata->id;?>" <?php selected($sectionval,$sectiondata->id);  ?>><?php echo $sectiondata->section_name;?></option>
						<?php }
						}?>
					</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="Exam Term"><?php _e('Exam Term','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-md-8 col-sm-8 col-xs-12">	
				<?php if($edit){ $sectionval1=$exam_data->exam_term; }elseif(isset($_POST['exam_term'])){$sectionval1=$_POST['exam_term'];}else{$sectionval1='';}?>
				<select class="form-control validate[required] term_category margin_top_10 width_100" name="exam_term">
					<option value=""><?php esc_html_e('Select Term','school-mgt');?></option>
					<?php 
					$activity_category=smgt_get_all_category('term_category');
					if(!empty($activity_category))
					{
						foreach ($activity_category as $retrive_data)
						{ 		 	
						?>
							<option value="<?php echo $retrive_data->ID;?>" <?php selected($retrive_data->ID,$sectionval1);  ?>><?php echo esc_attr($retrive_data->post_title); ?> </option>
						<?php }
					} 
					?> 
				</select>			
			</div>
			<div class="col-md-2 col-sm-2 col-xs-12">
				<button id="addremove_cat" class="btn btn-info sibling_add_remove margin_top_10" model="term_category"><?php _e('Add','school-mgt');?></button>		
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label " for="Passing Marks"><?php _e('Passing Marks','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-3">
				<input id="passing_mark" class="form-control text-input onlyletter_number_space_validation" type="number" value="<?php if($edit){ echo $exam_data->passing_mark;}?>" placeholder="<?php esc_html_e('Enter Passing Marks','school-mgt');?>"  name="passing_mark">
			</div>
			<label class="col-sm-2 control-label " for="Total Marks"><?php _e('Total Marks','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-3">
				<input id="total_mark" class="form-control onlyletter_number_space_validation text-input" type="number" value="<?php if($edit){ echo $exam_data->total_mark;}?>" placeholder="<?php esc_html_e('Enter Total Marks','school-mgt');?>"  name="total_mark">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="exam_start_date"><?php _e('Exam Start Date','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-3">
				<input id="exam_start_date" class="datepicker form-control validate[required] text-input" type="text" placeholder="<?php esc_html_e('Enter Exam Start Date','school-mgt');?>" name="exam_start_date" value="<?php if($edit){ echo date("Y-m-d",strtotime($exam_data->exam_start_date)); }?>" readonly>
			</div>
			<label class="col-sm-2 control-label" for="exam_end_date"><?php _e('Exam End Date','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-3">
				<input id="exam_end_date" class="datepicker form-control validate[required] text-input" type="text" placeholder="<?php esc_html_e('Enter Exam End Date','school-mgt');?>" name="exam_end_date" value="<?php if($edit){ echo date("Y-m-d",strtotime($exam_data->exam_end_date)); }?>" readonly>
			</div>
		</div>
		<?php wp_nonce_field( 'save_exam_admin_nonce' ); ?>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="exam_comment"><?php _e('Exam Comment','school-mgt');?></label>
			<div class="col-sm-8">
			 <textarea name="exam_comment" class="form-control validate[custom[address_description_validation]]" placeholder="<?php esc_html_e('Enter Exam Comment','school-mgt');?>" maxlength="150" id="exam_comment"><?php if($edit){ echo $exam_data->exam_comment;}?></textarea>
				
			</div>
		</div>
		<?php
		if($edit)
			{ 
				$doc_data=json_decode($exam_data->exam_syllabus);
			?>
				<div class="form-group">	
						<label class="control-label col-md-2 col-sm-2 col-xs-12" for="Exam Syllabu"><?php _e('Exam Syllabus','school-mgt');?></label>		
						<div class="col-md-2 col-sm-2 col-xs-12 margin_bottom_5">
							<input type="text"  name="document_name" id="title_value" placeholder="<?php esc_html_e('Enter Documents Title','school-mgt');?>" value="<?php if(!empty($doc_data[0]->title)) { echo esc_attr($doc_data[0]->title);}elseif(isset($_POST['document_name'])) echo esc_attr($_POST['document_name']);?>"  class="form-control validate[custom[onlyLetter_specialcharacter],maxSize[50]] margin_cause"/>
						</div>
						<div class="col-md-3 col-sm-3 col-xs-12">		
							<input type="file" name="exam_syllabus" class="form-control file_validation input-file"/>						
							<input type="hidden" name="old_hidden_exam_syllabus" value="<?php if(!empty($doc_data[0]->value)){ echo esc_attr($doc_data[0]->value);}elseif(isset($_POST['exam_syllabus'])) echo esc_attr($_POST['exam_syllabus']);?>">					
						</div>
						<?php
						if(!empty($doc_data[0]->value))
						{
						?>
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
							<a target="blank"  class="status_read btn btn-default" href="<?php print content_url().'/uploads/document_upload/'.$doc_data[0]->value; ?>" record_id="<?php echo $exam_data->exam_id;?>">
							<i class="fa fa-download"></i><?php echo $doc_data[0]->value;?></a>
						</div>
							<?php
						}
					?>
					</div>
			<?php 
			}
			else 
			{
			?>
		<div class="form-group">
			<label class="control-label col-md-2 col-sm-2 col-xs-12" for="Exam Syllabu"><?php _e('Exam Syllabus','school-mgt');?></label>	
			<div class="col-md-4 col-sm-4 col-xs-12 margin_bottom_5">
				<input type="text"  name="document_name" id="title_value"  placeholder="<?php esc_html_e('Enter Documents Title','school-mgt');?>"  class="form-control validate[custom[onlyLetter_specialcharacter],maxSize[50]] margin_cause"/>
			</div>
			<div class="col-md-4 col-sm-4 col-xs-12">
				<input type="file" name="exam_syllabus" class="col-md-2 col-sm-2 col-xs-12 form-control file_validation input-file ">	
			</div>
		</div>
			<?php 
			}
			?>
		<div class="col-sm-offset-2 col-sm-8">        	
        	<input type="submit" id="save_exam" value="<?php if($edit){ _e('Save Exam','school-mgt'); }else{ _e('Add Exam','school-mgt');}?>" name="save_exam" class="btn btn-success" />
        </div>        
        </form>