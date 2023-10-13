<?php 
//-------- CHECK BROWSER JAVA SCRIPT ----------//
MJ_smgt_browser_javascript_check();
$active_tab = isset($_GET['tab'])?$_GET['tab']:'classlist';
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
 
?>
<script>
$(document).ready(function() {
    $('#class_list').DataTable({
        responsive: true,
		language:<?php echo smgt_datatable_multi_language();?>	
    });
} );
</script>
<!-- Nav tabs -->
<div class="panel-body panel-white">
	<ul class="nav nav-tabs panel_tabs" role="tablist">
		<li class=" <?php echo $active_tab == 'classlist' ? 'active' : ''; ?>">
			<a href="?dashboard=user&page=class&tab=classlist" class="nav-tab2"> <strong>
				<i class="fa fa-align-justify"> </i> <?php _e('Class List', 'school-mgt'); ?></strong>
			</a>
		</li>
	</ul>
    <!-- Tab panes -->
	<?php
	if($active_tab == 'classlist')
	{
		$tablename="smgt_class";
		$user_id=get_current_user_id();
		 
		//------- EXAM DATA FOR TEACHER ---------//
		if($school_obj->role == 'teacher')
		{
			$own_data=$user_access['own_data'];
			if($own_data == '1')
			{ 
				$class_id 	= 	get_user_meta(get_current_user_id(),'class_name',true);	
				$retrieve_class	=get_all_class_data_by_class_array($class_id);
			}
			else
			{
				$retrieve_class = get_all_data($tablename);			
			}
		}
		//------- EXAM DATA FOR SUPPORT STAFF ---------//
		else
		{ 
			$retrieve_class = get_all_data($tablename);	
		} 
		?>
		<div class="panel-body">
			<div class="table-responsive">
				<table id="class_list" class="display dataTable exam_datatable" cellspacing="0" width="100%">
					 <thead>
						 <tr>
							<th><?php _e('Class Name','school-mgt');?></th>
							<th><?php _e('Class Numeric Name','school-mgt');?></th>
							<!--<th><?php _e('Section','school-mgt');?></th>-->
							<th><?php _e('Capacity','school-mgt');?></th>
						</tr>
					</thead>
		 
					<tfoot>
						 <tr>
							<th><?php _e('Class Name','school-mgt');?></th>
							<th><?php _e('Class Numeric Name','school-mgt');?></th>
							<!--<th><?php _e('Section','school-mgt');?></th>-->
							<th><?php _e('Capacity','school-mgt');?></th>
						</tr>
					</tfoot>
		 
					<tbody>
					 <?php 
					foreach ($retrieve_class as $retrieved_data)
					{ 
					 ?>
						<tr>
							<td><?php echo $retrieved_data->class_name;?></td>
							<td><?php echo $retrieved_data->class_num_name;?></td>
							<!--<td><?php echo $retrieved_data->class_section;?></td>-->
							<td><?php echo $retrieved_data->class_capacity;?></td>
					  </tr>
						<?php 
					} ?>
					</tbody>
				</table>
			</div>
		</div>
	<?php
	} ?>
 </div> 
<?php ?>