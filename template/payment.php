<?php
//-------- CHECK BROWSER JAVA SCRIPT ----------//
MJ_smgt_browser_javascript_check();
$tablename="smgt_payment";
$obj_invoice= new Smgtinvoice();
$active_tab=isset($_REQUEST['tab'])?$_REQUEST['tab']:'paymentlist';
//--------------- ACCESS WISE ROLE -----------//
$user_access=smgt_get_userrole_wise_access_right_array();
if (isset ( $_REQUEST ['page'] ))
{	
	if($user_access['view']=='0')
	{	
		MJ_smgt_access_right_page_not_access_message();
		die;
		
	}
	if(!empty($_REQUEST['action']))
	{
		if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == $user_access['page_link'] && ($_REQUEST['action']=='edit'))
		{
			if($user_access['edit']=='0')
			{	
				MJ_smgt_access_right_page_not_access_message();
				die;
			}			
		}
		if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == $user_access['page_link'] && ($_REQUEST['action']=='delete'))
		{
			if($user_access['delete']=='0')
			{	
				MJ_smgt_access_right_page_not_access_message();
				die;
			}	
		}
		if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == $user_access['page_link'] && ($_REQUEST['action']=='insert'))
		{
			if($user_access['add']=='0')
			{	
				MJ_smgt_access_right_page_not_access_message();
				die;
			}	
		} 
	}
}
//--------------- SAVE PAYMENT ---------------------//
if(isset($_POST['save_payment']))
{
	$nonce = $_POST['_wpnonce'];
	if ( wp_verify_nonce( $nonce, 'save_payment_frontend_nonce' ) )
	{
		$section_id=0;
		if(isset($_POST['class_section']))
			$section_id=$_POST['class_section'];
			$created_date = date("Y-m-d H:i:s");
		$payment_data=array(
			'student_id'=>MJ_smgt_onlyNumberSp_validation($_POST['student_id']),
			'class_id'=>MJ_smgt_onlyNumberSp_validation($_POST['class_id']),
			'section_id'=>$section_id,
			'payment_title'=>MJ_smgt_popup_category_validation($_POST['payment_title']),
			'description'=>MJ_smgt_address_description_validation($_POST['description']),
			'amount'=>MJ_smgt_onlyNumberSp_validation($_POST['amount']),
			'payment_status'=>MJ_smgt_popup_category_validation($_POST['payment_status']),
			'date'=>$created_date,					
			'payment_reciever_id'=>get_current_user_id(),
			'created_by'=>get_current_user_id()		
		);
			
		if($_REQUEST['action']=='edit')
		{
			$transport_id=array('payment_id'=>$_REQUEST['payment_id']);				
			$result=update_record($tablename,$payment_data,$transport_id);
			if($result){ 
				wp_redirect ( home_url() . '?dashboard=user&page=payment&tab=paymentlist&message=2');
			 }
		}
		else
		{
			$result=insert_record($tablename,$payment_data);
			if($result)
				wp_redirect ( home_url() . '?dashboard=user&page=payment&tab=paymentlist&message=1');
		}
    }
}
//--------save income-------------//
if(isset($_POST['save_income']))
{
	$nonce = $_POST['_wpnonce'];
	if ( wp_verify_nonce( $nonce, 'save_income_frontend_nonce' ) )
	{
		if($_REQUEST['action']=='edit')
		{
			$result=$obj_invoice->add_income($_POST);
			if($result)
			{
				wp_redirect ( home_url() . '?dashboard=user&page=payment&tab=incomelist&message=4');
			}
		}
		else
		{
			$result=$obj_invoice->add_income($_POST);
			if($result)
			{
				wp_redirect ( home_url() . '?dashboard=user&page=payment&tab=incomelist&message=3');
			}
		}
    }	
}
//--------save Expense-------------//
if(isset($_POST['save_expense']))
{
	$nonce = $_POST['_wpnonce'];
	if ( wp_verify_nonce( $nonce, 'save_expense_front_nonce' ) )
	{
		if($_REQUEST['action']=='edit')
		{
			$result=$obj_invoice->add_expense($_POST);
			if($result)
			{
				wp_redirect ( home_url() . '?dashboard=user&page=payment&tab=expenselist&message=6');
			}
		}
		else
		{
			$result=$obj_invoice->add_expense($_POST);
			if($result)
			{
				wp_redirect ( home_url() . '?dashboard=user&page=payment&tab=expenselist&message=5');
			}
		}
    }
}
//----------------- DELETE RECORD ------------//
if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
{
	if(isset($_REQUEST['payment_id'])){
	$result=delete_payment($tablename,$_REQUEST['payment_id']);
		if($result)
		{
			wp_redirect (home_url() . '?dashboard=user&page=payment&tab=paymentlist&message=8');
		}
	}
	if(isset($_REQUEST['income_id']))
	{
		$result=$obj_invoice->delete_income($_REQUEST['income_id']);
		if($result)
		{
			wp_redirect ( home_url() . '?dashboard=user&page=payment&tab=incomelist&message=9');
		}
	}
	if(isset($_REQUEST['expense_id']))
	{
		$result=$obj_invoice->delete_expense($_REQUEST['expense_id']);
		if($result)
		{
			wp_redirect (  home_url() . '?dashboard=user&page=payment&tab=expenselist&message=7');
		}
	}
}
		
if(isset($_REQUEST['delete_selected_payment']))
{		
	if(!empty($_REQUEST['id']))
	foreach($_REQUEST['id'] as $id)
		$result=delete_payment($tablename,$id);
	if($result)
	{ 
		wp_redirect (home_url() . '?dashboard=user&page=payment&tab=paymentlist&message=8');
	}
}
//----------------- DELETE RECORD ------------//
if(isset($_REQUEST['delete_selected_income']))
{		
	if(!empty($_REQUEST['id']))
	foreach($_REQUEST['id'] as $id)
		$result=$obj_invoice->delete_income($id);
	if($result)
	{ 
		wp_redirect ( home_url() . '?dashboard=user&page=payment&tab=incomelist&message=9');
	}
}
if(isset($_REQUEST['delete_selected_expense']))
{		
	if(!empty($_REQUEST['id']))
	foreach($_REQUEST['id'] as $id)
		$result=$obj_invoice->delete_expense($id);
	if($result)
	{ 
		wp_redirect (  home_url() . '?dashboard=user&page=payment&tab=expenselist&message=7');
	}
}

