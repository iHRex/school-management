<?php 
$custom_field_obj =new Smgt_custome_field;
// This is Dashboard at admin side!!!!!!!!! 
$role='student'; 
?>
<script type="text/javascript">
jQuery(document).ready(function() {
	    jQuery('#student_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});	 
		jQuery('#birth_date').datepicker({
			dateFormat: "yy-mm-dd",
			maxDate : 0,
			changeMonth: true,
	        changeYear: true,
	        yearRange:'-65:+25',
			beforeShow: function (textbox, instance) 
			{
				instance.dpDiv.css({
					marginTop: (-textbox.offsetHeight) + 'px'                   
				});
			},    
	        onChangeMonthYear: function(year, month, inst) {
	            jQuery(this).val(month + "/" + year);
	        }                    
		}); 
} );
</script>
   
     <?php 	
	if($active_tab == 'addstudent')
	 {
        	$edit=0;
				if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit'){
					
					$edit=1;
					$user_info = get_userdata($_REQUEST['student_id']);
					
				} ?>
		
       <div class="panel-body">
        <form name="student_form" action="" method="post" class="form-horizontal" id="student_form" enctype='multipart/form-data'>
         <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
		<input type="hidden" name="action" value="<?php echo $action;?>">
		<input type="hidden" name="role" value="<?php echo $role;?>"  />
		<div class="form-group">
			<label class="col-sm-2 control-label" for="class_name"><?php _e('Class','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<?php if($edit){ $classval=$user_info->class_name; }elseif(isset($_POST['class_name'])){$classval=$_POST['class_name'];}else{$classval='';}?>
                        <select name="class_name" class="form-control validate[required] class_in_student max_width_100" id="class_list">
                        	<option value=""><?php _e('Select Class','school-mgt');?></option>
                            <?php
								foreach(get_allclass() as $classdata)
								{  
								?>
								 <option value="<?php echo $classdata['class_id'];?>" <?php selected($classval, $classdata['class_id']);  ?>><?php echo $classdata['class_name'];?></option>
							<?php 
								} 	?>
                        </select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="class_name"><?php _e('Class Section','school-mgt');?></label>
			<div class="col-sm-8">
				<?php if($edit){ $sectionval=$user_info->class_section; }elseif(isset($_POST['class_section'])){$sectionval=$_POST['class_section'];}else{$sectionval='';}?>
                        <select name="class_section" class="form-control max_width_100" id="class_section">
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
		<div class="form-group">
			<label class="col-sm-2 control-label" for="roll_id"><?php _e('Roll Number','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="roll_id" class="form-control validate[required,custom[username_validation]]" maxlength="50" type="text" 
				value="<?php if($edit){ echo $user_info->roll_id;}elseif(isset($_POST['roll_id'])) echo $_POST['roll_id'];?>" name="roll_id">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="first_name"><?php _e('First Name','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="first_name" class="form-control validate[required,custom[onlyLetter_specialcharacter]] text-input" maxlength="50" type="text" value="<?php if($edit){ echo $user_info->first_name;}elseif(isset($_POST['first_name'])) echo $_POST['first_name'];?>" name="first_name">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="middle_name"><?php _e('Middle Name','school-mgt');?></label>
			<div class="col-sm-8">
				<input id="middle_name" class="form-control validate[custom[onlyLetter_specialcharacter]]" maxlength="50" type="text"  value="<?php if($edit){ echo $user_info->middle_name;}elseif(isset($_POST['middle_name'])) echo $_POST['middle_name'];?>" name="middle_name">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="last_name"><?php _e('Last Name','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="last_name" class="form-control validate[required,custom[onlyLetter_specialcharacter]] text-input" maxlength="50" type="text"  value="<?php if($edit){ echo $user_info->last_name;}elseif(isset($_POST['last_name'])) echo $_POST['last_name'];?>" name="last_name">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="gender"><?php _e('Gender','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
			<?php $genderval = "male"; if($edit){ $genderval=$user_info->gender; }elseif(isset($_POST['gender'])) {$genderval=$_POST['gender'];}?>
				<label class="radio-inline custom_radio">
			     <input type="radio" value="male" class="tog validate[required]" name="gender"  <?php  checked( 'male', $genderval);  ?>/><?php _e('Male','school-mgt');?>
			    </label>
			    <label class="radio-inline custom_radio">
			      <input type="radio" value="female" class="tog validate[required]" name="gender"  <?php  checked( 'female', $genderval);  ?>/><?php _e('Female','school-mgt');?> 
			    </label>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="birth_date"><?php _e('Date of birth','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="birth_date" class="form-control validate[required]" type="text"  name="birth_date" 
				value="<?php if($edit){ echo smgt_getdate_in_input_box($user_info->birth_date);}elseif(isset($_POST['birth_date'])) echo $_POST['birth_date'];?>" readonly>
			</div>
		</div>		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="address"><?php _e('Address','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="address" class="form-control validate[required,custom[address_description_validation]]" maxlength="150" type="text"  name="address" 
				value="<?php if($edit){ echo $user_info->address;}elseif(isset($_POST['address'])) echo $_POST['address'];?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="city_name"><?php _e('City','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="city_name" class="form-control validate[required,custom[city_state_country_validation]]" maxlength="50" type="text"  name="city_name" 
				value="<?php if($edit){ echo $user_info->city;}elseif(isset($_POST['city_name'])) echo $_POST['city_name'];?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="state_name"><?php _e('State','school-mgt');?></label>
			<div class="col-sm-8">
				<input id="state_name" class="form-control validate[custom[city_state_country_validation]]" maxlength="50" type="text"  name="state_name" 
				value="<?php if($edit){ echo $user_info->state;}elseif(isset($_POST['state_name'])) echo $_POST['state_name'];?>">
			</div>
		</div>
		
		<?php wp_nonce_field( 'save_teacher_admin_nonce' ); ?>
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="zip_code"><?php _e('Zip Code','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="zip_code" class="form-control  validate[required,custom[onlyLetterNumber]]" maxlength="15" type="text"  name="zip_code" value="<?php if($edit){ echo $user_info->zip_code;}elseif(isset($_POST['zip_code'])) echo $_POST['zip_code'];?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="mobile_number"><?php _e('Mobile Number','school-mgt');?></label>
			<div class="col-sm-1">
			
			<input type="text" readonly value="+<?php echo smgt_get_countery_phonecode(get_option( 'smgt_contry' ));?>"  class="form-control" name="phonecode">
			</div>
			<div class="col-sm-7">
				<input id="mobile_number" class="form-control margin_top_10_res text-input validate[custom[phone_number],minSize[6],maxSize[15]]" type="text"  name="mobile_number"
				value="<?php if($edit){ echo $user_info->mobile_number;}elseif(isset($_POST['mobile_number'])) echo $_POST['mobile_number'];?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="mobile_number"><?php _e('Alternate Mobile Number','school-mgt');?></label>
			<div class="col-sm-1">			
				<input type="text" readonly value="+<?php echo smgt_get_countery_phonecode(get_option( 'smgt_contry' ));?>"  class="form-control" name="alter_mobile_number">
			</div>
			<div class="col-sm-7">
				<input id="alternet_mobile_number" class="form-control margin_top_10_res text-input validate[custom[phone_number],minSize[6],maxSize[15]]" type="text"  name="alternet_mobile_number" 
				value="<?php if($edit){ echo $user_info->alternet_mobile_number;}elseif(isset($_POST['alternet_mobile_number'])) echo $_POST['alternet_mobile_number'];?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label " for="phone"><?php _e('Phone','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="phone" class="form-control validate[required,custom[phone_number],minSize[6],maxSize[15]] text-input" type="text"  name="phone" 
				value="<?php if($edit){ echo $user_info->phone;}elseif(isset($_POST['phone'])) echo $_POST['phone'];?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label " for="email"><?php _e('Email','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="email" class="form-control validate[required,custom[email]] text-input" maxlength="100" type="text"  name="email" 
				value="<?php if($edit){ echo $user_info->user_email;}elseif(isset($_POST['email'])) echo $_POST['email'];?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="username"><?php _e('User Name','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="username" class="form-control validate[required,custom[username_validation]]" maxlength="50" type="text"  name="username" 
				value="<?php if($edit){ echo $user_info->user_login;}elseif(isset($_POST['username'])) echo $_POST['username'];?>" <?php if($edit) echo "readonly";?>>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="password"><?php _e('Password','school-mgt');?><?php if(!$edit) {?><span class="require-field">*</span><?php }?></label>
			<div class="col-sm-8">
				<input id="password" class="form-control <?php if(!$edit){ echo 'validate[required,minSize[8],maxSize[12]]'; }else{ echo 'validate[minSize[8],maxSize[12]]'; } ?>" type="password"  name="password" value="">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="photo"><?php _e('Image','school-mgt');?></label>
			<div class="col-sm-2">
				
				<input type="text" id="smgt_user_avatar_url" class="form-control" name="smgt_user_avatar"  
				value="<?php if($edit)echo esc_url( $user_info->smgt_user_avatar );elseif(isset($_POST['smgt_user_avatar'])) echo $_POST['smgt_user_avatar']; ?>" readonly />
				
			</div>	
				<div class="col-sm-3">
       				 <input id="upload_user_avatar_button" type="button" class="button btn_top" value="<?php _e( 'Upload image', 'school-mgt' ); ?>" />      				
       		
			</div>
			<div class="clearfix"></div>
			
			<div class="col-sm-offset-2 col-sm-8">
                     <div id="upload_user_avatar_preview" >
	                     <?php if($edit) 
	                     	{
	                     	if($user_info->smgt_user_avatar == "")
	                     	{?>
	                     	<img class="image_preview_css" alt="" src="<?php echo get_option( 'smgt_student_thumb' ) ?>">
	                     	<?php }
	                     	else {
	                     		?>
					        <img class="image_preview_css" src="<?php if($edit)echo esc_url( $user_info->smgt_user_avatar ); ?>" />
					        <?php 
	                     	}
	                     	}
					        else {
					        	?>
					        	<img class="image_preview_css" src="<?php echo get_option( 'smgt_student_thumb' ) ?>">
					        	<?php 
					        }?>
    				</div>
   		 </div>
		</div>
		
		<div class="form-group">
			<div class="col-sm-10">
				<?php echo the_meta(); ?>
			</div>
		</div>
		<!-- Custom Fields Data -->	
			<script type="text/javascript">
				jQuery("document").ready(function($)
				{	
					"use strict";								
					//space validation
					$('.space_validation').keypress(function( e ) 
					{
					   if(e.which === 32) 
						 return false;
					});									
					//custom field datepicker
					$('.after_or_equal').datepicker({
						dateFormat: "yy-mm-dd",										
						minDate:0,
						beforeShow: function (textbox, instance) 
						{
							instance.dpDiv.css({
								marginTop: (-textbox.offsetHeight) + 'px'                   
							});
						}
					}); 
					$('.date_equals').datepicker({
						dateFormat: "yy-mm-dd",
						minDate:0,
						maxDate:0,										
						beforeShow: function (textbox, instance) 
						{
							instance.dpDiv.css({
								marginTop: (-textbox.offsetHeight) + 'px'                   
							});
						}
					}); 
					$('.before_or_equal').datepicker({
						dateFormat: "yy-mm-dd",
						maxDate:0,
						beforeShow: function (textbox, instance) 
						{
							instance.dpDiv.css({
								marginTop: (-textbox.offsetHeight) + 'px'                   
							});
						}
					}); 
				});
				//Custom Field File Validation//
				function Smgt_custom_filed_fileCheck(obj)
				{	
				   "use strict";
					var fileExtension = $(obj).attr('file_types');
					var fileExtensionArr = fileExtension.split(',');
					var file_size = $(obj).attr('file_size');
					
					var sizeInkb = obj.files[0].size/1024;
					
					if ($.inArray($(obj).val().split('.').pop().toLowerCase(), fileExtensionArr) == -1)
					{										
						alert("<?php esc_html_e('Only','school-mgt');?> "+fileExtension+" <?php esc_html_e('formats are allowed.','school-mgt');?>");
						$(obj).val('');
					}	
					else if(sizeInkb > file_size)
					{										
						alert("<?php esc_html_e('Only','school-mgt');?> "+file_size+" <?php esc_html_e('kb size is allowed.','school-mgt');?>");
						$(obj).val('');	
					}
				}
				//Custom Field File Validation//
			</script>
		<?php
		//Get Module Wise Custom Field Data
		$custom_field_obj =new Smgt_custome_field;
		
		$module='student';	
		 
		$compact_custom_field=$custom_field_obj->Smgt_getCustomFieldByModule($module);
		
		if(!empty($compact_custom_field))
		{	
			?>		
			<div class="header">
				<h3><?php esc_html_e('Custom Fields','school-mgt');?></h3>
				<hr>
			</div>						
			 
					<?php
					foreach($compact_custom_field as $custom_field)
					{
						if($edit)
						{
							$custom_field_id=$custom_field->id;
							
							$module_record_id=$_REQUEST['student_id'];
							 
							$custom_field_value=$custom_field_obj->Smgt_get_single_custom_field_meta_value($module,$module_record_id,$custom_field_id);
						}
						
						// Custom Field Validation // 
						$exa = explode('|',$custom_field->field_validation);
						$min = "";
						$max = "";
						$required = "";
						$red = "";
						$limit_value_min = "";
						$limit_value_max = "";
						$numeric = "";
						$alpha = "";
						$space_validation = "";
						$alpha_space = "";
						$alpha_num = "";
						$email = "";
						$url = "";
						$minDate="";
						$maxDate="";
						$file_types="";
						$file_size="";
						$datepicker_class="";
						foreach($exa as $key=>$value)
						{
							if (strpos($value, 'min') !== false)
							{
							   $min = $value;
							   $limit_value_min = substr($min,4);
							}
							elseif(strpos($value, 'max') !== false)
							{
							   $max = $value;
							   $limit_value_max = substr($max,4);
							}
							elseif(strpos($value, 'required') !== false)
							{
								$required="required";
								$red="*";
							}
							elseif(strpos($value, 'numeric') !== false)
							{
								$numeric="onlyNumberSp";
							}
							elseif($value == 'alpha')
							{
								$alpha="onlyLetterSp";
								$space_validation="space_validation";
							}
							elseif($value == 'alpha_space')
							{
								$alpha_space="onlyLetterSp";
							}
							elseif(strpos($value, 'alpha_num') !== false)
							{
								$alpha_num="onlyLetterNumber";
							}
							elseif(strpos($value, 'email') !== false)
							{
								$email = "email";
							}
							elseif(strpos($value, 'url') !== false)
							{
								$url="url";
							}
							elseif(strpos($value, 'after_or_equal:today') !== false )
							{
								$minDate=1;
								$datepicker_class='after_or_equal';
							}
							elseif(strpos($value, 'date_equals:today') !== false )
							{
								$minDate=$maxDate=1;
								$datepicker_class='date_equals';
							}
							elseif(strpos($value, 'before_or_equal:today') !== false)
							{	
								$maxDate=1;
								$datepicker_class='before_or_equal';
							}	
							elseif(strpos($value, 'file_types') !== false)
							{	
								$types = $value;													
							   
								$file_types=substr($types,11);
							}
							elseif(strpos($value, 'file_upload_size') !== false)
							{	
								$size = $value;
								$file_size=substr($size,17);
							}
						}
						$option =$custom_field_obj->Smgt_getDropDownValue($custom_field->id);
						$data = 'custom.'.$custom_field->id;
						$datas = 'custom.'.$custom_field->id;											
						
						if($custom_field->field_type =='text')
						{
							?>	
							 
							<div class="form-group">	
								<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="<?php echo $custom_field->id; ?>"><?php echo ucwords($custom_field->field_label); ?><span class="required red"><?php echo $red; ?></span></label>
								<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 has-feedback">
									<input class="form-control hideattar<?php echo $custom_field->form_name; ?> validate[<?php if(!empty($required)){ echo $required; ?>,<?php } ?><?php if(!empty($limit_value_min)){ ?> minSize[<?php echo $limit_value_min; ?>],<?php } if(!empty($limit_value_max)){ ?> maxSize[<?php echo $limit_value_max; ?>],<?php } if($numeric != '' || $alpha != '' || $alpha_space != '' || $alpha_num != '' || $email != '' || $url != ''){ ?> custom[<?php echo $numeric; echo $alpha; echo $alpha_space; echo $alpha_num; echo $email; echo $url; ?>]<?php } ?>] <?php echo $space_validation; ?>" type="text" name="custom[<?php echo $custom_field->id; ?>]" id="<?php echo $custom_field->id; ?>" label="<?php echo $custom_field->field_label; ?>" <?php if($edit){ ?> value="<?php echo $custom_field_value; ?>" <?php } ?>>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-0">
								</div>
							</div>
								 
							<?php
						}
						elseif($custom_field->field_type =='textarea')
						{
							?>
							<div class="form-group">	
								<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label "><?php echo $custom_field->field_label; ?><span class="required red"><?php echo $red; ?></span></label>
								<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 has-feedback">
									<textarea rows="3"
										class="form-control hideattar<?php echo $custom_field->form_name; ?> validate[<?php if(!empty($required)){ echo $required; ?>,<?php } ?><?php if(!empty($limit_value_min)){ ?> minSize[<?php echo $limit_value_min; ?>],<?php } if(!empty($limit_value_max)){ ?> maxSize[<?php echo $limit_value_max; ?>],<?php } if($numeric != '' || $alpha != '' || $alpha_space != '' || $alpha_num != '' || $email != '' || $url != ''){ ?> custom[<?php echo $numeric; echo $alpha; echo $alpha_space; echo $alpha_num; echo $email; echo $url; ?>]<?php } ?>] <?php echo $space_validation; ?>" 
										name="custom[<?php echo $custom_field->id; ?>]" 
										id="<?php echo $custom_field->id; ?>"
										label="<?php echo $custom_field->field_label; ?>"
										><?php if($edit){ echo $custom_field_value; } ?></textarea>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-0">
								</div>
							</div>
							<?php 
						}
						elseif($custom_field->field_type =='date')
						{
							?>	
							<div class="form-group">
								 <label for="bdate" class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label"><?php echo ucwords($custom_field->field_label); ?><span class="required red"><?php echo $red; ?></span></label>
							 
								<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 has-feedback">
									<input class="form-control error custom_datepicker <?php echo $datepicker_class; ?> hideattar<?php echo $custom_field->form_name; ?> <?php if(!empty($required)){ ?> validate[<?php echo $required; ?>] <?php } ?>"name="custom[<?php echo $custom_field->id; ?>]"<?php if($edit){ ?> value="<?php echo $custom_field_value; ?>" <?php } ?>id="<?php echo $custom_field->id; ?>" label="<?php echo $custom_field->field_label; ?>">
								</div>
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-0">
								</div>
							</div>
								
							<?php 
						}
						elseif($custom_field->field_type =='dropdown')
						{
							?>	
							<div class="form-group">
								<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="<?php echo $custom_field->id; ?>"><?php echo ucwords($custom_field->field_label); ?><span class="required red"><?php echo $red; ?></span></label>
								<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 has-feedback">
									<select class="form-control width_100 hideattar<?php echo $custom_field->form_name; ?> 
									<?php if(!empty($required)){ ?> validate[<?php echo $required; ?>] <?php } ?>" name="custom[<?php echo $custom_field->id; ?>]"	id="<?php echo $custom_field->id; ?>" label="<?php echo $custom_field->field_label; ?>"
									>
									<option value=""><?php _e( 'Select', 'school-mgt' ); ?></option>
										<?php
										if(!empty($option))
										{															
											foreach ($option as $options)
											{
												?>
												<option value="<?php echo $options->option_label; ?>" <?php if($edit){ echo selected($custom_field_value,$options->option_label); } ?>> <?php echo ucwords($options->option_label); ?></option>
												<?php
											}
										}
										?>
									</select>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-0">
								</div>
							</div>
							 
							<?php 
						}
						elseif($custom_field->field_type =='checkbox')
						{
							?>	
								<div class="form-group">
									<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label"><?php echo ucwords($custom_field->field_label); ?><span class="required red"><?php echo $red; ?></span></label>
								 
									<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 has-feedback">
										<?php
										if(!empty($option))
										{
											foreach ($option as $options)
											{ 
												if($edit)
												{
													$custom_field_value_array=explode(',',$custom_field_value);
												}
												?>	
												<div class="d-inline-block custom-control custom-checkbox mr-1">
													<input type="checkbox" value="<?php echo $options->option_label; ?>"  <?php if($edit){  echo checked(in_array($options->option_label,$custom_field_value_array)); } ?> class="custom-control-input hideattar<?php echo $custom_field->form_name; ?><?php if(!empty($required)){ ?> validate[<?php echo $required; ?>] <?php } ?>" name="custom[<?php echo $custom_field->id; ?>][]" >
													<label class="custom-control-label" style="margin-top: 7px;" for="colorCheck1"><?php echo $options->option_label; ?></label>
												</div>
												<?php
											}
										}
										?>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-0">
									</div>
								</div>
							<?php 
						}
						elseif($custom_field->field_type =='radio')
						{
							?>
							
							<div class="form-group">
									<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label"><?php echo ucwords($custom_field->field_label); ?><span class="required red"><?php echo $red; ?></span></label>
									
									 
								 
									<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 has-feedback">
										<?php
										if(!empty($option))
										{
											foreach ($option as $options)
											{
												?>
												<input type="radio"  value="<?php echo $options->option_label; ?>" <?php if($edit){ echo checked( $options->option_label, $custom_field_value); } ?> name="custom[<?php echo $custom_field->id; ?>]"  class="custom-control-input hideattar<?php echo $custom_field->form_name; ?> <?php if(!empty($required)){ ?> validate[<?php echo $required; ?>] <?php } ?> error " id="<?php echo $options->option_label; ?>">
												<label class="custom-control-label mr-1" style="margin-top: 7px;" for="<?php echo $options->option_label; ?>"><?php echo $options->option_label; ?></label>
												<?php
											}
										}
										?>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-0">
									</div>
								</div>
							<?php
						}
						elseif($custom_field->field_type =='file')
						{
							?>	
							<div class="form-group">
								<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label"><?php echo ucwords($custom_field->field_label); ?><span class="required red"><?php echo $red; ?></span></label>
								 
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 has-feedback">
									<input type="file"  onchange="Smgt_custom_filed_fileCheck(this);" Class="hideattar<?php echo $custom_field->form_name; if($edit){ if(!empty($required)){ if($custom_field_value==''){ ?> validate[<?php echo $required; ?>] <?php } } }else{ if(!empty($required)){ ?> validate[<?php echo $required; ?>] <?php } } ?>" name="custom_file[<?php echo $custom_field->id;?>]" <?php if($edit){ ?> value="<?php echo $custom_field_value; ?>" <?php } ?> id="<?php echo $custom_field->id; ?>" file_types="<?php echo $file_types; ?>" file_size="<?php echo $file_size; ?>">
									<p><?php esc_html_e('Please upload only ','school-mgt'); echo $file_types; esc_html_e(' file','school-mgt');?> </p>
								</div>
									<input type="hidden" name="hidden_custom_file[<?php echo $custom_field->id; ?>]" value="<?php if($edit){ echo $custom_field_value; } ?>">
									<label class="label_file"><?php if($edit){ echo $custom_field_value; } ?></label>
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-0">
								</div>
							</div>
						<?php
						}
					}	
					?>	 
		<?php
		}
		?>
		<div class="col-sm-offset-2 col-sm-8">
        	
        	<input type="submit" value="<?php if($edit){ _e('Save Student','school-mgt'); }else{ _e('Add Student','school-mgt');}?>" name="save_student" class="btn btn-success"/>
        </div>
          	
        
        </form>
        </div>
        
     <?php 
	 }
	 ?>