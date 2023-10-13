<script type="text/javascript">
$(document).ready(function() {
	var table =  jQuery('#example123').DataTable({
		responsive: true,
		"order": [[ 1, "desc" ]],
		"aoColumns":[
		  {"bSortable": false},
		  {"bSortable": true},
		  {"bSortable": true},
		  {"bSortable": true},
		  {"bSortable": true},
		  {"bSortable": false}],
		  language:<?php echo smgt_datatable_multi_language();?>
		});
});
</script>
<?php 
if($active_tab == 'memberlist')
{
	$school_obj = new School_Management ();?>
		<div class="panel-body">
		<div class="table-responsive">
			<table id="example123" class="display admin_memebrlist_datatable" cellspacing="0" width="100%">
				 <thead>
				<tr>
					<th><?php _e('Photo','school-mgt');?></th>
					<th><?php _e('Student Name','school-mgt');?></th>
					<th><?php _e('Class','school-mgt');?></th>
				   <th><?php _e('Roll No','school-mgt');?></th>
					<th><?php _e('Student Email','school-mgt');?></th>
					<th><?php _e('Action','school-mgt');?></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th><?php _e('Photo','school-mgt');?></th>
				 <th><?php _e('Student Name','school-mgt');?></th>
					<th><?php _e('Class','school-mgt');?></th>
				   <th><?php _e('Roll No','school-mgt');?></th>
					<th><?php _e('Student Email','school-mgt');?></th>
					<th><?php _e('Action','school-mgt');?></th>
				</tr>
			</tfoot>
			<tbody>
			 <?php
				$studentdata =$school_obj->get_all_student_list();
				if(!empty($studentdata))
				{
					foreach ($studentdata as $retrieved_data)
					{ 
						$book_issued = check_book_issued($retrieved_data->ID);
						if(!empty($book_issued))
						{ ?>
							<tr>
								<td class="user_image text-center"><?php $uid=$retrieved_data->ID;
										$umetadata=get_user_image($uid);
										if(empty($umetadata['meta_value'])){
											echo '<img src='.get_option( 'smgt_student_thumb' ).' height="50px" width="50px" class="img-circle" />';
										}
										else
										echo '<img src='.$umetadata['meta_value'].' height="50px" width="50px" class="img-circle"/>';
							?></td>
								<td class="name"><?php echo $retrieved_data->display_name;?></td>
								<td class="name"><?php $class_id=get_user_meta($retrieved_data->ID, 'class_name',true);
								echo $classname=get_class_name($class_id);?></td>
								<td class="roll_no"><?php echo get_user_meta($retrieved_data->ID, 'roll_id',true);?></td>
								<td class="email"><?php echo $retrieved_data->user_email;?></td>
								 
								<td> <a href="?dashboard=user&page=library&tab=memberlist&member_id=<?php echo $retrieved_data->ID;?>" idtest=<?php echo $retrieved_data->ID;?> id="view_member_bookissue_popup" class="btn btn-info"><?php _e('View','school-mgt');?> </a>
								<a href="?dashboard=user&page=library&tab=memberlist&member_id=<?php echo $retrieved_data->ID;?>" idtest=<?php echo $retrieved_data->ID;?> id="accept_returns_book_popup" class="btn btn-success"><?php _e('Accept Returns','school-mgt');?> </a>
								
								</td>
							   
							</tr>
					<?php } 
					} 
				}?>	
		 
			</tbody>
			
			</table>
        </div>
        </div>
<?php } ?>