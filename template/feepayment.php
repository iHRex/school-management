<?php 
//-------- CHECK BROWSER JAVA SCRIPT ----------//
MJ_smgt_browser_javascript_check();
$access=page_access_rolewise_and_accessright();
$tablename="smgt_payment";
$obj_invoice= new Smgtinvoice();
$obj_fees= new Smgt_fees();
$obj_feespayment= new Smgt_feespayment();
if($school_obj->role == 'teacher' || $school_obj->role == 'supportstaff')
{ 
	$active_tab=isset($_REQUEST['tab'])?$_REQUEST['tab']:'feeslist';
}
else
{
	$active_tab=isset($_REQUEST['tab'])?$_REQUEST['tab']:'feepaymentlist';
}
//--------------- ACCESS WISE ROLE -----------//
$user_access=smgt_get_userrole_wise_access_right_array();
if (isset ( $_REQUEST ['page'] ))
{	
	if($user_access['view']=='0')
	{	
		MJ_smgt_access_right_page_not_access_message();
		die;
	}
}
if(isset($_POST['add_feetype_payment']))
{
	//POP up data save in payment history
	if($_POST['payment_method'] == 'Paypal')
	{		
		require_once SMS_PLUGIN_DIR. '/lib/paypal/paypal_process.php';				
	}
	elseif($_POST['payment_method'] == 'Stripe')
	{
		require_once PM_PLUGIN_DIR. '/lib/stripe/index.php';			
	}
	elseif($_POST['payment_method'] == 'Skrill')
	{			
		require_once PM_PLUGIN_DIR. '/lib/skrill/skrill.php';
	}
	elseif($_POST['payment_method'] == 'Instamojo')
	{
		require_once PM_PLUGIN_DIR. '/lib/instamojo/instamojo.php';
	}
	elseif($_POST['payment_method'] == 'PayUMony')
	{
		require_once PM_PLUGIN_DIR. '/lib/OpenPayU/payuform.php';			
	}
	elseif($_REQUEST['payment_method'] == '2CheckOut')
	{				
		require_once PM_PLUGIN_DIR. '/lib/2checkout/index.php';
	}
	elseif($_POST['payment_method'] == 'iDeal')
	{		
		require_once PM_PLUGIN_DIR. '/lib/ideal/ideal.php';
	}
	elseif($_POST['payment_method'] == 'Paystack')
	{		
		require_once PM_PLUGIN_DIR. '/lib/paystack/paystack.php';
	}
	elseif($_POST['payment_method'] == 'paytm')
	{		
		require_once PM_PLUGIN_DIR. '/lib/PaytmKit/index.php';
	}
	else
	{			
		$result=$obj_feespayment->add_feespayment_history($_POST);			
		if($result)
		{
			wp_redirect ( home_url() . '?dashboard=user&page=feepayment&tab=feepaymentlist&message=1');
		}
	}
}
if(isset($_REQUEST['action'])&& $_REQUEST['action']=='success')
{ ?>
	<div id="message" class="updated below-h2 "><p>
		<?php 	_e('Payment successfully','school-mgt'); ?></p>
	</div>
<?php
}
$reference='';
$reference = isset($_GET['reference']) ? $_GET['reference'] : '';
if($reference)
{
      $paystack_secret_key=get_option('paystack_secret_key');
	  $curl = curl_init();
	  curl_setopt_array($curl, array(
	  CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($reference),
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_HTTPHEADER => [
		"accept: application/json",
		"authorization: Bearer $paystack_secret_key",
		"cache-control: no-cache"
	  ],
	));
	$response1 = curl_exec($curl);
	$err = curl_error($curl);
	if($err)
	{
		// there was an error contacting the Paystack API
	  die('Curl returned error: ' . $err);
	}
	$tranx = json_decode($response);
	if(!$tranx->status)
	{
	  // there was an error from the API
	  die('API returned error: ' . $tranx->message);
	}
	if('success' == $tranx->data->status)
	{
		$trasaction_id  = $tranx->data->reference;
		$feedata['fees_pay_id']=$tranx->data->metadata->custom_fields->fees_pay_id;
		$feedata['amount']=$tranx->data->amount / 100;
		$feedata['payment_method']='Paystack';	
		$feedata['trasaction_id']=$trasaction_id ;
		$PaymentSucces = $obj_feespayment->add_feespayment_history($feedata);
		if($PaymentSucces)
		{
			wp_redirect ( home_url() . '?dashboard=user&page=feepayment&tab=feepaymentlist&action=success');
		}	
	}
}

