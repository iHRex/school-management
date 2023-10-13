<?php 
	$obj_lib= new Smgtlibrary();
	if($active_tab == 'issuelist'){ ?>
	<div class="panel-body">
<script>
jQuery(document).ready(function() {
	var table =  jQuery('#issue_list').DataTable({
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
		<table id="issue_list" class="display" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th style="width: 20px;"><input name="select_all" value="all" id="checkbox-select-all" type="checkbox" /></th>  
				<th><?php _e('Student Name','school-mgt');?></th>
				<th><?php _e('Book Name','school-mgt');?></th>
				<th><?php _e('Issue Date','school-mgt');?></th>
				<th><?php _e('Return Date ','school-mgt');?></th>
				<th><?php _e('Period','school-mgt');?></th>
				<th><?php _e('Action','school-mgt');?></th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th></th>
				<th><?php _e('Student Name','school-mgt');?></th>
				<th><?php _e('Book Name','school-mgt');?></th>
				<th><?php _e('Issue Date','school-mgt');?></th>
				<th><?php _e('Return Date ','school-mgt');?></th>
				<th><?php _e('Period','school-mgt');?></th>
				<th><?php _e('Action','school-mgt');?></th>
			</tr>
		</tfoot>
		<tbody>
			<?php $retrieve_issuebooks=$obj_lib->get_all_issuebooks(); 
			if(!empty($retrieve_issuebooks))
			{
				foreach ($retrieve_issuebooks as $retrieved_data){ ?>
				<tr>
					<td><input type="checkbox" class="select-checkbox" name="id[]" value="<?php echo $retrieved_data->id;?>"></td>
					<td><?php  $student=get_userdata($retrieved_data->student_id);
						echo $student->display_name;?></td>
					<td><?php echo stripslashes(get_bookname($retrieved_data->book_id));?></td>
					<td><?php echo smgt_getdate_in_input_box($retrieved_data->issue_date);?></td>
					<td><?php echo smgt_getdate_in_input_box($retrieved_data->end_date);?></td>
					<td><?php echo get_the_title($retrieved_data->period);?></td>
					<td> <a href="?page=smgt_library&tab=issuebook&action=edit&issuebook_id=<?php echo $retrieved_data->id;?>" class="btn btn-info"><?php _e('Edit','school-mgt');?> </a>
					<a href="?page=smgt_library&tab=issuelist&action=delete&issuebook_id=<?php echo $retrieved_data->id;?>" class="btn btn-danger" onclick="return confirm('<?php _e('Are you sure you want to delete this record?','school-mgt');?>');"> <?php _e('Delete','school-mgt');?></a> 
					</td>
				</tr>
			<?php } 
			} ?>	
		</tbody>
	</table>
		<div class="print-button pull-left">
			<input id="delete_selected" type="submit" value="<?php _e('Delete Selected','school-mgt');?>" name="delete_selected_issuebook" class="btn btn-danger delete_selected"/>
		</div>
	</form>
</div>    
<?php } ?>