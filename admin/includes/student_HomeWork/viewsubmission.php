<div class="panel-body">
		<script>
			jQuery(document).ready(function() {
				var table =  jQuery('#class_list').DataTable({
					responsive: true,
					"order": [[ 1, "asc" ]],
					"aoColumns":[	                  
								  {"bSortable": false},
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
			   
				jQuery('#delete_selected').on('click', function(){
					 var c = confirm('Are you sure to delete?');
					if(c){
						jQuery('#frm-example').submit();
					}
					
				});
			   
			});

		</script>	
        <div class="table-responsive">
			<form id="frm-example" name="frm-example" method="post">
			
				<table id="class_list" class="display" cellspacing="0" width="100%">
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
					/*  $aaa=content_url();
					 var_dump($aaa);
					 die; */
					  
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
									   <?php  
										if($retrieved_data->uploaded_date==0000-00-00)
										{
											 ?>
											<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo "NA ";?></td>
											<?php 
										} 
										else
										{?>
											<td><?php echo smgt_getdate_in_input_box($retrieved_data->uploaded_date);?></td>
											<?php 
										}?>
											<td><?php echo smgt_getdate_in_input_box($retrieved_data->created_date);?></td>
										   <?php 
										if($retrieved_data->status==1)
										{ ?>
											<td> 
											<a download href="<?php print content_url().'/uploads/homework_file/'.$retrieved_data->file; ?>" class="status_read btn btn-info" record_id="<?php echo $retrieved_data->stu_homework_id;?>" download><?php esc_html_e(' Download', 'school-mgt');?></a>
										<?php 
										} 
										else 
										{ 
										?>
											<td><a href="<?php echo SMS_PLUGIN_URL;?>/uploadfile/<?php echo $retrieved_data->file;?>" class="btn btn-info" disabled> <?php _e('Download','school-mgt');?></a></th><?php 
										}?>
							</tr>
							<?php 
						} ?>
					</tbody>
				</table>
			</form>
        </div>
        </div>
       </div>