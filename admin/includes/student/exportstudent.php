<script type="text/javascript">
$(document).ready(function() {
	$('#upload_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});	
});
</script>
<div class="panel-body">
    <form name="upload_form" action="" method="post" class="form-horizontal" id="upload_form" enctype="multipart/form-data">
        <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
		<input type="hidden" name="action" value="<?php echo $action;?>">
		<input type="hidden" name="role" value="<?php echo $role;?>"  />
		<div class="form-group">
			<label class="col-sm-2 control-label" for="class_name"><?php _e('Select Class','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<select name="class_name" class="form-control validate[required]" id="class_list">
                    <option value=""><?php _e('Select Class','school-mgt');?></option>
                    <?php
						foreach(get_allclass() as $classdata)
						{  
						?>
							<option value="<?php echo $classdata['class_id'];?>" ><?php echo $classdata['class_name'];?></option>
					<?php }?>
                </select>
			</div>
		</div>
			
		<div class="form-group">
			<label class="col-sm-2 control-label" for="class_name"><?php _e('Class Section','school-mgt');?></label>
			<div class="col-sm-8">
                <select name="class_section" class="form-control" id="class_section">
                   	<option value=""><?php _e('Select Class Section','school-mgt');?></option>
                </select>
			</div>
		</div>		
		<div class="col-sm-offset-2 col-sm-8">        	
        	<input type="submit" value="<?php _e('Export IN CSV','school-mgt');?>" name="exportstudentin_csv" class="btn btn-success"/>
        </div>
	</form>
</div>