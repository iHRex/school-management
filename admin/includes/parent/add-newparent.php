<?php
$students = get_student_groupby_class();
$role='parent';
?>
<script type="text/javascript">
$(document).ready(function() {
	 $('#parent_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
	 $('#birth_date').datepicker({
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
			$(this).val(month + "/" + year);
		}
    }); 
	
	var numItems = $('.parents_child').length;
	if(numItems == 1)
	{$('#revove_item').hide();}
		 
});
</script>
	<?php 
		$edit=0;
		if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit' ) {
			$edit=1;	
			$user_info = get_userdata($_REQUEST['parent_id']);
		} ?>       
        <div class="panel-body">
        <form name="parent_form" action="" method="post" class="form-horizontal" id="parent_form" enctype="multipart/form-data">
        <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
		<input type="hidden" name="action" value="<?php echo $action;?>">
		<input type="hidden" name="role" value="<?php echo $role;?>"  />
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
				<label class="radio-inline">
			     <input type="radio" value="male" class="tog validate[required]" name="gender"  <?php  checked( 'male', $genderval);  ?>/><?php _e('Male','school-mgt');?> 
			    </label>
			    <label class="radio-inline">
			      <input type="radio" value="female" class="tog validate[required]" name="gender"  <?php  checked( 'female', $genderval);  ?>/><?php _e('Female','school-mgt');?> 
			    </label>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="birth_date"><?php _e('Date of birth','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="birth_date" class="form-control validate[required]" type="text"  name="birth_date" 
				value="<?php if($edit){ echo smgt_getdate_in_input_box($user_info->birth_date);}elseif(isset($_POST['birth_date'])) echo smgt_getdate_in_input_box($_POST['birth_date']);?>" readonly>
			</div>
		</div>	
		  <?php 
                if($edit)
                {
                   $parent_data = get_user_meta($user_info->ID, 'child', true);
                   if(!empty($parent_data)) 	
                    {
				        foreach($parent_data as $id1)
						{ ?>
							<div class="form-group parents_child">
								<label class="col-sm-2 control-label" for="student_list"><?php _e('Child','school-mgt');?><span class="require-field">*</span></label>
								<div class="col-sm-8">
									<select name="chield_list[]" id="student_list" class="form-control validate[required] max_width_100">
									<?php 
									foreach ($students as $label => $opt){ ?>
										<optgroup label="<?php echo "Class : ".$label; ?>">
											<?php foreach ($opt as $id => $name): ?>
											<option value="<?php echo $id; ?>" <?php selected($id, $id1);  ?> ><?php echo $name; ?></option>
											<?php endforeach; ?>
										</optgroup>
										<?php } ?>
									</select>
								</div>
							</div>
                <?php 
			            }
			        }
					else
					{ ?>
						<div class="form-group parents_child">
							<label class="col-sm-2 control-label" for="student_list"><?php _e('Child','school-mgt');?><span class="require-field">*</span></label>
							<div class="col-sm-8">                  
								<select name="chield_list[]" id="student_list" class="form-control validate[required] max_width_100">
								 <?php 
									foreach ($students as $label => $opt)
									{ ?>
										
										<optgroup label="<?php echo "Class : ".$label; ?>">
										<?php foreach ($opt as $id => $name): ?>
											<option value="<?php echo $id; ?>"><?php echo $name; ?></option>
										<?php endforeach; ?>
										</optgroup>
								<?php }  ?>
							   </select>
							</div>
						</div>
						
					<?php }
			    }
            else
			{ 	?>
		<div class="form-group parents_child">
			<label class="col-sm-2 control-label" for="student_list"><?php _e('Child','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">                  
                <select name="chield_list[]" id="student_list" class="form-control validate[required] max_width_100">
                 <?php 
                    foreach ($students as $label => $opt)
                    { ?>
                    	
                    	<optgroup label="<?php echo "Class : ".$label; ?>">
						<?php foreach ($opt as $id => $name): ?>
							<option value="<?php echo $id; ?>"><?php echo $name; ?></option>
						<?php endforeach; ?>
						</optgroup>
				<?php }  ?>
               </select>
            </div>
		</div>
		<?php } ?>		
		 <a href="" id="add-another_item"><?php _e('Add Other Child','school-mgt');?> </a>
		 <a href="#" id="revove_item"> <?php _e('Remove','school-mgt');?> </a>
		 <div class="marginbottom"></div>
		<script type="text/javascript">jQuery(document).ready(function($) {
			function deleteParentElement(n){
				alert("<?php esc_html_e('Do you really want to delete this ?','school-mgt');?>");
				n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
			}
			$('#add-another_item').on('click',function(event) {
				event.preventDefault();
				var $this = $(this);
				var $last = $this.prev(); // $this.parents('.something').prev() also useful
				var $clone = $last.clone(true);
				var $inputs = $clone.find('input,textarea,select');
				/* $inputs.val(''); */
				$last.after($clone);
				$inputs.eq(0).focus();
				
				var numItems = $('.parents_child').length;
				if(numItems > 1)
				{
					 $('#revove_item').show();
				}
				
			});		
			$('#revove_item').on('click',function(event) {
				event.preventDefault();
				var numItems = $('.parents_child').length;
				if(numItems > 1)
				{
					 $(this).prev().prev().remove();
					 if(numItems == 2)
						 $('#revove_item').hide();
				}
				else
				{ $('#revove_item').hide();}
			});	
	
		}); 
		</script>	 
		<div class="form-group">
			<label class="col-sm-2 control-label" for="relation"><?php _e('Relation','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<?php if($edit){ $relationval=$user_info->relation; }elseif(isset($_POST['relation'])){$relationval=$_POST['relation'];}else{$relationval='';}?>
                     <select name="relation" class="form-control validate[required] max_width_100" id="relation">
                     	<option value=""><?php _e('select relation','school-mgt');?></option>
                        <option value="<?php _e('Father','school-mgt');?>" <?php selected( $relationval, 'Father'); ?>><?php _e('Father','school-mgt');?></option>
                        <option value="<?php _e('Mother','school-mgt');?>" <?php selected( $relationval, 'Mother'); ?>><?php _e('Mother','school-mgt');?></option>
                     </select>
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
		<div class="form-group">
			<label class="col-sm-2 control-label" for="zip_code"><?php _e('Zip Code','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="zip_code" class="form-control  validate[required,custom[onlyLetterNumber]]" maxlength="15" type="text"  name="zip_code" 
				value="<?php if($edit){ echo $user_info->zip_code;}elseif(isset($_POST['zip_code'])) echo $_POST['zip_code'];?>">
			</div>
		</div>
		
		<?php wp_nonce_field( 'save_parent_admin_nonce' ); ?>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="mobile_number"><?php _e('Mobile Number','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-1">
			
			<input type="text" readonly value="+<?php echo smgt_get_countery_phonecode(get_option( 'smgt_contry' ));?>"  class="form-control country_code" name="phonecode">
			</div>
			<div class="col-sm-7">
				<input id="mobile_number" class="form-control btn_top validate[required,custom[phone_number],minSize[6],maxSize[15]] text-input" type="text"  name="mobile_number"
				value="<?php if($edit){ echo $user_info->mobile_number;}elseif(isset($_POST['mobile_number'])) echo $_POST['mobile_number'];?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label " for="phone"><?php _e('Phone','school-mgt');?></label>
			<div class="col-sm-8">
				<input id="phone" class="form-control validate[custom[phone_number],minSize[6],maxSize[15]] text-input" type="text"  name="phone" 
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
	              	{ ?>
	                  	<img class="image_preview_css" src="<?php echo get_option( 'smgt_student_thumb' ) ?>">
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
				<?php  } ?>
    		</div>
   		 </div>
		</div>
		<div class="col-sm-offset-2 col-sm-8">        	
        	<input type="submit" value="<?php if($edit){ _e('Save Parent','school-mgt'); }else{ _e('Add Parent','school-mgt');}?>" name="save_parent" class="btn btn-success"/>
        </div>      
        </form>
		</div>