<script type="text/javascript">
$(document).ready(function() {
	 $('#transport_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
} );
</script>
	<div class="add_transport">		
		<?php  
			$edit=0;
			if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
			{
				$edit=1;
				$transport_data= get_transport_by_id($_REQUEST['transport_id']);
			}
		?>
        
		<div class="panel-body">
        <form name="transport_form" action="" method="post" class="form-horizontal" id="transport_form">
          <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
		<input type="hidden" name="action" value="<?php echo $action;?>">
        <div class="form-group">
			<label class="col-sm-2 control-label" for="route_name"><?php _e('Route Name','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="route_name" class="form-control validate[required,custom[address_description_validation]]" type="text" maxlength="50" value="<?php if($edit){ echo $transport_data->route_name;}?>" name="route_name">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="number_of_vehicle"><?php _e('Vehicle Identifier','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="number_of_vehicle" class="form-control validate[required,custom[onlyNumberSp]]" maxlength="15" type="text" value="<?php if($edit){ echo $transport_data->number_of_vehicle;}?>" name="number_of_vehicle">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="vehicle_reg_num"><?php _e('Vehicle Registration Number','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="vehicle_reg_num" class="form-control validate[required,custom[address_description_validation]]" maxlength="50" type="text" value="<?php if($edit){ echo $transport_data->vehicle_reg_num;}?>" name="vehicle_reg_num">
			</div>
		</div>
		<?php wp_nonce_field( 'save_transpoat_admin_nonce' ); ?>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="driver_name"><?php _e('Driver Name','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="driver_name" class="form-control validate[required,custom[onlyLetter_specialcharacter]]" maxlength="50" type="text" value="<?php if($edit){ echo $transport_data->driver_name;}?>" name="driver_name">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="driver_phone_num"><?php _e('Driver Phone Number','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="driver_phone_num" class="form-control validate[required,custom[phone_number],minSize[6],maxSize[15]]" type="text" value="<?php if($edit){ echo $transport_data->driver_phone_num;}?>" name="driver_phone_num">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="driver_address"><?php _e('Driver Address','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<textarea name="driver_address" class="form-control validate[required,custom[address_description_validation]]" maxlength="150" id="driver_address"><?php if($edit){ echo $transport_data->driver_address;}?></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="driver_address"><?php _e('Image','school-mgt');?></label>
			<div class="col-sm-8">
				 <input type="text" id="smgt_user_avatar_url" name="smgt_user_avatar" value="<?php if($edit)echo esc_url( $transport_data->smgt_user_avatar ); ?>" readonly />
       				 <input id="upload_user_avatar_button" type="button" class="button btn_top" value="<?php _e( 'Upload image', 'school-mgt' ); ?>" />
       				 <span class="description"><?php _e('Upload image', 'school-mgt' ); ?></span>
                     
                     <div id="upload_user_avatar_preview">
                     <?php if($edit) 
	                     	{
	                     	if($transport_data->smgt_user_avatar == "")
	                     	{
	                     		?><img alt="" class="image_preview_css" src="<?php echo get_option( 'smgt_driver_thumb' ) ?>"><?php 
	                     	}
	                     	else {
	                     		?>
	                     	
					        <img class="image_preview_css" src="<?php if($edit)echo esc_url( $transport_data->smgt_user_avatar ); ?>" />
					        <?php 
	                     	}
	                     	}
					        else {
					        	?>
					        	<img alt="" class="image_preview_css" src="<?php echo get_option( 'smgt_driver_thumb' ) ?>">
					        	<?php 
					        }?>  
        
    				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="route_description"><?php _e('Description','school-mgt');?></label>
			<div class="col-sm-8">
				 <textarea name="route_description" class="form-control validate[custom[address_description_validation]]" maxlength="150" id="route_description"><?php if($edit){ echo $transport_data->route_description;}?></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="route_fare"><?php _e('Route Fare','school-mgt');?>(<?php echo get_currency_symbol();?>)<span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="route_fare" class="form-control validate[required,custom[onlyNumberSp],min[0],maxSize[10]]" type="text" value="<?php if($edit){ echo $transport_data->route_fare;}?>" name="route_fare">
			</div>
		</div>
		<div class="col-sm-offset-2 col-sm-8">
        	
        	<input type="submit" value="<?php if($edit){ _e('Save Transport','school-mgt'); }else{ _e('Add Transport','school-mgt');}?>" name="save_transport" class="btn btn-success"/>
        </div>
       	
        </form>
        </div>
    </div>