<?php 
$obj_fees= new Smgt_fees();
$obj_feespayment= new Smgt_feespayment();
if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete')
{
	if(isset($_REQUEST['fees_id']))
	{
		$result=$obj_fees->smgt_delete_feetype_data($_REQUEST['fees_id']);
		if($result)
		{
			wp_redirect ( admin_url() . 'admin.php?page=smgt_fees_payment&tab=feeslist&message=feetype_del');
		}
	}
	if(isset($_REQUEST['fees_pay_id']))
	{
		$result=$obj_feespayment->smgt_delete_feetpayment_data($_REQUEST['fees_pay_id']);
		if($result)
		{
			wp_redirect ( admin_url() . 'admin.php?page=smgt_fees_payment&tab=feespaymentlist&message=fee_del');
		}
	}	
}

if(isset($_REQUEST['delete_selected_feetype']))
{		
	if(!empty($_REQUEST['id']))
	foreach($_REQUEST['id'] as $id)
			$result=$obj_feespayment->smgt_delete_feetype_data($id);
	if($result){ ?>
		<div id="message" class="updated below-h2">
			<p><?php _e('Fee Type Successfully Delete','school-mgt');?></p>
		</div>
	<?php 
	}
}
if(isset($_REQUEST['delete_selected_feelist']))
{		
	if(!empty($_REQUEST['id']))
	foreach($_REQUEST['id'] as $id)
			$result=$obj_feespayment->smgt_delete_feetpayment_data($id);
	if($result)
	{ ?>
		<div id="message" class="updated below-h2">
			<p><?php _e('Fee Successfully Delete!','school-mgt');?></p>
		</div>
	<?php 
	}
}
	
if(isset($_POST['save_feetype']))
{	
    $nonce = $_POST['_wpnonce'];
	if ( wp_verify_nonce( $nonce, 'save_fees_type_admin_nonce' ) )	
	{		
		if($_REQUEST['action']=='edit')
		{	
			$result=$obj_fees->add_fees($_POST);
			if($result)
			{
				wp_redirect ( admin_url() . 'admin.php?page=smgt_fees_payment&tab=feeslist&message=fee_edit');
			}
		}
		else
		{
			if(!$obj_fees->is_duplicat_fees($_POST['fees_title_id'],$_POST['class_id']))
			{
				$result=$obj_fees->add_fees($_POST);			
				if($result)
				{
					wp_redirect ( admin_url() . 'admin.php?page=smgt_fees_payment&tab=feeslist&message=feetype_add');
				}
			}
			else
			{
				wp_redirect ( admin_url() . 'admin.php?page=smgt_fees_payment&tab=feeslist&message=fee_dub');
			}
		}	
    }	
}	
if(isset($_POST['add_feetype_payment']))
{		
	$result=$obj_feespayment->add_feespayment_history($_POST);			
	if($result)
	{
		wp_redirect ( admin_url() . 'admin.php?page=smgt_fees_payment&tab=feespaymentlist&message=1');
	}
}
	
if(isset($_POST['save_feetype_payment']))
{	
    $nonce = $_POST['_wpnonce'];
	if ( wp_verify_nonce( $nonce, 'save_payment_fees_admin_nonce' ) )
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
				wp_redirect ( admin_url() . 'admin.php?page=smgt_fees_payment&tab=feespaymentlist&message=feetype_edit');
			}
		}
		else
		{		
			$result=$obj_feespayment->add_feespayment($_POST);			
			if($result)
			{
				wp_redirect ( admin_url() . 'admin.php?page=smgt_fees_payment&tab=feespaymentlist&message=fee_add');
			}			
		}
    }	
}
$active_tab = isset($_GET['tab'])?$_GET['tab']:'feeslist';
?>
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
<div class="page-inner">
	<div class="page-title">
		<h3><img src="<?php echo get_option( 'smgt_school_logo' ) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo get_option( 'smgt_school_name' );?></h3>
	</div>
