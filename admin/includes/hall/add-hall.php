<script type="text/javascript">
	$(document).ready(function() {
		 $('#hall_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
	} );
</script>
			
	<?php  $edit=0;
	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
		{
			$edit=1;
			$hall_data= get_hall_by_id($_REQUEST['hall_id']);
		}
		?>
       
		<div class="panel-body">
        <form name="hall_form" action="" method="post" class="form-horizontal" id="hall_form">
          <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
		<input type="hidden" name="action" value="<?php echo $action;?>">
         <div class="form-group">
			<label class="col-sm-2 control-label" for="hall_name"><?php _e('Hall Name','school-mgt');?> <span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="hall_name" class="form-control validate[required,custom[popup_category_validation]] text-input" maxlength="50" type="text" value="<?php if($edit){ echo $hall_data->hall_name;}?>" name="hall_name">
				  <input type="hidden" name="hall_id" value="<?php if($edit){ echo $hall_data->hall_id;}?>"/> 
			</div>
		</div>
		 <div class="form-group">
			<label class="col-sm-2 control-label" for="number_of_hall"><?php _e('Hall Numeric Value','school-mgt');?> <span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="number_of_hall" class="form-control validate[required,custom[onlyNumberSp]]" maxlength="5" type="text" value="<?php if($edit){ echo $hall_data->number_of_hall;}?>" name="number_of_hall">				
			</div>
		</div>
		<?php wp_nonce_field( 'save_hall_admin_nonce' ); ?>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="hall_capacity"><?php _e('Capacity','school-mgt');?> <span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="hall_capacity" class="form-control validate[required,custom[onlyNumberSp]]" maxlength="5" type="text" value="<?php if($edit){ echo $hall_data->hall_capacity;}?>" name="hall_capacity">				
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="description"><?php _e('Description','school-mgt');?></label>
			<div class="col-sm-8">
				<textarea name="description" id="description" maxlength="150" class="form-control validate[custom[address_description_validation]]"><?php if($edit){ echo $hall_data->description;}?></textarea>		
			</div>
		</div>
		<div class="col-sm-offset-2 col-sm-8">        	
        	<input type="submit" value="<?php if($edit){ _e('Save Hall','school-mgt'); }else{ _e('Add Hall','school-mgt');}?>" name="save_hall" class="btn btn-success" />
        </div>
       
        </form>
        </div>
