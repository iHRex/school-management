<div class="panel-body">
<script>
jQuery(document).ready(function() {
	var table =  jQuery('#submission_list').DataTable({
        responsive: true,
		"order": [[ 1, "asc" ]],
		"aoColumns":[	                  
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
		<form id="frm-example" name="frm-example" method="post">
			<table id="submission_list" class="display" cellspacing="0" width="100%">
				<thead>
				<tr>
				   <!-- <th style="width: 20px;"><input name="select_all" value="all" id="checkbox-select-all" 
					type="checkbox" /></th>-->
					<th><?php _e('Homework Title','school-mgt');?></th>
					<th><?php _e('Class','school-mgt');?></th>
					<th><?php _e('Student','school-mgt');?></th>
					<th><?php _e('Subject','school-mgt');?></th>
					<th><?php _e('Status','school-mgt');?></th>
					<th><?php _e('Submitted Date','school-mgt');?></th>
					<th><?php _e('Date','school-mgt');?></th>
					<td><?php _e('Action','school-mgt');?></td>
				</tr>
				</thead>
				<tfoot>
					<tr>
						<th><?php _e('Homework Title','school-mgt');?></th>
						<th><?php _e('Class','school-mgt');?></th>
						<th><?php _e('Student','school-mgt');?></th>
						<th><?php _e('Subject','school-mgt');?></th>
						<th><?php _e('Status','school-mgt');?></th>
						<th><?php _e('Submitted Date','school-mgt');?></th>
						<th><?php _e('Date','school-mgt');?></th>
						<td><?php _e('Action','school-mgt');?></td>
					</tr>
				</tfoot>
				<tbody>
				  <?php 
					foreach ($retrieve_class as $retrieved_data)
					{ ?>
					<tr>
						<!-- <td><input type="checkbox" class="select-checkbox" name="id[]" 
						value="<?php echo $retrieved_data->homework_id;?>"></td>-->
						<td><?php echo $retrieved_data->title;?></td>
						<td><?php echo get_class_name($retrieved_data->class_name);?></td>
						<td><?php echo get_user_name_byid($retrieved_data->student_id);?></td>
						<td><?php echo get_single_subject_name($retrieved_data->subject);?></td>
						<?php  
						if($retrieved_data->status==1)
						{
							if(date('Y-m-d',strtotime($retrieved_data->uploaded_date)) <= $retrieved_data->submition_date)
							{
							?>
							  <td><label style="color:green"><?php _e('Submitted','school-mgt'); ?></label></td>
							 <?php
							}
							else
							{
							 ?><td><label style="color:green"><?php _e('Late-Submitted','school-mgt');?></label></td><?php
							}
						}  
						else 
						{?>
							<td><label style="color:red"><?php _e('Pending','school-mgt');?></label></td>
						 <?php
						}?>
						<?php  if($retrieved_data->uploaded_date==0000-00-00)
						{
						?>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo "NA ";?></td>
						<?php 
						} 
						else 
						{
						?>
						<td><?php echo smgt_getdate_in_input_box($retrieved_data->uploaded_date);?></td><?php }?>
						<td><?php echo smgt_getdate_in_input_box($retrieved_data->created_date);?></td>
					   <?php 
						if($retrieved_data->status==1)
						{ ?><td><a href="?dashboard=user&page=homework&tab=view_stud_detail&action=download&stud_homework_id=<?php echo $retrieved_data->stu_homework_id;?>" class="btn btn-info"> <?php _e('Download','school-mgt');?></a>
						</td>
						<?php
						} 
						else
						{ ?><td><a href="<?php echo SMS_PLUGIN_URL;?>/uploadfile/<?php echo $retrieved_data->file;?>" class="btn btn-info" disabled> <?php _e('Download','school-mgt');?></a></th><?php
						}?>
					</tr>
					<?php 
					} ?>
				</tbody>
			</table>
		</form>
    </div>
</div>