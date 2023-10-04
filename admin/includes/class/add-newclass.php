<script type="text/javascript">
$(document).ready(function() {
	$('#class_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
} );
</script>

        <?php 
			$edit=0;
			if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
			{
				$edit=1;
				$classdata= get_class_by_id($_REQUEST['class_id']);
			} 
		?>
       
    <div class="panel-body">	
        <form name="class_form" action="" method="post" class="form-horizontal" id="class_form">
          <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
		<input type="hidden" name="action" value="<?php echo $action;?>">
        <div class="form-group">
			<label class="col-sm-2 control-label" for="class_name"><?php _e('Class Name','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="class_name" class="form-control validate[required,custom[popup_category_validation]]" maxlength="50" type="text" value="<?php if($edit){ echo $classdata->class_name;}?>" name="class_name">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="class_num_name"><?php _e('Numeric  Class Name','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="class_num_name" class="form-control validate[required,min[0],maxSize[4]] text-input" type="number" value="<?php if($edit){ echo $classdata->class_num_name;}?>" name="class_num_name" >
			</div>
		</div>
		<!--<div class="form-group">
			<label class="col-sm-2 control-label" for="class_section"><?php _e('Section','school-mgt');?></label>
			<div class="col-sm-8">
				<input id="class_section" class="form-control" type="text" value="<?php if($edit){ echo $classdata->class_section;}?>" name="class_section" >
			</div>
		</div>-->

        <?php wp_nonce_field( 'save_class_admin_nonce' ); ?>		
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="class_capacity"><?php _e('Student Capacity In Section','school-mgt');?> </label>
			<div class="col-sm-8">
				<input id="class_capacity" class="form-control validate[min[0],maxSize[4]]" type="number" value="<?php if($edit){ echo $classdata->class_capacity;}?>" name="class_capacity">
			</div>
		</div>
		<div class="col-sm-offset-2 col-sm-8">        	
        	<input type="submit" value="<?php if($edit){ _e('Save Class','school-mgt'); }else{ _e('Add Class','school-mgt');}?>" name="save_class" class="btn btn-success" />
        </div>        
        </form>
    </div>