<div  id="main-wrapper" class=" payment_list"> 
<?php
$message_string="";
if(isset($_REQUEST['message']))
{	
	$message = isset($_REQUEST['message'])?$_REQUEST['message']:'';
	switch($message)
	{
		case 'feetype_del':
			$message_string = __('Fee Type Deleted Successfully.','school-mgt');
			break;
		case 'fee_del':
			$message_string = __('Fee Deleted Successfully.','school-mgt');
			break;
		case 'fee_edit':
			$message_string = __('Fee Updated Successfully.','school-mgt');
			break;
		case 'fee_add':
			$message_string = __('Fee added Successfully.','school-mgt');
			break;
		case 'fee_dub':
			$message_string = __('Duplicate Fee.','school-mgt');
			break;
		case 'feetype_edit':
			$message_string = __('Fee Type updated Successfully.','school-mgt');
			break;
		case 'feetype_add':
			$message_string = __('Fee Type added Successfully.','school-mgt');
			break;
		default:
			$message_string = __('Payment Successfully Done.','school-mgt');
	}		
	?>
		<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible">
			<p><?php echo $message_string;?></p>
			<button type="button" class="notice-dismiss" data-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>
		</div>
<?php				
} ?>

	<div class="panel panel-white">
	<div class="panel-body">
	<h2 class="nav-tab-wrapper">
		<a href="?page=smgt_fees_payment&tab=feeslist" class="nav-tab <?php echo $active_tab == 'feeslist' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-menu"></span>'.__('Fees Type List', 'school-mgt'); ?></a>
         <?php if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit' && $_REQUEST['tab'] == 'addfeetype')
		{?>
       <a href="?page=smgt_fees_payment&tab=addfeetype&action=edit&fees_id=<?php echo $_REQUEST['fees_id'];?>" class="nav-tab <?php echo $active_tab == 'addfeetype' ? 'nav-tab-active' : ''; ?>">
		<?php _e('Edit Fees Type', 'school-mgt'); ?></a>  
		<?php 
		}
		else
		{?>
    	<a href="?page=smgt_fees_payment&tab=addfeetype" class="nav-tab <?php echo $active_tab == 'addfeetype' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-plus-alt"></span>'.__('Add Fee Type', 'school-mgt'); ?></a>  
        <?php } ?>
    	<a href="?page=smgt_fees_payment&tab=feespaymentlist" class="nav-tab <?php echo $active_tab == 'feespaymentlist' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-menu"></span>'.__('Fees List', 'school-mgt'); ?></a>
         <?php if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit' && $_REQUEST['tab'] == 'addpaymentfee')
		{?>
       <a href="?page=smgt_fees_payment&tab=addpaymentfee&action=edit&fees_pay_id=<?php echo $_REQUEST['fees_pay_id'];?>" class="nav-tab <?php echo $active_tab == 'addpaymentfee' ? 'nav-tab-active' : ''; ?>">
		<?php _e('Edit Invoice', 'school-mgt'); ?></a>  
		<?php 
		}
		else
		{?>
    	<a href="?page=smgt_fees_payment&tab=addpaymentfee" class="nav-tab margin_bottom <?php echo $active_tab == 'addpaymentfee' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-plus-alt"></span>'.__('Generate Invoice', 'school-mgt'); ?></a>  
        <?php } ?>      
    </h2>
    <?php
	if($active_tab == 'feeslist')
	{	
		$retrieve_class = $obj_fees->get_all_fees();
	?>
<div class="panel-body">
<script>
	jQuery(document).ready(function() {
	var table =  jQuery('#feetype_list').DataTable({
        responsive: true,
		"order": [[ 1, "asc" ]],
		"aoColumns":[	                  
	        {"bSortable": false},	                 
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
	<form id="frm-example" name="frm-example" method="post">
       <table id="feetype_list" class="display admin_feestype_datatable" cellspacing="0" width="100%">
        <thead>
            <tr>
				<th style="width: 20px;"><input name="select_all" value="all" id="checkbox-select-all" type="checkbox" /></th>
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
				<th></th>
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
				foreach ($retrieve_class as $retrieved_data)
				{ 
			?>
            <tr>
				<td><input type="checkbox" class="select-checkbox" name="id[]" value="<?php echo $retrieved_data->fees_id;?>"></td>
				<td><?php echo get_the_title($retrieved_data->fees_title_id);?></td>
				<td><?php echo get_class_name($retrieved_data->class_id);?></td>
				<td><?php if($retrieved_data->section_id!=0){ echo smgt_get_section_name($retrieved_data->section_id); }else { _e('No Section','school-mgt');}?></td>				
				<td><?php echo "<span>".get_currency_symbol()."</span> ".number_format($retrieved_data->fees_amount,2); ?></td>
				<td><?php echo $retrieved_data->description;?></td>              
				<td>             
					<a href="?page=smgt_fees_payment&tab=addfeetype&action=edit&fees_id=<?php echo $retrieved_data->fees_id;?>" class="btn btn-info"><?php _e('Edit','school-mgt');?></a>
					<a href="?page=smgt_fees_payment&tab=feeslist&action=delete&fees_id=<?php echo $retrieved_data->fees_id;?>" class="btn btn-danger"
					onclick="return confirm('<?php _e('Are you sure you want to delete this record?','school-mgt');?>');"> <?php _e('Delete','school-mgt');?></a>
				</td>
            </tr>
        <?php } ?>     
        </tbody>        
        </table>
		<div class="print-button pull-left">
			<input id="delete_selected" type="submit" value="<?php _e('Delete Selected','school-mgt');?>" name="delete_selected_feetype" class="btn btn-danger delete_selected"/>			
		</div>
	</form>
</div>
	</div>
     <?php 
	}
	if($active_tab == 'addfeetype')
	{
		require_once SMS_PLUGIN_DIR. '/admin/includes/feespayment/add_feetype.php';
	}
	if($active_tab == 'feespaymentlist')
	{	
		$retrieve_class = $obj_feespayment->get_all_fees();	
	?>
<script type="text/javascript">
$(document).ready(function() {
	var table =  jQuery('#fee_paymnt').DataTable({
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
		  {"bSortable": true},
		// {"bSortable": true},
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
	<div class="panel-body">
        <div class="table-responsive">
		<form id="frm-example" name="frm-example" method="post">	
        <table id="fee_paymnt" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>        
				 <th style="width: 20px;"><input name="select_all" value="all" id="checkbox-select-all" 
				type="checkbox" /></th>        
                <th><?php _e('Fee Type','school-mgt');?></th>  
				<th><?php _e('Student Name','school-mgt');?></th>  
				<th><?php _e('Roll No','school-mgt');?></th>  
                <th><?php _e('Class','school-mgt');?> </th>  
                <th><?php _e('Section','school-mgt');?> </th>  
				<th><?php _e('Payment Status','school-mgt'); ?></th>
                <th><?php _e('Amount','school-mgt');?></th>
				 <th><?php _e('Due Amount','school-mgt');?></th>
                <!-- <th><?php _e('Description','school-mgt');?></th>  -->
				<th><?php _e('Year','school-mgt');?></th>
                <th><?php _e('Action','school-mgt');?></th>                 
            </tr>
        </thead>
 
        <tfoot>
            <tr>
				<th></th>
				<th><?php _e('Fee Type','school-mgt');?></th>  
				<th><?php _e('Student Name','school-mgt');?></th>
				<th><?php _e('Roll No','school-mgt');?></th>  
                <th><?php _e('Class','school-mgt');?> </th>  
				<th><?php _e('Section','school-mgt');?> </th>  
				<th><?php _e('Payment Status','school-mgt'); ?></th>
                <th><?php _e('Amount','school-mgt');?></th>
				 <th><?php _e('Due Amount','school-mgt');?></th>
                <!--<th><?php _e('Description','school-mgt');?></th> -->
				<th><?php _e('Year','school-mgt');?></th>
                <th><?php _e('Action','school-mgt');?></th>         
            </tr>
        </tfoot>
 
        <tbody>
          <?php 			
		 	foreach ($retrieve_class as $retrieved_data){ 
			 ?>
            <tr>
				<td><input type="checkbox" class="select-checkbox" name="id[]" 
				value="<?php echo $retrieved_data->fees_pay_id;?>"></td>
					<td><?php echo get_fees_term_name($retrieved_data->fees_id);?></td>
					<td><?php echo get_user_name_byid($retrieved_data->student_id);?></td>
					<td><?php echo get_user_meta($retrieved_data->student_id, 'roll_id',true);?></td>
					<td><?php echo get_class_name($retrieved_data->class_id);?></td>
					<td><?php if($retrieved_data->section_id!=0){ echo smgt_get_section_name($retrieved_data->section_id); }else { _e('No Section','school-mgt');}?></td>
				<td>
					<?php 
					echo "<span class='btn btn-success btn-xs'>";
					echo $payment_status=get_payment_status($retrieved_data->fees_pay_id);						
					echo "</span>";						
					?>
				</td>
				   <td><?php echo "<span> ". get_currency_symbol() ." </span>" . number_format($retrieved_data->total_amount,2); ?></td>
					<?php 
					$Due_amt = $retrieved_data->total_amount-$retrieved_data->fees_paid_amount;
					$due_amount=number_format($Due_amt,2);
					?>
					 <td><?php echo "<span> ". get_currency_symbol() ." </span>" .$due_amount; ?></td>
					 <!--<td><?php echo $retrieved_data->description;?></td>-->
					 <td><?php echo $retrieved_data->start_year.'-'.$retrieved_data->end_year;?></td>
               <td>
			   <?php if($retrieved_data->fees_paid_amount < $retrieved_data->total_amount || $retrieved_data->fees_paid_amount == 0)
			    { 
			    ?>
			 		<a href="#" class="show-payment-popup btn btn-default" idtest="<?php echo $retrieved_data->fees_pay_id; ?>" view_type="payment" due_amount="<?php echo $due_amount; ?>"><?php _e('Pay','school-mgt');?></a>
				   <?php 
			    } ?>
				<a href="#" class="show-view-payment-popup btn btn-default" idtest="<?php echo $retrieved_data->fees_pay_id; ?>" view_type="view_payment"><?php _e('View','school-mgt');?></a>
               <a href="?page=smgt_fees_payment&tab=addpaymentfee&action=edit&fees_pay_id=<?php echo $retrieved_data->fees_pay_id;?>" class="btn btn-info"><?php _e('Edit','school-mgt');?></a>
               <a href="?page=smgt_fees_payment&tab=feespaymentlist&action=delete&fees_pay_id=<?php echo $retrieved_data->fees_pay_id;?>" class="btn btn-danger"
               onclick="return confirm('<?php _e('Are you sure you want to delete this record?','school-mgt');?>');"> <?php _e('Delete','school-mgt');?></a></td>
            </tr>
            <?php } ?>     
        </tbody>       
        </table>
		 <div class="print-button pull-left">
			<input id="delete_selected" type="submit" value="<?php _e('Delete Selected','school-mgt');?>" name="delete_selected_feelist" class="btn btn-danger delete_selected"/>			
		</div>
		</form>
       </div>
	</div>
     <?php 
	}
	if($active_tab == 'addpaymentfee')
	{
		require_once SMS_PLUGIN_DIR. '/admin/includes/feespayment/add_paymentfee.php';		
	}	 
	 ?>
	</div>
	</div>
	</div>
</div>