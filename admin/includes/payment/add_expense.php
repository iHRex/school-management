<?php $obj_invoice= new Smgtinvoice(); ?>
<script type="text/javascript">
$(document).ready(function() {
	$('#expense_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
	$('#invoice_date').datepicker({
		dateFormat: "yy-mm-dd",
		  changeMonth: true,
	        changeYear: true,
	        dateFormat: 'yy-mm-dd',
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
} );
</script>
<?php 	
	if($active_tab == 'addexpense')
	{
       	$expense_id=0;
		if(isset($_REQUEST['expense_id']))
			$expense_id=$_REQUEST['expense_id'];
		$edit=0;
			if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit'){
				$edit=1;
				$result = $obj_invoice->smgt_get_income_data($expense_id);
		}
?>
		
       <div class="panel-body">
        <form name="expense_form" action="" method="post" class="form-horizontal" id="expense_form">
         <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
		<input type="hidden" name="action" value="<?php echo $action;?>">
		<input type="hidden" name="expense_id" value="<?php echo $expense_id;?>">
		<input type="hidden" name="invoice_type" value="expense">	
		<div class="form-group">
			<label class="col-sm-2 control-label" for="supplier_name"><?php _e('Supplier Name','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="supplier_name" class="form-control validate[required,custom[onlyLetter_specialcharacter]] text-input" maxlength="50" type="text" value="<?php if($edit){ echo $result->supplier_name;}elseif(isset($_POST['supplier_name'])) echo $_POST['supplier_name'];?>" name="supplier_name">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="payment_status"><?php _e('Status','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<select name="payment_status" id="payment_status" class="form-control validate[required] max_width_100">
					<option value="<?php _e("Paid","school-mgt");?>"
						<?php if($edit)selected('Paid',$result->payment_status);?> ><?php _e('Paid','school-mgt');?></option>
					<option value="<?php _e("Part Paid","school-mgt");?>"
						<?php if($edit)selected('Part Paid',$result->payment_status);?>><?php _e('Part Paid','school-mgt');?></option>
						<option value="<?php _e("Unpaid","school-mgt");?>"
						<?php if($edit)selected('Unpaid',$result->payment_status);?>><?php _e('Unpaid','school-mgt');?></option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="invoice_date"><?php _e('Date','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="invoice_date" class="form-control validate[required]" type="text"  value="<?php if($edit){ echo smgt_getdate_in_input_box($result->income_create_date);}elseif(isset($_POST['invoice_date'])){ echo smgt_getdate_in_input_box($_POST['invoice_date']);}else{ echo date("Y-m-d");}?>" name="invoice_date" readonly>
			</div>
		</div>
		<hr>		
		<?php 			
			if($edit)
			{
				$all_entry=json_decode($result->entry);
			}
			else
			{
				if(isset($_POST['income_entry']))
				{					
					$all_data=$obj_invoice->get_entry_records($_POST);
					$all_entry=json_decode($all_data);
				}					
			}
			if(!empty($all_entry))
			{
				$i=1;
				foreach($all_entry as $entry)
				{ ?>
				<div id="expense_entry">
					<div class="form-group income_fld">
						<label class="col-sm-2 control-label" for="income_entry"><?php _e('Expense Entry','school-mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-2">
						<input id="income_amount" class="form-control btn_top amt validate[required,min[0],maxSize[8]] text-input" type="number" step="0.01" value="<?php echo $entry->amount;?>" name="income_amount[]" >
					</div>
					<div class="col-sm-4">
						<input id="income_entry" class="form-control entry btn_top validate[required,custom[onlyLetter_specialcharacter]] text-input" maxlength="50" type="text" value="<?php echo $entry->entry;?>" name="income_entry[]">
					</div>
					<div class="col-sm-2">
						<button type="button" class="btn btn-default btn_top" onclick="deleteParentElement(this)">
						<i class="entypo-trash"><?php _e('Delete','school-mgt');?></i>
						</button>
					</div>
					</div>	
				</div>
				<div id="new_entry"></div>
				
				<?php $i++; }				
			}
			else { ?>
			<div id="expense_entry">
				<div class="form-group income_fld">
					<label class="col-sm-2 control-label" for="income_entry"><?php _e('Expense Entry','school-mgt');?><span class="require-field">*</span></label>
				<div class="col-sm-2">
					<input id="income_amount" class="form-control btn_top validate[required,min[0],maxSize[8]] text-input" type="number" step="0.01" value="" name="income_amount[]" placeholder="<?php _e('Expense Amount','school-mgt');?>">
				</div>
				<div class="col-sm-4">
					<input id="income_entry" class="form-control btn_top validate[required,custom[onlyLetter_specialcharacter]] text-input" maxlength="50" type="text" value="" name="income_entry[]" placeholder="<?php _e('Expense Entry Label','school-mgt');?>">
				</div>
						
				<div class="col-sm-2">
					<button type="button" class="btn btn-default btn_top" onclick="deleteParentElement(this)">
						<i class="entypo-trash"><?php _e('Delete','school-mgt');?></i>
					</button>
				</div>
				</div>	
			</div>					
		<?php } ?>
		
		<?php wp_nonce_field( 'save_expense_fees_admin_nonce' ); ?>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="expense_entry"></label>
			<div class="col-sm-3">				
				<button id="add_new_entry" class="btn btn-default btn-sm btn-icon icon-left" type="button"   name="add_new_entry" onclick="add_entry()"><?php _e('Add Expense Entry','school-mgt'); ?></button>
			</div>
		</div>
		<hr>
		<div class="col-sm-offset-2 col-sm-8">
        	<input type="submit" value="<?php if($edit){ _e('Save Expense','school-mgt'); }else{ _e('Create Expense Entry','school-mgt');}?>" name="save_expense" class="btn btn-success"/>
        </div>
        </form>
        </div>
<script>   	
   	var blank_income_entry ='';
   	$(document).ready(function() { 
   		blank_custom_label = $('#expense_entry').html();   		
   	}); 
	
   	function add_entry()
   	{	
		<?php if($edit){ ?> 
		blank_custom_label+='<div class="form-group">';
		blank_custom_label+='<label class="col-sm-2 control-label" for="income_entry"><?php _e('Expense Entry','school-mgt');?><span class="require-field">*</span></label>';
		blank_custom_label+='<div class="col-sm-2">';
		blank_custom_label+='<input id="income_amount" class="form-control amt validate[required,min[0],maxSize[8]] text-input" type="number" step="0.01" value="" name="income_amount[]" >';
		blank_custom_label+='</div>';
		blank_custom_label+='<div class="col-sm-4">';
		blank_custom_label+='<input id="income_entry" class="form-control entry validate[required,custom[onlyLetter_specialcharacter]] text-input" maxlength="50" type="text" value="" name="income_entry[]">';
		blank_custom_label+='</div>';
		blank_custom_label+='<div class="col-sm-2">';
		blank_custom_label+='<button type="button" class="btn btn-default" onclick="deleteParentElement(this)">';
		blank_custom_label+='<i class="entypo-trash"><?php _e('Delete','school-mgt');?></i>';
		blank_custom_label+='</button>';
		blank_custom_label+='</div>';
		blank_custom_label+='</div>';
		$("#expense_entry").html(blank_custom_label);	
		<?php } else{  ?>
			$("#expense_entry").append(blank_custom_label);	
		<?php } ?>
		//var add_entryabc = $('.amt:last-child').attr('data-id');		
		//$('.amt:last-child').removeAttr( 'data-id' );
		//var new_row_num = $('.amt:last-child').attr("data-id",parseInt(add_entryabc) + parseInt(1));	
   		
   	}	
	
	
   	
   	function deleteParentElement(n)
	{
		var size = $(".income_fld").size();
		if(size > 1)
		{
			alert("<?php esc_html_e('Do you really want to delete this ?','school-mgt');?>");
			n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
		}else{
			// alert("There is only single entry,You can not remove it.");
			alert("<?php esc_html_e('There is only single entry,You can not remove it.','school-mgt');?>");
		}
   	}
</script> 
<?php 
	}
?>