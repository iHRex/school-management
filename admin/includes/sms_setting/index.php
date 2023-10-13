<?php 
$current_sms_service_active =get_option( 'smgt_sms_service');


if(isset($_REQUEST['save_sms_setting']))
{
	

	if(isset($_REQUEST['select_serveice']) && $_REQUEST['select_serveice'] == 'clickatell')
	{
		$custm_sms_service = array();
		$result=get_option( 'smgt_clickatell_sms_service');
		
		$custm_sms_service['username'] = trim($_REQUEST['username']);
		$custm_sms_service['password'] = $_REQUEST['password'];
		$custm_sms_service['api_key'] = $_REQUEST['api_key'];
		$custm_sms_service['sender_id'] = $_REQUEST['sender_id'];
		//print_r($custm_crm_option);
		$result=update_option( 'smgt_clickatell_sms_service',$custm_sms_service );
	}
	if(isset($_REQUEST['select_serveice']) && $_REQUEST['select_serveice'] == 'twillo')
	{
		$custm_sms_service = array();
		$result=get_option( 'smgt_twillo_sms_service');
		$custm_sms_service['account_sid'] = trim($_REQUEST['account_sid']);
		$custm_sms_service['auth_token'] = trim($_REQUEST['auth_token']);
		$custm_sms_service['from_number'] = $_REQUEST['from_number'];
		//print_r($custm_crm_option);
		$result=update_option( 'smgt_twillo_sms_service',$custm_sms_service );
	}
	if(isset($_REQUEST['select_serveice']) && $_REQUEST['select_serveice'] == 'msg91')
	{
		$custm_sms_service = array();
		$result=get_option( 'smgt_msg91_sms_service');
		$custm_sms_service['msg91_senderID'] = trim($_REQUEST['msg91_senderID']);
		$custm_sms_service['sms_auth_key'] = trim($_REQUEST['sms_auth_key']);
		$custm_sms_service['wpnc_sms_route'] = $_REQUEST['wpnc_sms_route'];
		//print_r($custm_crm_option);
		$result=update_option( 'smgt_msg91_sms_service',$custm_sms_service );
	}
	
	update_option( 'smgt_sms_service',$_REQUEST['select_serveice'] );

	wp_redirect ( admin_url() . 'admin.php?page=smgt_sms-setting&message=1');
}
?>

<script type="text/javascript">

$(document).ready(function() {
	 $('#sms_setting_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
} );

</script>

<div class="page-inner">
<div class="page-title">
		<h3><img src="<?php echo get_option( 'smgt_school_logo' ) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo get_option( 'smgt_school_name' );?></h3>
	</div>
	<div  id="main-wrapper" class="marks_list">
<?php
	$message = isset($_REQUEST['message'])?$_REQUEST['message']:'0';
	switch($message)
	{
		case '1':
			$message_string = __('SMS Settings Updated Successfully.','school-mgt');
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
 
	<h2 class="nav-tab-wrapper">
    	<a href="?page=smgt_sms-setting" class="nav-tab margin_bottom  nav-tab-active">
		<?php echo '<span class="dashicons dashicons-awards"></span>'.__('SMS Setting', 'school-mgt'); ?></a>
    </h2>
    
	<div class="panel-body"> 
    <form action="" method="post" class="form-horizontal" id="sms_setting_form">  
		<div class="form-group">
			<label class="col-sm-2 control-label " for="enable"><?php _e('Select Message Service','school-mgt');?></label>
			<div class="col-sm-8">
				<div class="radio">
				 	<label>
  						<input id="checkbox" type="radio" <?php echo checked($current_sms_service_active,'clickatell');?>  name="select_serveice" class="label_set" value="clickatell"> <?php _e('Clickatell','school-mgt');?> 
  					</label> 
  					&nbsp;&nbsp;&nbsp;&nbsp;
  				<!-- <label>
  						<input id="checkbox" type="radio"  <?php echo checked($current_sms_service_active,'twillo');?> name="select_serveice" class="label_set" value="twillo">  <?php _e('Twilio','school-mgt');?>
  					</label>
					&nbsp;&nbsp;&nbsp;&nbsp; -->
  					<label>
  						<input id="checkbox" type="radio"  <?php echo checked($current_sms_service_active,'msg91');?> name="select_serveice" class="label_set" value="msg91">  <?php _e('MSG91','school-mgt');?>
  					</label>
  				</div>
			</div>
		</div>
    	
		<div id="sms_setting_block">
		<?php 
		if($current_sms_service_active == 'clickatell')
		{
			$clickatell=get_option( 'smgt_clickatell_sms_service');
			?>
		<div class="form-group">
			<label class="col-sm-2 control-label " for="username"><?php _e('Username','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="username" class="form-control validate[required]" type="text" value="<?php echo $clickatell['username'];?>" name="username">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label " for="password"><?php _e('Password','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="password" class="form-control validate[required]" type="text" value="<?php echo $clickatell['password'];?>" name="password">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label " for="api_key"><?php _e('API Key','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="api_key" class="form-control validate[required]" type="text" value="<?php echo $clickatell['api_key'];?>" name="api_key">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label " for="sender_id"><?php _e('Sender Id','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="sender_id" class="form-control validate[required]" type="text" value="<?php echo $clickatell['sender_id'];?>" name="sender_id">
			</div>
		</div>
		<?php 
		}
		if($current_sms_service_active == 'twillo')
		{
			/* $twillo=get_option( 'smgt_twillo_sms_service');
			?>
			<div class="form-group">
			<label class="col-sm-2 control-label " for="account_sid"><?php _e('Account SID','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="account_sid" class="form-control validate[required]" type="text" value="<?php echo $twillo['account_sid'];?>" name="account_sid">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="auth_token"><?php _e('Auth Token','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="auth_token" class="form-control validate[required] text-input" type="text" name="auth_token" value="<?php echo $twillo['auth_token'];?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="from_number"><?php _e('From Number','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="from_number" class="form-control validate[required] text-input" type="text" name="from_number" value="<?php echo $twillo['from_number'];?>">
			</div>
		</div> */
		
		}
		if($current_sms_service_active == 'msg91')
		{
			$msg91=get_option( 'smgt_msg91_sms_service');
			?>
			<div class="form-group">
			<label class="col-sm-2 control-label " for="sms_auth_key"><?php _e('Authentication Key','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="sms_auth_key" class="form-control validate[required]" type="text" value="<?php echo $msg91['sms_auth_key'];?>" name="sms_auth_key">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="msg91_senderID"><?php _e('SenderID','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="msg91_senderID" class="form-control validate[required] text-input" type="text" name="msg91_senderID" value="<?php echo $msg91['msg91_senderID'];?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="wpnc_sms_route"><?php _e('Route','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="wpnc_sms_route" class="form-control validate[required] text-input" type="text" name="wpnc_sms_route" value="<?php echo $msg91['wpnc_sms_route'];?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-10 control-label" for="wpnc_sms_route"><b><?php _e('If your operator supports multiple routes then give one route name. Eg: route=1 for promotional, route=4 for transactional SMS.','school-mgt');?></b></label>
		</div>	
		<?php 
		}
		?>
		</div>
    	
    	<div class="col-sm-offset-2 col-sm-8">        	
        	<input type="submit" value="<?php  _e('Save','school-mgt');?>" name="save_sms_setting" class="btn btn-success" />
        </div>
   
    </form>
</div>
    <div class="clearfix"> </div>
	 </div>
	 </div>
	 </div>    
</div>
<?php ?>