//Paytm Success//
if(isset($_REQUEST['STATUS']) && $_REQUEST['STATUS'] == 'TXN_SUCCESS')
{ 
    $trasaction_id  = $_REQUEST["TXNID"];
	$custom_array = explode("_",$_REQUEST['ORDERID']);
	$feedata['fees_pay_id']=$custom_array[1];
	$feedata['amount']=$_REQUEST['TXNAMOUNT'];
	$feedata['payment_method']='Paytm';	
	$feedata['trasaction_id']=$trasaction_id ;
	
	$PaymentSucces = $obj_feespayment->add_feespayment_history($feedata);
	if($PaymentSucces)
	{
		wp_redirect ( home_url() . '?dashboard=user&page=feepayment&tab=feepaymentlist&action=success');
	}	

}
//if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'ipn')
if(isset($_REQUEST['payment_status']) && $_REQUEST['payment_status'] == 'Completed')
{ 
	$trasaction_id  = $_POST["txn_id"];
	$custom_array = explode("_",$_POST['custom']);
	$feedata['fees_pay_id']=$custom_array[1];
	$feedata['amount']=$_POST['mc_gross_1'];
	$feedata['payment_method']='paypal';	
	$feedata['trasaction_id']=$trasaction_id ;
	$PaymentSucces = $obj_feespayment->add_feespayment_history($feedata);
	if($PaymentSucces)
	{
		wp_redirect ( home_url() . '?dashboard=user&page=feepayment&tab=feepaymentlist&action=success');
	}		
}
	//Payment History entry for skrill//
	if(isset($_REQUEST['pay_id']) && isset($_REQUEST['amt']))
	{		
		$obj_fees_payment = new Smgt_feespayment(); 
		$feedata['fees_pay_id']=$_REQUEST['pay_id'];
		$feedata['amount']=$_REQUEST['amt'];
		$feedata['payment_method']="Skrill";
		$feedata['created_by']=get_current_user_id();
		$feedata['paid_by_date']=date('Y-m-d');		
		$result = $obj_fees_payment->add_feespayment_history($feedata);		
		
		if($result){
			wp_redirect(home_url().'?dashboard=user&page=feepayment&tab=feepaymentlist&action=success');
		}
		
	}
	
	//Payment History entry for instamojo//
	if(isset($_REQUEST['payment_id']) && isset($_REQUEST['payment_request_id']))
	{	
		$obj_fees_payment = new Smgt_feespayment(); 
		 $feedata['fees_pay_id']=$_REQUEST['pay_id'];
		 $feedata['amount']=$_REQUEST['amount'];
		 $feedata['payment_method']="Instamojo";
		 $feedata['trasaction_id']=$_REQUEST['payment_id'];
		 $feedata['created_by']=get_current_user_id();
		 $feedata['paid_by_date']=date('Y-m-d');		
		 $result = $obj_fees_payment->add_feespayment_history($feedata);		
		 if($result)
		 {
			wp_redirect(home_url().'?dashboard=user&page=feepayment&tab=feepaymentlist&action=success');
		} 
	}
