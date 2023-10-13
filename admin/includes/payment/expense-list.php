<?php 
	$obj_invoice= new Smgtinvoice();	
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
        <table id="tblexpence" class="display" cellspacing="0" width="100%">
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
		
		 	foreach ($obj_invoice->get_all_expense_data() as $retrieved_data){ 
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
				<a href="?page=smgt_payment&tab=addexpense&action=edit&expense_id=<?php echo $retrieved_data->income_id;?>" class="btn btn-info"> <?php _e('Edit', 'school-mgt' ) ;?></a>
                <a href="?page=smgt_payment&tab=expenselist&action=delete&expense_id=<?php echo $retrieved_data->income_id;?>" class="btn btn-danger" 
                onclick="return confirm('<?php _e('Are you sure you want to delete this record?','school-mgt');?>');">
                <?php _e( 'Delete', 'school-mgt' ) ;?> </a>
                </td>
            </tr>
            <?php } ?>     
        </tbody>        
        </table>
		<div class="print-button pull-left">
			<input id="delete_selected" type="submit" value="<?php _e('Delete Selected','school-mgt');?>" name="delete_selected_expense" class="btn btn-danger delete_selected"/>			
		</div>
	</form>
</div>
</div>
<?php } ?>