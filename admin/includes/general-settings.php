<?php 	
if(isset($_POST['save_setting']))
{
	$optionval=smgt_option();
	foreach($optionval as $key=>$val)
	{
		if(isset($_POST[$key]))
		{
			$result=update_option( $key, $_POST[$key]);
		}
	}
	//	UPDATE GENERAL SETTINGS OPTION
	if(isset($_REQUEST['smgt_paymaster_pack']))
	{
		update_option( 'smgt_paymaster_pack', 'yes' );
	}
	else
	{
		update_option( 'smgt_paymaster_pack', 'no' );
	}
	//	UPDATE GENERAL SETTINGS OPTION
	if(isset($_REQUEST['smgt_mail_notification']))
	{
		update_option( 'smgt_mail_notification',1 );
	}
	else
	{
		update_option( 'smgt_mail_notification',0);
	}
	if(isset($_REQUEST['parent_send_message']))
		update_option( 'parent_send_message', 1 );
	else
		update_option( 'parent_send_message', 0 );
	
	if(isset($_REQUEST['student_send_message']))
		update_option( 'student_send_message', 1 );
	else
		update_option( 'student_send_message', 0 );
	if(isset($_REQUEST['student_approval']))
		update_option( 'student_approval', 1 );
	else
		update_option( 'student_approval', 0 );
	if(isset($_REQUEST['smgt_enable_sandbox']))
			update_option( 'smgt_enable_sandbox', 'yes' );
		else 
			update_option( 'smgt_enable_sandbox', 'no' );
	if(isset($_REQUEST['smgt_enable_virtual_classroom']))
	{
		update_option( 'smgt_enable_virtual_classroom', 'yes' );
	}
	else 
	{
		update_option( 'smgt_enable_virtual_classroom', 'no' );
	}
	if(isset($_REQUEST['smgt_enable_virtual_classroom_reminder']))
	{
		update_option( 'smgt_enable_virtual_classroom_reminder', 'yes' );
	}
	else 
	{
		update_option( 'smgt_enable_virtual_classroom_reminder', 'no' );
	}
	if(isset($_REQUEST['smgt_teacher_manage_allsubjects_marks']))
	{
			update_option( 'smgt_teacher_manage_allsubjects_marks', 'yes' );
	}
	else
	{ 
		update_option( 'smgt_teacher_manage_allsubjects_marks', 'no' );	
	}
	
	wp_redirect( admin_url() . 'admin.php?page=smgt_gnrl_settings&message=1');
}

?>
<script type="text/javascript">

