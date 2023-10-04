<div class="panel-body">
    <form name="upload_form" action="" method="post" class="form-horizontal" id="upload_form" enctype="multipart/form-data">
        <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
		<input type="hidden" name="action" value="<?php echo $action;?>">		
		<div class="col-sm-8">        	
        	<input type="submit" value="<?php _e('Export Attendance IN CSV','school-mgt');?>" name="export_attendance_in_csv" class="btn btn-success"/>
        </div>
	</form>
</div>