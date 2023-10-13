<script type="text/javascript">
$(document).ready(function() {
	 $('#homework_form_admin').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
	$('.datepicker').datepicker({
		minDate : '0',
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
<?php 			
$class_obj=new Smgt_Homework();
?>
   <?php 
		$edit=0;
		if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
		{
			$edit=1;
			$objj=new Smgt_Homework();
			$classdata= $objj->get_edit_record($_REQUEST['homework_id']);
			 
		} 
	?>
    <div class="panel-body"><!-- panel body siv start-->	
        <form name="homework_form" action="" method="post" class="form-horizontal" enctype="multipart/form-data" id="homework_form_admin">
		    <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
			<input type="hidden" name="action" value="<?php echo $action;?>">
				<div class="form-group">
					<label class="col-sm-2 control-label" for="class_name"><?php _e('Title','school-mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8">
						<input id="title" class="form-control validate[required,custom[address_description_validation]]" maxlength="100" type="text" value="<?php if($edit){ echo $classdata->title;}?>" name="title">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="class_name"><?php _e('Select Class','school-mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8">
					<?php if($edit){ $classval=$classdata->class_name; }elseif(isset($_POST['class_name'])){$classval=$_POST['class_name'];}else{$classval='';}?>
						<select name="class_name" class="form-control validate[required] max_width_100" id="class_list">
							<option value=""><?php _e('Select Class','school-mgt');?></option>
							<?php
								foreach(get_allclass() as $classdata1)
								{  
								?>
								 <option value="<?php echo $classdata1['class_id'];?>" <?php selected($classval, $classdata1['class_id']);  ?>><?php echo $classdata1['class_name'];?></option>
							<?php }?>
						</select>
					</div>
				</div>
				
				<div class="form-group">
				<label class="col-sm-2 control-label" for="class_name"><?php _e('Class Section','school-mgt');?></label>
				<div class="col-sm-8">
					<?php if($edit){ $sectionval=$classdata->section_id; }elseif(isset($_POST['class_section'])){$sectionval=$_POST['class_section'];}else{$sectionval='';}?>
							<select name="class_section" class="form-control max_width_100" id="class_section">
								<option value=""><?php _e('Select Class Section','school-mgt');?></option>
								<?php
								if($edit){
									foreach(smgt_get_class_sections($classdata->class_name) as $sectiondata)
									{  ?>
									 <option value="<?php echo $sectiondata->id;?>" <?php selected($sectionval,$sectiondata->id);  ?>><?php echo $sectiondata->section_name;?></option>
								<?php } 
								}?>
							</select>
				</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-2 control-label" for="class_name"><?php _e('Select Subject','school-mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8">
						<?php
						   $subject = ($edit)?smgt_get_subject_by_classid($classval):array();
						   ?>
						  <select name="subject_id" id="subject_list" class="form-control validate[required] text-input max_width_100">
						   <?php
						   if($edit)
						   {
								foreach($subject as $record)
								{
									$select = ($record->subid == $classdata->subject)?"selected":"";
								?>
									<option value="<?php echo $record->subid;?>" <?php echo $select; ?>><?php echo $record->sub_name; ?></option>
								<?php
								}
						   }
						   else
						   {
							   ?>
							  <option value=""><?php _e('Select Subject','school-mgt');?></option>
						  <?php
						  }
						   ?>
						</select>
					</div>
				</div>
				<?php
			if($edit)
			{
				$doc_data=json_decode($classdata->homework_document);
			?>
				<div class="form-group">	
						<label class="control-label col-md-2 col-sm-2 col-xs-12" for="Exam Syllabu"><?php _e('Homework Document','school-mgt');?></label>		
						<div class="col-md-2 col-sm-2 col-xs-12 margin_bottom_5">
							<input type="text"  name="document_name" id="title_value" placeholder="<?php esc_html_e('Enter Documents Title','school-mgt');?>" value="<?php if(!empty($doc_data[0]->title)) { echo esc_attr($doc_data[0]->title);}elseif(isset($_POST['document_name'])) echo esc_attr($_POST['document_name']);?>"  class="form-control validate[custom[onlyLetter_specialcharacter],maxSize[50]] margin_cause"/>
						</div>
						<div class="col-md-3 col-sm-3 col-xs-12">		
							<input type="file" name="homework_document" class="form-control file_validation input-file"/>						
							<input type="hidden" name="old_hidden_homework_document" value="<?php if(!empty($doc_data[0]->value)){ echo esc_attr($doc_data[0]->value);}elseif(isset($_POST['homework_document'])) echo esc_attr($_POST['homework_document']);?>">					
						</div>
						<?php
						if(!empty($doc_data[0]->value))
						{
						?>
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
							<a target="blank"  class="status_read btn btn-default" href="<?php print content_url().'/uploads/school_assets/'.$doc_data[0]->value; ?>" record_id="<?php echo $classdata->homework_id;?>">
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
			<label class="control-label col-md-2 col-sm-2 col-xs-12" for="Exam Syllabu"><?php _e('Homework Document','school-mgt');?></label>	
			<div class="col-md-4 col-sm-4 col-xs-12 margin_bottom_5">
				<input type="text"  name="document_name" id="title_value"  placeholder="<?php esc_html_e('Enter Documents Title','school-mgt');?>"  class="form-control validate[custom[onlyLetter_specialcharacter],maxSize[50]] margin_cause"/>
			</div>
			<div class="col-md-4 col-sm-4 col-xs-12">
				<input type="file" name="homework_document" class="col-md-2 col-sm-2 col-xs-12 form-control file_validation input-file ">	
			</div>
		</div>
			<?php 
			}
			?>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="class_capacity"><?php _e('Content','school-mgt');?> </label>
					<div class="col-sm-8">
						 <?php 
						 $setting=array(
						 'media_buttons' => false
						 );
						 
						if(!empty($classdata))
						{
							$content=$classdata->content;
						}
						else
						{
							$content="";
						}
						 wp_editor(isset($edit)?stripslashes($content) : '','content',$setting); ?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-2 control-label" for="class_capacity"><?php _e('Submission Date','school-mgt');?> <span class="require-field">*</span></label>
					<div class="col-sm-3">
						<input id="sdate" value="<?php if($edit){ echo date("Y-m-d",strtotime($classdata->submition_date));}?>" class="datepicker form-control validate[required] text-input" type="text" name="sdate" readonly>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="smgt_enable_homework_mail"><?php _e('Enable Send  Mail To Parents And Students','school-mgt');?></label>
					<div class="col-sm-8">
						<div class="checkbox">
							<label><input type="checkbox" name="smgt_enable_homework_mail"  value="1" <?php echo checked(get_option('smgt_enable_homework_mail'),'yes');?>/><?php _e('Enable','school-mgt');?>
						  </label>
						</div>
					</div>
				</div>
				
				<?php wp_nonce_field( 'save_homework_admin_nonce' ); ?>
				
				<div class="col-sm-offset-2 col-sm-8">        	
					<input type="submit" value="<?php if($edit){ _e('Save Homework','school-mgt'); }else{ _e('Save Homework','school-mgt');}?>" name="Save_Homework" class="btn btn-success" />
				</div>        
        </form>
    </div><!-- End panel body siv start-->	