if(isset($_REQUEST['action'])&& $_REQUEST['action']=='cancel')
{ ?>
	<div id="message" class="updated below-h2 "><p><?php _e('Payment Cancel','school-mgt');	?></p></div>
<?php
}
if(isset($_POST['save_feetype']))
{	
    $nonce = $_POST['_wpnonce'];
	if ( wp_verify_nonce( $nonce, 'save_fees_type_front_nonce' ) )	
	{		
		if($_REQUEST['action']=='edit')
		{	
			$result=$obj_fees->add_fees($_POST);
			if($result)
			{
				wp_redirect ( home_url() . '?dashboard=user&page=feepayment&tab=feeslist&message=5');
			}
		}
		else
		{
			if(!$obj_fees->is_duplicat_fees($_POST['fees_title_id'],$_POST['class_id']))
			{
				$result=$obj_fees->add_fees($_POST);			
				if($result)
				{
					wp_redirect ( home_url() . '?dashboard=user&page=feepayment&tab=feeslist&message=4');
				}
			}
			else
			{
				wp_redirect ( home_url() . '?dashboard=user&page=feepayment&tab=feeslist&message=6');
			}
		}	
    }	
}	
if(isset($_POST['save_feetype_payment']))
{		
	$nonce = $_POST['_wpnonce'];
	if ( wp_verify_nonce( $nonce, 'save_payment_fees_front_nonce' ) )
    {	
		if(isset($_REQUEST['smgt_enable_feesalert_mail']))
			update_option( 'smgt_enable_feesalert_mail', 1 );
		else
			update_option( 'smgt_enable_feesalert_mail', 0 );
			
		if($_REQUEST['action']=='edit')
		{
			 
			$result=$obj_feespayment->add_feespayment($_POST);
			if($result)
			{
				wp_redirect ( home_url() . '?dashboard=user&page=feepayment&tab=feepaymentlist&message=2');
			}
		}
		else
		{		
			$result=$obj_feespayment->add_feespayment($_POST);			
			if($result)
			{
				wp_redirect ( home_url() . '?dashboard=user&page=feepayment&tab=feepaymentlist&message=1');
			}			
		}
    }
}
if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete')
{
	if(isset($_REQUEST['fees_id']))
	{
		$result=$obj_fees->smgt_delete_feetype_data($_REQUEST['fees_id']);
		if($result)
		{
			wp_redirect ( home_url() . '?dashboard=user&page=feepayment&tab=feeslist&message=7');
		}
	}
	if(isset($_REQUEST['fees_pay_id']))
	{
		$result=$obj_feespayment->smgt_delete_feetpayment_data($_REQUEST['fees_pay_id']);
		if($result)
		{
			wp_redirect (  home_url() . '?dashboard=user&page=feepayment&tab=feepaymentlist&message=3');
		}
	}	
}
?>
<script type="text/javascript">
$(document).ready(function()
 {
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
} );
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
<script type="text/javascript">
$(document).ready(function() {
	jQuery('#paymentt_list').DataTable({
		 responsive: true,
		"order": [[ 8, "desc" ]],
		"aoColumns":[
	         {"bSortable": false},
	         {"bSortable": true},
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
} );
</script>
<!-- POP up code -->
<div class="popup-bg">
    <div class="overlay-content">
		<div class="modal-content">
			<div class="invoice_data"></div>
			<div class="category_list">
			</div>     
		</div>
    </div>
</div>
<!-- End POP-UP Code -->
<?php //$retrieve_class =  get_payment_list();?>
<div class="panel-body panel-white">
<?php
$message = isset($_REQUEST['message'])?$_REQUEST['message']:'0';
	switch($message)
	{
		case '1':
			$message_string = __('Fee added Successfully.','school-mgt');
			break;
		case '2':
			$message_string = __('Fee Updated Successfully.','school-mgt');
			break;	
		case '3':
			$message_string = __('Fee Deleted Successfully.','school-mgt');
			break;
		case '4':
			$message_string = __('Fee Type added Successfully.','school-mgt');
			break;
		case '5':
			$message_string = __('Fee Type updated Successfully.','school-mgt');
			break;
		case '6':
			$message_string = __('Duplicate Fee.','school-mgt');
			break;
		case '7':
			$message_string = __('Fee Type Deleted Successfully.','school-mgt');
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
<div class="panel-body panel-white">
 <ul class="nav nav-tabs panel_tabs" role="tablist">
 <?php
	if($school_obj->role == 'teacher' || $school_obj->role == 'supportstaff')
	{ ?>
		<li class="<?php if($active_tab=='feeslist'){?>active<?php }?>">
			<a href="?dashboard=user&page=feepayment&tab=feeslist"  class="tab <?php echo $active_tab == 'feeslist' ? 'active' : ''; ?>">
			 <i class="fa fa-align-justify"></i> <?php _e('Fees Type List', 'school-mgt'); ?></a>
			</a>
		</li>   
	<?php
	}
	?>
	<li class=" <?php echo $active_tab == 'addfeetype' ? 'active' : ''; ?>">
		<?php if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
		{?>
			<a href="?dashboard=user&page=feepayment&tab=addfeetype&action=edit&fees_id=<?php echo $_REQUEST['fees_id'];?>" class="nav-tab2 <?php echo $active_tab == 'addfeetype' ? 'nav-tab-active' : ''; ?>">
		<?php _e('Edit Fees Type', 'school-mgt'); ?></a>  
		<?php 
		}
		else
		{
			if($user_access['add']=='1')
			{ ?>
			<a href="?dashboard=user&page=feepayment&tab=addfeetype" class="nav-tab2  <?php echo $active_tab == 'addfeetype' ? 'nav-tab-active' : ''; ?>"><?php echo '<span class="fa fa-plus-circle"></span>'.__('Add Fee Type', 'school-mgt'); ?></a>  
        <?php 
			}
		}?>
		</li>
		<li class="<?php if($active_tab=='feepaymentlist'){?>active<?php }?>">
          <a href="?dashboard=user&page=feepayment&tab=feepaymentlist"  class="tab <?php echo $active_tab == 'feepaymentlist' ? 'active' : ''; ?>">
             <i class="fa fa-align-justify"></i> <?php _e('Fees Payment', 'school-mgt'); ?></a>
          </a>
		</li>   
	<li class=" <?php echo $active_tab == 'addpaymentfee' ? 'active' : ''; ?>">
		<?php if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
		{?>
			<a href="?dashboard=user&page=feepayment&tab=addpaymentfee&action=edit&fees_pay_id=<?php echo $_REQUEST['fees_pay_id'];?>" class="nav-tab2 <?php echo $active_tab == 'addpaymentfee' ? 'nav-tab-active' : ''; ?>">
		<?php _e('Edit Invoice', 'school-mgt'); ?></a>  
		<?php 
		}
		else
		{
			if($user_access['add']=='1')
			{ ?>
			<a href="?dashboard=user&page=feepayment&tab=addpaymentfee" class="nav-tab2  <?php echo $active_tab == 'addpaymentfee' ? 'nav-tab-active' : ''; ?>"><?php echo '<span class="fa fa-plus-circle"></span>'.__('Generate Invoice', 'school-mgt'); ?></a>  
        <?php 
			}
		}?>
		</li>
      
</ul>
		<div class="tab-content">
		<?php 
		if($active_tab == 'feeslist')
		{	
			
		?>
	<div class="panel-body">
	<script>
		jQuery(document).ready(function() {
		var table =  jQuery('#feetype_list').DataTable({
			responsive: true,
			"order": [[ 1, "asc" ]],
			"aoColumns":[	                                   
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
	   
	});
	</script>
	<div class="table-responsive">
		<form id="frm-example" name="frm-example" method="post">
		   <table id="feetype_list" class="display admin_feestype_datatable" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th><?php _e('Fee Type','school-mgt');?></th>
					<th><?php _e('Class','school-mgt');?> </th> 
					<th><?php _e('Section','school-mgt');?> </th>
					<th><?php _e('Amount','school-mgt');?></th>
					<th><?php _e('Description','school-mgt');?></th>
					<th><?php _e('Action','school-mgt');?></th>
				</tr>
			</thead> 
			<tfoot>
				<tr>
					
					<th><?php _e('Fee Type','school-mgt');?></th>
					<th><?php _e('Class','school-mgt');?> </th> 
					<th><?php _e('Section','school-mgt');?> </th>
					<th><?php _e('Amount','school-mgt');?></th>
					<th><?php _e('Description','school-mgt');?></th>
					<th><?php _e('Action','school-mgt');?></th>
				</tr>
			</tfoot>
			<tbody>
				<?php 
					$user_id=get_current_user_id();
					//------- EXAM DATA FOR STUDENT ---------//
					if($school_obj->role == 'student')
					{
						$own_data=$user_access['own_data'];
						if($own_data == '1')
						{ 
							$retrieve_class = $obj_fees->get_own_fees($user_id);
						}
						else
						{
							$retrieve_class = $obj_fees->get_all_fees();		
						}
					}
					//------- EXAM DATA FOR TEACHER ---------//
					elseif($school_obj->role == 'teacher')
					{
						$own_data=$user_access['own_data'];
						if($own_data == '1')
						{ 
							$retrieve_class = $obj_fees->get_own_fees($user_id);
						}
						else
						{
							$retrieve_class = $obj_fees->get_all_fees();	
						}
					}
					//------- EXAM DATA FOR PARENT ---------//
					elseif($school_obj->role == 'parent')
					{
						$own_data=$user_access['own_data'];
						if($own_data == '1')
						{ 
							$retrieve_class = $obj_fees->get_own_fees($user_id);
						}
						else
						{
							$retrieve_class = $obj_fees->get_all_fees();		
						}
					}
					//------- EXAM DATA FOR SUPPORT STAFF ---------//
					else
					{ 
						$own_data=$user_access['own_data'];
						if($own_data == '1')
						{ 
							$retrieve_class = $obj_fees->get_own_fees($user_id);
						}
						else
						{
							$retrieve_class = $obj_fees->get_all_fees();
						}
					} 
				foreach ($retrieve_class as $retrieved_data)
				{ 
				?>
				<tr>
					
					<td><?php echo get_the_title($retrieved_data->fees_title_id);?></td>
					<td><?php echo get_class_name($retrieved_data->class_id);?></td>
					<td><?php if($retrieved_data->section_id!=0){ echo smgt_get_section_name($retrieved_data->section_id); }else { _e('No Section','school-mgt');}?></td>				
					<td><?php echo "<span>".get_currency_symbol()."</span> ".number_format($retrieved_data->fees_amount,2); ?></td>
					<td><?php echo $retrieved_data->description;?></td>              
					<td>             
						<a href="?dashboard=user&page=feepayment&tab=addfeetype&action=edit&fees_id=<?php echo $retrieved_data->fees_id;?>" class="btn btn-info"><?php _e('Edit','school-mgt');?></a>
						<a href="?dashboard=user&page=feepayment&tab=feeslist&action=delete&fees_id=<?php echo $retrieved_data->fees_id;?>" class="btn btn-danger"
						onclick="return confirm('<?php _e('Are you sure you want to delete this record?','school-mgt');?>');"> <?php _e('Delete','school-mgt');?></a>
					</td>
				</tr>
			<?php } ?>     
			</tbody>        
			</table>
			
		</form>
	</div>
		</div>
		 <?php 
		}	
			if($active_tab == 'addfeetype')
			{
				$fees_id=0;
				if(isset($_REQUEST['fees_id']))
					$fees_id=$_REQUEST['fees_id'];
				$edit=0;
				if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
				{
					$edit=1;
					$result = $obj_fees->smgt_get_single_feetype_data($fees_id);
				} ?>
			<script type="text/javascript">
				$(document).ready(function() {
					$('#expense_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
					$('#invoice_date').datepicker({
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
			<div class="panel-body">
				<form name="expense_form" action="" method="post" class="form-horizontal" id="expense_form">
				<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
				<input type="hidden" name="action" value="<?php echo $action;?>">
				<input type="hidden" name="fees_id" value="<?php echo $fees_id;?>">
				<input type="hidden" name="invoice_type" value="expense">
				<div class="form-group">
					<label class="col-sm-2 control-label fees_type_label" for="category_data"><?php _e('Fee Type','school-mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8">
						<select class="form-control validate[required] smgt_feetype margin_top_10 max_width_100" name="fees_title_id" id="category_data">
								<option value=""><?php _e('Select Fee Type','school-mgt');?></option>
								<?php 
								$activity_category=smgt_get_all_category('smgt_feetype');
								if(!empty($activity_category))
								{
									if($edit)
									{
										$fees_val=$result->fees_title_id; 
									}
									else
									{
										$fees_val=''; 
									}
								
									foreach ($activity_category as $retrive_data)
									{ 		 	
									?>
										<option value="<?php echo $retrive_data->ID;?>" <?php selected($retrive_data->ID,$fees_val);  ?>><?php echo esc_attr($retrive_data->post_title); ?> </option>
									<?php }
								} 
								?> 
							</select>			
					</div>
					<div class="col-sm-2">
						<button id="addremove_cat" class="btn btn-info margin_top_10" model="smgt_feetype"><?php _e('Add','school-mgt');?></button>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="class_name"><?php _e('Class','school-mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8">
						<?php $classval = 0;
						if($edit)
						$classval = $result->class_id;?>
						<select name="class_id" class="form-control validate[required] max_width_100" id="class_list">
							<option value=""><?php _e('Select Class','school-mgt');?></option>
							<?php
								foreach(get_allclass() as $classdata)
								{  
								?>
								 <option value="<?php echo $classdata['class_id'];?>" <?php selected($classval, $classdata['class_id']);  ?>><?php echo $classdata['class_name'];?></option>
							<?php }?>
						</select>
					</div>
				</div>
				<?php wp_nonce_field( 'save_fees_type_front_nonce' ); ?>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="class_name"><?php _e('Class Section','school-mgt');?></label>
					<div class="col-sm-8">
						<?php if($edit){ $sectionval=$result->section_id; }elseif(isset($_POST['class_section'])){$sectionval=$_POST['class_section'];}else{$sectionval='';}?>
						<select name="class_section" class="form-control max_width_100" id="class_section">
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
					<label class="col-sm-2 control-label" for="fees_amount"><?php _e('Amount','school-mgt');?>(<?php echo get_currency_symbol();?>)<span class="require-field">*</span></label>
					<div class="col-sm-8">
						<input id="fees_amount" class="form-control validate[required,min[0],maxSize[8]] text-input" type="number" step="0.01" value="<?php if($edit){ echo $result->fees_amount;}elseif(isset($_POST['fees_amount'])) echo $_POST['fees_amount'];?>" name="fees_amount">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="description"><?php _e('Description','school-mgt');?></label>
					<div class="col-sm-8">
						<textarea name="description" class="form-control validate[custom[address_description_validation]]" maxlength="150"> <?php if($edit){ echo $result->description;}elseif(isset($_POST['description'])) echo $_POST['description'];?> </textarea>				
					</div>
				</div>
				
				<div class="col-sm-offset-2 col-sm-8">
					 <input type="submit" value="<?php if($edit){ _e('Save Fee Type','school-mgt'); }else{ _e('Create Fee Type','school-mgt');}?>" name="save_feetype" class="btn btn-success"/>
				</div>
			</form>
		</div>
		<script>   
			var blank_income_entry ='';
			$(document).ready(function() { 
				blank_expense_entry = $('#expense_entry').html();   	
			}); 

			function add_entry()
			{
				$("#expense_entry").append(blank_expense_entry);   		
			}
			   
			function deleteParentElement(n){
				alert("<?php esc_html_e('Do you really want to delete this ?','school-mgt');?>");
				n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
			}
		</script> 
		<?php 
		} 
		if($active_tab == 'feepaymentlist')
		{
			$user_id=get_current_user_id();
			//------- Payment DATA FOR STUDENT ---------//
			if($school_obj->role == 'student')
			{
				$data=$school_obj->feepayment;
			}
			//------- Payment DATA FOR TEACHER ---------//
			elseif($school_obj->role == 'teacher')
			{
				$own_data=$user_access['own_data'];
				if($own_data == '1')
				{ 
					global $wpdb;
					$class_id 	= 	get_user_meta(get_current_user_id(),'class_name',true);	
					$table_name = $wpdb->prefix .'smgt_fees_payment';
					$data =$wpdb->get_results("SELECT * FROM $table_name WHERE class_id in (".implode(',', $class_id).")");
				}
				else
				{
					$data=$school_obj->feepayment;
				}
			}
			//------- Payment DATA FOR PARENT ---------//
			elseif($school_obj->role == 'parent')
			{
				$data=$school_obj->feepayment;
			}
			//------- Payment DATA FOR SUPPORT STAFF ---------//
			else
			{ 
				$data=$school_obj->feepayment;
			} 
		?>
		<div class="panel-body">
			<div class="table-responsive">
				<table id="paymentt_list" class="display dataTable feespayment_datatable" cellspacing="0" width="100%">
					 <thead>
					<tr>                
						<th><?php _e('Fee Type','school-mgt');?></th>   
						<th><?php _e('Student Name','school-mgt');?></th>
						 <th><?php _e('Roll No.','school-mgt');?></th>
						<th><?php _e('Class','school-mgt');?> </th> 
						<th><?php _e('Section','school-mgt');?> </th> 
						<th><?php _e('Payment Status','school-mgt');?></th>
						<th><?php _e('Amount','school-mgt');?></th>
						<th><?php _e('Due Amount','school-mgt');?></th>
						<!--<th><?php _e('Description','school-mgt');?></th>-->
						<th><?php _e('Year','school-mgt');?></th>
						<th><?php _e('Action','school-mgt');?></th> 
					</tr>
				</thead>
		 
				<tfoot>
					<tr>
					<th><?php _e('Fee Type','school-mgt');?></th>   
						<th><?php _e('Student Name','school-mgt');?></th>
						 <th><?php _e('Roll No.','school-mgt');?></th>
						<th><?php _e('Class','school-mgt');?> </th> 
						<th><?php _e('Section','school-mgt');?> </th> 
						<th><?php _e('Payment Status','school-mgt');?></th>
						<th><?php _e('Amount','school-mgt');?></th>
						<th><?php _e('Due Amount','school-mgt');?></th>
						<!--<th><?php _e('Description','school-mgt');?></th> -->
						<th><?php _e('Year','school-mgt');?></th>                
						<th><?php _e('Action','school-mgt');?></th> 
						  
					</tr>
				</tfoot>
		 
				<tbody>
				  <?php 
					foreach ($data as $retrieved_data){ ?>
					<tr>
						<td width="110px"><?php echo get_fees_term_name($retrieved_data->fees_id);?></td>
						<td><?php echo get_user_name_byid($retrieved_data->student_id);?></td>
						<td><?php echo get_user_meta($retrieved_data->student_id, 'roll_id',true);?></td>
						<td><?php echo get_class_name($retrieved_data->class_id);?></td>  
						  <td><?php if($retrieved_data->section_id!=0){ echo smgt_get_section_name($retrieved_data->section_id); }else { _e('No Section','school-mgt');}?></td>
						<td>
							<?php 
							echo "<span class='btn btn-success btn-xs'>";
							echo get_payment_status($retrieved_data->fees_pay_id);
							echo "</span>";						
							?>
						</td>
						<td><?php echo "<span> ". get_currency_symbol() ." </span>" .number_format($retrieved_data->total_amount,2);?></td>
						<?php $Due_amt = $retrieved_data->total_amount-$retrieved_data->fees_paid_amount; ?>
						 <td><?php echo "<span> ". get_currency_symbol() ." </span>" .number_format($Due_amt,2);?></td>
					   
						<!--<td><?php  echo $retrieved_data->description;?></td>  -->
						<td><?php echo $retrieved_data->start_year.'-'.$retrieved_data->end_year;?></td>
						 <td>
						  <?php if($school_obj->role == 'supportstaff' || $school_obj->role == 'parent')
						   { 
							if($retrieved_data->fees_paid_amount < $retrieved_data->total_amount || $retrieved_data->fees_paid_amount == 0){ ?>
						<a href="#" class="show-payment-popup btn btn-default" idtest="<?php echo $retrieved_data->fees_pay_id; ?>" view_type="payment" due_amount="<?php echo number_format($Due_amt,2); ?>" student_id="<?php echo $retrieved_data->student_id; ?>" ><?php _e('Pay','school-mgt');?></a>
							<?php }
							} ?> 
						<a href="#" class="show-view-payment-popup btn btn-default" idtest="<?php echo $retrieved_data->fees_pay_id; ?>" view_type="view_payment"><?php _e('View','school-mgt');?></a>
						<?php
						if($user_access['edit']=='1')
						{
						?>
							<a href="?dashboard=user&page=feepayment&tab=addpaymentfee&action=edit&fees_pay_id=<?php echo $retrieved_data->fees_pay_id;?>" class="btn btn-info"><?php _e('Edit','school-mgt');?></a>
							<?php
						}
						if($user_access['delete']=='1')
						{
						?>
							<a href="?dashboard=user&page=feepayment&tab=examlist&action=delete&fees_pay_id=<?php echo $retrieved_data->fees_pay_id;?>" class="btn btn-danger" onclick="return confirm('<?php _e('Are you sure you want to delete this record?','school-mgt');?>');"><?php _e('Delete','school-mgt');?></a>
						<?php  
						}
						?>
					   </td>
						   
					   
					</tr>
					<?php } ?>
			 
				</tbody>
				
				</table>
			</div>
        </div>
        <?php 
		}
        if($active_tab == 'addpaymentfee')
		{
        	?>
			<script type="text/javascript">
			$(document).ready(function() {
				$('#expense_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
				$('#invoice_date').datepicker({
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
				$('#end_year').change(function(){
					
					var end_value = parseInt($('#end_year option:selected').val());
					var start_value = parseInt($('#start_year option:selected').attr("id"));
					if(start_value > end_value )
					{
						$("#end_year option[value='']").attr('selected','selected');
						alert('You can not select year lower then starting year');
						return false;
					}
				});
			} );
			</script>	
			<?php 	
				
					$fees_pay_id=0;
					if(isset($_REQUEST['fees_pay_id']))
						$fees_pay_id=$_REQUEST['fees_pay_id'];
					$edit=0;
					if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
					{
						$edit=1;
						$result = $obj_feespayment->smgt_get_single_fee_payment($fees_pay_id);
					}
					?>		
				<div class="panel-body">
					<form name="expense_form" action="" method="post" class="form-horizontal" id="expense_form">
						<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
						<input type="hidden" name="action" value="<?php echo $action;?>">
						<input type="hidden" name="fees_pay_id" value="<?php echo $fees_pay_id;?>">
						<input type="hidden" name="invoice_type" value="expense">
						<div class="form-group">
							<label class="col-sm-2 control-label" for="class_id"><?php _e('Class','school-mgt');?><span class="require-field">*</span></label>
							<div class="col-sm-8">
							<?php
							if($edit){ $classval=$result->class_id; }else{$classval='';}?>
								 <select name="class_id" id="class_list" class="form-control validate[required] load_fees max_width_100">
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
									<select name="class_section" class="form-control max_width_100" id="class_section">
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
					<?php if($edit){ ?>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="student_list"><?php _e('Student','school-mgt');?><span class="require-field">*</span></label>
						<div class="col-sm-8">
							<?php if($edit){ $classval=$result->class_id; }else{$classval='';}?>                     
							 <select name="student_id" id="student_list" class="form-control validate[required] max_width_100">
								<option value=""><?php _e('Select student','school-mgt');?></option>
								<?php 
									if($edit)
									{
										echo '<option value="'.$result->student_id.'" '.selected($result->student_id,$result->student_id).'>'.get_user_name_byid($result->student_id).'</option>';
									}
								?>
							 </select>
						</div>
					</div>
					<?php }
					else{
						?>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="student_list"><?php _e('Student','school-mgt');?></label>
							<div class="col-sm-8">
								<?php if($edit){ $classval=$result->class_id; }else{$classval='';}?>						 
									 <select name="student_id" id="student_list" class="form-control max_width_100">
										<option value=""><?php _e('Select Student','school-mgt');?></option>
										<?php 
											if($edit)
											{
												echo '<option value="'.$result->student_id.'" '.selected($result->student_id,$result->student_id).'>'.get_user_name_byid($result->student_id).'</option>';
											}
										?>
									 </select>
								<p><i><?php 
									/* _e('If You want to generate invoice for single student then select student otherewise generate invoice for all student as selected class','school-mgt'); */
									_e('Note : Please select a student to generate invoice for the single student or it will create the invoice for all students for selected class and section.','school-mgt');
									?></i>
								</p>
							</div>
						</div>
						<?php
					}
					?>
					<?php wp_nonce_field( 'save_payment_fees_admin_nonce' ); ?>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="category_data"><?php _e('Fee Type','school-mgt');?><span class="require-field">*</span></label>
						<div class="col-sm-8">
							<select name="fees_id" id="fees_data" class="form-control validate[required] max_width_100">
								<option value = ""><?php _e('Select Fee Type','school-mgt');?></option>
								<?php 				
								if($edit)
								{
									echo '<option value="'.$result->fees_id.'" '.selected($result->fees_id,$result->fees_id).'>'.get_fees_term_name($result->fees_id).'</option>';
								}
								?>
							</select>
						</div>			
					</div>		
					<div class="form-group">
						<label class="col-sm-2 control-label" for="fees_amount"><?php _e('Amount','school-mgt');?>(<?php echo get_currency_symbol();?>)<span class="require-field">*</span></label>
						<div class="col-sm-8">
							<input id="fees_amount" class="form-control validate[required,min[0],maxSize[8]] text-input" type="tax"  value="<?php if($edit){ echo $result->total_amount;}elseif(isset($_POST['fees_amount'])) echo $_POST['fees_amount'];?>" name="fees_amount" readonly>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-2 control-label" for="description"><?php _e('Description','school-mgt');?></label>
						<div class="col-sm-8">
							<textarea name="description" class="form-control validate[custom[address_description_validation]]" maxlength="150"> <?php if($edit){ echo $result->description;}elseif(isset($_POST['description'])) echo $_POST['description'];?> </textarea>				
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="start_year"><?php _e('Year','school-mgt');?><span class="require-field">*</span></label>
						<div class="col-sm-4">
							<select name="start_year" id="start_year" class="form-control validate[required]">
								<option value=""><?php _e('Starting year','school-mgt');?></option>
								<?php 
								$start_year = 0;
								$x = 00;
								if($edit)
								$start_year = $result->start_year;
								for($i=2000 ;$i<2030;$i++)
								{
									echo '<option value="'.$i.'" '.selected($start_year,$i).' id="'.$x.'">'.$i.'</option>';
									$x++;
								} ?>
							</select>
						</div>
						<div class="col-sm-4">
							<select name="end_year" id="end_year" class="form-control validate[required] margin_top_10_res">
								<option value=""><?php _e('Ending year','school-mgt');?></option>
								<?php 
								$end_year = '';
								if($edit)
									$end_year = $result->end_year;
									for($i=00 ;$i<31;$i++)
									{
										echo '<option value="'.$i.'" '.selected($end_year,$i).'>'.$i.'</option>';
									}
								?>
							</select>
						</div>
					</div>
					<?php wp_nonce_field( 'save_payment_fees_front_nonce' ); ?>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="smgt_enable_feesalert_mail"><?php _e('Enable Send  Mail To Parents','school-mgt');?></label>
						<div class="col-sm-8">
							<div class="checkbox">
								<label><input type="checkbox" name="smgt_enable_feesalert_mail"  value="1" <?php echo checked(get_option('smgt_enable_feesalert_mail'),'yes');?>/><?php _e('Enable','school-mgt');?>
							  </label>
							</div>
						</div>
					</div>
					
					<div class="col-sm-offset-2 col-sm-8">
						 <input type="submit" value="<?php if($edit){ _e('Save Invoice','school-mgt'); }else{ _e('Create Invoice','school-mgt');}?>" name="save_feetype_payment" class="btn btn-success"/>
					</div>
				</form>
			</div>
			<script>
				var blank_income_entry ='';
				$(document).ready(function() { 
					blank_expense_entry = $('#expense_entry').html();   	
				}); 

				function add_entry()
				{
					$("#expense_entry").append(blank_expense_entry);   		
				}
				   
				function deleteParentElement(n){
					alert("<?php esc_html_e('Do you really want to delete this ?','school-mgt');?>");
					n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
				}
			</script> 

        	<?php 
        }
        ?>
        </div>
    </div>
 <?php 
 ?>