?>
<script type="text/javascript">
$(document).ready(function() {	
	$('#invoice_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
	$('#income_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
	$('#expense_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});	
	$('#invoice_date').datepicker({
		changeMonth: true,
	    changeYear: true,
	    dateFormat: 'yy-mm-dd',
	    yearRange:'-65:+25',
	    onChangeMonthYear: function(year, month, inst) {
	        $(this).val(month + "/" + year);
	    }
    }); 
});
</script>
<!-- POP up code -->
<div class="popup-bg">
    <div class="overlay-content">
		<div class="modal-content">
			<div class="invoice_data"></div>		 
		</div>
    </div>    
</div>
<!-- End POP-UP Code -->
<div class="panel-body panel-white">
<?php
	$message = isset($_REQUEST['message'])?$_REQUEST['message']:'0';
	switch($message)
	{
		case '1':
			$message_string = __('Payment Successfully Inserted.','school-mgt');
			break;
		case '2':
			$message_string = __('Payment Successfully Updated.','school-mgt');
			break;	
		case '3':
			$message_string = __('Income Added successfully.','school-mgt');
			break;
		case '4':
			$message_string = __('Income updated successfully.','school-mgt');
			break;
		case '5':
			$message_string = __('Expense Added successfully.','school-mgt');
			break;
		case '6':
			$message_string = __('Expense updated successfully.','school-mgt');
			break;
		case '7':
			$message_string = __('Expense delete successfully.','school-mgt');
			break;
		case '8':
			$message_string = __('payment delete successfully.','school-mgt');
			break;
		case '9':
			$message_string = __('Income delete successfully.','school-mgt');
			break;
	}
	
	if($message)
	{ ?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
				<?php echo $message_string;?>
			</div>
<?php 
	} ?>
	<ul class="nav nav-tabs panel_tabs" role="tablist">
		<li class="<?php if($active_tab=='paymentlist'){?>active<?php }?>">
			<a href="?dashboard=user&page=payment&tab=paymentlist"  class="nav-tab2 <?php echo $active_tab == 'paymentlist' ? 'active' : ''; ?>">
				<i class="fa fa-align-justify"></i> <?php _e('Payment', 'school-mgt'); ?></a>
			</a>
		</li>
		<li class="<?php if($active_tab=='addinvoice'){?> active <?php }?>">
		  <?php  if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit' && isset($_REQUEST['payment_id']))
			{ ?>
			<a href="?dashboard=user&page=payment&tab=addinvoice&action=edit&invoice_id=<?php if(isset($_REQUEST['invoice_id'])) echo $_REQUEST['invoice_id'];?>" class="nav-tab2 <?php echo $active_tab == 'addinvoice' ? 'active' : ''; ?>">
			 <i class="fa fa"></i> <?php _e('Edit Payment', 'school-mgt'); ?></a>
			 <?php 
			}
			else
			{
				if($user_access['add']=='1')
				{ ?>
					<a href="?dashboard=user&page=payment&tab=addinvoice" class="nav-tab2 <?php echo $active_tab == 'addinvoice' ? 'active' : ''; ?>">
					<i class="fa fa-plus-circle"></i> <?php _e('Add Payment', 'school-mgt'); ?></a>
	  <?php 	} 
			}?>
		</li>
		<li class="<?php if($active_tab=='incomelist'){?>active<?php }?>">
			<a href="?dashboard=user&page=payment&tab=incomelist" class="nav-tab2 <?php echo $active_tab == 'incomelist' ? 'active' : ''; ?>">
				<i class="fa fa-align-justify"></i> <?php _e('Income List', 'school-mgt'); ?></a>
			</a>
		</li>
		<li class="<?php if($active_tab=='addincome'){?>active<?php }?>">
		  <?php  if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit' && isset($_REQUEST['invoice_id']))
			{?>
				<a href="?dashboard=user&page=payment&tab=addincome&action=edit&income_id=<?php if(isset($_REQUEST['income_id'])) echo $_REQUEST['income_id'];?>" class="nav-tab2 <?php echo $active_tab == 'addincome' ? 'active' : ''; ?>">
				<i class="fa fa"></i> <?php _e('Edit Income', 'school-mgt'); ?></a>
			 <?php 
			 }
			else
			{
				if($user_access['add']=='1')
				{ ?>
					<a href="?dashboard=user&page=payment&tab=addincome" class="nav-tab2 <?php echo $active_tab == 'addincome' ? 'active' : ''; ?>">
					<i class="fa fa-plus-circle"></i> <?php _e('Add Income', 'school-mgt'); ?></a>
	  <?php 	} 
			}?>
		</li>
		<li class="<?php if($active_tab=='expenselist'){?>active<?php }?>">
			<a href="?dashboard=user&page=payment&tab=expenselist" class="nav-tab2 <?php echo $active_tab == 'expenselist' ? 'active' : ''; ?>">
				<i class="fa fa-align-justify"></i> <?php _e('Expense List', 'school-mgt'); ?></a>
			</a>
		</li>
		<li class="<?php if($active_tab=='addexpense'){?>active<?php }?>">
		  <?php  if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit' && isset($_REQUEST['expense_id']))
			{?>
				<a href="?dashboard=user&page=payment&tab=addexpense&action=edit&expense_id=<?php if(isset($_REQUEST['expense_id'])) echo $_REQUEST['expense_id'];?>" class="nav-tab2 <?php echo $active_tab == 'addexpense' ? 'active' : ''; ?>">
				<i class="fa fa"></i> <?php _e('Edit Expense', 'school-mgt'); ?></a>
			 <?php
			}
			else
			{
				if($user_access['add']=='1')
				{?>
					<a href="?dashboard=user&page=payment&tab=addexpense" class="nav-tab2 margin_bottom <?php echo $active_tab == 'addexpense' ? 'active' : ''; ?>">
					<i class="fa fa-plus-circle"></i> <?php _e('Add Expense', 'school-mgt'); ?></a>
	  <?php		} 
			}?>
		</li>
	</ul>
	<div class="tab-content">
	<?php 
	if($active_tab == 'paymentlist')
	{
		$user_id=get_current_user_id();
			//------- Payment DATA FOR STUDENT ---------//
			if($school_obj->role == 'student')
			{
				$data=$school_obj->payment_list;
			}

			//------- Payment DATA FOR PARENT ---------//
			elseif($school_obj->role == 'parent')
			{
				$data=$school_obj->payment_list;
			}
			//------- Payment DATA FOR SUPPORT STAFF ---------//
			else
			{ 
				$own_data=$user_access['own_data'];
				if($own_data == '1')
				{ 
					$data	= $obj_invoice->get_invoice_created_by($user_id);
				}
				else
				{
					$data=$school_obj->payment_list;
				}
			} 
	?>
		<div class="panel-body">
		 <script>
		jQuery(document).ready(function() {
			var table =  jQuery('#payment_list').DataTable({
				responsive: true,
				"order": [[ 1, "asc" ]],
				"aoColumns":[ <?php if($school_obj->role == 'supportstaff')
						   {?>           
							  {"bSortable": false},	  
							  <?php }?>               
							  {"bSortable": true},
							  {"bSortable": true},
							  {"bSortable": true},
							  {"bSortable": true},	                 	                  
							  {"bSortable": true},	                 	                  
							  {"bSortable": true},	                 	                  
							  {"bSortable": true},	                 	                  
							  {"bSortable": false}],
				language:<?php echo smgt_datatable_multi_language();?>
			});
			 jQuery('#checkbox-select-all').on('click', function(){
			 
			  var rows = table.rows({ 'search': 'applied' }).nodes();
			  jQuery('input[type="checkbox"]', rows).prop('checked', this.checked);
		   }); 
		   
			 $("#delete_selected").on('click', function()
				{	
					if ($('.select-checkbox:checked').length == 0 )
					{
						alert("<?php esc_html_e('Please select atleast one record','school-mgt');?>");
						return false;
					}
				else{
						var alert_msg=confirm("<?php esc_html_e('Are you sure you want to delete this record?','school-mgt');?>");
							if(alert_msg == false)
							{
								return false;
							}
							else
							{
								return true;
							}
					}
			});
		   
		});
	</script>
		 <div class="table-responsive">
			<table id="payment_list" class="display dataTable" cellspacing="0" width="100%">
				<thead>
					<tr>    
						 <?php if($school_obj->role == 'supportstaff')
						   {?>
						<th style="width: 20px;"><input name="select_all" value="all" id="checkbox-select-all" 
						type="checkbox" /></th>     
						<?php }?>        
						<th><?php _e('Student Name','school-mgt');?></th>
						 <th><?php _e('Roll No.','school-mgt');?></th>
						<th><?php _e('Class','school-mgt');?> </th>
						<th><?php _e('Title','school-mgt');?></th>               
						<th><?php _e('Amount','school-mgt');?></th>
						<th><?php _e('Status','school-mgt');?></th>
						<th><?php _e('Date','school-mgt');?></th>
						<th><?php _e('Action','school-mgt');?></th> 
					</tr>
				</thead>
 
				<tfoot>
					<tr>
					 <?php if($school_obj->role == 'supportstaff')
						   {?><th></th><?php }?>
						<th><?php _e('Student Name','school-mgt');?></th>
						<th><?php _e('Roll No.','school-mgt');?></th>
						<th><?php _e('Class','school-mgt');?> </th>
						<th><?php _e('Title','school-mgt');?></th>              
						<th><?php _e('Amount','school-mgt');?></th>
						<th><?php _e('Status','school-mgt');?></th>
						<th><?php _e('Date','school-mgt');?></th>
						<th><?php _e('Action','school-mgt');?></th> 
					</tr>
				</tfoot>
		 
				<tbody>
				  <?php 
					foreach ($data as $retrieved_data)
					{			
					?>
						<tr>
						<?php if($school_obj->role == 'supportstaff')
							{?>
							<td><input type="checkbox" class="select-checkbox" name="id[]" 
							value="<?php echo $retrieved_data->payment_id;?>"></td><?php }?>
							<td><?php echo get_user_name_byid($retrieved_data->student_id);?></td>
							<td><?php echo get_user_meta($retrieved_data->student_id, 'roll_id',true);?></td>
							<td><?php echo get_class_name($retrieved_data->class_id);?></td>
							<td width="110px"><?php echo $retrieved_data->payment_title;?></td>
						   
							  <td><?php echo "<span> ". get_currency_symbol() ." </span>" . $retrieved_data->amount;?></td>
							   <td><?php 
									if($retrieved_data->payment_status=='Paid') 
											echo __('Paid','school-mgt');
										elseif($retrieved_data->payment_status=='Part Paid')
											echo __('Part Paid','school-mgt');
										else
											echo __('Unpaid','school-mgt');	?></td>
							<td><?php  echo smgt_getdate_in_input_box($retrieved_data->date);?></td>  
							<td>
								<a  href="#" class="show-invoice-popup btn btn-default" idtest="<?php echo $retrieved_data->payment_id; ?>" invoice_type="invoice">
									<i class="fa fa-eye"></i> <?php _e('View Income', 'school-mgt');?></a>
									  <?php
								if($user_access['edit']=='1')
								{
								?>
									<a href="?dashboard=user&page=payment&tab=addinvoice&action=edit&payment_id=<?php echo $retrieved_data->payment_id;?>" class="btn btn-info"><?php _e('Edit','school-mgt');?></a>
								<?php
								}
								if($user_access['delete']=='1')
								{ ?>
									<a href="?dashboard=user&page=payment&tab=paymentlist&action=delete&payment_id=<?php echo $retrieved_data->payment_id;?>" class="btn btn-danger"
						           onclick="return confirm('<?php _e('Are you sure you want to delete this record?','school-mgt');?>');"> <?php _e('Delete','school-mgt');?></a>
									<?php	
								} ?>
							</td> 
						</tr>
					<?php 
					} ?>     
				</tbody>        
			</table>
		</div>
		<?php if($school_obj->role == 'supportstaff')
            {
				if($user_access['delete']=='1')
				{ ?>
					<div class="print-button pull-left">
						<input id="delete_selected" type="submit" value="<?php _e('Delete Selected','school-mgt');?>" name="delete_selected_payment" class="btn btn-danger delete_selected"/>			
					</div>
		<?php 
				}
			}?>
        </div>
        <?php 
		}
        if($active_tab == 'addinvoice')
		{
        ?>
			<script type="text/javascript">
			$(document).ready(function() {
				$('#payment_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
			} );
			</script>
	<?php
		$edit = 0;
		if (isset ( $_REQUEST ['action'] ) && $_REQUEST ['action'] == 'edit') 
		{
			$edit = 1;
			$payment_data = get_payment_by_id($_REQUEST['payment_id']);
		} 
	?>
	  
			<div class="panel-body">
			<form name="payment_form" action="" method="post" class="form-horizontal" id="payment_form">
				<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
				<input type="hidden" name="action" value="<?php echo $action;?>">
				<div class="form-group">
					<label class="col-sm-2 control-label" for="payment_title"><?php _e('Title','school-mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8">
						<input id="payment_title" class="form-control validate[required,custom[popup_category_validation]]" maxlength="50" type="text" value="<?php if($edit){ echo $payment_data->payment_title;}?>" name="payment_title"/>
						<input type="hidden" name="payment_id"	value="<?php if($edit){ echo $payment_data->payment_id;}?>" />				
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-2 control-label" for="class_id"><?php _e('Class','school-mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8">
						<?php
						if($edit){ $classval=$payment_data->class_id; }else{$classval='';}?>
							<select name="class_id" id="class_list" class="form-control validate[required]">
							<?php if($addparent){ 
								$classdata=get_class_by_id($student->class_name);
							?>
							<option value="<?php echo $student->class_name;?>" ><?php echo $classdata->class_name;?></option>
							<?php } ?>
							<option value=""><?php _e('Select Class','school-mgt');?></option>
							<?php
								foreach(get_allclass() as $classdata)
								{ ?>
									 <option value="<?php echo $classdata['class_id'];?>" <?php selected($classval, $classdata['class_id']);  ?>><?php echo $classdata['class_name'];?></option>
							<?php }?>
							</select>
					</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="class_name"><?php _e('Class Section','school-mgt');?></label>
						<div class="col-sm-8">
							<?php if($edit){ $sectionval=$payment_data->section_id; }elseif(isset($_POST['class_section'])){$sectionval=$_POST['class_section'];}else{$sectionval='';}?>
							<select name="class_section" class="form-control" id="class_section">
								<option value=""><?php _e('Select Class Section','school-mgt');?></option>
								<?php
								if($edit){
								foreach(smgt_get_class_sections($payment_data->class_id) as $sectiondata)
								{  ?>
									 <option value="<?php echo $sectiondata->id;?>" <?php selected($sectionval,$sectiondata->id);  ?>><?php echo $sectiondata->section_name;?></option>
								<?php } 
								}?>
						   </select>
						</div>
					</div>
					<?php wp_nonce_field( 'save_payment_frontend_nonce' ); ?>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="student_list"><?php _e('Student','school-mgt');?><span class="require-field">*</span></label>
						<div class="col-sm-8">
							<?php if($edit){ $classval=$payment_data->class_id; }else{$classval='';}?>                     
								 <select name="student_id" id="student_list"class="form-control validate[required]">                    
								 <?php if(isset($payment_data->student_id)){ 
									$student=get_userdata($payment_data->student_id);
								 ?>
								 <option value="<?php echo $payment_data->student_id;?>" ><?php echo $student->first_name." ".$student->last_name;?></option>
								 <?php }
										else
										{?>
									<option value=""><?php _e('Select student','school-mgt');?></option>
										<?php } ?>
								 </select>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-2 control-label" for="amount"><?php _e('Amount','school-mgt');?>(<?php echo get_currency_symbol();?>)<span class="require-field">*</span></label>
						<div class="col-sm-8">
							<input id="amount" class="form-control validate[required,min[0],maxSize[12]]" type="number" step="0.01" value="<?php if($edit){ echo $payment_data->amount;}?>" name="amount">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="payment_status"><?php _e('Status','school-mgt');?><span class="require-field">*</span></label>
						<div class="col-sm-8">
							<select name="payment_status" id="payment_status" class="form-control">
								<option value="Paid"
									<?php if($edit)selected('Paid',$payment_data->payment_status);?> class="validate[required]"><?php _e('Paid','school-mgt');?></option>
								<option value="Part Paid"
									<?php if($edit)selected('Part Paid',$payment_data->payment_status);?> class="validate[required]"><?php _e('Part Paid','school-mgt');?></option>
									<option value="Unpaid"
									<?php if($edit)selected('Unpaid',$payment_data->payment_status);?> class="validate[required]"><?php _e('Unpaid','school-mgt');?></option>
						</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="description"><?php _e('Description','school-mgt');?></label>
						<div class="col-sm-8">
							<textarea name="description" id="description" class="form-control validate[custom[address_description_validation]]" maxlength="150"><?php if($edit){ echo $payment_data->description;}?></textarea>
						</div>
					</div>
					<div class="col-sm-offset-2 col-sm-8">        	
						<input type="submit" value="<?php if($edit){ _e('Save Payment','school-mgt'); }else{ _e('Add Payment','school-mgt');}?>" name="save_payment" class="btn btn-success" />
					</div>
					</form>
			</div>
	<?php 
		}
	//--------------------- INCOME LIST ------------------------//
		if($active_tab == 'incomelist')
		{ ?>
		<script type="text/javascript">
			$(document).ready(function() {
				var table = jQuery('#tblincome').DataTable({
					responsive: true,
					 "order": [[ 4, "Desc" ]],
					 "aoColumns":[
								  {"bSortable": false},
								  {"bSortable": true},
								  {"bSortable": true},
								  {"bSortable": true},
								  {"bSortable": true}, 
								  {"bSortable": false}
							   ],
					language:<?php echo smgt_datatable_multi_language();?>
					});
				
				jQuery('#checkbox-select-all').on('click', function(){
				 
				  var rows = table.rows({ 'search': 'applied' }).nodes();
				  jQuery('input[type="checkbox"]', rows).prop('checked', this.checked);
			   }); 
			   
				 $("#delete_selected").on('click', function()
					{	
						if ($('.select-checkbox:checked').length == 0 )
						{
							alert("<?php esc_html_e('Please select atleast one record','school-mgt');?>");
							return false;
						}
					else{
							var alert_msg=confirm("<?php esc_html_e('Are you sure you want to delete this record?','school-mgt');?>");
							if(alert_msg == false)
							{
								return false;
							}
							else
							{
								return true;
							}
						}
				});
			});
		</script>
		 <div class="panel-body">
				<div class="table-responsive">
				<form id="frm-example" name="frm-example" method="post">
			<table id="tblincome" class="display" cellspacing="0" width="100%">
				 <thead>
					<tr>
						<th style="width: 20px;"><input name="select_all" value="all" id="checkbox-select-all" 
						type="checkbox" /></th>  
						<th> <?php _e( 'Roll No.', 'school-mgt' ) ;?></th>
						<th> <?php _e( 'Student Name', 'school-mgt' ) ;?></th>
						<th> <?php _e( 'Amount', 'school-mgt' ) ;?></th>
						<th> <?php _e( 'Date', 'school-mgt' ) ;?></th>
						<th><?php  _e( 'Action', 'school-mgt' ) ;?></th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th></th>
						<th> <?php _e( 'Roll No.', 'school-mgt' ) ;?></th>
						<th> <?php _e( 'Student Name', 'school-mgt' ) ;?></th>
						<th> <?php _e( 'Amount', 'school-mgt' ) ;?></th>
						<th> <?php _e( 'Date', 'school-mgt' ) ;?></th>
						<th><?php  _e( 'Action', 'school-mgt' ) ;?></th>
					</tr>
				</tfoot>
		 
				<tbody>
				 <?php 
					foreach ($obj_invoice->get_all_income_data() as $retrieved_data)
					{ 
						$all_entry=json_decode($retrieved_data->entry);
						$total_amount=0;
						foreach($all_entry as $entry){
							$total_amount+=$entry->amount;
						}
				 ?>
						<tr>
							<td><input type="checkbox" class="select-checkbox" name="id[]" 
							value="<?php echo $retrieved_data->income_id;?>"></td>
							<td class="patient"><?php echo get_user_meta($retrieved_data->supplier_name, 'roll_id',true);?></td>
							<td class="patient_name"><?php echo get_user_name_byid($retrieved_data->supplier_name);?></td>
							<td class="income_amount"><?php echo "<span> ". get_currency_symbol() ." </span>" .$total_amount;?></td>
							<td class="status"><?php echo smgt_getdate_in_input_box($retrieved_data->income_create_date);?></td>
							
							<td class="action">
							<a  href="#" class="show-invoice-popup btn btn-default" idtest="<?php echo $retrieved_data->income_id; ?>" invoice_type="income">
							<i class="fa fa-eye"></i> <?php _e('View Income', 'school-mgt');?></a>
							 <?php
							if($user_access['edit']=='1')
							{
							?>
								<a href="?dashboard=user&page=payment&tab=addincome&action=edit&income_id=<?php echo $retrieved_data->income_id;?>" class="btn btn-info"> <?php _e('Edit', 'school-mgt' ) ;?></a>
							<?php
							}
							if($user_access['delete']=='1')
							{
							?>
							<a href="?dashboard=user&page=payment&tab=incomelist&action=delete&income_id=<?php echo $retrieved_data->income_id;?>" class="btn btn-danger" 
							onclick="return confirm('<?php _e('Are you sure you want to delete this record?','school-mgt');?>');">
							<?php _e( 'Delete', 'school-mgt' ) ;?> </a>
						<?php	
							}?>
							</td>
						</tr>
					<?php 
					} 
				?>
				</tbody>
			</table>
			<?php
			if($user_access['delete']=='1')
			{ ?>
				<div class="print-button pull-left">
					<input id="delete_selected" type="submit" value="<?php _e('Delete Selected','school-mgt');?>" name="delete_selected_income" class="btn btn-danger delete_selected"/>
					
				</div>
				<?php
			}
			?>
			</form>
			</div>
        </div>
	 <?php
		}
        if($active_tab == 'addincome')
        {
            $income_id=0;
			if(isset($_REQUEST['income_id']))
				$income_id=$_REQUEST['income_id'];
			$edit=0;
				if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
				{
					$edit=1;
					$result = $obj_invoice->smgt_get_income_data($income_id);
				}?>
		<div class="panel-body">
			<form name="income_form" action="" method="post" class="form-horizontal" id="income_form">
			 <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
			<input type="hidden" name="action" value="<?php echo $action;?>">
			<input type="hidden" name="income_id" value="<?php echo $income_id;?>">
			<input type="hidden" name="invoice_type" value="income">
			<div class="form-group">
				<label class="col-sm-2 control-label" for="class_id"><?php _e('Class','school-mgt');?><span class="require-field">*</span></label>
				<div class="col-sm-8">
					<?php
					if($edit){ $classval=$result->class_id; }else{$classval='';}?>
						 <select name="class_id" id="class_list" class="form-control validate[required]">
						 <?php if($addparent){ 
								$classdata=get_class_by_id($student->class_name);
							?>
						 <option value="<?php echo $student->class_name;?>" ><?php echo $classdata->class_name;?></option>
						 <?php }?>
							<option value=""><?php _e('Select Class','school-mgt');?></option>
								<?php
									foreach(get_allclass() as $classdata)
									{ ?>
									 <option value="<?php echo $classdata['class_id'];?>" <?php selected($classval, $classdata['class_id']);  ?>><?php echo $classdata['class_name'];?></option>
							   <?php }?>
						 </select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="class_name"><?php _e('Class Section','school-mgt');?></label>
				<div class="col-sm-8">
					<?php if($edit){ $sectionval=$result->section_id; }elseif(isset($_POST['class_section'])){$sectionval=$_POST['class_section'];}else{$sectionval='';}?>
							<select name="class_section" class="form-control" id="class_section">
								<option value=""><?php _e('Select Class Section','school-mgt');?></option>
								<?php
								if($edit){
									foreach(smgt_get_class_sections($result->class_id) as $sectiondata)
									{  ?>
									 <option value="<?php echo $sectiondata->id;?>" <?php selected($sectionval,$sectiondata->id);  ?>><?php echo $sectiondata->section_name;?></option>
								<?php } 
								}?>
							</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="student_list"><?php _e('Student','school-mgt');?><span class="require-field">*</span></label>
				<div class="col-sm-8">
					<?php if($edit){ $classval=$result->class_id; }else{$classval='';}?>
						 
						 <select name="supplier_name" id="student_list" class="form-control validate[required]">
						
						 <?php if(isset($result->supplier_name)){ 
							$student=get_userdata($result->supplier_name);
						 ?>
						 <option value="<?php echo $result->supplier_name;?>" ><?php echo $student->first_name." ".$student->last_name;?></option>
						 <?php }
								else
								{?>
							<option value=""><?php _e('Select student','school-mgt');?></option>
								<?php } ?>
						 </select>
				</div>
			</div>	
			
			<div class="form-group">
				<label class="col-sm-2 control-label" for="payment_status"><?php _e('Status','school-mgt');?><span class="require-field">*</span></label>
				<div class="col-sm-8">
					<select name="payment_status" id="payment_status" class="form-control validate[required]">
						<option value="Paid"
							<?php if($edit)selected('Paid',$result->payment_status);?> ><?php _e('Paid','school-mgt');?></option>
						<option value="Part Paid"
							<?php if($edit)selected('Part Paid',$result->payment_status);?>><?php _e('Part Paid','school-mgt');?></option>
							<option value="Unpaid"
							<?php if($edit)selected('Unpaid',$result->payment_status);?>><?php _e('Unpaid','school-mgt');?></option>
				</select>
				</div>
			</div>
			<?php wp_nonce_field( 'save_income_frontend_nonce' ); ?>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="invoice_date"><?php _e('Date','school-mgt');?><span class="require-field">*</span></label>
				<div class="col-sm-8">
					<input id="invoice_date" class="form-control " type="text"  value="<?php if($edit){ echo smgt_getdate_in_input_box($result->income_create_date);}elseif(isset($_POST['invoice_date'])){ echo smgt_getdate_in_input_box($_POST['invoice_date']);}else{ echo date("Y-m-d");}?>" name="invoice_date" readonly>
				</div>
			</div>
			<hr>
			
			<?php 
				
				if($edit){
					$all_entry=json_decode($result->entry);
				}
				else
				{
					if(isset($_POST['income_entry'])){
						
						$all_data=$obj_invoice->get_entry_records($_POST);
						$all_entry=json_decode($all_data);
					}
					
						
				}
				if(!empty($all_entry))
				{
						foreach($all_entry as $entry){
						?>
						<div id="income_entry">
							<div class="form-group income_fld">
							<label class="col-sm-2 control-label" for="income_entry"><?php _e('Income Entry','school-mgt');?><span class="require-field">*</span></label>
							<div class="col-sm-2">
								<input id="income_amount" class="form-control validate[required,min[0],maxSize[8]] text-input" type="number" step="0.01" value="<?php echo $entry->amount;?>" name="income_amount[]">
							</div>
							<div class="col-sm-4">
								<input id="income_entry" class="form-control validate[required,custom[onlyLetter_specialcharacter]] text-input" maxlength="50" type="text" value="<?php echo $entry->entry;?>" name="income_entry[]">
							</div>
							
							<div class="col-sm-2">
							<button type="button" class="btn btn-default" onclick="deleteParentElement(this)">
							<i class="entypo-trash"><?php _e('Delete','school-mgt');?></i>
							</button>
							</div>
							</div>	
						</div>
						<?php }
					
				}
				else
				{?>
						<div id="income_entry">
							<div class="form-group income_fld">
							<label class="col-sm-2 control-label" for="income_entry"><?php _e('Income Entry','school-mgt');?><span class="require-field">*</span></label>
							<div class="col-sm-2">
								<input id="income_amount" class="form-control validate[required,min[0],maxSize[8]] text-input" type="number" step="0.01" value="" name="income_amount[]" placeholder="<?php _e('Income Amount','school-mgt');?>">
							</div>
							<div class="col-sm-4">
								<input id="income_entry" class="form-control validate[required,custom[onlyLetter_specialcharacter]] text-input" maxlength="50" type="text" value="" name="income_entry[]" placeholder="<?php _e('Income Entry Label','school-mgt');?>">
							</div>						
							<div class="col-sm-2">
							<button type="button" class="btn btn-default" onclick="deleteParentElement(this)">
							<i class="entypo-trash"><?php _e('Delete','school-mgt');?></i>
							</button>
							</div>
							</div>	
						</div>
						
			<?php }?>
			
			
			<div class="form-group">
				<label class="col-sm-2 control-label" for="income_entry"></label>
				<div class="col-sm-3">
					
					<button id="add_new_entry" class="btn btn-default btn-sm btn-icon icon-left" type="button"   name="add_new_entry" onclick="add_entry()"><?php _e('Add Income Entry','school-mgt'); ?>
					</button>
				</div>
			</div>
			<hr>
			<div class="col-sm-offset-2 col-sm-8">
				<input type="submit" value="<?php if($edit){ _e('Save Income','school-mgt'); }else{ _e('Create Income Entry','school-mgt');}?>" name="save_income" class="btn btn-success"/>
			</div>
        </form>
        </div>
	<script> 
		var blank_custom_label ='';
		$(document).ready(function() { 
			blank_custom_label = $('#income_entry').html();
		}); 

		function add_entry()
		{
		<?php if($edit){ ?>
			blank_custom_label+='<div class="form-group">';
			blank_custom_label+='<label class="col-sm-2 control-label" for="income_entry"><?php _e('Income Entry','school-mgt');?><span class="require-field">*</span></label>';
			blank_custom_label+='<div class="col-sm-2">';
			blank_custom_label+='<input id="income_amount" class="form-control validate[required,min[0],maxSize[8]] text-input" type="number" step="0.01" value="" name="income_amount[]">';
			blank_custom_label+='</div>';
			blank_custom_label+='<div class="col-sm-4">';
			blank_custom_label+='<input id="income_entry" class="form-control validate[required,custom[onlyLetter_specialcharacter]] text-input" maxlength="50" type="text" value="" name="income_entry[]">';
			blank_custom_label+='</div>';
			blank_custom_label+='<div class="col-sm-2">';
			blank_custom_label+='<button type="button" class="btn btn-default" onclick="deleteParentElement(this)">';
			blank_custom_label+='<i class="entypo-trash"><?php _e('Delete','school-mgt');?></i>';
			blank_custom_label+='</button>';
			blank_custom_label+='</div>';
			blank_custom_label+='</div>';						
			$("#income_entry").html(blank_custom_label);
			<?php } else { ?> 
			$("#income_entry").append(blank_custom_label);
			<?php } ?>
		}
		
		// REMOVING INVOICE ENTRY
		function deleteParentElement(n)
		{
			var size = $(".income_fld").size();
			if(size > 1)
			{
				alert("<?php esc_html_e('Do you really want to delete this ?','school-mgt');?>");
				n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
			}
			else{
				//alert("There is only single entry,You can not remove it.");
				alert("<?php esc_html_e('There is only single entry,You can not remove it.','school-mgt');?>");
			}
		}
		   </script>
<?php 
	}
	if($active_tab == 'expenselist')
	{
		$invoice_id=0;
	?>
	<script type="text/javascript">
	$(document).ready(function() {
		var table = jQuery('#tblexpence').DataTable({
		"responsive": true,
		"order": [[ 2, "Desc" ]],
		"aoColumns":[
			{"bSortable": false},
			{"bSortable": true},
			{"bSortable": true},
			{"bSortable": true},	                                   
			{"bSortable": false}
		],
			language:<?php echo smgt_datatable_multi_language();?>
	});
	jQuery('#checkbox-select-all').on('click', function(){     
		  var rows = table.rows({ 'search': 'applied' }).nodes();
		  jQuery('input[type="checkbox"]', rows).prop('checked', this.checked);
	}); 
	   
	 $("#delete_selected").on('click', function()
			{	
				if ($('.select-checkbox:checked').length == 0 )
				{
					alert("<?php esc_html_e('Please select atleast one record','school-mgt');?>");
					return false;
				}
			else{
					var alert_msg=confirm("<?php esc_html_e('Are you sure you want to delete this record?','school-mgt');?>");
					if(alert_msg == false)
					{
						return false;
					}
					else
					{
						return true;
					}
				}
		});
	} );
	</script>
		<div class="panel-body">
			<div class="table-responsive">
				<form id="frm-example" name="frm-example" method="post">
				<table id="tblexpence" class="display expense_datatable" cellspacing="0" width="100%">
					 <thead>
						<tr>
							<th style="width: 20px;"><input name="select_all" value="all" id="checkbox-select-all" 
							type="checkbox" /></th>  
							<th> <?php _e( 'Supplier Name', 'school-mgt' ) ;?></th>
							<th> <?php _e( 'Amount', 'school-mgt' ) ;?></th>
							<th> <?php _e( 'Date', 'school-mgt' ) ;?></th>
							<th><?php  _e( 'Action', 'school-mgt' ) ;?></th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th></th>
							<th> <?php _e( 'Supplier Name', 'school-mgt' ) ;?></th>
							<th> <?php _e( 'Amount', 'school-mgt' ) ;?></th>
							<th> <?php _e( 'Date', 'school-mgt' ) ;?></th>
							<th><?php  _e( 'Action', 'school-mgt' ) ;?></th>
						</tr>
					</tfoot>
			 
					<tbody>
					 <?php 
						foreach ($obj_invoice->get_all_expense_data() as $retrieved_data)
						{ 
							$all_entry=json_decode($retrieved_data->entry);
				
							$total_amount=0;
							foreach($all_entry as $entry){
								$total_amount += $entry->amount;
							}
					 ?>
						<tr>
							<td><input type="checkbox" class="select-checkbox" name="id[]" 
							value="<?php echo $retrieved_data->income_id;?>"></td>
							<td class="patient_name"><?php echo $retrieved_data->supplier_name;?></td>
							<td class="income_amount"><?php echo "<span> ". get_currency_symbol() ." </span>" . $total_amount;?></td>
							<td class="status"><?php echo smgt_getdate_in_input_box($retrieved_data->income_create_date);?></td>
							
							<td class="action">
							<a  href="#" class="show-invoice-popup btn btn-default" idtest="<?php echo $retrieved_data->income_id; ?>" invoice_type="expense">
							<i class="fa fa-eye"></i> <?php _e('View Expense', 'school-mgt');?></a>
							 <?php
							if($user_access['edit']=='1')
							{
							?>
								<a href="?dashboard=user&page=payment&tab=addexpense&action=edit&expense_id=<?php echo $retrieved_data->income_id;?>" class="btn btn-info"> <?php _e('Edit', 'school-mgt' ) ;?></a>
							<?php
							}
							if($user_access['delete']=='1')
							{
							?>
							<a href="?dashboard=user&page=payment&tab=expenselist&action=delete&expense_id=<?php echo $retrieved_data->income_id;?>" class="btn btn-danger" 
							onclick="return confirm('<?php _e('Are you sure you want to delete this record?','school-mgt');?>');">
							<?php _e( 'Delete', 'school-mgt' ) ;?> </a>
							<?php
							}
							?>
							</td>
						</tr>
						<?php } 
						
					?>
					</tbody>
				</table>
				<?php
				if($user_access['delete']=='1')
				{ ?>
					<div class="print-button pull-left">
						<input id="delete_selected" type="submit" value="<?php _e('Delete Selected','school-mgt');?>" name="delete_selected_expense" class="btn btn-danger delete_selected"/>
					</div>
				<?php
				}  ?>
				</form>
			</div>
		</div>
	<?php 
	} 
	if($active_tab == 'addexpense')
	{
		$expense_id=0;
		if(isset($_REQUEST['expense_id']))
			$expense_id=$_REQUEST['expense_id'];
		$edit=0;
			if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit'){
				$edit=1;
				$result = $obj_invoice->smgt_get_income_data($expense_id);
		}?>
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
					<select name="payment_status" id="payment_status" class="form-control validate[required]">
						<option value="Paid"
							<?php if($edit)selected('Paid',$result->payment_status);?> ><?php _e('Paid','school-mgt');?></option>
						<option value="Part Paid"
							<?php if($edit)selected('Part Paid',$result->payment_status);?>><?php _e('Part Paid','school-mgt');?></option>
							<option value="Unpaid"
							<?php if($edit)selected('Unpaid',$result->payment_status);?>><?php _e('Unpaid','school-mgt');?></option>
				</select>
				</div>
			</div>
			
			<?php wp_nonce_field( 'save_expense_front_nonce' ); ?>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="invoice_date"><?php _e('Date','school-mgt');?><span class="require-field">*</span></label>
				<div class="col-sm-8">
					<input id="invoice_date" class="form-control validate[required]" type="text"  value="<?php if($edit){ echo $result->income_create_date;}elseif(isset($_POST['invoice_date'])){ echo $_POST['invoice_date'];}else{ echo date("Y-m-d");}?>" name="invoice_date" readonly>
				</div>
			</div>
			<hr>
			
			<?php 
				if($edit){
					$all_entry=json_decode($result->entry);
				}
				else
				{
					if(isset($_POST['income_entry'])){
						
						$all_data=$obj_invoice->get_entry_records($_POST);
						$all_entry=json_decode($all_data);
					}
				}
				if(!empty($all_entry))
				{
						foreach($all_entry as $entry){
						?>
						<div id="expense_entry">
							<div class="form-group income_fld">
							<label class="col-sm-2 control-label" for="income_entry"><?php _e('Expense Entry','school-mgt');?><span class="require-field">*</span></label>
							<div class="col-sm-2">
								<input id="income_amount" class="form-control validate[required,min[0],maxSize[8]] text-input" type="number" step="0.01" value="<?php echo $entry->amount;?>" name="income_amount[]" >
							</div>
							<div class="col-sm-4">
								<input id="income_entry" class="form-control validate[required,custom[onlyLetter_specialcharacter]] text-input" maxlength="50" type="text" value="<?php echo $entry->entry;?>" name="income_entry[]">
							</div>
							
							<div class="col-sm-2">
							<button type="button" class="btn btn-default" onclick="deleteParentElement(this)">
							<i class="entypo-trash"><?php _e('Delete','school-mgt');?></i>
							</button>
							</div>
							</div>	
						</div>
						<?php }
				}
				else
				{?>
						<div id="expense_entry">
							<div class="form-group income_fld">
							<label class="col-sm-2 control-label" for="income_entry"><?php _e('Expense Entry','school-mgt');?><span class="require-field">*</span></label>
							<div class="col-sm-2">
								<input id="income_amount" class="form-control validate[required,min[0],maxSize[8]] text-input" type="number" step="0.01" value="" name="income_amount[]" placeholder="<?php _e('Expense Amount','school-mgt');?>">
							</div>
							<div class="col-sm-4">
								<input id="income_entry" class="form-control validate[required,custom[onlyLetter_specialcharacter]] text-input" maxlength="50" type="text" value="" name="income_entry[]" placeholder="<?php _e('Expense Entry Label','school-mgt');?>">
							</div>
							
							<div class="col-sm-2">
							<button type="button" class="btn btn-default" onclick="deleteParentElement(this)">
							<i class="entypo-trash"><?php _e('Delete','school-mgt');?></i>
							</button>
							</div>
							</div>	
						</div>
						
			<?php }?>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="expense_entry"></label>
				<div class="col-sm-3">
					
					<button id="add_new_entry" class="btn btn-default btn-sm btn-icon icon-left" type="button"   name="add_new_entry" onclick="add_entry()"><?php _e('Add Expense Entry','school-mgt'); ?>
					</button>
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
				}	
				function deleteParentElement(n)
				{
					var size = $(".income_fld").size();
					if(size > 1)
					{
						alert("<?php esc_html_e('Do you really want to delete this ?','school-mgt');?>");
						n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
					}
					else{
						//alert("There is only single entry,You can not remove itaa.");
						alert("<?php esc_html_e('There is only single entry,You can not remove it.','school-mgt');?>");
					}
				}
			</script> 
		 <?php 
	}
        ?>
    </div>
</div>
<?php ?>