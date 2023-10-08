<?php
$obj_hostel=new smgt_hostel;
 ?>
<script type="text/javascript">
	$(document).ready(function() {
		 $('#room_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
	} );
</script>
<!--Group POP up code -->
<div class="popup-bg">
	<div class="overlay-content admission_popup">
		<div class="modal-content">
			<div class="category_list">
			</div>     
		</div>
	</div>     
</div>
	<?php 
	$edit=0;
	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit_room')
		{
			$edit=1;
			$room_data=$obj_hostel->get_room_by_id($_REQUEST['room_id']);
		}
		?>
       
		<div class="panel-body">
        <form name="room_form" action="" method="post" class="form-horizontal" id="room_form">
          <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
		<input type="hidden" name="action" value="<?php echo $action;?>">
		<input type="hidden" name="room_id" value="<?php if($edit){ echo $room_data->id;}?>"/> 
         <div class="form-group">
			<label class="col-sm-2 control-label" for="room_unique_id"><?php _e('Room Unique ID','school-mgt');?> <span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="room_unique_id" class="form-control validate[required] text-input" type="text" value="<?php if($edit){ echo $room_data->room_unique_id; } else { echo generate_room_code(); } ?>"  name="room_unique_id" readonly>		
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="hostel_type"><?php _e('Select Hostel','school-mgt');?> <span class="require-field">*</span></label>
			<div class="col-sm-8">
				<select name="hostel_id" class="form-control validate[required] width_100" id="hostel_id">
					<option value=""><?php echo _e( 'Select Hostel', 'school-mgt' ) ;?></option>
					<?php $hostelval='';
					$hostel_data=$obj_hostel->smgt_get_all_hostel();
					if($edit){  
						$hostelval=$room_data->hostel_id; 
						foreach($hostel_data as $hostel)
						{ ?>
						<option value="<?php echo $hostel->id;?>" <?php selected($hostel->id,$hostelval);  ?>>
						<?php echo $hostel->hostel_name;?></option> 
					<?php }
					}else
					{
						foreach($hostel_data as $hostel)
						{ ?>
						<option value="<?php echo $hostel->id;?>" <?php selected($hostel->id,$hostelval);  ?>><?php echo $hostel->hostel_name;?></option> 
					<?php }
					}
					?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="hostel_type"><?php _e('Room Category','school-mgt');?> <span class="require-field">*</span></label>
			<div class="col-sm-8">
				<select class="form-control validate[required] room_category margin_top_10 width_100" name="room_category" id="room_category">
					<option value=""><?php esc_html_e('Select Room','school-mgt');?></option>
					<?php 
					$activity_category=smgt_get_all_category('room_category');
					if(!empty($activity_category))
					{
						if($edit)
						{
							$room_val=$room_data->room_category; 
						}
						else
						{
							$room_val=''; 
						}
						foreach ($activity_category as $retrive_data)
						{ 		 	
						?>
							<option value="<?php echo $retrive_data->ID;?>" <?php selected($retrive_data->ID,$room_val);  ?>><?php echo esc_attr($retrive_data->post_title); ?> </option>
						<?php }
					} 
					?> 
				</select>	
			</div>
			<div class="col-md-1 col-sm-1 col-xs-12">
				<button id="addremove_cat" class="btn btn-info sibling_add_remove margin_top_10" model="room_category"><?php _e('Add','school-mgt');?></button>		
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="Bed Capacity"><?php _e('Beds Capacity','school-mgt');?> <span class="require-field">*</span></label> 
			<div class="col-sm-8">
				<input id="beds_capacity" class="form-control validate[required,custom[onlyNumberSp],maxSize[2],min[1]] text-input" placeholder="<?php esc_html_e('Enter Beds Capacity','school-mgt');?>"  type="text" value="<?php if($edit){ echo $room_data->beds_capacity; } ?>"  name="beds_capacity">
			</div>
		</div>
		<?php wp_nonce_field( 'save_room_admin_nonce' ); ?>
		 
		<div class="form-group">
			<label class="col-sm-2 control-label" for="room_description"><?php _e('Description','school-mgt');?></label>
			<div class="col-sm-8">
				<textarea name="room_description" id="room_description" maxlength="150" class="form-control validate[custom[address_description_validation]]"><?php if($edit){ echo $room_data->room_description;}?></textarea>		
			</div>
		</div>
		<div class="col-sm-offset-2 col-sm-8">        	
        	<input type="submit" value="<?php if($edit){ _e('Save Room','school-mgt'); }else{ _e('Add Room','school-mgt');}?>" name="save_room" class="btn btn-success" />
        </div>
       
        </form>
        </div>