$(document).ready(function() {
	//alert("hello");
	 $('#setting_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
} );
</script>
<div class="page-inner">
<div class="page-title">


		<h3><img src="<?php echo get_option( 'smgt_school_logo' ) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo get_option( 'smgt_school_name' );?></h3>
	</div>
	<div id="main-wrapper">
	<?php
	$message = isset($_REQUEST['message'])?$_REQUEST['message']:'0';
	switch($message)
	{
		case '1':
			$message_string = __('Settings Updated Successfully.','school-mgt');
			break;
	}
	
	if($message)
	{ ?>
		<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible">
			<p><?php echo $message_string;?></p>
			<button type="button" class="notice-dismiss" data-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>
		</div>
<?php } ?>
	<div class="panel panel-white">
					<div class="panel-body">
<h2>
        	<?php echo esc_html( __( 'General Settings', 'school-mgt')); ?>
        </h2>
		<div class="panel-body">
        <form name="student_form" action="" method="post" class="form-horizontal" id="setting_form">
        <div class="form-group">
			<label class="col-sm-2 control-label" for="smgt_school_name"><?php _e('School Name','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="smgt_school_name" class="form-control validate[required,custom[popup_category_validation]]" type="text" maxlength="100" value="<?php echo get_option( 'smgt_school_name' );?>"  name="smgt_school_name">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="smgt_staring_year"><?php _e('Starting Year','school-mgt');?></label>
			<div class="col-sm-8">
				<input id="smgt_staring_year" class="form-control validate[minSize[4],maxSize[4],min[0]]" min="1" step="1" type="number" value="<?php echo get_option( 'smgt_staring_year' );?>"  name="smgt_staring_year">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="smgt_school_address"><?php _e('School Address','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="smgt_school_address" class="form-control validate[required,custom[address_description_validation]]" maxlength="150" type="text" value="<?php echo get_option( 'smgt_school_address' );?>"  name="smgt_school_address">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="smgt_contact_number"><?php _e('Official Phone Number','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="smgt_contact_number" class="form-control  validate[required,custom[phone_number],minSize[6],maxSize[15]]" type="text" value="<?php echo get_option( 'smgt_contact_number' );?>"  name="smgt_contact_number">
			</div>
		</div>
		<div class="form-group" class="form-control" id="">
			<label class="col-sm-2 control-label" for="smgt_contry"><?php _e('Country','school-mgt');?></label>
			<div class="col-sm-8">
			<?php 
			$url = plugins_url( 'countrylist.xml', __FILE__ );
			if(get_remote_file($url))
			{
				$xml =simplexml_load_string(get_remote_file($url));
			}
			else 
			{
				die("Error: Cannot create object");
			}
		
			?>
			<select name="smgt_contry" class="form-control validate[required]" id="smgt_contry">
				<option value=""><?php _e('Select Country','school-mgt');?></option>
				<?php
					foreach($xml as $country)
					{  
					?>
					 <option value="<?php echo $country->name;?>" <?php selected(get_option( 'smgt_contry' ), $country->name);  ?>><?php echo $country->name;?></option>
				<?php }?>
            </select> 
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="smgt_email"><?php _e('Email','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="smgt_email" class="form-control validate[required,custom[email]] text-input" maxlength="100" type="text" value="<?php echo get_option( 'smgt_email' );?>"  name="smgt_email">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="smgt_notification_fcm_key"><?php _e('Notification FCM Key','school-mgt');?></label>
			<div class="col-sm-8">
				<input id="smgt_notification_fcm_key" class="form-control text-input" type="text" value="<?php echo get_option( 'smgt_notification_fcm_key' );?>"  name="smgt_notification_fcm_key">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="smgt_datepicker_format"><?php _e('Date Format','school-mgt');?>
			</label>
			<div class="col-sm-8">
			<?php $date_format_array = smgt_datepicker_dateformat();
			if(get_option( 'smgt_datepicker_format' ))
			{
				$selected_format = get_option( 'smgt_datepicker_format' );
			}
			else
				$selected_format = 'Y-m-d';
			?>
			<select id="smgt_datepicker_format" class="form-control" name="smgt_datepicker_format">
				<?php 
				foreach($date_format_array as $key=>$value)
				{
					echo '<option value="'.$value.'" '.selected($selected_format,$value).'>'.$value.'</option>';
				}
				?>
			</select>
				
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="smgt_email"><?php _e('School Logo','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
			<input type="text" id="smgt_user_avatar_url" name="smgt_school_logo" class="validate[required]" value="<?php  echo get_option( 'smgt_school_logo' ); ?>" readonly />
       				 <input id="upload_user_avatar_button" type="button" class="button btn_top" value="<?php _e( 'Upload image', 'school-mgt' ); ?>" />
       				 <span class="description"><?php _e('Upload image.', 'school-mgt' ); ?></span>
                     
                     <div id="upload_user_avatar_preview">
			<img class="image_preview_css" src="<?php  echo get_option( 'smgt_school_logo' ); ?>" />
			
				
			</div>
		</div>
		</div>
			<div class="form-group">
			<label class="col-sm-2 control-label" for="smgt_cover_image"><?php _e('Profile Cover Image','school-mgt');?></label>
			<div class="col-sm-8">
			
			<input type="text" id="smgt_school_background_image" name="smgt_school_background_image" value="<?php  echo get_option( 'smgt_school_background_image' ); ?>" readonly />	
       				  <input id="upload_image_button" type="button" class="button upload_user_cover_button btn_top" value="<?php _e( 'Upload Cover Image', 'school-mgt' ); ?>" />
       				 <span class="description"><?php _e('Upload Cover Image', 'school-mgt' ); ?></span>
                     <div id="upload_school_cover_preview" style="min-height: 100px;margin-top:5px;">
						<img style="width:100%;height:300px;" src="<?php  echo get_option( 'smgt_school_background_image' ); ?>" />
			</div>
		</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="smgt_enable_sandbox"><?php _e('Enable Sandbox','school-mgt');?></label>
			<div class="col-sm-8">
				<div class="checkbox">
					<label>
	              		<input type="checkbox" name="smgt_enable_sandbox"  value="1" <?php echo checked(get_option('smgt_enable_sandbox'),'yes');?>/><?php _e('Enable','school-mgt');?>
	              </label>
              </div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="smgt_paypal_email"><?php _e('Paypal Email Id','school-mgt');?></label>
			<div class="col-sm-8">
				<input id="smgt_paypal_email" class="form-control validate[custom[email]] text-input" maxlength="100" type="text" value="<?php echo get_option( 'smgt_paypal_email' );?>"  name="smgt_paypal_email">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="smgt_currency_code"><?php _e('Select Currency','school-mgt');?></label>
			<div class="col-sm-8">
			
				<select name="smgt_currency_code" class="form-control text-input">
		  <option value=""> <?php _e('Select Currency','school-mgt');?></option>
		  <option value="AUD" <?php echo selected(get_option( 'smgt_currency_code' ),'AUD');?>>
		  <?php _e('Australian Dollar','school-mgt');?></option>
		  <option value="BRL" <?php echo selected(get_option( 'smgt_currency_code' ),'BRL');?>>
		  <?php _e('Brazilian Real','school-mgt');?> </option>
		  <option value="CAD" <?php echo selected(get_option( 'smgt_currency_code' ),'CAD');?>>
		  <?php _e('Canadian Dollar','school-mgt');?></option>
		  <option value="CZK" <?php echo selected(get_option( 'smgt_currency_code' ),'CZK');?>>
		  <?php _e('Czech Koruna','school-mgt');?></option>
		  <option value="DKK" <?php echo selected(get_option( 'smgt_currency_code' ),'DKK');?>>
		  <?php _e('Danish Krone','school-mgt');?></option>
		  <option value="EUR" <?php echo selected(get_option( 'smgt_currency_code' ),'EUR');?>>
		  <?php _e('Euro','school-mgt');?></option>
		  
		  <option value="GHC" <?php echo selected(get_option( 'smgt_currency_code' ),'GHC');?>>
		  <?php _e('Cedis','school-mgt');?></option>
		  
		  <option value="HKD" <?php echo selected(get_option( 'smgt_currency_code' ),'HKD');?>>
		  <?php _e('Hong Kong Dollar','school-mgt');?></option>
		  <option value="HUF" <?php echo selected(get_option( 'smgt_currency_code' ),'HUF');?>>
		  <?php _e('Hungarian Forint','school-mgt');?> </option>
		  <option value="INR" <?php echo selected(get_option( 'smgt_currency_code' ),'INR');?>>
		  <?php _e('Indian Rupee','school-mgt');?></option>

		  <option value="IDR" <?php echo selected(get_option( 'smgt_currency_code' ),'IDR');?>>
		  <?php _e('Indonesian Rupiah','school-mgt');?></option>
		  
		  <option value="PKR" <?php echo selected(get_option( 'smgt_currency_code' ),'PKR');?>>
		  <?php _e('Pakistan Rupee','school-mgt');?></option>
		  
		  <option value="ILS" <?php echo selected(get_option( 'smgt_currency_code' ),'ILS');?>>
		  <?php _e('Israeli New Sheqel','school-mgt');?></option>
		  <option value="JPY" <?php echo selected(get_option( 'smgt_currency_code' ),'JPY');?>>
		  <?php _e('Japanese Yen','school-mgt');?></option>
		  <option value="MYR" <?php echo selected(get_option( 'smgt_currency_code' ),'MYR');?>>
		  <?php _e('Malaysian Ringgit','school-mgt');?></option>
		  <option value="MXN" <?php echo selected(get_option( 'smgt_currency_code' ),'MXN');?>>
		  <?php _e('Mexican Peso','school-mgt');?></option>
		  <option value="NOK" <?php echo selected(get_option( 'smgt_currency_code' ),'NOK');?>>
		  <?php _e('Norwegian Krone','school-mgt');?></option>
		  <option value="NZD" <?php echo selected(get_option( 'smgt_currency_code' ),'NZD');?>>
		  <?php _e('New Zealand Dollar','school-mgt');?></option>
		  <option value="PHP" <?php echo selected(get_option( 'smgt_currency_code' ),'PHP');?>>
		  <?php _e('Philippine Peso','school-mgt');?></option>
		  <option value="PLN" <?php echo selected(get_option( 'smgt_currency_code' ),'PLN');?>>
		  <?php _e('Polish Zloty','school-mgt');?></option>
		  <option value="GBP" <?php echo selected(get_option( 'smgt_currency_code' ),'GBP');?>>
		  <?php _e('Pound Sterling','school-mgt');?></option>
		  <option value="SGD" <?php echo selected(get_option( 'smgt_currency_code' ),'SGD');?>>
		  <?php _e('Singapore Dollar','school-mgt');?></option>
		  <option value="SEK" <?php echo selected(get_option( 'smgt_currency_code' ),'SEK');?>>
		  <?php _e('Swedish Krona','school-mgt');?></option>
		  <option value="CHF" <?php echo selected(get_option( 'smgt_currency_code' ),'CHF');?>>
		  <?php _e('Swiss Franc','school-mgt');?></option>
		  <option value="TWD" <?php echo selected(get_option( 'smgt_currency_code' ),'TWD');?>>
		  <?php _e('Taiwan New Dollar','school-mgt');?></option>
		  <option value="THB" <?php echo selected(get_option( 'smgt_currency_code' ),'THB');?>>
		  <?php _e('Thai Baht','school-mgt');?></option>
		  <option value="TRY" <?php echo selected(get_option( 'smgt_currency_code' ),'TRY');?>>
		  <?php _e('Turkish Lira','school-mgt');?></option>
		  <option value="USD" <?php echo selected(get_option( 'smgt_currency_code' ),'USD');?>>
		  <?php _e('U.S. Dollar','school-mgt');?></option>
		  <option value="ZAR" <?php echo selected(get_option( 'smgt_currency_code' ),'ZAR');?>>
		  <?php _e('South African Rand','school-mgt');?></option>
		 <option value="NGN" <?php echo selected(get_option( 'smgt_currency_code' ),'NGN');?>>
		  <?php _e('Nigerian Naira','school-mgt');?></option>
		   <option value="BDT" <?php echo selected(get_option( 'smgt_currency_code' ),'BDT');?>>
		  <?php _e('Bangladeshi Taka','school-mgt');?></option>
		</select>
		<span class="description"><?php _e('Selected currency might not supported by paypal. Please check with paypal.', 'school-mgt' ); ?></span>
			</div>
			<div class="col-sm-1">
				<span style="font-size: 23px;"><?php echo get_currency_symbol();?></span>
			</div>
		</div>
		
		<?php if(is_plugin_active('paymaster/paymaster.php')) 
		{ ?> 
		<div class="form-group">
			<label for="smgt_paymaster_pack" class="col-sm-2 control-label"><?php _e('Use Paymaster Payment Gateways','school-mgt');?></label>
			<div class="col-sm-4">
				<div class="checkbox">
				<label><input type="checkbox" value="yes" <?php echo checked(get_option('smgt_paymaster_pack'),'yes');?> name="smgt_paymaster_pack"><?php _e('Enable','school-mgt') ?> </label>
			  </div>
			</div>
		</div>
		<?php } ?>
		<div class="form-group">
			<label for="smgt_mail_notification" class="col-sm-2 control-label"><?php _e('Mail Notification','school-mgt');?></label>
			<div class="col-sm-4">
				<div class="checkbox">
				<label><input type="checkbox" value="1" <?php echo checked(get_option('smgt_mail_notification'),1);?> name="smgt_mail_notification"><?php _e('Enable','school-mgt') ?> </label>
			  </div>
			</div>
		</div>
		<div class="head">
			<hr>
			<h4 class="section"><?php _e('Virtual Classroom Setting(Zoom)','school-mgt');?></h4>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="smgt_enable_virtual_classroom"><?php _e('Virtual Classroom','school-mgt');?></label>
			<div class="col-sm-8">
				<div class="checkbox">
					<label>
	              		<input type="checkbox" name="smgt_enable_virtual_classroom"  value="1" <?php echo checked(get_option('smgt_enable_virtual_classroom'),'yes');?>/><?php _e('Enable','school-mgt');?>
	              </label>
              </div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="smgt_virtual_classroom_client_id"><?php _e('Client Id','school-mgt');?></label>
			<div class="col-sm-8">
				<input id="smgt_virtual_classroom_client_id" class="form-control text-input" type="text" value="<?php echo get_option( 'smgt_virtual_classroom_client_id' );?>"  name="smgt_virtual_classroom_client_id">
				<span class="description"><?php _e('That will be provided by zoom.', 'school-mgt' ); ?></span>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="smgt_virtual_classroom_client_secret_id"><?php _e('Client Secret Id','school-mgt');?></label>
			<div class="col-sm-8">
				<input id="smgt_virtual_classroom_client_secret_id" class="form-control text-input" type="text" value="<?php echo get_option( 'smgt_virtual_classroom_client_secret_id' );?>"  name="smgt_virtual_classroom_client_secret_id">
				<span class="description"><?php _e('That will be provided by zoom.', 'school-mgt' ); ?></span>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="smgt_virtual_classroom_client_id"><?php _e('Redirect URL','school-mgt');?></label>
			<div class="col-sm-8">
				<input id="" class="form-control text-input" type="text" value="<?php echo site_url().'?page=callback';?>"  name="" disabled>
				<span class="description"><?php _e('Please copy this Redirect URL and add in your zoom account Redirect URL.', 'school-mgt' ); ?></span>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="smgt_enable_virtual_classroom_reminder"><?php _e('Mail Notification Virtual ClassRoom Reminder','school-mgt');?></label>
			<div class="col-sm-8">
				<div class="checkbox">
					<label>
	              		<input id="virtual_classroom_reminder" type="checkbox" name="smgt_enable_virtual_classroom_reminder"  value="1" <?php echo checked(get_option('smgt_enable_virtual_classroom_reminder'),'yes');?>/><?php _e('Enable','school-mgt');?>
	              	</label>
              	</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="smgt_virtual_classroom_reminder_before_time"><?php esc_html_e('Reminder Before Time','school-mgt');?></label>
			<div class="col-sm-8">
				<input id="smgt_virtual_classroom_reminder_before_time" class="form-control" min="0" type="number" onKeyPress="if(this.value.length==2) return false;"  placeholder="<?php esc_html_e('01 Minute','school-mgt');?>"value="<?php echo get_option( 'smgt_virtual_classroom_reminder_before_time' );?>"  name="smgt_virtual_classroom_reminder_before_time">
			</div>
		</div>
		<div class="head">
			<hr>
			<h4 class="section"><?php _e('Message Setting','school-mgt');?></h4>
		</div>
		<div class="form-group">
			<label for="parent_send_message" class="col-sm-4 control-label"><?php _e('Parent can send message to class students','school-mgt');?></label>
			<div class="col-sm-4">
				<div class="checkbox">
					<label>
	              		<input type="checkbox" value="1" <?php echo checked(get_option('parent_send_message'),1);?> name="parent_send_message"><?php _e('Enable','school-mgt') ?></label>
              </div>
			</div>
		</div>
		<div class="form-group">
			<label for="student_send_message" class="col-sm-4 control-label"><?php _e(' Student can send message to each other','school-mgt');?></label>
			<div class="col-sm-4">
				<div class="checkbox">
					<label>
	              		<input type="checkbox" value="1" <?php echo checked(get_option('student_send_message'),1);?> name="student_send_message"><?php _e('Enable','school-mgt') ?></label>
              </div>
			</div>
		</div>
		<div class="head">
			<hr>
			<h4 class="section"><?php _e('Student Approval setting','school-mgt');?></h4>
		</div>
		<div class="form-group">
			<label for="student_approval" class="col-sm-2 control-label"><?php _e('Student Approval','school-mgt');?></label>
			<div class="col-sm-4">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked(get_option('student_approval'),1);?> name="student_approval"><?php _e('Enable','school-mgt') ?>
					</label>
				</div>
			</div>
		</div>
		<div class="col-sm-8">        	
        	<input type="submit" value="<?php _e('Save', 'school-mgt' ); ?>" name="save_setting" class="btn btn-success"/>
        </div>
        
        
        </form>
		</div>
        </div>
        </div>
        </div>
        </div>
 <?php

?> 