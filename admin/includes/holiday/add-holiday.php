<script type="text/javascript">
$(document).ready(function() {
	 $('#holiday_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
	  
	  $('#date').datepicker({		
		dateFormat: "yy-mm-dd",
		minDate:0,
        onSelect: function (selected) {
            var dt = new Date(selected);
            dt.setDate(dt.getDate() + 0);
            $("#end_date").datepicker("option", "minDate", dt);
        }
	}); 
	$('#end_date').datepicker({		
		dateFormat: "yy-mm-dd",
		minDate:0,
        onSelect: function (selected) {
            var dt = new Date(selected);
            dt.setDate(dt.getDate() - 0);
            $("#date").datepicker("option", "maxDate", dt);
        }
	}); 	 
} );
</script>
<?php  
	$edit=0;
	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
	{
		$edit=1;
		$holiday_data= get_holiday_by_id($_REQUEST['holiday_id']);
	}
?>
<div class="panel-body">
    <form name="holiday_form" action="" method="post" class="form-horizontal" id="holiday_form">
       <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
		<input type="hidden" name="action" value="<?php echo $action;?>">
        <div class="form-group">
			<label class="col-sm-2 control-label" for="holiday_title"><?php _e('Holiday Title','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="holiday_title" class="form-control validate[required,custom[popup_category_validation]] text-input" maxlength="50" type="text" value="<?php if($edit){ echo $holiday_data->holiday_title;}?>" name="holiday_title">
				<input type="hidden" name="holiday_id"   value="<?php if($edit){ echo $holiday_data->holiday_id;}?>"/> 
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="description"><?php _e('Description','school-mgt');?></label>
			<div class="col-sm-8">
				<input id="holiday_title" class="form-control validate[custom[address_description_validation]]" maxlength="150" type="text" value="<?php if($edit){ echo $holiday_data->description;}?>" name="description">				
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="date"><?php _e('Start Date','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="date" class="datepicker form-control validate[required] text-input" type="text" value="<?php if($edit){ echo date("Y-m-d",strtotime($holiday_data->date)); }?>" name="date" readonly>				
			</div>
		</div>
		<?php wp_nonce_field( 'save_holiday_admin_nonce' ); ?>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="date"><?php _e('End Date','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="end_date" class="datepicker form-control validate[required] text-input" type="text" value="<?php if($edit){ echo date("Y-m-d",strtotime($holiday_data->end_date));}?>" name="end_date" readonly>				
			</div>
		</div>
		<div class="col-sm-offset-2 col-sm-8">        	
        	<input type="submit" value="<?php if($edit){ _e('Save Holiday','school-mgt'); }else{ _e('Add Holiday','school-mgt');}?>" name="save_holiday" class="btn btn-success" />
        </div>        
    </form>
</div>